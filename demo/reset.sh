#!/usr/bin/env bash
# Delete the demo WordPress + database and build it again (downloads are kept in .cache/).
set -euo pipefail
source "$(dirname "$0")/lib/common.sh"
stop_all
info "Removing $WP_DIR and $DB_DIR"
rm -f "$WP_DIR/wp-content/themes/raspibackup-pro"   # only the link – never the theme itself
rm -rf "$WP_DIR" "$DB_DIR" "$RUN_DIR"
exec "$DEMO_DIR/setup.sh"
