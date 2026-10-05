# Phase Scope Map

This file maps every feature family to a specific implementation phase so scope does not disappear during bug-fix cycles.

There are 13 numbered phases, Phase 0 through Phase 12.

## Phase 0 — Freeze/Audit the V32 contract
Owns:
- exhaustive V32 feature inventory
- feature parity matrix
- business rules
- source/reference map
- sanitized fixture preparation
- expected accounting results
- intentional-deviation register

Does not end until the V32 contract is captured.

## Phase 1 — Foundation / Installer / Security / Base Logging
Owns:
- PHP bootstrap
- config/environment
- DB connection
- migration runner
- installer
- install lock
- Admin/Developer users
- login/logout/session
- CSRF
- login rate limit
- base authorization
- error boundary
- structured Audit/System/Debug log APIs and storage hooks
- health skeleton
- version/build metadata
- storage directories
- cron/scheduler convention
- backup/Telegram config placeholders
- mobile-safe base shell/viewport/input sizing
- shared design tokens

## Phase 2 — Company / Panel / AccountSettings
Owns:
- Company CRUD/status
- Panel CRUD/status
- multiple Panels per Company
- Panel-level name mode
- AccountSettings upload/import
- AccountSettings sync
- source hash/history/stats
- stable Account identity
- original/display name split
- rate type
- active/inactive
- new/missing Account handling
- wrong Panel/Company source detection
- import audit/system/error logging
- mobile Company/Panel UI

## Phase 3 — Daily Report_WL / Accounting Engine / Preview
Owns:
- daily Report_WL upload
- Company required
- Jalali business-date input + canonical date
- rates/percentage inputs
- money-scale-aware rate input
- Username matching / Panel inference
- wrong-company Report block
- unknown Account modal/options
- duplicate detection
- test-only duplicate override if retained
- calculation Domain Service
- decimal-safe math
- 3-step entry flow
- preview table
- add/edit/delete row
- outcome loss/win/zero
- immediate totals
- back preserving draft
- finalization transaction
- historical snapshots
- final output
- edit stored Report
- new Report
- accounting workflow audit/system/error events
- mobile preview/edit UX

## Phase 4 — Customer / Grouping / Ledger / Sharing
Owns:
- Customer search/profile
- original/display identity
- Account grouping
- ungroup/reassign
- suffix suggestions
- grouped ledger
- click from final output
- display-name edit
- customer image
- image preview/download/share
- WhatsApp/Telegram customer share
- share fallback
- customer mutation audit

## Phase 5 — Archive / Reports / Search
Owns:
- report archive
- filters: date/company/panel/customer/type
- Daily view
- Monthly view
- Multi-month view
- Detailed ledger
- last-10 fallbacks
- report open/edit behavior
- summary totals
- explicit Site Win/Loss/Settled
- Jalali-facing date UX
- reporting mobile UX

## Phase 6 — Excel / PDF / Print / Summary Image
Owns:
- preview Excel
- final Excel
- report Excel
- final PDF/print
- analytics/report PDF/print
- print-only clean layouts
- current dataset guarantees
- theme colors/text/opacity
- page breaks/no overlap
- customer image fidelity
- summary settlement image
- grouped Customer netting
- summary image Telegram/WhatsApp share
- export error logging

## Phase 7 — Settings / Theme / Numbers / Fonts
Owns:
- default rates
- default loss percent
- full/trim3/trim4 money scale
- dynamic entry hint
- Persian/English numeral mode
- theme per semantic category
- background color
- opacity
- text color
- live theme preview
- theme propagation to UI/Reports/PDF/Excel
- font manager:
  - Vazirmatn
  - IRANSans
  - global UI
  - headings
  - forms/buttons
  - tables
  - print/PDF
- settings persistence/audit
- mobile settings UI

## Phase 8 — Dashboard / Shell / Full UX Parity
Owns:
- Dashboard stats
- quick actions
- seven-period trend
- latest activity
- top settings/logout
- bottom navigation
- approved login visual/game parity
- responsive polish
- iPhone SE test pass
- safe-area/keyboard behavior
- no unwanted mobile zoom
- no accidental horizontal scroll
- final V32 visual/interaction parity sweep

## Phase 9 — PWA
Owns:
- manifest
- icons
- service worker
- install flow
- standalone mode
- update/version signaling
- cache strategy
- safe invalidation
- offline static shell
- live confirmation rule for writes

## Phase 10 — Developer Operations / Logs / Backup / Telegram
Owns:
- Developer dashboard
- Audit Log viewer
- System Log viewer
- Debug/Error Log viewer
- filtering/search
- retention
- health details
- disk/database/schema/version/import-error status
- backup manual
- backup schedule
- cPanel cron instructions
- local backup storage
- retention/rotation
- Telegram Bot config
- Chat/Channel config
- Telegram connection test
- send backup
- send status/retry
- local fallback on Telegram failure
- backup download
- Developer-only restore
- restore audit
- pre-restore safety backup

## Phase 11 — MCP
Owns:
- MCP endpoint/adapter
- same Application Services as UI
- token issue
- hashed token storage
- scopes
- Read/Write/Full-equivalent permissions
- revoke
- expiry
- last used
- audit
- Company/Panel/Account/Customer/Report reads
- controlled writes
- settings/backup/diagnostics permissions
- no direct accounting duplication
- no default raw SQL

## Phase 12 — Hardening / Release
Owns:
- automated parser/calculation/sync/report/export/settings/security tests
- regression against V32 inventory
- regression against parity matrix
- clean install test
- upgrade migration test
- rollback/backup restore drill
- cPanel deployment guide
- PHP/server requirements
- production logging/error settings
- performance pass for ~1 CPU / 1GB
- public-repo secret/data review
- final release package

## Phase acceptance discipline

A phase is not complete at commit time.

Flow:
PLANNED -> IN_PROGRESS -> READY_FOR_USER_TEST -> ACCEPTED

If broken later:
ACCEPTED -> REGRESSION_FOUND -> IN_PROGRESS -> READY_FOR_USER_TEST -> ACCEPTED

Before moving to the next phase:
- update PROJECT_STATUS.md
- update FEATURE_PARITY_MATRIX.md
- record fixes/decisions
- keep all later phases intact
