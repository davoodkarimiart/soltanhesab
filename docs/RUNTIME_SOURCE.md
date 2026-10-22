# Runtime Source Authority (2026-10-22)

## Canonical repositories

- **Executable current source:** [davoodkarimiart/hesabsvo](https://github.com/davoodkarimiart/hesabsvo); verified `main` version `0.6.25` on 2026-10-22.
- **Planning, historical implementation and domain contract:** [davoodkarimiart/soltanhesab](https://github.com/davoodkarimiart/soltanhesab).
- The source files and `VERSION` in the planning repository are **outdated** and must not be used to deploy the live app.
- `v0.6.25` is undergoing **test-host customer validation**, **not** a production Stable tag or verified full fresh-host rollout.

## Release rule

Fix bugs in the canonical executable repository, not in the historical source tree. Keep versions, migrations, tests and a release tag together. Once customer feedback is closed, validate the complete new-host installer against an empty database and test upgrades/rollback separately; do not infer success from lint alone.

## Git and privacy

Keep in Git: PHP, CSS, JS, migrations, installer, tests, sanitized fixtures, config **examples**, documentation.

Keep out of Git: `config/config.php`, passwords, bot tokens, access tokens, live uploads, customer Excel reports, `storage/logs`, database dumps, backups, generated private exports and unlicensed font binaries.

## Development and debugging

Financial logic must stay in shared application/domain services. Log/Audit/Error foundations exist but there is no verified full Developer-log viewer, automatic Telegram backup and restore workflow or MCP adapter. See [RELEASE_AND_DEBUG_HANDOFF.md](RELEASE_AND_DEBUG_HANDOFF.md).
