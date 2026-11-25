# Talkila — Deployment Guide

Everything about getting Talkila to production and keeping it there: the pipeline, the first deployment from zero, everyday releases, database migrations, seeders, maintenance mode, backups, rollbacks and troubleshooting.

**Production:** https://talkila.blazingsun.space · Hostinger shared hosting · PHP 8.5 · MariaDB 11.8 · deployed by GitHub Actions over SSH.

## Contents

1. [How it fits together](#1-how-it-fits-together)
2. [The CI/CD pipeline](#2-the-cicd-pipeline)
3. [Deploying from zero (first deployment)](#3-deploying-from-zero-first-deployment)
4. [Everyday workflow](#4-everyday-workflow)
5. [Releasing a new version (a new deploy)](#5-releasing-a-new-version-a-new-deploy)
6. [Database migrations](#6-database-migrations)
7. [Seeders](#7-seeders)
8. [Maintenance mode and downtime](#8-maintenance-mode-and-downtime)
9. [The production `.env`](#9-the-production-env)
10. [Cron jobs](#10-cron-jobs)
11. [Backups and restore](#11-backups-and-restore)
12. [Rolling back a bad release](#12-rolling-back-a-bad-release)
13. [Logs and debugging](#13-logs-and-debugging)
14. [Troubleshooting](#14-troubleshooting)
15. [Reference](#15-reference)

All server commands below use this login (set up in [step 3.1](#31-ssh-deploy-key)):

```bash
ssh -p 65002 -i ~/.ssh/talkila_deploy u383076216@46.202.158.29
cd domains/blazingsun.space/public_html/talkila      # the project folder on the server
```

---

## 1. How it fits together

```
Your machine                     GitHub                                   Hostinger
─────────────                    ──────                                   ─────────
git push master   ───────────▶   checks: lint, API, web, E2E      (never deploys)
git push tag v1.2.3 ─────────▶   checks ─▶ release check ─▶ bundle ─▶ deploy ──SSH──▶ domains/blazingsun.space/
                                                                                       public_html/talkila/
```

On the server, the project folder is the **whole Laravel project**, and the subdomain's document root points at it:

```
public_html/talkila/
├── .htaccess          ← from deploy/root.htaccess: rewrites every request into public/
├── .env               ← production settings, created by you, never touched by deploys
├── public/            ← the only folder visitors can reach
├── app/ config/ routes/ resources/ database/ vendor/ …   ← unreachable from the web
└── storage/           ← logs, sessions, cache, uploaded files — never touched by deploys
```

`public_html/` also contains the separate **blazingsun.space** site. Talkila's deploy only ever writes inside `public_html/talkila/`, and blazingsun.space's rules never apply inside it.

---

## 2. The CI/CD pipeline

Defined in `.github/workflows/ci-cd.yml`. Every run shows these jobs, each as its own box in **Actions**:

| Job | What it does | Runs on |
|---|---|---|
| 🔍 **Lint (report-only)** | ESLint + Stylelint over `talkila.backend/public`; findings are listed in the summary but never fail the build | every run |
| 🐳 **Build Docker image** | builds the PHP 8.5 image from `Docker/Laravel/Dockerfile`, or reuses it from the cache if nothing changed | every run |
| 🧪 **PHPUnit — API** | starts the full Docker stack (nginx, Laravel, MariaDB 11.8, Redis), migrates + seeds, runs `tests/Feature/Api` | every run, in parallel |
| 🌐 **PHPUnit — web routes** | same stack, runs `tests/Feature/Web` | every run, in parallel |
| 🎭 **E2E (Playwright)** | same stack, opens the site in Chromium (desktop + mobile), runs `tests/e2e` | every run, in parallel |
| 🏷️ **Release check** | the tag must be `v` + `package.json` version, higher than every earlier release, and on `master` | tags only |
| 📦 **Release bundle** | after all tests pass: git-tracked files + `composer install --no-dev`, built with the **same image** the tests used | tags only |
| 🚀 **Deploy** | uploads the bundle to production (see [section 5](#5-releasing-a-new-version-a-new-deploy)) | tags only |

| You do | Result |
|---|---|
| Open / update a pull request into `master` | checks only |
| Push to `master` or merge a PR (a merge **is** a push) | checks only |
| Push a tag `vX.Y.Z` | checks → release check → bundle → **deploy** |
| Actions → CI/CD → **Run workflow** on a tag | redeploys that release |

---

## 3. Deploying from zero (first deployment)

What it takes to bring Talkila up on an empty server. **For talkila.blazingsun.space all of this is already done.** Use it again if you ever move hosts or rebuild the server.

### 3.1 SSH deploy key

GitHub logs in with a key, never with the hosting password.

```bash
ssh-keygen -t ed25519 -f ~/.ssh/talkila_deploy -C "github-actions-deploy" -N ""
cat ~/.ssh/talkila_deploy.pub
```

Add the printed line in **hPanel → Websites → blazingsun.space → Advanced → SSH Access → SSH keys** (or append it to `~/.ssh/authorized_keys` on the server). Test, which must print `ok` without a password prompt:

```bash
ssh -i ~/.ssh/talkila_deploy -p 65002 u383076216@46.202.158.29 'echo ok'
```

### 3.2 GitHub variables and secret

**github.com/donmilorad87/talkila → Settings → Secrets and variables → Actions**

| Name | Type | Value |
|---|---|---|
| `SSH_PRIVATE_KEY` | secret | whole output of `cat ~/.ssh/talkila_deploy`, including the `-----BEGIN` / `-----END` lines |
| `SSH_HOST` | variable | `46.202.158.29` |
| `SSH_PORT` | variable | `65002` |
| `SSH_USER` | variable | `u383076216` |
| `DEPLOY_PATH` | variable | `domains/blazingsun.space/public_html/talkila` |

The server's SSH host keys are pinned in `deploy/known_hosts`: the deploy refuses to connect to anything else.

### 3.3 Production `.env`

The deploy refuses to run until `.env` exists on the server. Start from `deploy/production.env.example` (or a copy of your local `.env` with production values), keep your copy **outside** the repository (e.g. `~/talkila-production.env`), then:

```bash
scp -P 65002 -i ~/.ssh/talkila_deploy ~/talkila-production.env \
    u383076216@46.202.158.29:domains/blazingsun.space/public_html/talkila/.env
ssh -p 65002 -i ~/.ssh/talkila_deploy u383076216@46.202.158.29 \
    'chmod 600 domains/blazingsun.space/public_html/talkila/.env'
```

What must be set is described in [section 9](#9-the-production-env).

### 3.4 Hosting settings

- **hPanel → Advanced → PHP Configuration:** PHP **8.5** with `pdo_mysql`, `intl`, `gd`, `bcmath`, `exif`, `zip` (all enabled on this plan).
- **hPanel → Databases:** database and user `u383076216_talkila`. The deploy creates the tables.
- **SSL** for `talkila.blazingsun.space`: hPanel → Security → SSL.

### 3.5 First release

```bash
git push origin master            # wait for the green run in Actions
git tag v1.0.0                     # must equal "version" in package.json
git push origin v1.0.0             # → 🚀 Release v1.0.0
```

The first deploy uploads about 18,000 files. It skips maintenance mode (there is no running site yet), runs all migrations on the empty database, and creates the API signing keys (`storage/oauth-*.key`).

### 3.6 One-time data setup (right after the first deploy)

```bash
php artisan db:seed --force
php artisan passport:client --personal --name="Talkila Personal Access Client" --provider=users --no-interaction
php artisan config:cache
```

- `db:seed` fills roles, permissions, countries, categories, pages and the admin user. See [section 7](#7-seeders) and **never run it twice**.
- `passport:client` creates the client that issues login tokens. Without it, every login fails with HTTP 500.

Then **log in at https://talkila.blazingsun.space/login as `admin@admin.com` / `password` and change the password immediately.**

### 3.7 Cron jobs and external services

Add the two cron jobs from [section 10](#10-cron-jobs), then point external services at the production domain:

| Service | Setting |
|---|---|
| Stripe | Webhook endpoint `https://talkila.blazingsun.space/stripe/webhook` → its signing secret into `STRIPE_WEBHOOK_SECRET` |
| Google, Facebook, LinkedIn, Instagram, Twitter | OAuth redirect URLs on `https://talkila.blazingsun.space/...` (the exact list is in `.env`, `*_REDIRECT*`) |
| Pusher | the app keys are in `.env` (`PUSHER_APP_*`, cluster `eu`) |
| Google Vision (optional) | service-account JSON into `storage/app/google/` on the server, never into `public/` |

---

## 4. Everyday workflow

```
feature branch ──PR──▶ master ──(checks)──▶ … more merges … ──npm version + tag──▶ production
```

1. Work on a branch; run the stack locally (`docker compose up -d`) and the tests (`README.md` → Testing).
2. Open a pull request into `master`. The checks run on every push to the PR.
3. Merge when green. `master` collects tested changes; **nothing is deployed** yet.
4. When you want those changes live, release ([section 5](#5-releasing-a-new-version-a-new-deploy)).

---

## 5. Releasing a new version (a new deploy)

### Commands

```bash
git checkout master && git pull
npm version patch            # bug fixes:        1.0.0 → 1.0.1
#   npm version minor        # new features:     1.0.1 → 1.1.0
#   npm version major        # breaking changes: 1.1.0 → 2.0.0
git push origin master
git push origin --tags
```

`npm version` bumps `"version"` in `package.json`, commits it and creates the matching tag `vX.Y.Z`. Pushing the tag starts **🚀 Release vX.Y.Z** in Actions.

### What the deploy does

`scripts/deploy.sh`, after every test has passed:

| # | Step | Detail |
|---|---|---|
| 1 | Check the server | `.env` must exist |
| 2 | **Maintenance on** | `php artisan down`: visitors get a 503 "back soon" page |
| 3 | **Upload only what changed** | `rsync --checksum` compares every file and sends only new or changed ones. Files deleted from the project are deleted on the server. `.env`, `storage/`, `public/assets/images/user/`, `public/storage` are never sent and never deleted. |
| 4 | Laravel steps | `package:discover`, `optimize:clear`, **`migrate --force`**, API keys if missing, `storage:link`, `config:cache`, `view:cache` |
| 5 | **Maintenance off** | `php artisan up` |
| 6 | Smoke test | `/v1/health` must return `{"status":"ok","database":"ok"}`, and `.env`, `composer.json`, `artisan`, `vendor/autoload.php`, `storage/logs/laravel.log` must **not** be downloadable |

The run's **Summary** tab shows how many files were sent and deleted, plus the health result.

### Redeploying

- **Same release again** (e.g. after an SSH timeout): open the failed run → **Re-run failed jobs**.
- Only the **newest** release can be deployed. Older tags are rejected, so nobody rolls back by accident ([section 12](#12-rolling-back-a-bad-release)).

---

## 6. Database migrations

Migrations live in `talkila.backend/database/migrations/`. **The deploy runs `php artisan migrate --force` automatically**: every new migration in a release is applied to production during step 4, while the site is in maintenance mode.

### Adding a migration

```bash
docker compose exec -u www-data laravel php artisan make:migration add_bio_to_teachers_table
# edit the new file in talkila.backend/database/migrations/
docker compose exec -u www-data laravel php artisan migrate          # apply locally
docker compose exec -u www-data laravel php artisan migrate:rollback # check down() works
docker compose exec -u www-data laravel php artisan migrate          # and up() again
```

Commit it, merge, release. The CI tests run every migration on a fresh MariaDB 11.8 (the production engine), so a migration that cannot run fails the build before it can reach production.

### Rules

- **Never edit a migration that is already in production.** Production has recorded it as done and will not run it again. Write a new migration instead.
- **Use the schema builder, not raw SQL** (`$table->string(...)`, `->change()`, …). It works on MariaDB locally, in CI and in production.
- **Prefer additive changes:** new tables, new nullable columns, columns with defaults. Renaming or dropping a column the current code still uses breaks the site for the seconds between migration and new code; do it in two releases (stop using it → drop it).
- **Back up before risky migrations** (dropping or converting data): [section 11](#11-backups-and-restore).

### Checking and running by hand

```bash
php artisan migrate:status                 # Ran / Pending for every migration
php artisan migrate --force                # apply pending migrations (the deploy does this)
php artisan migrate:rollback --step=1 --force   # undo the last migration — only if its down() is safe
```

**Never run `migrate:fresh`, `migrate:reset` or `db:wipe` in production**: they delete every table and all data.

---

## 7. Seeders

Seeders fill tables with data the application needs. They live in `talkila.backend/database/seeders/`; `DatabaseSeeder` runs 27 of them in order:

| Group | Seeders |
|---|---|
| Access control | `Permissions`, `Roles`, `PermissionRole`, `RoleUser`, `RoleAffiliate` |
| Users | `UsersTableSeeder`: the admin **admin@admin.com / password**, `BillingAddresses`, `Partner` |
| Reference data | `Countries`, `CountriesVAT`, `VAT`, `FinanceCurrencies`, `Languages` (+ Polish), `DisposalDomains`, `StaticForbiddenNames`, `StaticProfessions`, `ReportReasons` |
| Content | `TalkCategories`, `TalkSubCategories`, `TalkSubCategoriesOther` (+ Polish), `CallsCancellationReasons` (+ Polish), `StaticPages`, `Page` |

### Locally

```bash
docker compose exec -u www-data laravel php artisan migrate:fresh --seed   # wipe and rebuild the LOCAL database
docker compose exec -u www-data laravel php artisan db:seed --class=CountriesTableSeeder   # one seeder
```

### In production

- `db:seed` ran **once**, at the first deployment ([3.6](#36-one-time-data-setup-right-after-the-first-deploy)). **The deploy never runs seeders.**
- **Do not run `db:seed` again.** Most seeders insert rows with fixed IDs, so a second run stops with `Duplicate entry '1' for key 'PRIMARY'`. Worse, the admin seeder would try to recreate the admin account.

### Adding new seed data later

For example, a new talk category or a new country:

1. Create a dedicated seeder: `docker compose exec -u www-data laravel php artisan make:seeder AddHealthCategorySeeder`
2. Make it **safe to run more than once**: use `updateOrCreate` / `firstOrCreate` keyed on a natural key, never a hard-coded `insert`:

   ```php
   TalkCategory::updateOrCreate(['slug' => 'health'], ['name' => 'Health', 'active' => 1]);
   ```

3. Test locally, commit, release.
4. After the deploy, run **only that seeder** on the server:

   ```bash
   php artisan db:seed --class=AddHealthCategorySeeder --force
   ```

Alternatively, put the data change in a **migration** (`DB::table(...)->updateOrInsert(...)` in `up()`). It then runs automatically with the deploy, exactly once.

---

## 8. Maintenance mode and downtime

### During a deploy

The deploy switches maintenance on before uploading and off after migrating. Visitors see Laravel's 503 page with `Retry-After: 60`; the window is usually **10–60 seconds**, mostly migrations and cache rebuilds, because rsync only sends what changed.

The first deployment ("from zero") has no maintenance window: there is no running site to protect yet.

### Zero-downtime?

This setup is **not** zero-downtime: there is a short, deliberate maintenance window so visitors never hit a half-updated site (new files with old database, or the reverse). That is the right trade-off for shared hosting. If true zero-downtime is ever needed, the usual approach is *atomic releases*: upload each release into its own folder (`releases/v1.2.3/`), run migrations, then switch a `current` symlink in one step. It requires backward-compatible migrations (section 6 rules) and a document root that follows the symlink. It is not set up today.

### If a deploy fails

If anything fails after maintenance is switched on, **the site stays in maintenance** and the run fails with *"Deploy failed — site left in maintenance mode"*. That is intentional. Then:

1. Read the failed step's log in Actions and fix the cause.
2. Release a new version, or re-run the job, **or** bring the site back by hand:

   ```bash
   php artisan up
   ```

### By hand

```bash
php artisan down --retry=60                    # maintenance on
php artisan down --secret=my-bypass-phrase     # on, but https://talkila.blazingsun.space/my-bypass-phrase lets YOU in
php artisan up                                 # maintenance off
```

---

## 9. The production `.env`

Lives only on the server (`public_html/talkila/.env`, permissions `600`) and in your private copy `~/talkila-production.env`. It is **never** in git, and deploys never upload or delete it.

| Setting | Production value |
|---|---|
| `APP_ENV` / `APP_DEBUG` | `production` / `false` |
| `APP_URL`, `APP_FRONTEND_URL`, `APP_BACKEND_URL`, `APP_BACKEND_ADMIN_URL` | `https://talkila.blazingsun.space` (…`/v1`, …`/admin`) — e-mail links are built from `APP_FRONTEND_URL` |
| `APP_KEY` | generated once; **never change it** (it encrypts sessions and stored data) |
| `DB_HOST` / `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` | `localhost` / `u383076216_talkila` / `u383076216_talkila` / the database password (in single quotes) |
| `CACHE_DRIVER` / `SESSION_DRIVER` / `QUEUE_CONNECTION` | `file` / `file` / `database`: there is no Redis on shared hosting |
| `SESSION_DOMAIN` / `SESSION_SECURE_COOKIE` | `talkila.blazingsun.space` / `true` |
| `BROADCAST_DRIVER`, `PUSHER_APP_*` | `pusher`, cluster `eu`; keep `PUSHER_HOST`, `PUSHER_PORT`, `PUSHER_SCHEME` **empty** |
| `SOCKET_SERVER_URL_SHORT` / `SOCKET_SERVER_PORT` | `ws-eu.pusher.com` / `443` (where browsers connect for live call events) |
| `MAIL_*` | a real mailbox (hPanel → Emails) for delivered e-mail; a Mailtrap sandbox only catches mail |
| Stripe, PayPal, Twilio, Google, Facebook, Firebase, … | your service keys |

### Changing a value

```bash
nano ~/talkila-production.env
scp -P 65002 -i ~/.ssh/talkila_deploy ~/talkila-production.env \
    u383076216@46.202.158.29:domains/blazingsun.space/public_html/talkila/.env
ssh -p 65002 -i ~/.ssh/talkila_deploy u383076216@46.202.158.29 \
    'cd domains/blazingsun.space/public_html/talkila && chmod 600 .env && php artisan config:cache'
```

`config:cache` matters: Laravel reads the cached configuration, not `.env`, until you rebuild it. Every deploy rebuilds it too.

### Later: managing it from GitHub

Store the whole file as a secret `PRODUCTION_ENV`, pass it to the deploy step, and in `scripts/deploy.sh` (before "Package discovery") write it to the server with
`printf '%s\n' "$PRODUCTION_ENV" | ssh "${ssh_opts[@]}" "$SSH_USER@$SSH_HOST" "cat > $DEPLOY_PATH/.env && chmod 600 $DEPLOY_PATH/.env"`.

---

## 10. Cron jobs

**hPanel → Websites → blazingsun.space → Advanced → Cron Jobs → Custom**, both **every minute** (`* * * * *`):

| Purpose | Command |
|---|---|
| Scheduler: talk reminders, call duration, starting rooms, calendar sync, cleanup, payouts | `/usr/bin/php /home/u383076216/domains/blazingsun.space/public_html/talkila/artisan schedule:run >> /dev/null 2>&1` |
| Queue worker: e-mails and notifications | `/usr/bin/php /home/u383076216/domains/blazingsun.space/public_html/talkila/artisan queue:work database --stop-when-empty --max-time=55 --tries=3 >> /dev/null 2>&1` |

Shared hosting cannot keep a worker running, so a worker starts every minute, empties the queue and exits within 55 seconds. Check:

```bash
php artisan schedule:list                  # tasks and their next run
php artisan queue:monitor database:default # queue size: should be 0 or falling
php artisan queue:failed                   # jobs that failed 3 times
php artisan queue:retry all                # retry them after fixing the cause
```

---

## 11. Backups and restore

Hostinger keeps automatic backups (hPanel → Files → Backups). Take your own before risky releases:

```bash
# database → a file on your machine
ssh -p 65002 -i ~/.ssh/talkila_deploy u383076216@46.202.158.29 \
    'MYSQL_PWD="<db password>" mysqldump -h localhost -u u383076216_talkila --single-transaction u383076216_talkila' \
    | gzip > talkila-db-$(date +%F-%H%M).sql.gz

# uploaded files → a file on your machine
ssh -p 65002 -i ~/.ssh/talkila_deploy u383076216@46.202.158.29 \
    'cd domains/blazingsun.space/public_html/talkila && tar -cz storage/app public/assets/images/user' \
    > talkila-uploads-$(date +%F-%H%M).tar.gz
```

Restore a database backup (this **replaces** the current data; put the site in maintenance first):

```bash
gunzip -c talkila-db-2026-11-26-1200.sql.gz | ssh -p 65002 -i ~/.ssh/talkila_deploy u383076216@46.202.158.29 \
    'MYSQL_PWD="<db password>" mysql -h localhost -u u383076216_talkila u383076216_talkila'
```

---

## 12. Rolling back a bad release

The release check only allows versions **higher** than the last one, so a rollback is a **new release containing the old code**:

```bash
git revert <bad-commit>        # or several; creates commits that undo the change
git push origin master         # wait for green checks
npm version patch && git push origin master && git push origin --tags
```

If the bad release ran a migration that changed or deleted data, also restore the database backup ([section 11](#11-backups-and-restore)). If the site is broken right now and you need a moment: `php artisan down` while you prepare the fix.

---

## 13. Logs and debugging

```bash
tail -n 100 storage/logs/laravel-$(date +%F).log          # today's application log
grep -h "\.ERROR" storage/logs/laravel-*.log | tail -20   # recent errors
php artisan about                                         # PHP/Laravel versions, drivers, cache state
curl -s https://talkila.blazingsun.space/v1/health         # {"status":"ok","database":"ok"}
```

In GitHub: every job writes a **Summary** (test results, lint counts, files deployed). Failed E2E runs upload a **playwright-report** artifact with screenshots and traces.

---

## 14. Troubleshooting

| Symptom | Cause / fix |
|---|---|
| Deploy: `.env is missing` | Create it: [3.3](#33-production-env) |
| Deploy: `Permission denied (publickey)` | Public key not on the server, or `SSH_PRIVATE_KEY` incomplete (must include the BEGIN/END lines) |
| Deploy: `Host key verification failed` | The server's SSH key changed. Compare with hPanel → SSH Access fingerprints and update `deploy/known_hosts` |
| Release check: `package.json at this tag says …` | Tag and version differ: use `npm version …` to create the tag |
| Release check: `must be higher than vX.Y.Z` | Bump the version; older versions cannot be deployed |
| Release check: `not on master` | Merge into `master` first, then tag that commit |
| Site shows the maintenance page | A deploy failed on purpose (section 8): fix and redeploy, or `php artisan up` |
| Smoke test: "Project file is public" | `.htaccess` in the project root is missing or broken. **Check immediately**, `.env` may be downloadable |
| HTTP 500 everywhere | Read the log (section 13). Typical: wrong DB password in `.env`, or `config:cache` not rebuilt after an `.env` change |
| Login fails with HTTP 500 | Passport client missing: `php artisan passport:client --personal …` ([3.6](#36-one-time-data-setup-right-after-the-first-deploy)) |
| E-mails not sent | Queue cron missing (section 10), or `MAIL_*` wrong; check `php artisan queue:failed` |
| `Duplicate entry … for key 'PRIMARY'` after `db:seed` | Seeders were run twice; nothing was changed. See [section 7](#7-seeders) |
| Live call events do not arrive | `BROADCAST_DRIVER=pusher`, `PUSHER_APP_*` set, `PUSHER_HOST` empty, then `config:cache` |

---

## 15. Reference

| File | Purpose |
|---|---|
| `.github/workflows/ci-cd.yml` | the pipeline |
| `.github/actions/start-stack/action.yml` | shared step: start the Docker stack with a seeded database for a test job |
| `scripts/build-release.sh` | builds the release bundle (`release/`) |
| `scripts/deploy.sh` | the deploy (maintenance, rsync, migrate, smoke test) |
| `scripts/ci/check-release.sh` | the release rules (tested by `tests/ci/check-release.test.sh`) |
| `scripts/ci/prepare-env.sh` | throwaway `.env` files for CI (refuses to run outside CI) |
| `deploy/root.htaccess` | becomes `.htaccess` in the project root on the server |
| `deploy/known_hosts` | pinned SSH host keys of the server |
| `deploy/production.env.example` | template for the production `.env` |
| `package.json` → `"version"` | the release version |
