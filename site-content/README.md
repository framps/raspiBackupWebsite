# Replacing Simple File List on the live site

wordpress.org closed the **Simple File List** plugin on 2026-07-23 for a *security issue*.
It no longer receives updates. `documents-page.html` is a replacement for the Documents page
built only from standard WordPress blocks – no plugin needed. The links point to the PDFs at
their current location `/wp-content/uploads/simple-file-list/`, so the file URLs stay the same.

## Steps (≈10 minutes)

1. **Back up the PDFs** – copy the folder `wp-content/uploads/simple-file-list/` to your computer (FTP/SFTP or your hoster's file manager).
2. **Replace the page content**
   - *Pages* → edit “Documents about raspiBackup”.
   - Top-right menu ⋮ → **Code editor**.
   - Select all, delete, paste the complete content of `documents-page.html`.
   - ⋮ → **Visual editor** – you should see 6 cards with download buttons – then **Update**.
3. **Remove the plugin** – *Plugins* → Simple File List → **Deactivate** → **Delete**.
4. **Check** – open the Documents page and click two or three download buttons.
   If a PDF is missing, upload it from your backup (step 1) into the same folder.

(Tested in the local demo: uninstalling the plugin left all 11 PDFs in place, and the block editor
reports all 49 blocks of the page as valid.)

## Adding a document later
Upload the PDF (e.g. via *Media* or FTP), then in the editor duplicate one of the cards
(block toolbar ⋮ → Duplicate) and change title, texts and the button links.

The cards are styled by the raspiBackup Pro theme; with the classic Zakra theme they are shown as a simple list.

# Impressum / Imprint

`impressum-de.html` (German) and `imprint-en.html` (English) are imprint pages according to § 5 DDG
and § 18 (2) MStV, built from standard blocks. The repository is public, so they contain
**placeholders in square brackets** – fill in your real data only in WordPress, never here.

1. *Pages* → **Add New**, title `Impressum`, ⋮ → **Code editor**, paste `impressum-de.html`.
2. Replace every `[...]` placeholder (name, postal address – no PO box –, email, phone), then **Publish**.
3. Polylang: set the language to Deutsch, add the English translation with title `Imprint` and `imprint-en.html` the same way.
4. *Appearance* → *Customize* → raspiBackup Pro → **Impressum URL**: the URL of the German page.
   The landing page footer then shows the link – on English pages automatically to the `Imprint` translation (theme 1.1.2+).
5. For all other pages: add the Impressum page to the footer menu (*Appearance* → *Menus*),
   because the imprint must be reachable from every page.
