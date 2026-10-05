# AI_PROJECT_CONTEXT.md

این فایل قرارداد انتقال Context پروژه «سلطان حساب» بین ChatGPT/Codex/Developerها است. قبل از هر تغییر معماری یا حسابداری خوانده شود.

## 1. ماهیت پروژه
- سیستم شخصی، تک‌مالک و چندشرکتی.
- هدف فعلی: تبدیل Prototype HTML تک‌فایل به Web App واقعی با Backend + Database + Installer + PWA + MCP.
- اولویت: صحت حسابداری و قابلیت تست، نه نمایش‌های فانتزی یا معماری بیش‌ازحد پیچیده.

## 2. مدل دامنه
- Company: شرکت.
- Panel: زیرمجموعه Company؛ AccountSettings و تنظیم نمایش نام در سطح Panel است.
- Account: حساب/Username/UUID واردشده از AccountSettings.
- Customer: هویت تجمیعی مشتری، مستقل از Account. یک Customer می‌تواند چند Account داشته باشد.
- DailyReport: گزارش روزانه Report_WL.
- DailyReportRow: snapshot محاسبات هر Account در یک DailyReport.
- CustomerGroup/Mapping: نگاشت چند Account به یک Customer.
- Settings: تنظیمات سراسری نمایش/عدد/رنگ.
- AuditLog / ErrorLog / SystemLog.
- MCP Token و Scope.

رابطه پایه:
Company -> Panel -> Account
Customer -> many Accounts

## 3. AccountSettings
- هر Panel AccountSettings مستقل دارد.
- اولین Import حساب‌ها را ایجاد می‌کند.
- Sync بعدی:
  - حساب جدید را اضافه می‌کند.
  - حساب موجود را به‌روزرسانی می‌کند بدون نابود کردن نام نمایشی دستی.
  - حساب حذف‌شده/غایب را برای تعیین تکلیف علامت می‌زند.
- اگر AccountSettings به Panel/Company دیگری تعلق داشته باشد باید هشدار/Block شود.
- original_name دقیق منبع حفظ شود.
- display_name قابل ویرایش و پایدار باشد.
- mode نمایش نام در سطح Panel:
  - original
  - display

## 4. ورود Daily Report_WL
- فعلاً فقط Report روزانه داریم.
- قبل از پردازش Company باید انتخاب شود.
- Usernameهای شناخته‌شده Report با AccountSettings تطبیق داده می‌شوند.
- اگر Report متعلق به Company دیگر باشد پردازش Block شود.
- Panel از Account matching تشخیص داده می‌شود.
- Report duplicate باید Server-side شناسایی شود.
- Preview قابل ویرایش است و Final Save باید تراکنشی باشد.

## 5. منطق حسابداری
Baseline فعلی:
- Member Win < 0 => مشتری باخته / سایت دریافت دارد.
  - gross = abs(member_win) * rate
  - commission = gross * customer_loss_percent / 100
  - received = gross - commission
- Member Win > 0 => مشتری برده / سایت پرداخت دارد.
  - paid = member_win * rate
  - percentage روی برنده اثر مالی ندارد.
- Member Win = 0 => صفر.

جمع سایت:
site_net = total_received - total_paid
- > 0: برد سایت
- < 0: باخت سایت
- = 0: تسویه

این Rule باید فقط در Domain Service مرکزی پیاده شود و UI/MCP/Report Export از همان نتیجه استفاده کنند.

## 6. نرخ و نمایش تومان
- نرخ عمومی/default و نرخ ویژه/special.
- Account/Customer نوع نرخ دارد.
- تنظیم نمایش تومان:
  - full
  - trim_3
  - trim_4
این تنظیم فقط قرارداد ورود/نمایش است. مقدار canonical در DB باید کامل/دقیق ذخیره شود.
- نمایش اعداد:
  - fa
  - en

## 7. مشتری و تجمیع
- Customer می‌تواند چند Account داشته باشد.
- نام‌های دارای suffix عددی در Prototype برای پیشنهاد Grouping استفاده می‌شوند، ولی Backend باید نگاشت صریح account_customer داشته باشد.
- کلیک روی مشتری باید Ledger تجمیعی تمام Accountهای Customer را نشان دهد.
- خروجی Customer قابل تصویر/اشتراک است.

## 8. گزارش‌ها
- Daily: هر DailyReport یک رکورد؛ بدون بازه آخرین 10 گزارش.
- Monthly: Aggregate گزارش‌های روزانه به تفکیک ماه.
- Multi-month: بازه تاریخ و Aggregate ماهانه.
- Ledger: ریز ردیف‌ها/حساب‌ها؛ بدون بازه از آخرین 10 Report.
- همه Reportها summary totals دارند:
  - received
  - paid
  - commission
  - site net + explicit win/loss status
- Excel/PDF باید از dataset همان Preview جاری ساخته شود.

## 9. Theme حسابداری
برای هر category:
- background color
- background opacity
- text color

Categories:
- received/customer loss
- paid/customer win
- commission
- site win
- site loss

Theme در UI Preview، Final Output، Analytics Reports، PDF و تا حد ممکن Excel یکسان باشد.

## 10. Frontend UX
- mobile-first
- PWA
- navigation: home / companies / entry / customers / reports
- Entry flow:
  1. ورود اطلاعات
  2. پیش‌نمایش و اصلاح
  3. خروجی حساب
- Step 2 فقط Preview/Editor را نشان دهد، نه فرم Import.
- Back از Preview به Entry بدون از دست رفتن draft.
- ثبت نهایی مستقیم Final Output را نشان دهد.

## 11. Login
Prototype گل یا پوچ صرفاً UI/friction است و Security واقعی محسوب نمی‌شود.
Backend واقعی:
- password hashing
- secure session
- CSRF
- rate limiting
- optional real captcha if required
- no sensitive secrets in client JS

## 12. Backend Architecture
هدف برای هاست حدود 1 CPU / 1GB:
- PHP backend سبک، بدون microservice.
- MySQL/MariaDB.
- Service/Domain layer مشترک.
- REST-like endpoints برای UI و MCP adapters.
- server-side validation.
- transaction برای import/final save.
- migrations versioned.
- filesystem فقط برای config/backups/temp exports؛ canonical accounting data در DB.

## 13. Roles
Admin:
- business operations and settings.

Developer:
- Admin +
- MCP
- tokens/scopes
- logs
- backup
- health/diagnostics

## 14. MCP
MCP adapter باید Application Service را صدا بزند، نه SQL مستقیم.
Scopes نمونه:
- read:companies
- read:reports
- read:customers
- write:reports
- write:customers
- admin:settings
- admin:backup
هر action حساس audit شود.

## 15. Installer
- prerequisite check
- DB connection
- create/migrate schema
- create initial admin/developer
- generate secure config
- mark installed/lock installer
- support future migrations separately from first install

## 16. Source authority
- Latest product UI prototype at time of this context: V32.
- `hesabdari_soltan_fixed (2).html` is accounting behavior reference only. Never use it as the new product base.
- Excel samples are fixtures/reference data, not production database.

## 17. Development rules
- Small incremental patches.
- Test each phase.
- Never silently change accounting semantics.
- Business rules before code.
- Avoid duplicated calculation logic in JS/PHP/MCP.
- Preserve source data + manual overrides.
- Every schema migration must be reversible or have a clear backup plan.
- Never commit real DB credentials, passwords, tokens, customer production exports, or private backups.


## 18. Typography / Font Settings
- Font choice must be configurable from Admin settings.
- Supported product fonts currently planned:
  - Vazirmatn
  - IRANSans
- Font selection should not be limited to one global switch. Admin should be able to choose at least:
  - global/site UI font
  - headings/titles font
  - forms, inputs, selects and buttons font
  - accounting tables and report tables font
  - printable/exported report font
- Defaults should remain readable and mobile-first.
- Typography settings must affect UI preview and printable/PDF outputs consistently.
- Do not commit or redistribute proprietary font binaries in the public repository unless licensing/publication is explicitly verified. Keep font asset integration deploy-time configurable.
