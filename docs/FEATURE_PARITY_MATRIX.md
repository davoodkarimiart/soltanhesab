# V32 Feature Parity Matrix

This checklist is the migration contract from the approved single-file prototype to the production website.

Status legend:
- [ ] not implemented
- [~] partially implemented
- [x] implemented and acceptance-tested

## Login / session
- [ ] Full-screen approved login visual.
- [ ] Mobile-specific login image behavior/crop.
- [ ] Hidden clickable hand regions.
- [ ] Correct-hand reveal behavior.
- [ ] Wrong hand does nothing and does not rerandomize.
- [ ] Closing login form starts a new randomized game.
- [ ] Arithmetic anti-bot UI if retained.
- [ ] Forgot-password UI/flow.
- [ ] Real server-side login.
- [ ] Logout returns to login and resets presentation state.
- [ ] Login rate limiting.
- [ ] Secure sessions.

## Dashboard
- [ ] Dashboard page.
- [ ] Current period received total.
- [ ] Current period paid total.
- [ ] Commission total.
- [ ] Site win/loss status.
- [ ] Recent reports/activity.
- [ ] Recent period trend visualization.
- [ ] Quick navigation cards.

## Companies
- [ ] Company list.
- [ ] Create Company.
- [ ] Edit Company.
- [ ] Activate/deactivate Company.
- [ ] Company-level data isolation/filtering.

## Panels
- [ ] Multiple Panels per Company.
- [ ] Create Panel.
- [ ] Edit Panel.
- [ ] Activate/deactivate Panel.
- [ ] Panel name.
- [ ] Panel-level AccountSettings.
- [ ] Panel-level display-name mode.
- [ ] One Panel may use original names while another Panel in same Company uses display names.

## AccountSettings
- [ ] Upload XLS/XLSX.
- [ ] Initial Account import.
- [ ] Re-import/sync.
- [ ] Detect existing Accounts.
- [ ] Add new Accounts.
- [ ] Handle missing/deleted source Accounts explicitly.
- [ ] Preserve original_name exactly.
- [ ] Preserve manual display_name across sync.
- [ ] Stable username/UUID matching.
- [ ] Warn/block probable wrong Panel source.
- [ ] Import history.
- [ ] Import file hash.
- [ ] Import stats.
- [ ] Account active/inactive state.

## Accounts / customers
- [ ] Customer search by Persian/display name.
- [ ] Customer search by original name.
- [ ] Customer search by Username/UUID.
- [ ] Customer search by Panel.
- [ ] Customer search by Company.
- [ ] Customer profile.
- [ ] Original name visible.
- [ ] Display/Persian name visible/editable.
- [ ] Username/UUID visible.
- [ ] Company visible.
- [ ] Panel visible.
- [ ] Rate type visible/editable.
- [ ] Active/inactive state.
- [ ] Group several Accounts under one Customer.
- [ ] Ungroup/reassign Account.
- [ ] Suggested grouping from trailing numeric suffix.
- [ ] Suggestions never silently alter ownership.

## Accounting entry step 1
- [ ] Entry page.
- [ ] Report_WL file upload.
- [ ] Daily report only.
- [ ] Required report date.
- [ ] Jalali/Persian-friendly display.
- [ ] Required Company selector.
- [ ] Company list from stored Companies/AccountSettings context.
- [ ] General/default rate input.
- [ ] Special rate input.
- [ ] Customer-loss percentage input.
- [ ] Money-scale-aware rate entry help.
- [ ] Calculate/build preview button.
- [ ] Report validation against selected Company.
- [ ] Wrong-company report warning/block.
- [ ] Duplicate report detection.
- [ ] Optional developer/test override only if intentionally retained.

## Accounting entry step 2 — preview/edit
- [ ] Import/rate form hidden in preview step.
- [ ] Preview title/company context.
- [ ] Classic accounting table.
- [ ] Customer/account display name resolved by Panel policy.
- [ ] Username visible.
- [ ] Commission column.
- [ ] Dollar/member-win values.
- [ ] Received column.
- [ ] Paid column.
- [ ] Totals recalculate immediately.
- [ ] Add row.
- [ ] Edit row in mobile-friendly modal/sheet.
- [ ] Delete row with confirmation.
- [ ] Outcome selector: customer loss / customer win / zero.
- [ ] Percentage disabled for win/zero.
- [ ] Amount editing.
- [ ] Rate editing.
- [ ] Back to step 1 without losing draft.
- [ ] Final save button directly opens final output.

## Unknown account workflow
- [ ] Detect Username absent from AccountSettings.
- [ ] Explain warning.
- [ ] Temporary current-report row option.
- [ ] Controlled register option.
- [ ] Warn that correct Panel AccountSettings sync is safest.
- [ ] Never invent source UUID silently.

## Accounting formulas
- [ ] General/default rate.
- [ ] Special rate.
- [ ] member_win < 0 loss formula.
- [ ] member_win > 0 win formula.
- [ ] member_win = 0.
- [ ] Percentage affects loss side only.
- [ ] Site net = received - paid.
- [ ] Positive site net = site win.
- [ ] Negative site net = site loss.
- [ ] Zero = settled.
- [ ] Decimal-safe server arithmetic.
- [ ] Server is authoritative, not client values.

## Final accounting output
- [ ] Final output opens immediately after save.
- [ ] Classic table structure.
- [ ] Customer/name cell clickable.
- [ ] Click opens grouped customer ledger.
- [ ] Commission semantic color.
- [ ] Received semantic color.
- [ ] Paid semantic color.
- [ ] Site result explicit: win/loss/settled.
- [ ] Site result semantic color.
- [ ] Totals.
- [ ] Edit stored report action.
- [ ] New report action.
- [ ] Excel export.
- [ ] PDF/Print export.
- [ ] Summary image export.
- [ ] No whole-report WhatsApp/Telegram button unless later explicitly approved.

## Customer ledger dialog
- [ ] Aggregates all Accounts belonging to same Customer.
- [ ] Shows account rows.
- [ ] Shows totals.
- [ ] Shows net/balance.
- [ ] Allows display-name editing where appropriate.
- [ ] Customer image generation.
- [ ] Save/download image.
- [ ] Share flow.
- [ ] Telegram/WhatsApp share/fallback flow.

## Summary image
- [ ] Groups Accounts by Customer.
- [ ] Nets same Customer.
- [ ] Received list.
- [ ] Paid list.
- [ ] Total received.
- [ ] Total paid.
- [ ] Explicit site result.
- [ ] Theme-aware.
- [ ] Font-aware.
- [ ] Save/download.
- [ ] Share.

## Stored reports
- [ ] Daily report stored in DB.
- [ ] Reopen stored report in final form.
- [ ] Edit stored daily report.
- [ ] Revision history/audit.
- [ ] Snapshot rate/percentage/name semantics preserved.
- [ ] New current settings do not silently rewrite old financial history.

## Reporting filters
- [ ] Date from.
- [ ] Date to.
- [ ] Company.
- [ ] Panel.
- [ ] Customer.
- [ ] Report type.

## Daily report view
- [ ] One stored DailyReport per row.
- [ ] Last 10 when date range omitted.
- [ ] Received colored.
- [ ] Paid colored.
- [ ] Commission colored.
- [ ] Explicit win/loss/settled status.
- [ ] Site result colored.
- [ ] Open report.
- [ ] Edit where allowed.
- [ ] Summary totals for multi-row view.

## Monthly report view
- [ ] Aggregate by month.
- [ ] Last 10 month periods when no range.
- [ ] Received.
- [ ] Paid.
- [ ] Commission.
- [ ] Explicit site result.
- [ ] Summary totals.

## Multi-month report view
- [ ] Date range.
- [ ] Monthly grouping.
- [ ] Received.
- [ ] Paid.
- [ ] Commission.
- [ ] Site result.
- [ ] Summary totals.

## Detailed ledger report
- [ ] Underlying customer/account rows.
- [ ] Last 10 reports when no range.
- [ ] All report filters apply.
- [ ] Summary totals.

## PDF/Print
- [ ] Clean document only.
- [ ] No application buttons.
- [ ] No nav.
- [ ] Current preview dataset.
- [ ] Correct title/date/filter context.
- [ ] Received background/text.
- [ ] Paid background/text.
- [ ] Commission background/text.
- [ ] Site win background/text.
- [ ] Site loss background/text.
- [ ] Opacity.
- [ ] Totals.
- [ ] No overlap.
- [ ] Proper page breaks.
- [ ] Font setting respected.
- [ ] Digit style respected.

## Excel
- [ ] Current preview dataset.
- [ ] Proper headers.
- [ ] Numeric cells remain numeric where possible.
- [ ] Semantic colors.
- [ ] Text colors.
- [ ] Approximate opacity by color blending if needed.
- [ ] Totals.
- [ ] Explicit site result.
- [ ] Digit/display settings applied appropriately without corrupting numeric semantics.

## Global settings
- [ ] General/default rate.
- [ ] Special rate.
- [ ] Default loss percentage.
- [ ] Money scale: full.
- [ ] Money scale: trim 3 zeros.
- [ ] Money scale: trim 4 zeros.
- [ ] Rate-entry example/help updates with scale.
- [ ] Persian digit mode.
- [ ] English digit mode.

## Theme settings
For each category below:
- [ ] background color
- [ ] opacity slider/control
- [ ] text color
- [ ] live preview
- [ ] save/persist
- [ ] apply to screen preview
- [ ] apply to final output
- [ ] apply to reports
- [ ] apply to PDF/print
- [ ] apply to Excel where possible

Categories:
- [ ] received/customer loss
- [ ] paid/customer win
- [ ] commission
- [ ] site win
- [ ] site loss

## Font settings
Fonts:
- [ ] Vazirmatn
- [ ] IRANSans

Areas:
- [ ] whole site/global UI
- [ ] headings/titles
- [ ] forms/inputs/selects/buttons
- [ ] accounting/report tables
- [ ] PDF/print output

Behavior:
- [ ] live preview where useful
- [ ] persistence
- [ ] mobile readability
- [ ] fallback stack
- [ ] deployment font asset availability check

## Mobile UX
- [ ] Mobile-first layout.
- [ ] iPhone SE width usable.
- [ ] No page-level horizontal scroll.
- [ ] Inputs/selects touch-friendly.
- [ ] Edit modals/sheets touch-friendly.
- [ ] Tables usable at narrow widths.
- [ ] Bottom navigation.
- [ ] Login composition/crop tuned for mobile.
- [ ] Desktop remains usable.

## PWA
- [ ] manifest.
- [ ] icons.
- [ ] service worker.
- [ ] installable.
- [ ] update strategy.
- [ ] safe cache invalidation.
- [ ] no offline financial finalization without live confirmation.

## Admin / Developer
- [ ] Admin role.
- [ ] Developer role.
- [ ] Developer diagnostics.
- [ ] Health checks.
- [ ] Audit logs.
- [ ] Error logs.
- [ ] System logs.
- [ ] Backup.
- [ ] Restore procedure.
- [ ] Migration status.

## MCP
- [ ] MCP token management.
- [ ] Token name.
- [ ] Hashed token storage.
- [ ] Scopes.
- [ ] Revoke.
- [ ] Optional expiry.
- [ ] Last used.
- [ ] Audit.
- [ ] Read companies.
- [ ] Read panels/accounts.
- [ ] Read customers.
- [ ] Read reports.
- [ ] Controlled write reports.
- [ ] Controlled customer writes.
- [ ] Settings scope.
- [ ] Backup/diagnostics scopes.
- [ ] Same Application Services as UI.
