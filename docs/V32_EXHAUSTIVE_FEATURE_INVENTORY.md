# V32 Exhaustive Feature Inventory

Source audited: soltanhesab-full-functional-preview-v32(1).html

Purpose: preserve every meaningful option/behavior from the latest approved single-file prototype before migration to the real website.

This inventory complements FEATURE_PARITY_MATRIX.md. If an item exists here but is not implemented on the production site, migration is incomplete unless there is an explicit documented product decision.

## 1. Login / access presentation
- Full-screen login screen.
- Separate desktop/mobile visual treatment.
- Hidden clickable left/right hand regions.
- Random correct-hand game.
- Wrong hand does not advance.
- Correct hand reveals login panel.
- Closing login panel resets game.
- Username/password inputs.
- Password visibility toggle.
- Human checkbox.
- Arithmetic puzzle/captcha UI.
- Login button.
- Forgot-password UI action.
- Logout action.
- Settings shortcut in top bar.
- Real production implementation must replace demo auth with server session/security while preserving approved presentation.

## 2. Main shell / navigation
- Brand: سلطان حساب.
- Top settings shortcut.
- Top logout.
- Bottom mobile navigation:
  - Home
  - Companies
  - Accounting entry
  - Customers
  - Reporting
- Active navigation state.
- Mobile-first responsive shell.

## 3. Dashboard
- Accounting dashboard hero.
- Current-period Received stat.
- Current-period Paid stat.
- Commission stat.
- Site Win/Loss stat.
- Quick actions:
  - Enter report
  - Customers
  - Archive/reports
  - Companies
- Seven-period trend chart placeholder/contract.
- Latest activity section.

## 4. Companies
- Companies/Panels page.
- Add Company/Panel action.
- Company cards/list.
- Company status/context display.
- Company edit/settings entry where legacy UI still exposes it.
- Final production rule: customer name display mode is Panel-level, not Company-level.

## 5. Panels
- Multiple Panels under one Company.
- Panel name.
- Panel-level AccountSettings source.
- Panel-level customer-name display mode:
  - display/Persian
  - original AccountSettings name
- Panel create/update modal.
- AccountSettings file picker.
- Import / Sync action.
- Import status.
- Safe sync note/behavior.
- Duplicate Username should not create duplicate Account.
- Similar/wrong Panel source warning behavior.

## 6. Customers page
- Customer list.
- Search field across:
  - display/Persian name
  - original/source name
  - Username
  - Panel
  - Company
- Company filter.
- Panel filter.
- Customer profile modal.
- Customer original name.
- Customer display/Persian name.
- Username/UUID/account identity.
- Company/Panel context.
- Rate type.
- Active/inactive context.
- Multi-Account grouping under one Customer.
- Ungroup/reassign behavior in final production model.

## 7. Accounting entry — Step 1
- Daily accounting input only.
- Report_WL file picker.
- General/default rate.
- Special rate.
- Customer-loss percentage.
- Required Company selector.
- Jalali/Persian report date input.
- Hidden canonical report date.
- Calculate/build preview action.
- Duplicate test override checkbox.
- Clear duplicate-test history action.
- Money-scale-aware rate entry/display contract.
- Company validation against report Account matches.
- Wrong-company report warning/block.
- Unknown Account detection.

## 8. Accounting entry — Step 2 Preview/Edit
- Import form hidden after preview.
- Preview Company/accounting title.
- Classic accounting table.
- Columns:
  - Customer name
  - Username
  - Customer percentage
  - Loss/member-win dollar side
  - Received Toman
  - Win/member-win dollar side
  - Paid Toman
- Semantic Commission/Received/Paid styling.
- Immediate totals.
- Back to entry without losing draft.
- Add row action.
- Add-new-row action on mobile/preview.
- Preview Excel export.
- Finalize and show output.
- Cancel/reset preview.
- Row edit modal/sheet.
- Row outcome selector:
  - loss
  - win
  - zero
- Amount edit.
- Rate edit.
- Percentage edit.
- Percentage disabled/irrelevant for win/zero.
- Delete row with confirmation.
- Mobile-specific row action treatment.

## 9. Unknown Account modal
- Explicit warning that Username is not in AccountSettings.
- Register in AccountSettings + report option.
- Temporary-current-report-only option.
- Cancel option.
- Production safety rule: do not invent a fake source UUID; safest permanent route is correct Panel AccountSettings sync.

## 10. Accounting calculation contract
- Negative Member Win = customer loss/site receives.
- gross = abs(Member Win) * rate.
- commission = gross * loss percentage / 100.
- received = gross - commission.
- Positive Member Win = customer win/site pays.
- paid = Member Win * rate.
- winner commission effect = zero.
- zero Member Win = zero financial values.
- Site net = total received - total paid.
- Positive = Site Win.
- Negative = Site Loss.
- Zero = Settled.
- Server-side decimal-safe calculation is authoritative in production.

## 11. Final accounting output
- Final Company/accounting title.
- Classic final table.
- Totals.
- Explicit Site Win/Loss/Settled result.
- Clickable customer/name.
- Click opens grouped Customer account card.
- Summary-image action.
- Excel export.
- PDF/Print action.
- Edit stored report action.
- New report action.
- No whole-report Telegram/WhatsApp button in final report toolbar.

## 12. Customer account card
- Grouped customer account across all linked Accounts.
- Classic account table.
- Account rows.
- Customer totals.
- Net/balance.
- Display-name correction/edit section.
- Save customer-account image.
- Share image.
- WhatsApp share target.
- Telegram share target.
- Share status.
- Image preview.

## 13. Summary settlement image
- Summary settlement modal.
- Group Accounts by Customer.
- Net/offset same Customer before listing.
- Received list.
- Paid list.
- Total received.
- Total paid.
- Site result.
- Save image.
- Send/share to Telegram.
- Send/share to WhatsApp.
- Preview generated summary image.

## 14. Stored-report history
- Local prototype history becomes DB history.
- Reopen stored report.
- Edit stored report.
- Revision/Audit history.
- Historical snapshot of calculation inputs.
- Duplicate fingerprint/history behavior.

## 15. Reporting / archive
- Archive/reporting/search page.
- Apply-filter action.
- Report type selector:
  - Daily
  - Monthly
  - Multi-month
  - Detailed ledger
- Company filter.
- Panel filter.
- Customer text filter.
- From date.
- To date.
- Jalali-facing date controls with hidden canonical values.
- Current result title.
- Current report table.
- Report summary totals.
- Excel report export.
- PDF/Print report export.

### Daily semantics
- One stored Daily Report per row.
- No range => last 10 matching Daily Reports.
- Open stored report.
- Edit where allowed.
- Received / Paid / Commission / explicit Site result.

### Monthly semantics
- Aggregate daily reports by month.
- No range => last 10 monthly periods.
- Totals and Site result.

### Multi-month semantics
- Meaningful date range.
- Group by month.
- Totals and Site result.

### Detailed ledger semantics
- Underlying Customer/Account rows.
- No range => data from last 10 Reports.
- All filters apply.

## 16. Reporting visual semantics
- Received semantic category.
- Paid semantic category.
- Commission semantic category.
- Site Win semantic category.
- Site Loss semantic category.
- Settled state.
- Same colors/text rules apply to report table and summary.

## 17. PDF / Print
- Clean document.
- Application buttons/navigation excluded.
- Current report dataset, never stale previous report.
- Correct title/date/filter context.
- Theme background colors.
- Theme text colors.
- Theme opacity.
- Received/Paid/Commission/Site result consistency.
- Totals after table.
- Page-break handling.
- No overlap.
- Final-accounting print path.
- Analytics/reporting print path.

## 18. Excel
- Preview Excel export.
- Final-report Excel export.
- Analytics/report Excel export.
- Current dataset only.
- Headers.
- Rows.
- Totals.
- Numeric semantics where possible.
- Semantic colors.
- Text colors.
- Opacity approximated by blending with white because SpreadsheetML does not provide normal CSS opacity.
- Explicit Site Win/Loss/Settled result.

## 19. Default accounting settings
- Default general rate.
- Default special rate.
- Default loss percentage.
- Legacy default-name mode exists in prototype data; production authoritative display-name choice is Panel-level.
- Money display/input scale:
  - full
  - trim 3 zeros
  - trim 4 zeros
- Dynamic amount/rate entry hint based on selected scale.
- Numeral mode:
  - Persian digits
  - English digits
- Save defaults.
- Settings persist.

## 20. Theme settings
Semantic categories:
- Received / customer loss.
- Paid / customer win.
- Commission.
- Site Win.
- Site Loss.

Per category:
- background color.
- background opacity 0–100.
- text color.
- live miniature preview.
- save/persist.
- apply live to screen.
- apply to final report.
- apply to analytics/reporting.
- apply to Print/PDF.
- apply to Excel where possible.

V32 Theme is the authoritative theme layer over older color settings.

## 21. Typography settings required for production
Not yet fully present in V32 UI, but explicitly approved for the website:
Fonts:
- Vazirmatn.
- IRANSans.

Independent areas:
- global UI.
- headings/titles.
- forms/inputs/selects/buttons.
- accounting/report tables.
- print/PDF.

Font choices persist and affect preview/output consistently.

## 22. Admin/Developer cards already represented in V32
- MCP management card:
  - Read / Write / Full Access concept
  - revoke token
  - AI operation Audit
- Telegram Backup card:
  - Bot token
  - Chat/Channel ID
  - scheduled backup
  - manual send
- Audit Log card:
  - report changes
  - imports
  - customer edits
  - MCP operations
- System Health card:
  - Database
  - disk space
  - latest backup
  - import errors
  - application version

These are represented in V32 as scope placeholders and are mandatory to make functional on the production site.

## 23. Logging required beyond the visible V32 cards
Three separate concerns:
- Audit Log.
- System/Operational Log.
- Debug/Error Log.
Debug/Error details are Developer-only and redacted in production.

## 24. Backup/Telegram required production behavior
- Manual DB backup.
- Scheduled DB backup via cPanel-compatible cron.
- Local host backup storage.
- Retention/rotation.
- Telegram delivery.
- Delivery status/retry.
- If Telegram fails, local backup must remain.
- Developer-only download/restore.
- Restore audit.
- Pre-restore safety backup where practical.

## 25. MCP required production behavior
- MCP uses the same Application Services/Domain rules as the UI.
- Token management.
- Read/Write/Full or equivalent scoped permission model.
- Revoke.
- Audit.
- No direct duplicate accounting logic.
- No default raw SQL access.
- Read Company/Panel/Account/Customer/Report.
- Controlled Report/Customer writes.
- Settings/backup/diagnostic scopes.

## 26. Health / Developer operations
- Database health.
- storage/disk health.
- app version.
- schema/migration status.
- latest backup.
- import errors.
- system log.
- debug/error log.
- audit log.
- Telegram backup status.
- MCP token/usage status.

## 27. Mobile-first behavior
- No page-level horizontal scroll.
- Narrow iPhone-class widths.
- Bottom navigation.
- Mobile-friendly edit sheets/modals.
- Small-screen accounting tables.
- Mobile login crop/hitbox behavior.
- Touch-friendly actions.
- Prevent unwanted iOS input-focus zoom in production.
- Safe-area support.
- Mobile keyboard must not hide critical primary actions.
- Desktop stays functional.

## 28. PWA
- Installable.
- manifest.
- service worker.
- icons.
- update/version strategy.
- safe cache invalidation.
- standalone/mobile shell.
- offline static shell where safe.
- no offline finalization of financial writes without live server confirmation.

## 29. Data migration rule
Prototype localStorage concepts become durable DB entities/settings, including:
- companies/panels.
- report history.
- duplicate fingerprints.
- defaults.
- money scale.
- numeral mode.
- accounting colors/theme/opacity/text colors.

Production DB is canonical; browser localStorage is not financial source of truth.

## 30. No-detail-loss rule
Before a production release:
1. Compare the production site against this inventory.
2. Compare against FEATURE_PARITY_MATRIX.md.
3. Compare against BUSINESS_RULES.md.
4. Run golden fixture tests.
5. Any missing V32 feature is a bug unless explicitly documented as intentionally replaced/removed.
