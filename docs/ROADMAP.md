# نقشه راه سلطان حساب | وضعیت ۲۴ اکتبر ۲۰۲۶

منبع تعریف تعهدات: [MASTER_IMPLEMENTATION_PLAN.md](MASTER_IMPLEMENTATION_PLAN.md). این فایل ترتیب اجرایی فعلی را بدون حذف فازهای قرارداد مشخص می‌کند.

## اکنون: Phase 11 پذیرفته‌شده در دامنهٔ محدود؛ Phase 12 در حال سخت‌سازی

- سورس اجرایی روی هاست تست و `main` مخزن [hesabsvo](https://github.com/davoodkarimiart/hesabsvo) اکنون `0.6.53` است؛ PR #2 پس از موفقیت CI ادغام شد.
- دامنهٔ پذیرفته‌شدهٔ فاز ۱۱: خواندن و تحلیل گزارش‌ها، تشخیص مشکل از health و لاگ‌های مجاز، و تهیهٔ بکاپ دیتابیس. این پذیرش به‌معنی parity کامل CRUD یا پایداری Production نیست.
- هاست زندهٔ تست گزارش داده که OAuth و ابزارهای خواندن/diagnostics کار کرده‌اند و `create_backup` فایل بکاپ ساخته است. ارسال همان بکاپ جدید به Telegram هنوز تأیید نشده.
- Phase 12 هنوز دروازهٔ انتشار است: بررسی PR سورس، نصب/ارتقا/rollback، تست مالی، restore بکاپ، cron، Telegram و امنیت روی محیط آزمایشی.

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
10. Developer operations / diagnostics / manual and scheduled backup / Telegram (**implemented; restore, cron and latest Telegram delivery remain Phase 12 checks**)
11. MCP scoped report reading, diagnostics and backup (**ACCEPTED in the owner-approved limited scope; broader CRUD parity and A/B framework excluded**)
12. Security, tests, migration/upgrade/rollback and release (**production gate remains**)

### Release sequence
1. Customer feedback and financial regression.
2. Freeze `hesabsvo` stable candidate (tag + changelog + reproducible artifacts).
3. Test **new host** installer, schema migrations, admin/developer login, reports/transfers/exports and installer lock.
4. Security + backup/restore + rollback rehearsals sufficient for production handoff (mandatory Phase 12 release gate).
5. Keep the sanitized v0.6.53 source synced and exclude runtime secrets.
6. Finish Phase 12 backup/restore, cron/Telegram, clean-install and financial regression checks before any Stable claim.

**Phase 11 acceptance is limited to the owner-approved scope; Phase 12 remains mandatory before a Stable or production claim.** Keep `PROJECT_STATUS.md` and feature acceptance evidence current. Do not use the old unchecked V32 parity matrix as proof that a feature is absent or complete; validate it against the current runtime.

No customer data, credentials, uploads or proprietary fonts may be committed.
