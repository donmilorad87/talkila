#!/usr/bin/env bash
# Deploys the release bundle (scripts/build-release.sh) to production over SSH:
#   1. checks the server is ready (.env exists)          4. migrate + rebuild caches
#   2. maintenance mode on (php artisan down)            5. maintenance mode off (php artisan up)
#   3. rsync: only changed files are sent; files removed  6. smoke test: /v1/health ok, .env & co. not reachable
#      from the project are deleted on the server
# If any step after 2 fails, the site STAYS in maintenance (never half-deployed). Recover with `php artisan up`.
#
# Env: SSH_HOST SSH_PORT SSH_USER DEPLOY_PATH SSH_KEY_FILE (private key file) [SITE_URL] [PHP_BIN] [RELEASE_DIR]
set -euo pipefail
cd "$(dirname "$0")/.."

: "${SSH_HOST:?missing}" "${SSH_PORT:?missing}" "${SSH_USER:?missing}" "${DEPLOY_PATH:?missing}" "${SSH_KEY_FILE:?missing}"
SITE_URL="${SITE_URL:-https://talkila.blazingsun.space}"
PHP_BIN="${PHP_BIN:-php}"
RELEASE_DIR="${RELEASE_DIR:-release}"
summary="${GITHUB_STEP_SUMMARY:-/dev/null}"

[[ -f "$RELEASE_DIR/artisan" && -f "$RELEASE_DIR/vendor/autoload.php" ]] \
	|| { echo "No release bundle in $RELEASE_DIR/ — run scripts/build-release.sh first" >&2; exit 1; }
[[ "$DEPLOY_PATH" != /* && "$DEPLOY_PATH" != *..* ]] \
	|| { echo "DEPLOY_PATH must be relative to the SSH home and contain no '..' (got: $DEPLOY_PATH)" >&2; exit 1; }

ssh_opts=(-p "$SSH_PORT" -i "$SSH_KEY_FILE" -o BatchMode=yes -o IdentitiesOnly=yes
	-o StrictHostKeyChecking=yes -o UserKnownHostsFile="$PWD/deploy/known_hosts" -o ConnectTimeout=30)
remote() { # remote <script>: runs a bash script in DEPLOY_PATH on the server
	ssh "${ssh_opts[@]}" "$SSH_USER@$SSH_HOST" "cd $(printf '%q' "$DEPLOY_PATH") && bash -euo pipefail -s" <<< "$1"
}

echo "▶ Checking the server"
remote "test -f .env || { echo '.env is missing in $DEPLOY_PATH: create it first (DEPLOYMENT.md, section 3.3)' >&2; exit 1; }"
first_deploy=$(remote "test -f artisan && echo no || echo yes")

maintenance=off
on_exit() {
	local status=$?
	if (( status != 0 )) && [[ "$maintenance" == on ]]; then
		echo "::error title=Deploy failed — site left in maintenance mode::Fix the cause, then redeploy or run: cd $DEPLOY_PATH && $PHP_BIN artisan up"
		echo "### ❌ Deploy failed — the site is in **maintenance mode** until a redeploy or \`php artisan up\`" >> "$summary"
	fi
}
trap on_exit EXIT

if [[ "$first_deploy" == no ]]; then
	echo "▶ Maintenance mode on"
	remote "$PHP_BIN artisan down --retry=60"
	maintenance=on
else
	echo "▶ First deploy: no running app yet, skipping maintenance mode"
fi

echo "▶ Uploading changed files (rsync)"
# Never sent and never deleted on the server: secrets, runtime data and user uploads.
started=$SECONDS
rsync -rlz --checksum --delete --omit-dir-times --no-perms --no-owner --no-group --chmod=D755,F644 \
	--itemize-changes --stats \
	--exclude='/.env' --exclude='/.user.ini' --exclude='/php.ini' \
	--exclude='/storage/' --exclude='/public/storage' --exclude='/public/assets/images/user/' \
	-e "ssh ${ssh_opts[*]}" \
	"$RELEASE_DIR/" "$SSH_USER@$SSH_HOST:$DEPLOY_PATH/" > rsync.log
grep -E '^(<f|\*deleting)' rsync.log | head -n 300 || true # only shows the list; rsync's own status is checked above
transferred=$(grep -c '^<f' rsync.log || true)
deleted=$(grep -c '^\*deleting' rsync.log || true)
echo "  $transferred files sent, $deleted deleted in $((SECONDS - started))s"

# storage/ is excluded above; create its skeleton without touching existing files (logs, uploads, sessions).
rsync -rlz --ignore-existing --omit-dir-times --no-perms --no-owner --no-group --chmod=D755,F644 \
	-e "ssh ${ssh_opts[*]}" "$RELEASE_DIR/storage/" "$SSH_USER@$SSH_HOST:$DEPLOY_PATH/storage/"

echo "▶ Package discovery, migrations, caches"
remote "
	mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
	$PHP_BIN artisan package:discover --ansi
	$PHP_BIN artisan optimize:clear
	$PHP_BIN artisan migrate --force
	test -f storage/oauth-private.key || $PHP_BIN artisan passport:keys # API token signing keys, once (storage/ is never uploaded)
	$PHP_BIN artisan storage:link || echo '::warning title=storage:link failed::public/storage is not linked; uploaded files under storage/app/public will 404'
	$PHP_BIN artisan config:cache
	$PHP_BIN artisan view:cache
"

echo "▶ Maintenance mode off"
remote "$PHP_BIN artisan up"
maintenance=off

echo "▶ Smoke test $SITE_URL"
health=$(curl --silent --show-error --fail-with-body --retry 3 --retry-delay 5 --max-time 30 "$SITE_URL/v1/health") \
	|| { echo "Health check failed: $health" >&2; exit 1; }
[[ "$health" == *'"status":"ok"'* ]] || { echo "Unexpected health response: $health" >&2; exit 1; }
for secret_path in .env composer.json artisan vendor/autoload.php storage/logs/laravel.log; do
	code=$(curl --silent --output /dev/null --write-out '%{http_code}' --max-time 30 "$SITE_URL/$secret_path")
	[[ "$code" != 200 ]] || { echo "::error title=Project file is public::$SITE_URL/$secret_path returned 200 — check the root .htaccess" >&2; exit 1; }
done
echo "  health: $health; project files are not reachable"

{
	echo "### 🚀 Deployed to $SITE_URL"
	echo "- Files sent: **$transferred**, deleted: **$deleted** ($((SECONDS - started))s)"
	echo "- Health: \`$health\`"
	[[ "$first_deploy" == yes ]] && echo "- First deploy (no maintenance window needed)"
	echo
} >> "$summary"
