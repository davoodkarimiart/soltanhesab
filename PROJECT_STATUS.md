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
| 8 | Dashboard / Shell / Full UX Parity | PLANNED | pending | Mobile-first is continuous before this parity sweep. |
| 9 | PWA | PLANNED | pending | |
| 10 | Developer Ops / Logs / Backup / Telegram | PLANNED | pending | Base logging/config/scheduler hooks begin in Phase 1. |
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
