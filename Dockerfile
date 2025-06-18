FROM php:8.2-fpm

# تثبيت تبعيات النظام
RUN apt-get update && apt-get install -y \
    git curl unzip zip \
    libzip-dev libpng-dev libonig-dev \
    libxml2-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# تثبيت Node.js (لـ Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# نسخ Composer من الصورة الرسمية
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تعيين مجلد العمل
WORKDIR /var/www/html

# نسخ ملفات المشروع
COPY . .

# تثبيت حزم npm وبناء أصول Vite (يجب قبل composer)
RUN npm install && npm run build

# تثبيت حزم PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# نسخ ملف .env وإنشاء مفتاح التطبيق
RUN cp .env.example .env && php artisan key:generate

# تعيين صلاحيات على مجلدات التخزين والـ cache
RUN chmod -R 775 storage bootstrap/cache storage/logs && \
    chown -R www-data:www-data storage bootstrap/cache storage/logs

# كشف المنفذ
EXPOSE 10000

# تشغيل سيرفر Laravel (للتطوير)
CMD php artisan serve --host=0.0.0.0 --port=10000
