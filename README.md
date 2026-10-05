# سلطان حساب (Soltan Hesab)

سلطان حساب یک سیستم حسابداری شخصی، چندشرکتی و موبایل‌محور است که برای مدیریت گزارش‌های روزانه، پنل‌ها، حساب‌های مشتریان، تسویه‌ها، گزارش‌گیری و خروجی‌های حسابداری طراحی شده است.

> وضعیت فعلی: UI/Prototype منطق اصلی تقریباً تثبیت شده و پروژه وارد فاز تبدیل به Web App واقعی با Backend، Database، Installer، PWA و MCP شده است.

## هدف پروژه

ساخت یک سیستم یکپارچه که:
- چند شرکت را مدیریت کند.
- هر شرکت چند پنل داشته باشد.
- هر پنل AccountSettings مستقل داشته باشد.
- Accountها را از Report_WL روزانه تشخیص و محاسبه کند.
- Customer را جدا از Account نگه دارد و چند Account را زیر یک مشتری تجمیع کند.
- گزارش روزانه، ماهانه، چندماهه و ریزحساب بسازد.
- خروجی Excel/PDF/تصویر قابل چاپ و اشتراک تولید کند.
- روی هاست سبک cPanel قابل نصب باشد.
- PWA داشته باشد.
- از MCP برای کار با AI با همان Business Logic اصلی استفاده کند.

## معماری دامنه

```
Company
  └── Panel
        └── Account

Customer
  └── can group multiple Accounts
```

Customer با Panel یا Account یکی نیست. یک مشتری می‌تواند چند حساب داشته باشد و منطق تجمیع باید در سطح Customer انجام شود.

## جریان اصلی حسابداری

```
AccountSettings Sync
      ↓
Daily Report_WL Import
      ↓
Company validation
      ↓
Account/Panel matching
      ↓
Accounting calculation
      ↓
Editable Preview
      ↓
Final Save
      ↓
Reports / Customer Ledger / Exports
```

## قواعد کلیدی

- ورودی حسابداری فعلاً فقط Daily Report_WL است.
- شرکت قبل از پردازش Report باید انتخاب شود.
- Report اشتباه متعلق به شرکت دیگر باید شناسایی و Block شود.
- AccountSettings در سطح Panel است.
- Sync بعدی AccountSettings باید حساب‌های جدید/حذف‌شده را مدیریت کند، نه Replace کور.
- نام اصلی منبع همیشه حفظ می‌شود.
- نام نمایشی قابل ویرایش است.
- انتخاب استفاده از نام اصلی یا نمایشی در سطح Panel ذخیره می‌شود.
- نرخ عمومی و ویژه پشتیبانی می‌شود.
- برد سایت = جمع دریافتی - جمع پرداختی.
  - مثبت: برد سایت
  - منفی: باخت سایت
  - صفر: تسویه
- تنظیمات نمایش مبلغ تومان مستقل از منطق واقعی ذخیره می‌شود:
  - کامل
  - حذف ۳ صفر
  - حذف ۴ صفر
- تنظیم نمایش اعداد فارسی/انگلیسی است.
- Theme حسابداری قابل تنظیم است:
  - رنگ پس‌زمینه
  - opacity
  - رنگ متن
  برای دریافتی، پرداختی، کمیسیون، برد سایت و باخت سایت.

## گزارش‌ها

انواع گزارش:
- روزانه
- ماهانه
- چندماهه
- ریز حساب

تمام گزارش‌ها باید از داده Database ساخته شوند و خروجی Excel/PDF دقیقاً بر اساس Preview فعلی تولید شود.

## Backend

هدف: Backend سبک و متمرکز، مناسب هاست تقریبی 1 CPU / 1GB RAM.

اصول:
- یک Database مرکزی.
- Business Logic مالی Server-side.
- UI، Reports، Installer و MCP از Service Layer مشترک استفاده کنند.
- محاسبات مالی به داده Client اعتماد نکنند.
- ثبت نهایی Report تراکنشی باشد.
- Duplicate detection Server-side باشد.
- Audit Log برای عملیات حساس ثبت شود.

## نقش‌ها

### Admin
- استفاده از سیستم
- مدیریت شرکت/پنل/مشتری
- AccountSettings Sync
- گزارش‌ها و تنظیمات

### Developer
تمام دسترسی Admin به‌علاوه:
- MCP
- Token / Scope
- System Log
- Error Log
- Audit Log
- Backup
- Health / diagnostics

## Installer

Installer نهایی باید:
1. بررسی پیش‌نیازها
2. دریافت Database credentials
3. ساخت Schema/Migrations
4. ساخت کاربر اولیه Admin/Developer
5. ایجاد config امن
6. قفل شدن بعد از نصب

## PWA

نسخه واقعی باید:
- mobile-first باشد
- installable باشد
- manifest و service worker داشته باشد
- UI فعلی را حفظ کند
- روی iPhone/Android/Desktop مناسب باشد

## MCP

MCP نباید منطق یا دیتابیس مستقل داشته باشد.

```
MCP → Application Services → Domain Rules → Database
UI  → Application Services → Domain Rules → Database
```

Tokenها باید Scope، revoke و audit داشته باشند.

## وضعیت سورس UI

Prototype اصلی فعلی در فاز UI با نام نسخه‌ای تا V32 توسعه داده شده است. این فایل قرارداد رفتاری محصول فعلی محسوب می‌شود تا زمانی که Frontend ماژولار جایگزین آن شود.

HTML قدیمی حسابداری فقط Reference برای رفتار حسابداری است و نباید به‌عنوان Base محصول جدید استفاده شود.

## اسناد پروژه

برای ادامه توسعه ابتدا این فایل‌ها را بخوانید:
- `AI_PROJECT_CONTEXT.md`
- `docs/ARCHITECTURE.md`
- `docs/BUSINESS_RULES.md`
- `docs/DATABASE_PLAN.md`
- `docs/ROADMAP.md`

## اصل توسعه

تغییرات کوچک، قابل تست و قابل Rollback بر تغییرات عظیم ارجح‌اند. به‌خصوص در Accounting، ابتدا Business Semantics مشخص شود و بعد کد تغییر کند.
