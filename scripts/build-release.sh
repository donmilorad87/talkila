#!/usr/bin/env bash
# Builds the production bundle that scripts/deploy.sh uploads:
#   - the files of talkila.backend tracked by git at HEAD (never .env, uploads, logs or local node_modules)
#   - production composer dependencies, installed with the same PHP 8.5 Docker image the tests ran in
#   - deploy/root.htaccess as the bundle's .htaccess (serves the app from public/)
# Usage: scripts/build-release.sh [output-dir]   (default: release)   Env: PHP_IMAGE (default talkila-laravel:ci)
set -euo pipefail
cd "$(dirname "$0")/.."

out="${1:-release}"
image="${PHP_IMAGE:-talkila-laravel:ci}"

docker image inspect "$image" > /dev/null 2>&1 \
	|| { echo "Docker image $image not found: build it first (docker build -f Docker/Laravel/Dockerfile -t $image .)" >&2; exit 1; }

rm -rf "$out"
mkdir -p "$out"
git archive --format=tar HEAD talkila.backend | tar -x -C "$out" --strip-components=1
cp deploy/root.htaccess "$out/.htaccess"

# --no-scripts: package discovery needs a booted app; deploy.sh runs it on the server after the upload.
docker run --rm -u "$(id -u):$(id -g)" -e COMPOSER_HOME=/tmp/composer -v "$PWD/$out:/app" -w /app "$image" \
	composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-scripts

for required in artisan .htaccess public/index.php public/.htaccess vendor/autoload.php; do
	[[ -f "$out/$required" ]] || { echo "Release bundle is incomplete: $required is missing" >&2; exit 1; }
done
[[ ! -e "$out/.env" ]] || { echo "Release bundle must not contain .env" >&2; exit 1; }

files=$(find "$out" -type f | wc -l)
echo "Release bundle ready in $out/: $files files, $(du -sh "$out" | cut -f1)"
