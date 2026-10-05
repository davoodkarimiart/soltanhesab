# Soltan Hesab Project Status

| Phase | Name | State | User acceptance | Notes |
|---|---|---|---|---|
| 0 | Freeze/Audit V32 contract | IN_PROGRESS | pending | Exhaustive V32 inventory and 13-phase scope map created. Sanitized golden fixtures/expected outputs remain. |
| 1 | Foundation / Installer / Security / Base Logging | ACCEPTED | accepted | v0.1.1 passed real cPanel install/login/health test and was accepted by user. Final login visual remains intentionally mapped to Phase 8. |
| 2 | Company / Panel / AccountSettings | ACCEPTED | accepted | v0.2.3 fixed AccountSettings name import and user confirmed Phase 2 data flow works. Remaining UX regression: Account search did not restore/list-filter dynamically after clearing. v0.2.5 cumulative patch prepared with live search plus cleanup controls for wrong Accounts/import history; waiting for retest. |
| 3 | Daily Report_WL / Accounting Engine / Preview | ACCEPTED | accepted | v0.3.1 passed functional retest. Accounting calculations, unknown-user resolution, panel/day overlap rules, delete flow and final save were accepted. Remaining visual density/readability/button-layout issues are recorded as UX debt for Phase 8 Full UX Parity. |
| 4 | Customer / Grouping / Ledger / Sharing | PLANNED | pending | |
| 5 | Archive / Reports / Search | PLANNED | pending | |
| 6 | Excel / PDF / Print / Summary Image | PLANNED | pending | |
| 7 | Settings / Theme / Numbers / Fonts | PLANNED | pending | |
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
