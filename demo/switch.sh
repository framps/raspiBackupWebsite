#!/usr/bin/env bash
# Switch the demo between the new design and the classic layout – exactly what
# "Appearance → Themes → Activate" does on the real site.
#   ./switch.sh new       → raspiBackup Pro
#   ./switch.sh classic   → Zakra (old layout)
set -euo pipefail
source "$(dirname "$0")/lib/common.sh"
case "${1:-}" in
	new|pro)     theme=raspibackup-pro ;;
	classic|old) theme=zakra ;;
	*) die "Usage: ./switch.sh new|classic" ;;
esac
pid_alive "$RUN_DIR/db.pid" || db_start
wp theme activate "$theme" --quiet
wp option get stylesheet >/dev/null   # runs after_switch_theme (copies Zakra settings/menus on first activation)
ok "Switched to $theme – reload the page in your browser"
print_urls
