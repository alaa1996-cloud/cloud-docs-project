# Use official PHP with extensions
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip zip \
    libzip-dev libpng-dev libonig-dev \
    libxml2-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Node.js (for Vite build)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy files
COPY . .

# Install PHP deps
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy .env & generate key
RUN cp .env.example .env

# Set permissions
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Build Vite assets
RUN npm install && npm run build

# Generate Laravel key
RUN php artisan key:generate

# Expose port
EXPOSE 10000

# Start Laravel dev server
CMD php artisan serve --host=0.0.0.0 --port=10000
