# Deploying Talkila

Production: **https://talkila.blazingsun.space** on Hostinger (PHP 8.5, MariaDB 11.8), deployed by GitHub Actions over SSH.

## How the pipeline works

| You do | GitHub runs | Deploys? |
|---|---|---|
| Open or update a pull request into `master` | 🔍 Lint (report-only), 🐳 Tests in Docker (PHPUnit API + web, Playwright E2E) | no |
| Push to `master`, or merge a PR (a merge *is* a push) | the same checks | no |
| Push a tag `vX.Y.Z` | the same checks, then 🏷️ Release check, then 🚀 Deploy | **yes** |

- **Tests run inside the project's Docker image** (PHP 8.5 + MariaDB 11.8 + nginx), the same stack as local development. The release bundle is built from that image right after the tests pass: the files that were tested are the files that ship.
- **Release check:** the tag must be `v` + the `"version"` in the root `package.json`, higher than every earlier release, and on a commit that is already on `master`.
- **Deploy** (`scripts/deploy.sh`):
  1. `php artisan down`: maintenance page (HTTP 503) for visitors
  2. `rsync` over SSH: **only changed files are sent**; files deleted from the project are deleted on the server
  3. package discovery, `migrate --force`, config and view caches
  4. `php artisan up`
  5. smoke test: `/v1/health` must answer `{"status":"ok","database":"ok"}`, and `.env`, `composer.json`, `artisan`, `vendor/` and logs must **not** be downloadable

  If anything fails after step 1, the site **stays in maintenance mode**, so it is never half-updated. Fix the cause and redeploy, or bring it back by hand (see [Troubleshooting](#troubleshooting)).

  Never uploaded and never deleted on the server: `.env`, `storage/` (logs, sessions, uploaded files), `public/assets/images/user/` (profile photos), `public/storage`.

---

## One-time setup

Do these steps once, in order. Steps 1–3 are needed before the first deploy can succeed.

### 1. Create the SSH deploy key

GitHub logs in to the server with a key, never with your password.

On your Linux machine:

```bash
ssh-keygen -t ed25519 -f ~/.ssh/talkila_deploy -C "github-actions-deploy" -N ""
cat ~/.ssh/talkila_deploy.pub      # the PUBLIC key, for hPanel
```

In **hPanel → Websites → blazingsun.space → Advanced → SSH Access → SSH keys → Add SSH key**: paste the whole line printed by `cat` and save.

Test it (must print `ok` without asking for a password):

```bash
ssh -i ~/.ssh/talkila_deploy -p 65002 u383076216@46.202.158.29 'echo ok'
```

The same key also works for the blazing_sun repository (same hosting account).

### 2. Add the variables and the secret in GitHub

Repository **donmilorad87/talkila → Settings → Secrets and variables → Actions**.

**Variables tab → New repository variable** (not secret):

| Name | Value |
|---|---|
| `SSH_HOST` | `46.202.158.29` |
| `SSH_PORT` | `65002` |
| `SSH_USER` | `u383076216` |
| `DEPLOY_PATH` | `domains/blazingsun.space/public_html/talkila` |

**Secrets tab → New repository secret**:

| Name | Value |
|---|---|
| `SSH_PRIVATE_KEY` | the **private** key: the whole output of `cat ~/.ssh/talkila_deploy`, including the `-----BEGIN OPENSSH PRIVATE KEY-----` and `-----END OPENSSH PRIVATE KEY-----` lines |

No FTP or database secrets are needed. The database password lives only in the server's `.env` (step 3).

Optional: **Settings → Environments → production → Required reviewers** makes every deploy wait for your click. **Settings → Branches → Add rule for `master`** with the *Tests in Docker* check required blocks merging broken PRs.

### 3. Create the production `.env` on the server

The deploy refuses to run until this file exists.

1. Copy the template: `cp deploy/production.env.example ~/talkila-production.env` (keep it **outside** the repository).
2. Fill it in:
   - `APP_KEY`: generate one with `docker compose exec laravel php artisan key:generate --show` and paste the output (`base64:…`). **Never change it later**: it encrypts sessions and stored data.
   - `DB_PASSWORD`: the password of the `u383076216_talkila` database user (hPanel → Databases). The database name, user and `DB_HOST=localhost` are already filled in.
   - `PUSHER_APP_ID`, `PUSHER_APP_KEY`, `PUSHER_APP_SECRET`, `PUSHER_APP_CLUSTER`: from step 6. Keep `PUSHER_HOST`, `PUSHER_PORT` and `PUSHER_SCHEME` **empty**. If your cluster is not `eu`, also change `SOCKET_SERVER_URL` / `SOCKET_SERVER_URL_SHORT` to `ws-<cluster>.pusher.com`.
   - `MAIL_USERNAME` / `MAIL_PASSWORD`: a mailbox from hPanel → Emails (for example `talkila@blazingsun.space`).
   - Stripe, PayPal, Twilio, Google, Facebook, …: copy the values from your local `talkila.backend/.env` for the features you want live (test keys are fine to start with).
3. Upload it and lock it down:

```bash
scp -P 65002 -i ~/.ssh/talkila_deploy ~/talkila-production.env \
    u383076216@46.202.158.29:domains/blazingsun.space/public_html/talkila/.env
ssh -p 65002 -i ~/.ssh/talkila_deploy u383076216@46.202.158.29 \
    'chmod 600 domains/blazingsun.space/public_html/talkila/.env'
```

**To change a value later:** edit `~/talkila-production.env`, upload it again with the same `scp` command, then rebuild the config cache:

```bash
ssh -p 65002 -i ~/.ssh/talkila_deploy u383076216@46.202.158.29 \
    'cd domains/blazingsun.space/public_html/talkila && php artisan config:cache'
```

### 4. Check the PHP version

**hPanel → Websites → blazingsun.space → Advanced → PHP Configuration**: **PHP 8.5** (already the case; the CLI used by the deploy and cron is also 8.5). The required extensions (`pdo_mysql`, `intl`, `gd`, `bcmath`, `exif`, `zip`) are enabled.

### 5. Add the cron jobs

**hPanel → Websites → blazingsun.space → Advanced → Cron Jobs → Custom**, both with "every minute" (`* * * * *`):

| Purpose | Command |
|---|---|
| Laravel scheduler (talk reminders, calendar sync, payouts, …) | `/usr/bin/php /home/u383076216/domains/blazingsun.space/public_html/talkila/artisan schedule:run` |
| Queue worker (e-mails, notifications) | `/usr/bin/php /home/u383076216/domains/blazingsun.space/public_html/talkila/artisan queue:work database --stop-when-empty --max-time=55 --tries=3` |

Shared hosting cannot keep a worker running permanently, so the queue worker starts every minute, empties the queue and exits.

### 6. Create the Pusher app (live call events)

Shared hosting cannot run the Reverb WebSocket server that Docker runs locally. Production uses **Pusher Channels** instead (same protocol, no code differences):

1. Sign up at <https://pusher.com> → **Channels → Create app**: name `talkila`, cluster **eu (Ireland)**, frontend "vanilla JS", backend "Laravel".
2. **App Keys** tab: copy `app_id`, `key`, `secret` and `cluster` into `PUSHER_APP_*` in the production `.env` (step 3) and re-upload.

### 7. First release

```bash
npm version 1.0.0 --no-git-tag-version   # only if package.json is not 1.0.0 already
git add -A && git commit -m "Release 1.0.0"
git tag v1.0.0
git push && git push --tags
```

Watch **Actions → 🚀 Release v1.0.0**. The first deploy uploads about 18,000 files (later deploys only send what changed).

Then, **once**, fill the empty database with the base data (roles, permissions, countries, categories, pages) and create the API token client:

```bash
ssh -p 65002 -i ~/.ssh/talkila_deploy u383076216@46.202.158.29
cd domains/blazingsun.space/public_html/talkila
php artisan db:seed --force
php artisan passport:client --personal --name="Talkila Personal Access Client" --provider=users --no-interaction
php artisan config:cache
```

⚠️ The seeder creates the admin **admin@admin.com / password**. Log in at https://talkila.blazingsun.space/login **immediately** and change that password (or the e-mail) in the admin panel.

### 8. External services

Update the URLs in each provider's dashboard to the production domain:

| Service | Setting |
|---|---|
| Stripe | Developers → Webhooks → endpoint `https://talkila.blazingsun.space/stripe/webhook`; put its signing secret in `STRIPE_WEBHOOK_SECRET` |
| Google (login + calendar) | OAuth client → Authorized redirect URIs: `https://talkila.blazingsun.space/auth/google/callback`, `https://talkila.blazingsun.space/auth/google/calendar` |
| Facebook, LinkedIn, Instagram, Twitter | redirect URLs as listed in `deploy/production.env.example` |
| Google Vision (image moderation, optional) | upload the service-account JSON to `domains/blazingsun.space/public_html/talkila/storage/app/google/` (never to `public/`) |

---

## Releasing (every time)

1. Merge your changes into `master` (each push runs the checks).
2. Bump the version and tag that commit:

```bash
npm version patch          # 1.0.0 → 1.0.1: updates package.json, commits and creates the tag v1.0.1
git push && git push --tags
```

Use `npm version minor` / `major` for bigger releases. The release check rejects a tag whose version does not match `package.json`, is not higher than the last release, or is not on `master`.

**Redeploy the same release** (for example after a temporary SSH failure): open the failed run and click **Re-run failed jobs**.

---

## Troubleshooting

| Symptom | Fix |
|---|---|
| Deploy fails with `.env is missing` | Do [step 3](#3-create-the-production-env-on-the-server) |
| Deploy fails with `Permission denied (publickey)` | The public key is not in hPanel → SSH keys, or `SSH_PRIVATE_KEY` is incomplete (it must include the BEGIN/END lines) |
| Deploy fails with `Host key verification failed` | Hostinger changed the server's SSH key. Compare the fingerprints in hPanel → SSH Access with `deploy/known_hosts` and update that file |
| Site shows the maintenance page after a failed deploy | Intentional. Fix the cause and redeploy, or: `ssh … 'cd domains/blazingsun.space/public_html/talkila && php artisan up'` |
| Smoke test: "Project file is public" | The root `.htaccess` (from `deploy/root.htaccess`) is missing or broken on the server: **check it immediately**, `.env` may be downloadable |
| HTTP 500 after deploy | `ssh …` then `tail -n 50 domains/blazingsun.space/public_html/talkila/storage/logs/laravel-$(date +%F).log` |
| E-mails are not sent | The queue cron job (step 5) is missing, or the `MAIL_*` values are wrong |

## Later: moving the database credentials into GitHub

Today the production `.env` is uploaded by hand (step 3). To manage it from GitHub instead:

1. Add a secret `PRODUCTION_ENV` whose value is the whole filled-in production `.env` file.
2. In `.github/workflows/ci-cd.yml`, pass it to the deploy step (`PRODUCTION_ENV: ${{ secrets.PRODUCTION_ENV }}`).
3. In `scripts/deploy.sh`, before "Package discovery", write it to the server:
   `printf '%s\n' "$PRODUCTION_ENV" | ssh "${ssh_opts[@]}" "$SSH_USER@$SSH_HOST" "cat > $DEPLOY_PATH/.env && chmod 600 $DEPLOY_PATH/.env"`.

The `.env` check at the start of the deploy then no longer applies.
