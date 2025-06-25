# المرحلة الأولى: بناء الواجهة الأمامية (Node)
FROM node:18 as node-builder

WORKDIR /var/www/html

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# المرحلة الثانية: إعداد PHP مع Composer و Laravel
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# نسخ Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

COPY --from=node-builder /var/www/html/public/build /var/www/html/public/build

RUN cp .env.example .env && php artisan key:generate

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
