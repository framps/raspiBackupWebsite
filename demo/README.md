# Local demo – raspiBackup Pro vs. classic layout

A complete local copy of raspibackup.linux-tips-and-tricks.de to evaluate the new design:
WordPress + Zakra + Polylang + BlockArt, with your real EN/DE home pages and
the Documents page imported from the live site. Nothing on the live site is changed.

## Usage

```bash
cd demo
./setup.sh            # once: downloads, installs, imports (≈1 min) and starts the demo
./start.sh --open     # start (and open the browser)
./switch.sh classic   # show the old layout   (same as activating "Zakra")
./switch.sh new       # show the new design   (same as activating "raspiBackup Pro")
./stop.sh             # stop
./reset.sh            # throw everything away and rebuild with a fresh snapshot of the live site
```

| What | URL |
|---|---|
| Home English | http://127.0.0.1:8091/en/ |
| Startseite Deutsch | http://127.0.0.1:8091/de/ |
| Documents page | http://127.0.0.1:8091/en/documents-about-raspibackup/ |
| Old home while new design is active | http://127.0.0.1:8091/en/?rbp_classic=1 |
| Admin (user `admin`, password `admin`) | http://127.0.0.1:8091/wp-admin/ |
| Customizer → "raspiBackup Pro" | http://127.0.0.1:8091/wp-admin/customize.php |

A small badge at the bottom left shows which design you are looking at.

In the admin you can also try the real workflow: *Appearance → Themes → Activate*, the
Customizer switches, and editing pages.

## Notes

- The theme is **linked**, not copied: edits in `../raspibackup-pro/` are visible after a browser reload.
- Everything stays inside `demo/`: its own MariaDB instance (127.0.0.1:33917, data in `db/`),
  PHP's built-in web server (127.0.0.1:8091). Your system MariaDB is not used.
  Other ports: `RBP_DEMO_PORT=8092 RBP_DEMO_DB_PORT=33918 ./start.sh`
- Images inside the imported page content load from the live site, so the classic pages need internet access.
- The classic look uses CSS captured from the live site (`wordpress/wp-content/mu-plugins/rbp-demo.php`);
  that plugin exists only in the demo and is not part of the theme.
- Requirements: `php` (with mysqli), `mariadb-server`, `curl`, `unzip`.
- Logs: `logs/web.log`, `logs/db.log`.
