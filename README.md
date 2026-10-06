# سلطان حساب (Soltan Hesab)

وب‌اپ حسابداری سبک و cPanel-friendly برای مدیریت شرکت‌ها، پنل‌ها، AccountSettings، گزارش‌های Win/Loss، محاسبات حسابداری، مشتری‌های تجمیعی و خروجی‌های مدیریتی.

**نسخه Runtime فعلی: `v0.4.13`**  
**Stack:** PHP 8.1+ / MySQL or MariaDB / Vanilla JS / CSS / PWA-ready architecture

## وضعیت پروژه

فازهای Foundation، Company/Panel/AccountSettings و موتور اصلی حسابداری تأیید شده‌اند. Package 4 شامل Customer/Grouping، Reports، Export/Print و Settings تا v0.4.13 پیاده‌سازی شده و در آستانه Acceptance نهایی است. وضعیت دقیق هر فاز در [`PROJECT_STATUS.md`](PROJECT_STATUS.md) ثبت می‌شود.

## قابلیت‌های Runtime فعلی

- Installer مرورگری، Migration runner و Install lock
- Login واقعی با Admin/Developer، Session، CSRF و Login throttling
- Company → Panel → Account و Sync فایل AccountSettings (`.xls` / `.xlsx`)
- نگهداری `original_name` و `display_name`، نرخ عمومی/ویژه و Active state
- Import گزارش Report_WL و تشخیص Panel/Company از Usernameها
- موتور حسابداری Server-side با Snapshot نرخ/درصد و ثبت Transactional
- Preview قابل ویرایش، Duplicate/overlap guardrail و Unknown-user resolution
- گزارش نهایی، حذف Soft-delete و Revision history
- Customer auto-grouping، Manual split/link و دفتر حساب مشتری
- گزارش‌های روزانه، ماهانه، چندماهه و ریز حساب با تاریخ شمسی
- Excel RTL با Border و رنگ‌های Theme
- Print/PDF با Theme و `font_print`
- تصویر گزارش و کارت حساب مشتری با Share / WhatsApp / Telegram
- خلاصه گزارش نهایی به‌صورت Modal با PNG/Share/Print
- Settings برای نرخ، مقیاس مبلغ، ارقام، Theme و نقش‌های Font
- Audit / System / Error logging infrastructure

## معماری

UI و endpointهای وب از Serviceهای Application/Domain مشترک استفاده می‌کنند. منطق حسابداری نباید در UI، Export یا MCP دوباره پیاده‌سازی شود. MySQL/MariaDB منبع داده Canonical است و مبالغ مالی با DECIMAL نگهداری می‌شوند.

مسیرهای مهم:

```text
app/                    PHP application/services/support
assets/                 CSS + browser JavaScript
config/                 example configuration (live config is ignored)
database/migrations/    versioned schema migrations
install/                 browser installer
upgrade/                 release upgrade helpers
tests/                   regression/smoke tests
index.php                main web application
export.php               Excel XML export
print.php                browser Print/PDF output
summary_report.php       legacy/direct summary route (main UX is modal)
```

برای جزئیات معماری و Scope به این فایل‌ها مراجعه شود:

- [`AI_PROJECT_CONTEXT.md`](AI_PROJECT_CONTEXT.md): خلاصه فنی/محصولی برای AI یا توسعه‌دهنده جدید
- [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md)
- [`docs/BUSINESS_RULES.md`](docs/BUSINESS_RULES.md)
- [`docs/DATABASE_PLAN.md`](docs/DATABASE_PLAN.md)
- [`docs/MASTER_IMPLEMENTATION_PLAN.md`](docs/MASTER_IMPLEMENTATION_PLAN.md)
- [`docs/V32_EXHAUSTIVE_FEATURE_INVENTORY.md`](docs/V32_EXHAUSTIVE_FEATURE_INVENTORY.md)
- [`PROJECT_STATUS.md`](PROJECT_STATUS.md)

## نصب توسعه/هاست

1. PHP 8.1+ و MySQL/MariaDB آماده باشد.
2. `config/config.example.php` را مبنا قرار بده. Installer در نصب واقعی config امن را می‌سازد.
3. `config/config.php`، لاگ‌ها، Backupها، Report sourceها و داده واقعی عمداً در Git نیستند.
4. برای نصب تازه از `/install/` استفاده کن.
5. برای Upgradeهای Release از فایل متناظر در `upgrade/` و دستورهای Release استفاده کن.

Root فعلی Production پروژه در cPanel:

```text
~/public_html/soltan.toseno.ir
```

## Font assets

کد از Vazirmatn WebFont پشتیبانی می‌کند و برای IRANSans مسیر Local asset را می‌شناسد. فایل‌های فونت دارای مجوز، Secret/config و داده مشتری عمداً در Repository عمومی Commit نمی‌شوند. Runtime در صورت وجود فایل Local از آن استفاده می‌کند و در غیر این صورت fallback امن دارد.

## تست سریع

```bash
php -l index.php
php -l export.php
php -l print.php
php tests/phase3_formula_smoke.php
```

در محیط نصب‌شده همچنین:

```bash
php verify_release.php
```

## قواعد مهم توسعه

- فرمول حسابداری فقط در Service مرکزی تغییر کند.
- گزارش ذخیره‌شده باید Snapshot مالی خود را حفظ کند.
- Raw customer XLS/XLSX، config واقعی، token، password، log و backup وارد Git نشود.
- هر Release باید ZIP قابل Deploy، Changelog، دستور Upgrade و Source commit متناظر داشته باشد.
- Acceptance یک فاز فقط بعد از تست واقعی روی cPanel ثبت می‌شود.

## Release

`v0.4.13` آخرین Runtime source موجود در Repository است. Release ZIP از همین Source tree ساخته می‌شود، با حذف Secretها، Runtime storage و Font binaries دارای مجوز.
