# Upgrade to v0.4.14

No database migration is required.

1. Back up the live application directory.
2. Extract `soltanhesab-release-v0.4.14.zip` over the application root.
3. Run `php -l index.php`, `php -l export.php`, `php -l print.php`, `php -l summary_report.php`, `php verify_release.php`, and `php tests/phase3_formula_smoke.php`.
4. Hard-refresh once so asset version `0414` is loaded.
