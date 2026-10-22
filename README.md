# سلطان حساب | مخزن نقشه راه و مستندات

این مخزن (`davoodkarimiart/soltanhesab`) محل **نقشه راه، تصمیم‌های معماری و سابقه توسعه** است. کد PHP موجود در آن یک نسخه قدیمی تاریخی است و **سورس اجرایی فعلی نیست**.

## دو مخزن و نقش هرکدام

| Repo | Purpose | Current verified state (2026-10-22) |
|---|---|---|
| [hesabsvo](https://github.com/davoodkarimiart/hesabsvo) | **سورس اجرایی و نصب تازه** | `VERSION=0.6.25` on `main` |
| [soltanhesab](https://github.com/davoodkarimiart/soltanhesab) | **برنامه فازها و مستندات تاریخی** | Runtime source / `VERSION` in this repo is old: **do not deploy it** |

## وضعیت فعلی محصول

نسخه ۰.۶.۲۵ روی **هاست تست** در مرحله بازبینی مشتری است. هنوز Stable / Production accepted اعلام نشده؛ اصلاحات نهایی حسابداری/گزارش/ترانسفر باید بر اساس بازخورد مشتری بسته شوند. انتقال به هاست جدید بعد از تثبیت نسخه و تست **نصب واقعی از صفر** انجام می‌شود.

فازهای اصلی حسابداری، گزارش، رابط موبایل، PWA و قابلیت ترانسفر در سورس جدید وجود دارند؛ این به‌معنی تکمیل یا پذیرش فازهای عملیات توسعه‌دهنده، بکاپ تلگرام، MCP و انتشار حرفه‌ای نیست.

### از اینجا شروع کنید
- [PROJECT_STATUS.md](PROJECT_STATUS.md): وضعیت واقعی فازهای ۰ تا ۱۲ و ترتیب کار بعدی
- [docs/MASTER_IMPLEMENTATION_PLAN.md](docs/MASTER_IMPLEMENTATION_PLAN.md): شرح تعهدات هر فاز (قرارداد اصلی)
- [docs/ROADMAP.md](docs/ROADMAP.md): اولویت‌ها و دروازه Stable
- [docs/RELEASE_AND_DEBUG_HANDOFF.md](docs/RELEASE_AND_DEBUG_HANDOFF.md): راهنمای خطایابی و تحویل هاست جدید
- [AI_PROJECT_CONTEXT.md](AI_PROJECT_CONTEXT.md): قوانین حسابداری و معماری برای AI/Developer
- [docs/RUNTIME_SOURCE.md](docs/RUNTIME_SOURCE.md): سیاست سورس و همگام‌سازی

**اصل مهم:** برای تغییر کد و آماده‌سازی بسته نصب، به `hesabsvo` مراجعه کنید. این مخزن فقط اسناد مدیریت پروژه را به‌روز نگه می‌دارد. هیچ رمز، توکن، فایل مشتری یا بکاپ واقعی نباید در هیچ‌یک از مخزن‌های عمومی وارد شود.
