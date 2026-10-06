# Changelog

## v0.4.14
- Finalized report Summary as an in-app modal; legacy `summary_report.php` routes back into the modal instead of acting as the primary UI.
- Summary customer-name and amount cells now use configured Receive/Pay theme fills in modal, generated PNG, and print.
- Excel export now applies semantic Receive/Pay/Commission colors to headers and data rows with SpreadsheetML border styling preserved.
- Print/PDF uses the selected `font_print` from hosted local font assets and waits for `document.fonts.ready` before invoking print.
- Browser asset cache keys bumped to `0414`.
- No database migration.

## v0.4.13
- Replaced the finalized-report Summary link/new-tab page with an in-app modal.
- Added automatic Summary PNG generation, download, native share, WhatsApp, Telegram and in-page Print/PDF.
- Corrected Summary Receive/Pay colors across both customer-name and amount cells.
- Excel output now derives Receive/Pay/Commission/Site Win/Site Loss fills from Settings instead of hard-coded colors.
- Kept Excel borders and RTL worksheet behavior.
- Print/PDF now explicitly applies the selected print font and disables cached stale font CSS.
- Added fallback support for both `Iranian-Sans.ttf` and `Iranian Sans.ttf` when a licensed IRANSans asset is present on the host.
- Removed source-file column from generic daily Excel export for parity with the web report table.
- No database migration.
