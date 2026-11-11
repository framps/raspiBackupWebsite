# Shared settings for the raspiBackup Pro demo environment. Sourced by the other scripts.

DEMO_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
PROJECT_DIR="$(cd "$DEMO_DIR/.." && pwd)"
THEME_DIR="$PROJECT_DIR/raspibackup-pro"

WP_DIR="$DEMO_DIR/wordpress"
DB_DIR="$DEMO_DIR/db"
RUN_DIR="$DEMO_DIR/run"
LOG_DIR="$DEMO_DIR/logs"
CACHE_DIR="$DEMO_DIR/.cache"
SNAP_DIR="$DEMO_DIR/snapshot"

PORT="${RBP_DEMO_PORT:-8091}"
DB_PORT="${RBP_DEMO_DB_PORT:-33917}"
URL="http://127.0.0.1:$PORT"
LIVE="https://raspibackup.linux-tips-and-tricks.de"

WPCLI="$CACHE_DIR/wp-cli.phar"

wp() { php "$WPCLI" --path="$WP_DIR" "$@"; }
db() { mariadb --no-defaults -h 127.0.0.1 -P "$DB_PORT" -u root "$@"; }

info() { printf '\033[1;34m==>\033[0m %s\n' "$*"; }
ok()   { printf '\033[1;32m✓\033[0m %s\n' "$*"; }
die()  { printf '\033[1;31m✗ %s\033[0m\n' "$*" >&2; exit 1; }

pid_alive() { [ -f "$1" ] && kill -0 "$(cat "$1")" 2>/dev/null; }

db_start() {
	mkdir -p "$RUN_DIR" "$LOG_DIR"
	if pid_alive "$RUN_DIR/db.pid"; then ok "Database already running (port $DB_PORT)"; return; fi
	# Private MariaDB instance: own data directory, localhost only, no effect on any system database.
	nohup mariadbd --no-defaults --datadir="$DB_DIR" --socket="$RUN_DIR/db.sock" \
		--bind-address=127.0.0.1 --port="$DB_PORT" --pid-file="$RUN_DIR/db.pid" \
		--log-error="$LOG_DIR/db.log" >/dev/null 2>&1 &
	for _ in $(seq 1 30); do
		db -e 'select 1' >/dev/null 2>&1 && { ok "Database started (127.0.0.1:$DB_PORT)"; return; }
		sleep 0.5
	done
	die "Database did not start – see $LOG_DIR/db.log"
}

web_start() {
	mkdir -p "$RUN_DIR" "$LOG_DIR"
	if pid_alive "$RUN_DIR/web.pid"; then ok "Web server already running ($URL)"; return; fi
	nohup php -S "127.0.0.1:$PORT" -t "$WP_DIR" "$DEMO_DIR/lib/router.php" >"$LOG_DIR/web.log" 2>&1 &
	echo $! >"$RUN_DIR/web.pid"
	for _ in $(seq 1 20); do
		curl -s -o /dev/null "$URL/wp-login.php" && { ok "Web server started ($URL)"; return; }
		sleep 0.5
	done
	die "Web server did not start – see $LOG_DIR/web.log (is port $PORT free? set RBP_DEMO_PORT=…)"
}

stop_all() {
	if pid_alive "$RUN_DIR/web.pid"; then kill "$(cat "$RUN_DIR/web.pid")"; ok "Web server stopped"; fi
	rm -f "$RUN_DIR/web.pid"
	if pid_alive "$RUN_DIR/db.pid"; then
		kill "$(cat "$RUN_DIR/db.pid")"
		for _ in $(seq 1 30); do pid_alive "$RUN_DIR/db.pid" || break; sleep 0.5; done
		ok "Database stopped"
	fi
}

current_theme() { wp option get stylesheet 2>/dev/null; }

print_urls() {
	local theme; theme="$(current_theme)"
	local label="classic layout (Zakra)"; [ "$theme" = "raspibackup-pro" ] && label="NEW design (raspiBackup Pro)"
	cat <<EOF

  Active: $label

  Home (English)     $URL/en/
  Startseite (DE)    $URL/de/
  Documents page     $URL/en/documents-about-raspibackup/
  Classic home preview while new design is active:
                     $URL/en/?rbp_classic=1
  Admin              $URL/wp-admin/        user: admin   password: admin
  Customizer         $URL/wp-admin/customize.php   (section "raspiBackup Pro")

  Switch:  ./switch.sh new | classic      Stop: ./stop.sh

EOF
}
