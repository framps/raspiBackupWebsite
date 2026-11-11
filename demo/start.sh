#!/usr/bin/env bash
# Start the demo (database + web server). Add --open to open the browser.
set -euo pipefail
source "$(dirname "$0")/lib/common.sh"
[ -d "$WP_DIR" ] || die "Demo not set up yet – run ./setup.sh first"
db_start
web_start
print_urls
if [ "${1:-}" = "--open" ] && command -v xdg-open >/dev/null; then xdg-open "$URL/en/" >/dev/null 2>&1 & fi
