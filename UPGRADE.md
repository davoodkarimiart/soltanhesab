# Upgrade to v0.4.15

No database migration is required.

1. Back up the live application root.
2. Extract this ZIP over the current app root.
3. Run `php -l index.php`, `php -l export.php`, `php -l print.php`, `php verify_release.php`, and `php tests/phase3_formula_smoke.php`.
4. Hard-refresh once so `0415` assets are loaded.
