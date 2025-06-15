# استخدم صورة PHP-FPM الرسمية مع PHP 8.2
FROM php:8.2-fpm

# تثبيت الأدوات اللازمة
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تعيين مجلد العمل
WORKDIR /var/www/html

# نسخ ملفات المشروع
COPY . .

# نسخ ملف .env.example إلى .env إذا لم يكن .env موجودًا
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# تثبيت باقات Composer بدون تفاعل
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# توليد مفتاح التطبيق
RUN php artisan key:generate

# كاش الإعدادات
RUN php artisan config:cache

# ضبط صلاحيات مجلدات التخزين والBootstrap cache
RUN chown -R www-data:www-data storage bootstrap/cache

# تعريض بورت 10000
EXPOSE 10000

# تشغيل خادم Laravel على 0.0.0.0:10000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
