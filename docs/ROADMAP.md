# نقشه راه سلطان حساب | وضعیت 2026-10-22

منبع تعریف تعهدات: [MASTER_IMPLEMENTATION_PLAN.md](MASTER_IMPLEMENTATION_PLAN.md). این فایل ترتیب اجرایی فعلی را بدون حذف فازهای قرارداد مشخص می‌کند.

## اکنون: تحویل نسخه Stable، نه توسعه قابلیت جدید

- کد اجرایی موجود: [hesabsvo](https://github.com/davoodkarimiart/hesabsvo), `v0.6.25` on `main`.
- محیط فعلی: **هاست تست**؛ دوره بازخورد مشتری و آزمایش نهایی حسابداری.
- شرط خاتمه این مرحله: رفع باگ‌های تأییدشده + تست مجدد مالی و خروجی‌ها + پذیرش صاحب پروژه/مشتری.
- فقط پس از آن: نام‌گذاری نسخه Stable، تهیه snapshot سورس و اجرای clean-install روی هاست جدید با **دیتابیس خالی**.

## فازهای قرارداد

0. V32 contract / fixtures (historical gaps)
1. Foundation / Installer / Security / Base Logging (foundation exists; target-host install unverified)
2. Company / Panel / AccountSettings (implemented)
3. Daily Report_WL / accounting (implemented, regression gate)
4. Customer grouping / ledger (implemented; final acceptance pending)
5. Archive / reports (implemented; final acceptance pending)
6. Excel / PDF / image exports (implemented; compatibility acceptance pending)
7. Settings / themes / fonts (implemented; acceptance pending)
8. Dashboard / shell / mobile UX parity (implemented; acceptance pending)
9. PWA (implemented; update/offline acceptance pending)
10. Developer operations / audit, system, error logs / manual and scheduled backup / Telegram delivery and restore (**substantial remaining scope**)
11. MCP token-scoped services and tools (**not delivered as a complete verified module**)
12. Security, tests, migration/upgrade/rollback and release (**production gate remains**)

### Release sequence
1. Customer feedback and financial regression.
2. Freeze `hesabsvo` stable candidate (tag + changelog + reproducible artifacts).
3. Test **new host** installer, schema migrations, admin/developer login, reports/transfers/exports and installer lock.
4. Security + backup/restore + rollback rehearsals sufficient for production handoff (mandatory Phase 12 release gate).
5. Complete Phase 10 Developer panel/log browsing/backup/Telegram in planned milestones.
6. Implement and test Phase 11 MCP; finish Phase 12 comprehensive hardening.

**Phases 10–12 are not implicitly accepted by a stable UI build.** Keep `PROJECT_STATUS.md` and feature acceptance evidence current. Do not use the old unchecked V32 parity matrix as proof that a feature is absent or complete; validate it against the current runtime.

No customer data, credentials, uploads or proprietary fonts may be committed.
