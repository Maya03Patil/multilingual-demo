FROM php:8.2-cli

# Install system dependencies and PHP extensions commonly needed by Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql pdo_sqlite mbstring zip gd bcmath \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP dependencies (production mode)
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Make sure Laravel can write to storage and cache
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Clear stale cached config (built with no env vars), run migrations,
# then start the app. Render sets $PORT automatically.
CMD php artisan config:clear \
    && php artisan migrate --force \
    && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}