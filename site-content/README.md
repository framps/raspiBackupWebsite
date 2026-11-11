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
