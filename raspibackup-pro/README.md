# raspiBackup Pro – WordPress Child Theme

Professional, bilingual (DE/EN) design for https://raspibackup.linux-tips-and-tricks.de.
Child theme of **Zakra**. Your pages, Zakra settings and Polylang configuration are **not changed** –
you can switch between the new and the classic layout at any time.

---

## Deutsch

### Installation
1. Zakra muss installiert bleiben (es ist das Eltern-Theme).
2. *Design → Themes → Theme hinzufügen → Theme hochladen* → `raspibackup-pro.zip` auswählen → **Installieren**.
3. Optional vorher ansehen: beim Theme auf **Live-Vorschau** klicken.
4. **Aktivieren** → das neue Layout ist sofort online.

Beim Aktivieren werden Logo, Menüs und die Polylang-Sprachmenüs automatisch von Zakra übernommen.

### Zurück zum alten Layout
*Design → Themes →* **Zakra** aktivieren. Fertig – die Seite sieht exakt so aus wie vorher.
(Getestet: Die Seiten sind nach dem Zurückschalten byte-identisch mit dem Original.)

Teilweise zurück: *Design → Customizer → raspiBackup Pro*
- „Neue Startseite verwenden“ aus → klassische Startseite, aber modernisierte übrige Seiten
- „Modernisiertes Design für alle anderen Seiten“ aus → nur die neue Startseite
- Vorschau der alten Startseite bei aktivem neuen Theme: `…/de/home-deutsch/?rbp_classic=1`

### Inhalte ändern
- Alle Texte (DE + EN) stehen in `inc/content.php`.
- Demo-GIF je Sprache und ein optionales YouTube-Video: *Customizer → raspiBackup Pro*.
  Das Video wird DSGVO-freundlich erst nach einem Klick von YouTube geladen.
- Impressum- und Datenschutz-Link für den Footer: ebenfalls im Customizer.

---

## English

### Install
1. Keep Zakra installed (it is the parent theme).
2. *Appearance → Themes → Add New → Upload Theme* → choose `raspibackup-pro.zip` → **Install**.
3. Optional: click **Live Preview** first.
4. **Activate** → the new layout is live.

On activation, logo, menus and Polylang language menus are copied over from Zakra automatically.

### Back to the classic layout
*Appearance → Themes →* activate **Zakra**. Done – the site looks exactly as before.

Partial rollback in *Appearance → Customize → raspiBackup Pro*:
- untick “Use new home page” → classic home page, refreshed inner pages
- untick “Refreshed styling for all other pages” → only the new home page
- preview the classic home page while the new theme is active: `…/en/home/?rbp_classic=1`

### Editing content
- All texts (EN + DE) live in `inc/content.php`.
- Demo GIF per language and an optional YouTube video: *Customizer → raspiBackup Pro*
  (video loads only after a click – privacy friendly).
- Imprint and privacy links for the footer: Customizer as well.

---

## What's inside
| File | Purpose |
|---|---|
| `templates/landing.php` | New home page (used automatically for the EN and DE front page; also selectable as page template “raspiBackup Landing”) |
| `inc/content.php` | All texts, EN + DE |
| `inc/helpers.php` | Language detection (Polylang), language switcher, icons, GitHub release/stars (server-side, cached 12 h) |
| `inc/customizer.php` | Settings panel “raspiBackup Pro” |
| `inc/migrate.php` | Copies Zakra settings + Polylang menus on activation (Zakra itself is never modified) |
| `assets/css/landing.css` | Home page design |
| `assets/css/inner.css` | Refreshed look for all other pages (CSS only) |
| `assets/js/landing.js` | Mobile menu, copy button, click-to-load video |

Privacy: no Google Fonts, no external scripts, no tracking. The GitHub numbers are fetched by the server, not by visitors' browsers.
