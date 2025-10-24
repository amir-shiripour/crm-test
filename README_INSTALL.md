# CRM Scaffold — Installation & Deployment Guide

این راهنما شامل دو مسیر نصب است: **(A) توصیه‌شده: Docker (برای توسعه و deploy ساده)** و **(B) Shared / VPS بدون Docker**.

> قبل از شروع: این scaffold یک ساختار پروژه و فایل‌های کمکی فراهم می‌کند. برای اجرای کامل Laravel نیاز است که یک پروژه Laravel نصب یا با `composer create-project laravel/laravel` ساخته شود و سپس فایل‌های scaffold را در آن کپی کنید. برای تسهیل، اسکریپت `setup.sh` (زیر) می‌تواند این روند را خودکار کند (نیاز به composer و npm روی سیستم دارد).

---

## محتویات جدید افزوده شده
- `backend/.env.example` — مثال فایل محیطی
- `setup.sh` — اسکریپت خودکار برای ایجاد پروژه لاراول جدید و کپی scaffold (نیاز به composer و npm)
- `database/seeders/CustomerSeeder.php` — Seeder نمونه برای جدول customers
- `README_INSTALL.md` — همین فایل

---

## مسیر A — راه‌اندازی با Docker (توصیه‌شده برای توسعه)
1. نصب Docker و Docker Compose روی سرور یا ماشین محلی.
2. از ریشه پروژه دستور زیر را اجرا کن:
   ```
   docker compose up -d
   ```
   این سرویس‌ها در `docker-compose.yml` موجودند: `db` (MySQL), `redis`, `node` (vite dev).
3. در ماشین محلی یا داخل کانتینر `app` (اگر اضافه کنید)، یک پروژه Laravel جدید بساز یا فایل‌های scaffold را داخل پروژه لاراولی که دارید کپی کن:
   ```
   composer create-project laravel/laravel backend
   ```
   یا اگر از قبل `backend` پروژه لاراول است، به قدم بعدی برو.
4. در ریشه backend فایل `.env` را بر اساس `backend/.env.example` بساز و مقادیر DB (host=db) را تغییر نده (برای Docker).
5. نصب پکیج‌های PHP و JS:
   ```
   cd backend
   composer install
   cp .env.example .env
   php artisan key:generate
   npm install
   npm run build   # یا npm run dev برای توسعه
   ```
6. Run migrations & seed:
   ```
   php artisan migrate
   php artisan db:seed --class=\Database\Seeders\CustomerSeeder
   ```
7. اگر از Nginx/Apache خارجی استفاده می‌کنی، کانفیگ‌اش کن تا پوشه `backend/public` را به عنوان root در نظر بگیرد. در محیط Docker می‌توانی یک سرویس `app` و `nginx` اضافه کنی؛ فایل نمونه placeholder در scaffold موجود است.

---

## مسیر B — نصب روی VPS / Shared hosting (بدون Docker)
1. آپلود محتویات پروژه (همه فایل‌ها) به هاست.
2. اجرا در هاست:
   - اطمینان از نصب PHP >=8.1، Composer، MySQL و Node.js (برای assets).
   - در پوشه `backend`:
     ```
     composer install --no-dev --optimize-autoloader
     cp .env.example .env
     php artisan key:generate
     npm install
     npm run build
     php artisan migrate --force
     php artisan db:seed --class=\Database\Seeders\CustomerSeeder --force
     ```
3. ست کردن permissions:
   ```
   chown -R www-data:www-data storage bootstrap/cache
   chmod -R 775 storage bootstrap/cache
   ```
4. وبسرور (Nginx) config snippet:
   ```nginx
   server {
       listen 80;
       server_name example.com;
       root /path/to/backend/public;
       index index.php index.html;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
           fastcgi_index index.php;
           include fastcgi_params;
           fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
           fastcgi_param PATH_INFO $fastcgi_path_info;
       }
   }
   ```
5. Queue worker (supervisor) example for queues:
   ```
   [program:crm-worker]
   process_name=%(program_name)s_%(process_num)02d
   command=php /path/to/backend/artisan queue:work redis --sleep=3 --tries=3
   autostart=true
   autorestart=true
   user=www-data
   numprocs=1
   redirect_stderr=true
   stdout_logfile=/var/log/cron/worker.log
   ```

---

## setup.sh — اسکریپت خودکار (نیاز به composer و npm)
اسکریپت زیر پروژه Laravel را ساخته، scaffold را در آن کپی و پکیج‌ها را نصب می‌کند. آن را در ریشه اجرا کن:
```
bash setup.sh
```

---

## نکات مربوط به هاستینگ و توسعه بعدی
- اگر می‌خواهی نسخه production را میزبانی کنی، از Docker + nginx + certbot استفاده کن یا با استفاده از CI/CD (GitHub Actions / GitLab CI) image بساز و deploy کن.
- برای مقیاس‌پذیری استفاده از managed DB (RDS) و Redis managed توصیه می‌شود.
- برای ssl از Let's Encrypt استفاده کن.
- برای نگهداشت لاگ و monitoring از Sentry و Prometheus/Grafana یا سرویس managed استفاده کن.

---

اگر می‌خوای من `setup.sh` را اجرا کنم و یک پروژه لاراول کامل (composer create-project) داخل این محیط بسازم و scaffold را در آن کپی کنم، توجه کن که محیط اجرای من دسترسی اینترنت ندارد و نمی‌تواند composer packages را دانلود کند. بنابراین اجرای کامل اسکریپت فقط روی ماشین تو (هاست یا لپ‌تاپ) ممکن است. من اسکریپت را تولید کردم تا روی سیستم خودت اجرا کنی.
