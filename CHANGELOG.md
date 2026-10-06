# Changelog

## v0.4.15
- Summary modal header cells (`نام مشتری` and `مبلغ`) now inherit the same Receive/Pay theme colors as the corresponding panel and rows.
- Generated Summary PNG now colors its header cells too, matching the on-screen modal.
- Print/PDF waits for the selected print font explicitly; Vazirmatn gets a network fallback only when its local webfont is unavailable.
- Excel semantic color styling from v0.4.14 remains active for headers, rows and totals.
- Asset cache keys bumped to `0415`.
- No database migration.

## v0.4.14
- Finalized report Summary as an in-app modal; legacy `summary_report.php` now redirects into the modal instead of opening a second standalone screen.
- Summary customer-name and amount cells now use the configured Receive/Pay theme fills, including generated PNG and print mode.
- Excel exports now apply semantic Receive/Pay/Commission colors to headers and data rows with stronger SpreadsheetML compatibility.
- Print/PDF now uses the selected `font_print` from local hosted font assets and waits for `document.fonts.ready` before invoking browser print.
- Bumped browser asset cache keys to `0414`.
- No database migration is required.

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
