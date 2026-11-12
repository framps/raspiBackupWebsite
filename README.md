<p align="center">
  <img src="./images/Icon_rot_blau_final_128.png" alt="raspiBackup logo" />
</p>

# raspiBackup Website

Theme and content for **[raspibackup.linux-tips-and-tricks.de](https://raspibackup.linux-tips-and-tricks.de)**,
the website of [raspiBackup](https://github.com/framps/raspiBackup), the backup tool for Raspberry Pi.

This repository contains:

| Folder / file | What it is |
|---|---|
| [`raspibackup-pro/`](raspibackup-pro/) | **raspiBackup Pro**, a Zakra child theme with a bilingual landing page and refreshed styling for all other pages |
| `raspibackup-pro.zip` | The theme, packaged for upload to WordPress |
| [`site-content/`](site-content/) | Page content maintained outside WordPress: the plugin-free Documents page |
| [`demo/`](demo/) | Scripts that build a local copy of the website to try out changes before publishing them |

## Local demo

The demo is a complete local copy of the website with its own WordPress, its own database and PHP's built-in web server.
The live site is never changed. Use it to try out theme changes before publishing them.

```bash
cd demo
./setup.sh            # once: downloads WordPress and plugins, imports the pages, starts the demo
./start.sh --open     # start it and open http://127.0.0.1:8091/en/
./switch.sh new       # new design     (./switch.sh classic for the Zakra layout)
./stop.sh
```

The theme folder is linked into the demo, so edits show up after a browser reload.
Requirements: `php` with mysqli, `mariadb-server`, `curl`, `unzip`. More in [`demo/README.md`](demo/README.md).

## License

GNU General Public License v3 or later, like raspiBackup.
