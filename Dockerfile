FROM php:8.2-apache

# تثبيت الإضافات المطلوبة
RUN docker-php-ext-install pdo pdo_mysql

# نسخ ملفات المشروع
COPY . /var/www/html/

# إعداد صلاحيات Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ ملف .env.example إلى .env
RUN cp .env.example .env

# تثبيت الاعتماديات
RUN composer install --no-dev --optimize-autoloader

# إنشاء مفتاح التطبيق
RUN php artisan key:generate

EXPOSE 80
