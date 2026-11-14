# Impressum for www.linux-tips-and-tricks.de (Joomla, Cassiopeia template)

`impressum-de.html` (German) and `imprint-en.html` (English) contain **placeholders in square brackets** –
this repository is public, so fill in your real data only in Joomla.

1. **Content → Articles → New**: title `Impressum`, language *Deutsch*.
   Click **Toggle Editor**, paste `impressum-de.html`, click **Toggle Editor** again, replace every `[...]`, **Save & Close**.
2. Same for `Imprint` with language *English* and `imprint-en.html`.
   In the article's **Associations** tab link it to the German Impressum (if the tab is shown).
3. **Menus → Manage → New**: menu `Footer DE` (and `Footer EN`).
   In each, add a menu item of type **Articles → Single Article** pointing to the article, language set accordingly
   (alias `impressum` / `imprint`).
4. **Content → Site Modules → New → Menu**: show `Footer DE`, position **footer**, menu assignment *On all pages*,
   language *Deutsch*. Repeat for `Footer EN` with language *English*.

## Datenschutzerklärung / Privacy policy

`datenschutz-de.html` and `privacy-en.html`: server logs at the hoster (anonymised IPs, kept for statistics),
Joomla session cookie, no external resources, search.
Create both articles like the imprint (Toggle Editor, paste, Associations) and add a menu item
`Datenschutz` / `Privacy` to the `Footer DE` / `Footer EN` menus.
