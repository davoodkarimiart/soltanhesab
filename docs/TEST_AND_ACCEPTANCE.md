# Test and Acceptance Strategy

The migration should be verified against known spreadsheet fixtures and the V32 prototype behavior.

## Test layers

### 1. Parser tests
AccountSettings:
- valid source
- missing required headers
- duplicate source rows
- new Accounts
- existing Accounts
- missing Accounts
- wrong-panel source

Report_WL:
- valid Username/Member Win
- totals/grand-total rows ignored
- unknown Username
- foreign-company mix
- empty report
- duplicate file/content

### 2. Accounting unit tests

Loss row:
- negative member_win
- rate
- percentage
- expected gross
- expected commission
- expected received

Win row:
- positive member_win
- expected paid
- zero commission

Zero row.

Special rate.

Decimal member_win values.

Rounding policy edge cases.

### 3. Site result tests
- received > paid => win
- received < paid => loss
- equal => settled

Same expected label and status across every output/report type.

### 4. Sync tests
- second identical AccountSettings import does not duplicate Accounts
- display_name survives
- original_name changes are tracked safely if source changes
- new source Account appears
- missing source Account is surfaced
- wrong Panel is rejected/warned

### 5. Workflow tests
- Step 1 -> Step 2
- preview hides import form
- back preserves draft
- edit row recalculates
- delete row recalculates
- add row recalculates
- final save stores server result
- duplicate blocked
- reopen stored report

### 6. Customer tests
- group multiple Accounts
- ungroup
- customer ledger includes all linked Accounts
- search by all supported identifiers
- click from final output opens correct grouped Customer

### 7. Reporting tests
Daily:
- filters
- last 10 fallback
- totals

Monthly:
- monthly grouping
- last 10 month fallback
- totals

Multi-month:
- range
- grouping
- totals

Ledger:
- underlying rows
- last 10 report fallback
- totals

### 8. Export tests
PDF:
- no buttons
- no navigation
- current dataset
- theme
- text colors
- opacity
- totals
- no overlap
- page break

Excel:
- current dataset
- totals
- numeric values
- semantic colors
- text colors

Image:
- customer
- summary
- correct grouping/netting

### 9. Settings tests
- money full
- trim 3
- trim 4
- Persian digits
- English digits
- theme per semantic category
- opacity
- text color
- global font
- heading font
- forms font
- tables font
- print font

### 10. Security tests
- login success/failure
- session fixation prevention
- logout
- rate limit
- CSRF
- Admin vs Developer authorization
- direct endpoint authorization
- token scope checks
- installer locked after install

## Golden fixtures

Before relying on automated CI, create sanitized fixtures derived from real source shapes:
- account-settings-shahin-sanitized.xlsx
- report-wl-loss-win-mixed.xlsx
- report-wl-unknown-account.xlsx
- report-wl-wrong-company.xlsx
- expected-daily-result.json
- expected-customer-grouping.json

Golden expected data should include exact decimal values before display formatting.

## Definition of accepted phase

A phase is accepted only when:
1. its deliverables exist,
2. its acceptance tests pass,
3. no previously accepted feature in FEATURE_PARITY_MATRIX regresses,
4. DB migration/rollback or backup procedure is documented where schema changed.
