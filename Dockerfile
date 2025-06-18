FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl unzip zip \
    libzip-dev libpng-dev libonig-dev \
    libxml2-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN cp .env.example .env && php artisan key:generate

RUN chmod -R 775 storage bootstrap/cache storage/logs && \
    chown -R www-data:www-data storage bootstrap/cache storage/logs

RUN npm install && npm run build

EXPOSE 10000

php artisan serve --host=0.0.0.0 --port=${PORT}

