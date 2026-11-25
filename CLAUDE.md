# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Repository Overview

**Talkila** — a peer-to-peer marketplace for booking 1-on-1 video/voice calls with teachers and specialists. The original Twilio microservice (talkila.twiliobackend) has been merged into `talkila.backend/` and removed.

| Directory | Purpose |
|-----------|---------|
| `talkila.backend/` | Combined Laravel 12 app (main site + Twilio call server) |
| `Docker/` | Docker infrastructure (Nginx, Laravel, Postgres, configs) |

## Docker Development

```bash
# Start everything
docker compose up --build -d

# Served via ~/Desktop/gambling/reverse-proxy (talkila binds 127.0.0.8). Hosts: "192.168.0.109 talkila.local"
# App:          https://talkila.local
# pgAdmin:      https://talkila.local/pgadmin/   (admin@local.talkila.com / admin)
# Supervisord:  https://talkila.local/supervisor/ (admin / talkila)

# Run artisan inside container
docker compose exec laravel php artisan <command>

# Composer
docker compose exec laravel composer <command>

# Run tests
docker compose exec laravel vendor/bin/phpunit
docker compose exec laravel vendor/bin/phpunit --filter=TestClassName

# Migrations
docker compose exec laravel php artisan migrate
docker compose exec laravel php artisan db:seed

# Logs
docker compose logs -f laravel
docker compose logs -f nginx

# Rebuild after Dockerfile changes
docker compose up --build -d
```

### Docker Architecture

- **Nginx** — SSL termination (self-signed for local.talkila.com), reverse proxy to PHP-FPM, pgAdmin, Supervisord, and WebSockets
- **Laravel** (PHP 8.4-FPM) — Supervisord manages: php-fpm, 2x queue workers (Redis), scheduler (every minute), Reverb WebSocket server (port 6001)
- **PostgreSQL 16** — Database (migrated from MySQL; DB_CONNECTION=pgsql)
- **Redis 7** — Cache, sessions, queue
- **pgAdmin** — Database management UI

## Common Commands

```bash
# Frontend assets
docker compose exec laravel npm run dev
docker compose exec laravel npm run build

# Swagger API docs
docker compose exec laravel php artisan l5-swagger:generate

# WebSocket server (managed by supervisord, but manual start)
docker compose exec laravel php artisan reverb:start

# Queue
docker compose exec laravel php artisan queue:work redis
```

### Code Style

StyleCI with Laravel preset (`.styleci.yml`). No local linter configured.

## Architecture

### Tech Stack

- **Laravel 12.53** on **PHP 8.4**
- **PostgreSQL 16** (migrated from MySQL)
- **Redis 7** for cache/queue/sessions
- **Laravel Reverb** for WebSockets (replaced beyondcode/laravel-websockets)
- **Spatie MediaLibrary v11** for file/image uploads
- **OpCodes Log Viewer v3** (replaced arcanedev/log-viewer)

### Route System

Routes loaded via `RouteServiceProvider::map()`:

| File | Middleware | Purpose |
|------|-----------|---------|
| `routes/api.php` | `api` | REST API v1 + Twilio routes (`v1/twilio/*`) |
| `routes/auth.php` | `web` | Login, register, OAuth, password reset |
| `routes/admin.php` | `web, auth, role:Admin` | Admin dashboard & CRUD |
| `routes/affiliates.php` | `web, auth, role:Affiliate` | Affiliate management |
| `routes/private.php` | `web, auth, role:Student\|Teacher\|Affiliate` | Authenticated user actions |
| `routes/public.php` | `web` | Public pages |
| `routes/frontend-api.php` | `web` | Frontend AJAX endpoints |
| `routes/web.php` | `web` | Blade view routes |

### Twilio Routes (merged from twiliobackend)

All under `v1/twilio/` prefix with `auth:api` middleware:

| Method | Endpoint | Handler |
|--------|----------|---------|
| POST | `/v1/twilio/socket-event` | `TwilioController@handleEvents` |
| POST | `/v1/twilio/room-status` | `TwilioController@roomStatus` |
| POST | `/v1/twilio/network-quality` | `SocketNetworkQualityController@store` |
| POST | `/v1/twilio/user-rooms` | `TwilioController@userRooms` |

### Controller Namespaces

- `Api\V1\Admin\*` — Admin API (CRUD for users, talks, categories, reports)
- `Api\V1\Auth\*` — Authentication (login, register, social auth)
- `Api\V1\FrontendApiCalls\*` — Frontend-specific API
- `Admin\*` — Admin Blade view controllers
- `TwilioController` — Call lifecycle (root namespace, merged from twiliobackend)
- `Socket*Controller` — Socket room/participant/protocol/quality helpers

### Model Layer

- **78 models** in `app/Models/`
- `app/ModelsApi/` — API-specific model variants
- Key: `User`, `Talk`, `Booking`, `Feedback`, `Availability`, `Wallet`, `SocketRoom`, `SocketParticipant`

### Entity Classes (Value Objects & Services)

`app/Entity/` contains typed constants and service wrappers:
- **Enums**: `CallTypes`, `TalkTypes`, `UserTypes`, `StateTypes`, `RoomStates`, `ParticipantStates`, `Events` (50+ call events), `NetworkQualityLevels`
- **Services**: `Twilio.php` (SDK wrapper: rooms, tokens, kick, SMS), `Notification.php` (Firebase + APNS push)
- **Domain**: `CancellationReasons`, `PaymentTypes`, `SocialProviders`, `UserRoles`

### Scheduled Commands

Defined in `app/Console/Kernel.php`:
- Every minute: `check_talk_start_time_one_minute`, `check_talk_start_time_ten_minutes`, `calendar:fetch`, `notify:duration`, `start:newroom`
- Every 30 min: `remove:not_verified_users`
- Daily: `static:metric`, `update:users_inactive`, `calendar:sync`

### Event-Driven Architecture

Pattern: **Event → Job → Mail**

- 22 broadcast events in `app/Events/` (call lifecycle + screen share + raise hand)
- 22 queued jobs in `app/Jobs/`
- 47 mail classes in `app/Mail/`
- Broadcasting via Laravel Reverb (self-hosted WebSocket server on port 6001)
- Channel: `room.{roomId}` for live call state updates

### Key Integrations

- **Twilio** — Video rooms, JWT tokens, participant management, SMS
- **Stripe/PayPal/Adyen** — Payment gateways + wallet/coins system
- **Google Calendar** — Teacher availability sync
- **Socialite** — Google, Facebook, Apple, LinkedIn, Instagram OAuth
- **Firebase + APNS** — Push notifications (Android + iOS VoIP)
- **Spatie Media Library v11** — File/image uploads
- **Laravel Reverb** — Self-hosted WebSocket server

### Call Flow

1. User creates **Booking** (pays, selects time slot)
2. Frontend calls `POST /v1/twilio/socket-event` to prepare the call
3. `TwilioController` creates SocketRoom, Twilio video room + JWT tokens
4. Participants join; all events flow through `handleEvents()`
5. Events broadcast via WebSockets to connected clients
6. On call end, email notifications sent

## Key Environment Variables

- `DB_CONNECTION=pgsql`, `DB_HOST=postgres` — PostgreSQL via Docker
- `REDIS_HOST=redis` — Redis for cache/queue/sessions
- `TWILIO_ACCOUNT_SID`, `TWILIO_AUTH_TOKEN`, `TWILIO_API_SID`, `TWILIO_API_SECRET`
- `STRIPE_KEY`, `STRIPE_SECRET`, `PAYPAL_*`
- `GOOGLE_*`, `FACEBOOK_*`, `APPLE_*`, `LINKEDIN_*` — Social OAuth
- `FIREBASE_ACCESS_KEY`, `APNS_TOPIC`, `APNS_CERT_NAME` — Push notifications
- `PUSHER_*` — WebSocket config (Laravel Reverb server)

## Database Notes

- **PostgreSQL 16** (migrated from MySQL). Migrations directory is currently empty — fresh migrations need to be created.
- Raw SQL in controllers still uses MySQL-specific functions (`IF()`, `DATE_FORMAT()`, `CONVERT_TZ()`, `CAST AS DOUBLE`) — these need PostgreSQL equivalents before those routes work.
- Affected files: ~15 admin controllers, 3 models (`User`, `Talk`, `Payout`).

## PSR-4 Warnings

Several files in `app/Virtual/Resources/` have typos in filenames (`Rersource.php` instead of `Resource.php`). Also:
- `app/Http/TokenController.php` — misplaced (should be in Controllers/)
- `app/Http/Controllers/Admin/NotificationsController.php.php` — double `.php` extension

## Stripe Webhooks (local)

```bash
stripe login
stripe listen --forward-to https://talkila.local/stripe/webhook --skip-verify
```
