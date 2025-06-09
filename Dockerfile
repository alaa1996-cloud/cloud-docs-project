FROM php:8.2-apache

# تثبيت الإضافات المطلوبة للـ Laravel و PostgreSQL
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql zip

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ الملفات إلى مجلد Apache
COPY . /var/www/html/

# إعداد الصلاحيات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# نسخ ملف Apache config
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

# تفعيل mod_rewrite
RUN a2enmod rewrite
