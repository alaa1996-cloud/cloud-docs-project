# استخدم صورة PHP الرسمية
FROM node:18 AS node

# مرحلة تثبيت الباكجات الخاصة بـ Vite
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# المرحلة الأساسية
FROM php:8.2-fpm

# تثبيت الأدوات المطلوبة
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libzip-dev zip libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ضبط مجلد العمل
WORKDIR /var/www/html

# نسخ المشروع
COPY . .

# نسخ ملفات البناء من مرحلة node
COPY --from=node /app/public/build ./public/build

# تثبيت باقات PHP
RUN composer install --no-dev --optimize-autoloader

# توليد app key + cache
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan key:generate

# إعطاء الصلاحيات
RUN chown -R www-data:www-data storage bootstrap/cache

# فتح البورت
EXPOSE 10000
# تثبيت Node.js وبناء ملفات Vite
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs
RUN npm install
RUN npm run build

# تشغيل السيرفر
CMD php artisan serve --host=0.0.0.0 --port=10000
