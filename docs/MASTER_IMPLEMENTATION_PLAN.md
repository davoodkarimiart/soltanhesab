# Soltan Hesab — Master Implementation Plan

This file is the authoritative phase-by-phase build plan. Its job is to prevent scope loss while fixes and debugging happen between phases.

## Core migration rule

The production site must reach feature parity with the latest approved prototype (currently V32) unless a later explicit product decision changes a behavior.

Do not delete or simplify a working prototype capability merely because the backend implementation is harder.

The prototype is not the final architecture, but it is the current behavioral contract.

---

## Phase 0 — Preserve the prototype contract

### Goal
Freeze the current behavior before backend migration.

### Deliverables
- Preserve V32 as a reference artifact outside production code.
- Maintain the feature parity checklist.
- Maintain business rules and formulas.
- Maintain source map for old accounting reference and spreadsheet fixtures.
- Create anonymized test fixtures from AccountSettings and Report_WL.
- Define expected outputs for those fixtures.

### Acceptance
- Every visible feature in V32 is listed in FEATURE_PARITY_MATRIX.md.
- Every accounting rule has at least one fixture expectation.
- Any feature intentionally excluded later requires an explicit documented decision.

---

## Phase 1 — Application foundation + installer

### Goal
A clean site can be uploaded to shared hosting and installed from a browser.

### Backend foundation
- PHP application bootstrap.
- Environment/config loader.
- PDO database connection.
- Exception/error boundary.
- Application logger.
- Session bootstrap.
- CSRF helper.
- Authorization helper.
- JSON response helper.
- Request validation utilities.
- Version constant/build metadata.

### Installer
- Environment checks:
  - PHP version
  - PDO
  - pdo_mysql
  - mbstring
  - fileinfo
  - JSON
  - writable storage/config directories
- Database connection form.
- Database connection test.
- Migration runner.
- First Admin/Developer creation.
- Secure password hashing.
- Application secret/config generation.
- installed.lock or equivalent.
- Refuse reinstall unless an explicit developer reset is performed.

### Authentication
- Login.
- Logout.
- Session regeneration after login.
- CSRF protection.
- Rate limit login attempts.
- Admin and Developer roles.
- Developer-only diagnostics page.

### Health
- App version.
- PHP version.
- Database connectivity.
- migration version.
- writable paths.
- server time/timezone.
- basic storage health.

### Acceptance
A clean database can be installed end-to-end, user can log in, installer locks, dashboard opens, and health page is green.

---

## Phase 2 — Companies, Panels, AccountSettings

### Company
- Create.
- Edit.
- Activate/deactivate.
- List/search.

### Panel
- Create under Company.
- Edit.
- Activate/deactivate.
- Panel-level name display mode:
  - original source name
  - display/Persian name
- Panel-level AccountSettings source history.

### AccountSettings import
- XLS/XLSX upload.
- Parse required source columns.
- First import creates Accounts.
- Repeat import performs diff/sync.
- New Accounts added.
- Existing Accounts updated safely.
- Manual display_name preserved.
- Missing source Accounts surfaced for explicit handling.
- Store source file hash and import stats.
- Detect probable wrong Panel/Company source.
- Import audit log.

### Account
- stable source username/UUID identity
- original_name
- display_name
- rate type
- active/inactive
- panel/company relationships
- last seen metadata

### Acceptance
Importing the same fixture twice is idempotent. Manual display names survive sync. Wrong-panel imports are blocked/warned.

---

## Phase 3 — Daily Report_WL accounting workflow

### Import
- Company selection required.
- Daily business date required.
- XLS/XLSX Report_WL upload.
- Parse Username and Member Win.
- Ignore total/grand-total rows.
- Match Accounts to Panels.
- Detect foreign-company report.
- Detect unknown accounts.
- Duplicate fingerprinting.

### Unknown Account workflow
Offer:
1. temporary row for this report only
2. controlled registration path

Permanent registration must not fabricate a fake source UUID. Preferred path is syncing the correct Panel AccountSettings.

### Calculation
Central server-side accounting service.

For member_win < 0:
- gross = abs(member_win) * rate
- commission = gross * loss_percent / 100
- received = gross - commission
- paid = 0

For member_win > 0:
- paid = member_win * rate
- received = 0
- commission = 0

For member_win = 0:
- all values zero

### Preview
Three-step UX:
1. data entry
2. preview/edit
3. final output

Preview step must not keep the import/rates form visible.

Editable row actions:
- edit
- delete with confirmation
- add manual row
- switch outcome loss/win/zero
- edit amount
- edit rate
- edit percentage where applicable
- totals recalculate immediately

Back to Step 1 must preserve draft state.

### Finalization
- Server recalculates all rows.
- Revalidate Company and Account ownership.
- Revalidate unknown-account policy.
- Revalidate duplicate policy.
- Store report + rows atomically.
- Store snapshots of names, rates, percentages.
- Store source metadata/hash.
- Store totals.
- Store revision/audit record.
- Final output opens immediately after save.

### Acceptance
Server totals match fixture expectations and cannot be forged by editing client-side requests.

---

## Phase 4 — Customer identity, grouping and ledger

### Customer management
- Create/edit customer.
- Search by:
  - display name
  - original name
  - username/UUID
  - panel
  - company
- active/inactive state.

### Account grouping
- group multiple Accounts under one Customer.
- ungroup/reassign.
- suffix-number heuristics can suggest grouping but never silently apply it.

### Customer ledger
Clicking a customer/name in final accounting output must open the grouped customer account.

Ledger includes:
- all linked Accounts
- row history
- received
- paid
- commission
- net balance
- company/panel/account context

### Customer output/share
- customer image output
- download
- Web Share API
- Telegram/WhatsApp flow where supported
- fallback share/download behavior

### Acceptance
A customer with several Accounts across Panels is shown as one grouped ledger with correct net totals.

---

## Phase 5 — Reporting and archive

### Filters
- date range
- company
- panel
- customer
- report type

### Daily
- one stored daily report per row
- no date range => last 10 matching reports
- open stored report
- edit stored daily report with revision history

### Monthly
- aggregate daily reports by month
- no range => last 10 month periods
- totals and site result

### Multi-month
- explicit meaningful date range
- aggregate by month
- totals and site result

### Detailed ledger
- underlying rows/accounts/customers
- no range => data from last 10 stored reports
- filters apply consistently

### Summary
Any multi-row report shows:
- total received
- total paid
- total commission
- site_net
- explicit site win/loss/settled status

### Acceptance
All report types derive from stored DB data and use the same accounting definitions.

---

## Phase 6 — Exports and printable outputs

### PDF/Print
- clean print-only document
- no application buttons/navigation
- current dataset only
- theme colors preserved
- text color preserved
- background opacity represented
- totals follow table without overlap
- mobile UI does not affect print layout

### Excel
- current dataset only
- headers
- rows
- totals
- semantic background colors
- text colors
- approximate opacity by pre-blending with white if native opacity is unavailable
- correct numeric values, not formatted strings as source of truth

### Customer image
- grouped ledger image
- theme/typography consistency

### Summary image
- grouped customers
- same-customer offset/netting
- received/payment columns
- totals and site result

### Acceptance
Exports match the current previewed dataset, not a stale previous report.

---

## Phase 7 — Settings, number format, theme and fonts

### Money display
- full value
- trim 3 zeros
- trim 4 zeros

This changes input/display convention only. Canonical DB money remains full precision.

### Digit style
- Persian digits
- English digits

Must apply consistently to:
- UI
- reports
- final output
- dates where appropriate
- PDF/print
- image exports

### Accounting theme
Per category:
- background color
- background opacity
- text color

Categories:
- received/customer loss
- paid/customer win
- commission
- site win
- site loss

Live preview required.

### Typography
Available product choices:
- Vazirmatn
- IRANSans

Admin-selectable areas:
- global UI
- headings/titles
- forms/inputs/selects/buttons
- accounting/report tables
- printable/PDF output

### Font asset policy
Font binary availability must be deployment-configurable. Do not publish proprietary font binaries in the public repository unless license permission is confirmed.

### Acceptance
Changing a setting updates real UI previews and subsequent exports consistently.

---

## Phase 8 — Dashboard and product UX parity

### Dashboard
- current-period received
- current-period paid
- commission
- site result
- recent activity/reports
- recent trend visualization

### Navigation
Mobile-first navigation:
- home
- companies
- entry
- customers
- reporting
- settings access
- logout

### Responsive behavior
- iPhone SE class width supported
- no accidental horizontal page scroll
- accounting tables remain usable
- modals/bottom sheets mobile-friendly

### Login presentation
Keep the approved visual/game concept if desired, but treat it only as presentation.

Real authentication remains server-side.

### Acceptance
Core production UI retains the recognizable approved V32 workflow and layout logic.

---

## Phase 9 — PWA

### Deliverables
- manifest.webmanifest
- icons
- service worker
- installability
- offline shell for static UI
- update strategy/versioning
- safe cache invalidation

### Financial safety
Never allow stale offline cached data to silently finalize a financial write.
Writes require live server confirmation.

### Acceptance
Installable on supported mobile browsers and updates safely without stale accounting logic.

---

## Phase 10 — Developer operations

### Developer panel
- health
- system log
- error log
- audit log
- migration status
- application version
- backup status

### Backup
- DB backup
- optional app/config backup excluding unsafe secrets as appropriate
- download
- retention
- restore procedure
- restore dry-run/validation where practical

### Audit
Track sensitive writes:
- login/security events
- Company/Panel changes
- AccountSettings sync
- report finalization/edit
- customer regrouping
- settings changes
- token creation/revoke
- restore operations

### Acceptance
A developer can diagnose the app without direct DB browsing for ordinary failures.

---

## Phase 11 — MCP

### Architecture
MCP must call the same Application Services as UI.

Never:
- duplicate accounting formulas in MCP
- grant raw SQL access by default
- bypass authorization/audit

### Token management
- named tokens
- hashed at rest
- scope list
- optional expiry
- revoke
- last used
- audit

### Planned scope families
- read:companies
- read:panels
- read:accounts
- read:customers
- read:reports
- write:reports
- write:customers
- admin:settings
- admin:backup
- admin:diagnostics

### Acceptance
An MCP-created/read report produces the same accounting result as UI for the same inputs.

---

## Phase 12 — Hardening, migration and production release

### Tests
- fixture parser tests
- accounting calculation tests
- duplicate tests
- import sync tests
- auth/authorization tests
- CSRF tests
- report aggregation tests
- export dataset tests
- settings presentation tests

### Production
- cPanel deployment guide
- document-root hardening
- cron needs documented
- PHP limits documented
- backup/restore drill
- clean install drill
- upgrade/migration drill
- rollback procedure
- error reporting disabled to users
- logs retained privately

### Acceptance
A fresh production installation and an upgrade from previous schema both succeed using documented steps.

---

# Definition of Done for the whole migration

The migration is not finished merely because the backend exists.

It is finished when every item in FEATURE_PARITY_MATRIX.md is either:
- implemented and tested, or
- explicitly marked as intentionally changed/removed with a documented product decision.
