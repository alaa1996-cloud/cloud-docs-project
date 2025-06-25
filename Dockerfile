# المرحلة الأولى: بناء الواجهة الأمامية (Node.js)
FROM node:18 as node-builder

WORKDIR /var/www/html

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# المرحلة الثانية: إعداد PHP مع Composer و Laravel
FROM php:8.2-fpm

# تحديث النظام وتثبيت الحزم المطلوبة مع إضافة دعم PostgreSQL (pdo_pgsql)
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# نسخ Composer من الصورة الرسمية
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# نسخ ملفات المشروع إلى الصورة
COPY . .

# تثبيت باكجات PHP باستخدام Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# نسخ ملفات البناء للواجهة الأمامية من المرحلة الأولى
COPY --from=node-builder /var/www/html/public/build /var/www/html/public/build

# إنشاء ملف البيئة .env من المثال وتوليد مفتاح التطبيق
RUN cp .env.example .env && php artisan key:generate

# تعديل صلاحيات المجلدات الضرورية
RUN chown -R www-data:www-data storage bootstrap/cache

# تعريض المنفذ 8080
EXPOSE 8080

# أمر تشغيل الخادم
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
