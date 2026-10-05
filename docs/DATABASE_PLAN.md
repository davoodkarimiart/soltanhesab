# Database Plan

Initial production schema plan. Exact column precision can be refined from fixture tests before migration freeze.

## users
- id
- username
- email nullable
- password_hash
- role: admin|developer
- active
- last_login_at
- created_at
- updated_at

## companies
- id
- name
- active
- created_at
- updated_at

## panels
- id
- company_id
- name
- display_name_mode: original|display
- active
- created_at
- updated_at

## accounts
- id
- panel_id
- source_username
- source_uuid nullable
- original_name
- display_name nullable
- rate_type: default|special
- active
- source_payload_json nullable
- first_seen_at
- last_seen_at
- created_at
- updated_at

Indexes/constraints:
- panel/source identity uniqueness
- panel_id
- source_username
- source_uuid where appropriate

## customers
- id
- display_name
- active
- created_at
- updated_at

## customer_accounts
- customer_id
- account_id
- created_at

Constraint:
- one Account belongs to at most one Customer unless future business rules explicitly change.

## account_settings_imports
- id
- panel_id
- source_filename
- source_hash
- status
- stats_json
- imported_by
- imported_at
- error_message nullable

## daily_reports
- id
- company_id
- report_date
- source_filename
- source_hash
- duplicate_fingerprint
- status: draft|final
- total_received DECIMAL
- total_paid DECIMAL
- total_commission DECIMAL
- site_net DECIMAL
- site_status: win|loss|settled
- created_by
- finalized_at nullable
- created_at
- updated_at

Indexes:
- company_id, report_date
- duplicate_fingerprint

## daily_report_rows
Historical snapshot fields:
- id
- daily_report_id
- account_id nullable
- panel_id nullable
- customer_id nullable
- source_username
- original_name_snapshot
- display_name_snapshot
- member_win DECIMAL
- rate_type_snapshot
- rate_value_snapshot DECIMAL
- loss_percent_snapshot DECIMAL
- commission DECIMAL
- received DECIMAL
- paid DECIMAL
- row_origin: import|manual|temporary
- created_at
- updated_at

## report_revisions
- id
- daily_report_id
- revision_no
- before_json
- after_json
- changed_by
- created_at

## settings
Typed key/value storage or structured settings table.

Initial keys:
- default_rate
- special_rate
- default_loss_percent
- money_display_scale
- digit_style
- accounting_theme
- typography

Example accounting_theme:
{
  "received":{"bg":"#EF4444","opacity":0.18,"text":"#000000"},
  "paid":{"bg":"#3B82F6","opacity":0.18,"text":"#000000"},
  "commission":{"bg":"#22C55E","opacity":0.18,"text":"#000000"},
  "site_win":{"bg":"#1E3A8A","opacity":0.18,"text":"#000000"},
  "site_loss":{"bg":"#F97316","opacity":0.18,"text":"#000000"}
}

Example typography:
{
  "global":"vazirmatn",
  "headings":"vazirmatn",
  "forms":"vazirmatn",
  "tables":"vazirmatn",
  "print":"vazirmatn"
}

## audit_logs
- id
- actor_user_id nullable
- actor_type: user|mcp|system
- action
- entity_type
- entity_id nullable
- metadata_json
- created_at

## system_logs
- id
- level
- event
- context_json
- created_at

## error_logs
- id
- error_code
- message_sanitized
- context_json_sanitized
- created_at

Do not store passwords/tokens/raw secrets in logs.

## mcp_tokens
- id
- name
- token_hash
- scopes_json
- active
- expires_at nullable
- last_used_at nullable
- created_by
- created_at
- revoked_at nullable

## migrations
- version
- name
- checksum
- applied_at

## app_meta
Optional simple table for:
- installed_at
- app_version
- schema_version
- instance_id

## Date policy
Store canonical Gregorian DATE/DATETIME values.

Render Jalali/Persian dates in UI.

If source supplies a Jalali business date, parse once and store normalized canonical date plus original text if needed for audit.

## Money policy
Use DECIMAL, never FLOAT/DOUBLE.

Do not store formatted values with commas, Persian digits, or trimmed zeros as canonical money.

## Deletion policy
Prefer active/inactive or archival status for business entities with historical references.

Do not cascade-delete accounting history casually.
