# Soltan Hesab Project Status

| Phase | Name | State | User acceptance | Notes |
|---|---|---|---|---|
| 0 | Freeze/Audit V32 contract | IN_PROGRESS | pending | Exhaustive V32 inventory and 13-phase scope map created. Sanitized golden fixtures/expected outputs remain. |
| 1 | Foundation / Installer / Security / Base Logging | ACCEPTED | accepted | v0.1.1 passed real cPanel install/login/health test and was accepted by user. Final login visual remains intentionally mapped to Phase 8. |
| 2 | Company / Panel / AccountSettings | ACCEPTED | accepted | v0.2.3 fixed AccountSettings name import and user confirmed Phase 2 data flow works. Remaining UX regression: Account search did not restore/list-filter dynamically after clearing. v0.2.5 cumulative patch prepared with live search plus cleanup controls for wrong Accounts/import history; waiting for retest. |
| 3 | Daily Report_WL / Accounting Engine / Preview | ACCEPTED | accepted | v0.3.1 passed functional retest. Accounting calculations, unknown-user resolution, panel/day overlap rules, delete flow and final save were accepted. Remaining visual density/readability/button-layout issues are recorded as UX debt for Phase 8 Full UX Parity. |
| 4 | Customer / Grouping / Ledger / Sharing | READY_FOR_USER_TEST | pending | v0.4.0 reached host test. v0.4.1 correction prepared: default auto-grouping with remembered manual splits, current-report customer dialog/image/share parity, searchable account/customer pickers, customer rate/active controls. Waiting for retest. |
| 5 | Archive / Reports / Search | READY_FOR_USER_TEST | pending | v0.4.1 correction prepared: Jalali date picker/display, Jalali monthly grouping, direct daily Open/Edit actions in archive, searchable customer filter, recent-entry list reduced to 3. Waiting for retest. |
| 6 | Excel / PDF / Print / Summary Image | READY_FOR_USER_TEST | pending | v0.4.1 correction prepared: bordered RTL Excel export, stronger mobile/A4 print layout, full report-table image instead of totals-only placeholder, current-report customer image/share flow. Waiting for retest. |
| 7 | Settings / Theme / Numbers / Fonts | READY_FOR_USER_TEST | pending | v0.4.1 correction prepared: money-scale semantics aligned to thousand-Toman accounting base; font diagnostics and licensed-font upload flow added so desktop/mobile/PDF use the same hosted assets. Waiting for retest. |
| 8 | Dashboard / Shell / Full UX Parity | READY_FOR_USER_TEST | pending | v0.5.3 login parity correction prepared from the user-supplied approved V28 HTML: exact desktop and portrait login artwork, exact final crop rules and exact fist hitboxes restored while keeping real PHP authentication. Waiting for final mobile/desktop login retest. |nup, final accounting-table readability, modal/action redesign, login Golpooch parity and responsive hardening are now active work. |
| 9 | PWA | READY_FOR_USER_TEST | pending | v0.5.0 adds manifest, supplied-brand icons/maskable icons, Apple touch icon, install prompt, network-first service worker and offline shell. Waiting for install/update test. |nding | Base logging/config/scheduler hooks begin in Phase 1. |
| 11 | MCP | PLANNED | pending | |
| 12 | Hardening / Release | PLANNED | pending | |

State values:
PLANNED / IN_PROGRESS / BLOCKED / READY_FOR_USER_TEST / ACCEPTED / REGRESSION_FOUND

## Current next action
Complete Phase 0 by creating sanitized golden fixtures and expected accounting outputs from the known source shapes, then start Phase 1 on the feature branch.


## Accepted UX debt after Phase 2
- Company/Panel/AccountSettings management is functionally accepted.
- Dense vertical stacking of sync controls and import history is acknowledged as mobile/web UX debt.
- This must be corrected in Phase 8 Full UX Parity / responsive polish, not forgotten.
- Phase 3 can proceed now because the data model/import flow is accepted.


## Phase 3 accepted visual UX debt
- Accounting/report table is functionally accepted but current typography is too small for the available cell area.
- Cell separators should be darker/stronger like the approved HTML reference.
- Mobile button placement and action grouping still need app-like polish.
- These items are explicitly deferred to Phase 8 Full UX Parity / responsive polish and must not be dropped.


## v0.4.3 font loading correction
- Removed Settings font file upload controls.
- Removed broken dual IRANSans filename fallback that caused 404 requests for both hyphenated and spaced names.
- Vazirmatn now has a browser webfont fallback and prefers existing local hosted files when present.
- IRANSans is only requested when the canonical local file exists; otherwise it falls back cleanly to Vazirmatn.
- Asset cache keys bumped to v043.


## v0.4.4 saved-report and terminology correction
- Saved report route hardened against missing Phase 4 auto-group exclusion migration to prevent report-view 500s.
- Upgrade v0.4.4 runs pending migrations and verifies customer_autogroup_exclusions.
- Generic report label "مانده" removed from operational reporting. Reports now show explicit برد سایت / باخت سایت / تسویه with semantic color; customer ledger uses دریافت از مشتری / پرداخت به مشتری / تسویه.
- favicon added to remove the unrelated favicon 404 noise.


## v0.4.5 report/mobile/customer-card correction
- Final-report customer card rebuilt to match approved HTML composition on mobile and desktop: grouped table, semantic colors, 3 totals, full-width receive/pay balance, automatic image generation and native-share fallback.
- Generic "تفصیلی" label replaced with "ریز حساب" while keeping internal report type compatibility.
- Daily reporting view now catches/logs report-generation exceptions instead of collapsing into the global generic error page.
- Print/PDF mobile layout hardened and Back now closes the spawned print tab or returns to Reports.
- Bottom navigation forced above report content on mobile.
- Report image semantic colors and site win/loss footer corrected; displayed precision reduced.
- New Report_WL uploads are retained under private storage and archive shows a small Download link instead of exposing the filename. Existing historic uploads cannot be reconstructed retroactively.


## v0.4.6 stability correction
- Fixed daily Reports SQL crash when `daily_reports.source_storage_path` is missing; report query now degrades safely and upgrade repairs the column.
- Fixed Customers page 500 when `customer_autogroup_exclusions` is missing; customer suggestions are now migration-safe and upgrade repairs the table.
- Company/Panel filters in Reports are now linked: selected Company constrains Panel options.
- Final-report customer card responsive layout rebuilt for both desktop and mobile; duplicate generated image preview hidden while share/download image generation remains available.
- Semantic header colors and stronger accounting-grid borders applied.
- Bottom navigation forced visible above Reports on mobile.


## v0.4.7 customer-card density correction
- Reduced dead horizontal/vertical padding in the final-report customer aggregate card.
- Increased customer names, numeric values and totals font sizes while preserving the seven-column mobile fit.
- Reduced row/totals/balance heights for a denser, cleaner mobile card.
- Desktop aggregate card remains width-constrained with no horizontal overflow.


## v0.4.8 customer/reporting correction
- Customers rebuilt as searchable directory with Company/Panel filters and per-customer profile editing.
- Customer profile now supports original/display name editing, rate type, active state, account unlink/link and scoped aggregation suggestions.
- Added separate configurable theme colors for Site Win and Site Loss; defaults inherit Pay and Receive colors.
- Reports Company/Panel filters are now hard-linked in UI and validated server-side.
- Report navigation and bottom navigation hardened.
- Old source-file rows now show a consistent Download control state instead of filename/status text.
- Final/customer accounting color hierarchy and customer aggregate responsiveness tightened.


## v0.4.9 customer-directory and reporting hard fix
- Customer directory is account-backed: every Account is represented, including manually separated accounts.
- Manual split now creates a standalone customer instead of making the Account disappear from Customers.
- Reports Company->Panel filtering is server-rendered and server-validated; Company change submits immediately to rebuild only valid Panels.
- Older saved reports can infer panel_id from report rows so daily filters do not silently lose rows.
- Daily/monthly site result is recomputed from total_received-total_paid for rendering.
- Report Download always works: original source when retained, reconstructed XLS from immutable saved rows for older reports.
- Final-report customer aggregate dialog has hard no-horizontal-overflow rules on desktop and mobile.


## v0.4.10 final Package 4 stabilization
- Daily report site win/loss TypeError fixed by normalizing PDO DECIMAL values before rendering.
- Daily report Panel filtering now uses report rows as authoritative ownership; stale Company/Panel combinations are reset instead of accepted.
- Saved report totals/site status are repaired from immutable rows during upgrade.
- Customers directory is completed from AccountSettings via deterministic auto-grouping; unnamed accounts fall back to Username instead of `- -`.
- Manual split remains an explicit exception; manual link can move an Account between customer groups safely.
- Customer aggregate dialog is made genuinely responsive rather than hiding overflow.
- Historical report download is reconstructed directly from saved rows when original upload is unavailable.
- v0.4.10 is READY_FOR_USER_TEST and is intended to close Package 4 before Phase 8.


## v0.4.11 Package 4 cleanup/output correction
- AccountSettings cleanup now ignores Account references that exist only in soft-deleted reports; active reports still block destructive cleanup.
- Historical deleted reports preserve immutable row/name/rate snapshots; deleting Accounts safely nulls report-row account_id via existing FK semantics.
- Restored Summary Report action for finalized reports: two-column Received/Paid summary, totals and site win/loss, with PNG and Print/PDF output.
- Removed source-file field from PDF/report-image outputs; source Download remains web-UI only.
- PDF/image/summary output semantic fills now derive from Settings theme colors and theme opacity.
- Intended as the final correction before Package 4 acceptance / Phase 8.


## v0.4.12 reporting/mobile cleanup
- Rebuilt from the latest live cPanel export supplied by the user after v0.4.11.
- Daily report UI: removed the source-file column; Operations is now a single compact View eye action.
- Daily/monthly/multi report header colors are semantic only: Receive/Pay/Commission and Site Win/Loss. Neutral fields (Date, Company, Panel, Period, Count) stay neutral.
- Mobile report table widths/typography were tightened to fit without the previous color/column confusion.
- Browser-native confirm/alert flows in the touched destructive/report flows were replaced with in-app mobile bottom-sheet dialogs.
- No DB migration is required.
- A canonical runtime-source branch was created: `source/v0.4.12-runtime`.
- The runtime-source branch was seeded from the live export; secrets, runtime storage, logs, database config and font binaries are intentionally excluded.


## v0.4.14 final Package 4 polish
- User accepted v0.4.12 reporting/mobile fixes and requested the remaining Summary/Excel/Print fixes.
- Summary is now an in-app modal with image/share/WhatsApp/Telegram/print actions.
- Summary receive/pay customer name + amount cells follow configured theme colors.
- Excel semantic colors and borders are applied from Settings.
- Print/PDF honors `font_print` and waits for hosted web fonts before printing.
- No DB migration.
- Release ZIP: `soltanhesab-release-v0.4.14.zip`.
- Runtime source sync is being reconciled against the live-export base; secrets, logs, backups, customer uploads and licensed font binaries remain excluded from Git.


## v0.4.13 summary/export/font correction
- Finalized-report Summary now opens as an in-app modal instead of a new browser tab.
- Summary modal includes automatic PNG generation, Save Image, native Share, WhatsApp, Telegram, and in-place Print/PDF.
- Receive/Pay colors now fill both customer-name and amount cells in the Summary UI and image.
- Excel export now derives Receive/Pay/Commission/Site Win/Site Loss fills from Settings theme colors and opacity instead of fixed hard-coded pastels; borders/RTL remain.
- Generic daily Excel export no longer includes the source-file column.
- Print/PDF explicitly applies the selected `font_print` family to the entire printable document and supports both `Iranian-Sans.ttf` and `Iranian Sans.ttf` when a licensed asset exists on the host.
- No database migration.
- Intended as the final Package 4 correction before acceptance and Phase 8.


## v0.4.14 summary header/print correction
- Summary Report customer-name/amount header cells now use the same semantic Receive/Pay colors as their panel instead of staying white.
- Summary Print/PDF no longer prints a fixed-position dialog repeatedly across multiple pages.
- During print the Summary dialog is temporarily moved to the document root, printed as a single static flow, then restored to its original place.
- No database migration.


## v0.4.15 summary one-page print correction
- Summary Report column headers (نام مشتری / مبلغ) now use exactly the same Receive/Pay color as the rest of each panel.
- Summary image generation uses the same panel color for title, headers and populated rows.
- Summary PDF/Print is now produced from the rendered summary image in an isolated print iframe and forced to one A4 landscape page, scaling down as needed.
- The live Summary dialog is no longer moved in the DOM during print, removing the temporary duplicate/ghost dialog and the two-click close problem after printing.
- No database migration.


## v0.4.16 summary theme parity
- Summary Receive/Pay panels now use the exact computed Settings themeFill colors (including opacity), matching the corresponding total cards instead of using raw theme hex values.
- No database migration.
- Phase 8 / Package 5 development has started in parallel while Package 4 awaits final live confirmation.


## v0.5.0 Package 5 — Phase 8 + 9
- Built directly on the accepted v0.4.16 Package 4 base.
- Uses the user-supplied Soltan Hesab square mark and horizontal logo as retained brand sources.
- Generated favicon, Apple touch icon, 192/512 PWA icons and maskable PWA icons from the square source.
- Reordered bottom navigation: Home, Entry, Customers, Reports, Companies, using one consistent outline icon language.
- Removed test/schema/product-development language from the customer dashboard.
- Companies/Panels, Entry, Customers and Reports received a mobile-density pass to reduce vertical waste.
- Entry/report/customer filter fields use compact responsive grids; Enter advances through data-entry fields where appropriate.
- Accounting tables use stronger black grid lines, larger effective text and tighter cells.
- Restored V32 Golpooch login scene over the real server-side authentication.
- PWA manifest + service worker + offline shell added; writes remain network-only.
- No database migration.


## v0.5.1 Phase 8 polish
- Entry parameters follow one consistent structure across desktop/mobile: company/date/loss percent and paired general/special rates.
- Rate inputs in Entry and Settings use live thousands grouping.
- Customer directory includes Persian alphabetical sorting and balanced typography.
- Company/Panel cards and Settings cards are substantially denser.
- Reporting data-grid text is enlarged while retaining full-width fit.
- Golpooch login no longer shows instructional copy; the V32 full-screen crop and fist hit areas are restored.
- Dashboard adds a seven-report site-result trend visualization.
- PWA static cache bumped to v051.
- No database migration.


## v0.5.2 dashboard/share correction
- Replaced the "last 7 reports" chart with a useful 7/30/90-day analytical trend chart.
- Chart aggregates site net by company across the selected range, includes overall win/loss ratio and net KPI, and plots up to the most active four companies.
- Customer-card, summary-report and report-image native shares now send only the image file, with no title/caption/body text.
- WhatsApp/Telegram fallback no longer pre-populates or copies text; unsupported browsers receive an image-download-only fallback.
- PWA cache bumped to v052.
- No database migration.


## v0.5.3 login parity correction
- Rebased the Golpooch login visual behavior on the user-supplied approved V28 HTML rather than approximating it.
- Extracted and retained the exact V28 desktop landscape artwork and dedicated portrait mobile artwork.
- Desktop hit targets now match the final V23 rules: left 46%/40.5%/8.5%/12.5%, right 57%/40.5%/8.5%/12.5%.
- Mobile crop/hit targets now match the final V25 rules: portrait artwork, translateY(-8%) scale(1.20), left 27%/40.5%/20%/15%, right 53%/40.5%/20%/15%.
- No login business/security logic changed; successful Golpooch selection still reveals the real server-side login form.
- PWA cache bumped to v053.
- No database migration.


## v0.5.4 settings/customer UX correction
- Fixed Settings save failure caused by grouped numeric values such as 200,000 / Persian digits being rejected by server-side numeric validation.
- Numeric settings now normalize Persian/Arabic digits, thousands separators and decimal separators before validation/storage.
- Customer search is now live on input and no longer requires pressing Apply Filter for name matching.
- Customer search/profile text fields are hardened against mobile password-manager/autofill prompts.
- Keyboard Enter/Next flow expanded to Settings/customer profile/search fields.
- PWA cache bumped to v054.
- No database migration.
