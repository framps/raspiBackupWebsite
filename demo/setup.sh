#!/usr/bin/env bash
# One-time setup of the local raspiBackup demo (WordPress + Zakra + Polylang + your content).
# Everything lives in this demo/ folder. Run ./reset.sh to rebuild from scratch.
set -euo pipefail
source "$(dirname "$0")/lib/common.sh"

# ---------- Prerequisites ----------
for cmd in php curl unzip tar mariadbd mariadb-install-db mariadb; do
	command -v "$cmd" >/dev/null || die "Missing '$cmd'. On Debian/Ubuntu: sudo apt install php-cli php-mysql php-gd php-curl php-xml php-mbstring mariadb-server curl unzip"
done
php -m | grep -qi mysqli || die "PHP extension mysqli missing (sudo apt install php-mysql)"
[ -d "$THEME_DIR" ] || die "Theme not found at $THEME_DIR"
[ -e "$WP_DIR" ] && die "Demo already set up. Start it with ./start.sh – or rebuild with ./reset.sh"

mkdir -p "$CACHE_DIR" "$SNAP_DIR" "$RUN_DIR" "$LOG_DIR"

# ---------- Downloads (cached) ----------
fetch() { # url file
	if [ ! -s "$CACHE_DIR/$2" ]; then
		info "Downloading $2"
		curl -fsSL -o "$CACHE_DIR/$2.part" "$1" && mv "$CACHE_DIR/$2.part" "$CACHE_DIR/$2"
	fi
}
fetch https://wordpress.org/latest.tar.gz                                         wordpress.tar.gz
fetch https://downloads.wordpress.org/theme/zakra.zip                             zakra.zip
fetch https://downloads.wordpress.org/plugin/polylang.latest-stable.zip           polylang.zip
fetch https://downloads.wordpress.org/plugin/blockart-blocks.latest-stable.zip    blockart-blocks.zip
fetch https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar   wp-cli.phar

# ---------- Snapshot of the live site ----------
info "Taking a snapshot of $LIVE"
snap() { # path file
	if curl -fsSL -A "Mozilla/5.0 (raspiBackup demo)" -o "$SNAP_DIR/$2.part" "$LIVE$1"; then
		mv "$SNAP_DIR/$2.part" "$SNAP_DIR/$2"
	else
		rm -f "$SNAP_DIR/$2.part"
		[ -s "$SNAP_DIR/$2" ] || die "Could not download $LIVE$1"
		info "Using older snapshot for $1"
	fi
}
snap /en/home/                         home-en.html
snap /de/home-deutsch/                 home-de.html
snap /en/documents-about-raspibackup/  documents-en.html

# ---------- WordPress files ----------
info "Installing WordPress files"
mkdir -p "$WP_DIR"
tar xzf "$CACHE_DIR/wordpress.tar.gz" -C "$WP_DIR" --strip-components=1
unzip -q "$CACHE_DIR/zakra.zip" -d "$WP_DIR/wp-content/themes"
for p in polylang blockart-blocks; do unzip -q "$CACHE_DIR/$p.zip" -d "$WP_DIR/wp-content/plugins"; done
ln -s "$THEME_DIR" "$WP_DIR/wp-content/themes/raspibackup-pro"   # live link: theme edits show up immediately
mkdir -p "$WP_DIR/wp-content/mu-plugins"
cp "$DEMO_DIR/lib/demo-mu-plugin.php" "$WP_DIR/wp-content/mu-plugins/rbp-demo.php"

# Media used by both designs (logo, demo GIFs) at the same paths as on the live site.
info "Downloading logo and demo GIFs"
for f in 2023/09/Icon_rot_blau_final.png 2023/09/Icon_rot_blau_final_32.png 2023/09/Icon_rot_blau_final_64.png \
         2026/11/install_en.gif 2026/11/install_de.gif; do
	mkdir -p "$WP_DIR/wp-content/uploads/$(dirname "$f")"
	curl -fsSL -o "$WP_DIR/wp-content/uploads/$f" "$LIVE/wp-content/uploads/$f" || info "Could not download $f (continuing)"
done

# PDFs for the Documents page (same location as on the live site).
info "Downloading the PDFs of the Documents page"
mkdir -p "$WP_DIR/wp-content/uploads/simple-file-list"
for f in $(grep -oE 'simple-file-list/[^"]+\.pdf' "$PROJECT_DIR/site-content/documents-page.html" | sort -u | cut -d/ -f2); do
	curl -fsSL -o "$WP_DIR/wp-content/uploads/simple-file-list/$f" "$LIVE/wp-content/uploads/simple-file-list/$f" || info "Could not download $f (continuing)"
done

# ---------- Database ----------
info "Creating private database in $DB_DIR"
mariadb-install-db --no-defaults --datadir="$DB_DIR" --auth-root-authentication-method=normal --skip-test-db >"$LOG_DIR/db-install.log" 2>&1 \
	|| die "mariadb-install-db failed – see $LOG_DIR/db-install.log"
db_start
db -e "CREATE DATABASE IF NOT EXISTS wordpress CHARACTER SET utf8mb4"

# ---------- WordPress install ----------
info "Installing WordPress"
wp config create --dbname=wordpress --dbuser=root --dbpass= --dbhost="127.0.0.1:$DB_PORT" --skip-check --quiet
wp config set WP_ENVIRONMENT_TYPE local --quiet
wp config set DISABLE_WP_CRON true --raw --quiet
wp core install --url="$URL" --title="How to backup your Raspberries" \
	--admin_user=admin --admin_password=admin --admin_email=admin@example.invalid --skip-email --quiet
wp rewrite structure '/%postname%/' --quiet

# Zakra: behave like a long-standing installation (classic header, as on the live site).
wp option update zakra_migrations 1 --quiet
wp option delete zakra_maybe_enable_builder --quiet 2>/dev/null || true

wp plugin activate polylang blockart-blocks --quiet
wp theme activate zakra --quiet

info "Importing content from the snapshot"
wp eval-file "$DEMO_DIR/lib/import.php" "$SNAP_DIR" "$PROJECT_DIR/site-content/documents-page.html"
wp rewrite flush --quiet

# Start with the new design (Zakra settings + Polylang menus are copied on activation).
wp theme activate raspibackup-pro --quiet
wp option get stylesheet >/dev/null   # runs after_switch_theme

web_start
ok "Demo is ready"
print_urls
