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

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy .env and generate key
RUN cp .env.example .env && php artisan key:generate

# Set storage/cache permissions
RUN chmod -R 775 storage bootstrap/cache storage/logs && \
    chown -R www-data:www-data storage bootstrap/cache storage/logs

# Install npm packages and build Vite assets
RUN npm install && npm run build

# ✅ Fix permissions for Vite build output
RUN chmod -R 755 public/build && \
    chown -R www-data:www-data public/build

# Expose port
EXPOSE 10000
RUN apt-get update && apt-get install -y openssh-server

# Start Laravel dev server
CMD ["/bin/bash"]


