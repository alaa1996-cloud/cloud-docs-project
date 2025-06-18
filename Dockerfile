# استخدم صورة PHP 8.2 مع FPM
FROM php:8.2-fpm

# تثبيت أدوات النظام المطلوبة
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libzip-dev \
    zip \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql zip

# نسخ Composer من صورة Composer الرسمية
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# إعداد مجلد العمل
WORKDIR /var/www/html

# نسخ ملفات المشروع إلى الصورة
COPY . .

# تثبيت مكتبات PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# تثبيت حزم npm وبناء الواجهة الأمامية (Vite)
RUN npm install
RUN npm run build

# ضبط الصلاحيات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# تعريض المنفذ 8000 (يمكن تغييره)
EXPOSE 8000

# أمر تشغيل تطبيق Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
