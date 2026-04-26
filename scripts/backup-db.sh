#!/usr/bin/env bash
set -euo pipefail

# Laravel DB backup (MySQL/MariaDB) using .env credentials.
# Output: storage/backups/db/<db>_<timestamp>.sql.gz

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
ENV_FILE="${ENV_FILE:-$ROOT_DIR/.env}"
BACKUP_DIR="${BACKUP_DIR:-$ROOT_DIR/storage/backups/db}"
KEEP_DAYS="${KEEP_DAYS:-14}"

if [[ ! -f "$ENV_FILE" ]]; then
  echo "ERROR: .env not found at: $ENV_FILE" >&2
  exit 1
fi

read_env() {
  local key="$1"
  # Reads KEY=VALUE lines; strips surrounding quotes.
  local line value
  line="$(grep -m1 -E "^${key}=" "$ENV_FILE" || true)"
  value="${line#*=}"
  value="${value%$'\r'}"
  value="${value%\"}"; value="${value#\"}"
  value="${value%\'}"; value="${value#\'}"
  echo -n "$value"
}

DB_CONNECTION="$(read_env DB_CONNECTION)"
DB_HOST="$(read_env DB_HOST)"
DB_PORT="$(read_env DB_PORT)"
DB_DATABASE="$(read_env DB_DATABASE)"
DB_USERNAME="$(read_env DB_USERNAME)"
DB_PASSWORD="$(read_env DB_PASSWORD)"

if [[ "$DB_CONNECTION" != "mysql" ]]; then
  echo "ERROR: DB_CONNECTION must be mysql (got: $DB_CONNECTION)" >&2
  exit 1
fi

if [[ -z "$DB_DATABASE" || -z "$DB_USERNAME" ]]; then
  echo "ERROR: Missing DB_DATABASE / DB_USERNAME in .env" >&2
  exit 1
fi

mkdir -p "$BACKUP_DIR"

ts="$(date -u +'%Y%m%dT%H%M%SZ')"
out="${BACKUP_DIR}/${DB_DATABASE}_${ts}.sql.gz"

echo "Backing up '${DB_DATABASE}' to: $out"

pw_arg=()
if [[ -n "$DB_PASSWORD" ]]; then
  pw_arg=( -p"$DB_PASSWORD" )
fi

mysqldump \
  --host="$DB_HOST" \
  --port="${DB_PORT:-3306}" \
  --user="$DB_USERNAME" \
  "${pw_arg[@]}" \
  --single-transaction \
  --quick \
  --routines \
  --triggers \
  --events \
  --default-character-set=utf8mb4 \
  "$DB_DATABASE" \
  | gzip -9 > "$out"

echo "Backup OK: $out"

# Retention cleanup
if [[ "$KEEP_DAYS" =~ ^[0-9]+$ ]] && [[ "$KEEP_DAYS" -gt 0 ]]; then
  find "$BACKUP_DIR" -type f -name "${DB_DATABASE}_*.sql.gz" -mtime "+$KEEP_DAYS" -print -delete || true
fi

