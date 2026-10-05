# Business Rules

These rules are authoritative unless a later explicit product decision changes them.

## 1. Company, Panel, Account, Customer

- One Company has many Panels.
- One Panel belongs to exactly one Company.
- One Panel owns its AccountSettings import/sync context.
- One Account belongs to one Panel.
- Customer is a separate aggregate identity.
- One Customer can group several Accounts.
- Account identity must rely on stable source username/UUID, not a display label.

## 2. Names

Store separately:
- original_name: exact source value
- display_name: manual/user-facing value

Manual display_name survives later AccountSettings sync.

Name display policy belongs to the Panel, not the Company.

Allowed Panel display modes:
- original
- display

Different Panels in the same Company may use different modes.

## 3. AccountSettings sync

First import:
- creates source Accounts.

Later import:
- identifies existing Accounts.
- updates source fields safely.
- adds new Accounts.
- identifies missing source Accounts.
- does not silently delete user history.
- preserves manual display_name.
- stores import metadata and hash.

If the source appears to belong to another Panel/Company:
- warn and block unsafe replacement.

## 4. Daily Report_WL

Current business input type is daily only.

Required before preview:
- report file
- report date
- selected Company
- rates/percentage required by the current workflow

Report usernames are matched to Accounts.

If recognized usernames indicate another Company:
- stop processing/finalization and show a clear error.

Panel is inferred from Account matching.

## 5. Unknown Account

When Report_WL contains an unknown Username:
- allow temporary row for the current report, or
- use controlled registration flow.

Do not fabricate a source UUID.

Preferred permanent resolution:
- sync the correct Panel AccountSettings.

## 6. Rate types

Supported:
- default/general
- special

Account/Customer business configuration resolves which rate applies.

The exact precedence rule between Account and Customer overrides must be kept explicit in implementation and covered by tests.

## 7. Accounting formulas

Use decimal-safe arithmetic.

### Customer loss / site receives

Condition:
member_win < 0

Calculation:
gross = abs(member_win) * rate
commission = gross * loss_percent / 100
received = gross - commission
paid = 0

### Customer win / site pays

Condition:
member_win > 0

Calculation:
received = 0
commission = 0
paid = member_win * rate

Loss percentage has no accounting effect on a winning row.

### Zero

Condition:
member_win = 0

Calculation:
received = 0
commission = 0
paid = 0

## 8. Site result

site_net = total_received - total_paid

- site_net > 0 => SITE_WIN
- site_net < 0 => SITE_LOSS
- site_net = 0 => SETTLED

This definition must be identical in:
- final daily output
- dashboard
- daily report list
- monthly report
- multi-month report
- detailed ledger summaries
- PDF
- Excel
- MCP

## 9. Preview editing

Preview can:
- add row
- edit row
- delete row with confirmation
- change outcome loss/win/zero
- change amount
- change rate
- change percentage where valid

Changing outcome recalculates the row using the central accounting service.

## 10. Finalization

The server:
- does not trust client totals.
- recalculates rows.
- validates Company ownership.
- validates duplicate policy.
- validates unknown Account handling.
- stores report and rows atomically.
- stores source metadata/hash.
- stores name/rate/percentage snapshots.
- stores totals.
- writes audit/revision data.

## 11. Stored report edits

Editing an old report must preserve historical semantics.

Do not silently apply today's changed rates or display configuration to historical financial calculations.

Financial snapshots are historical.

Pure presentation settings such as font/theme/digit style may be rendered using current settings unless a later product decision adds historical presentation snapshots.

## 12. Customer grouping

Grouping is explicit.

Trailing-number name cleanup can suggest likely groups but never silently merges Accounts.

Customer ledger:
customer_net = sum(received - paid)

## 13. Reporting

Daily:
- one row per stored daily report
- without date range => last 10 matching reports

Monthly:
- aggregate stored daily reports per month
- without date range => last 10 monthly periods

Multi-month:
- uses a meaningful date range
- groups by month

Detailed ledger:
- shows underlying rows/accounts/customers
- without date range => data from last 10 reports

All multi-row reports show totals and explicit site status.

## 14. Money scale

Options:
- full
- trim_3
- trim_4

This changes display/input convention only.

Canonical financial values are stored in complete units in the database.

## 15. Digits

Global display mode:
- fa
- en

Digit localization must not change numeric meaning or database values.

## 16. Theme

Semantic categories:
- received/customer loss
- paid/customer win
- commission
- site win
- site loss

Each category stores:
- background color
- opacity
- text color

Theme applies consistently to screen and outputs.

## 17. Fonts

Admin can choose between available product fonts for:
- global UI
- headings
- forms/buttons
- accounting/report tables
- print/PDF

Supported planned fonts:
- Vazirmatn
- IRANSans

Font binary deployment is separate from business configuration.

## 18. Security boundary

The login game/captcha in the prototype is not a security boundary.

Real security:
- password hashing
- server-side session
- CSRF
- authorization
- login rate limiting
- protected secrets
- audit
