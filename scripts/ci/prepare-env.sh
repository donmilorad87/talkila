#!/usr/bin/env bash
# Writes throwaway .env files for the CI Docker stack from the committed .env.example templates.
# Only runs in CI (it overwrites .env files); secrets stay empty, so no real Stripe/Twilio/… calls can succeed.
set -euo pipefail
cd "$(dirname "$0")/../.."
[[ "${CI:-}" == "true" ]] || { echo "prepare-env.sh only runs in CI: it would overwrite your local .env files" >&2; exit 1; }

set_value() { # set_value <file> <KEY> <value>
	local file="$1" key="$2" value="$3"
	grep -q "^$key=" "$file" || { echo "$key not found in $file" >&2; exit 1; }
	sed -i "s|^$key=.*|$key=$value|" "$file"
}

cp .env.example .env
set_value .env DB_USERNAME talkila
set_value .env DB_PASSWORD talkila_secret
set_value .env DB_ROOT_PASSWORD talkila_root

app_env=talkila.backend/.env
cp talkila.backend/.env.example "$app_env"
set_value "$app_env" APP_KEY "base64:$(head -c 32 /dev/urandom | base64)"
set_value "$app_env" DB_USERNAME talkila
set_value "$app_env" DB_PASSWORD talkila_secret
set_value "$app_env" JWT_SECRET "$(head -c 32 /dev/urandom | base64 | tr -d '/+=')"
# No real Pusher in CI: broadcasts are written to the log instead.
set_value "$app_env" BROADCAST_DRIVER log
echo "CI .env files written"
