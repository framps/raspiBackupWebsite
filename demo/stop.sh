#!/usr/bin/env bash
# Stop the demo web server and database.
set -euo pipefail
source "$(dirname "$0")/lib/common.sh"
stop_all
