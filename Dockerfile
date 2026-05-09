FROM php:8.2-cli

WORKDIR /var/www/html

# 1. Install system dependencies including PostgreSQL dev tools
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# 2. Copy the composer binary from the official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Copy application files
COPY . .

# 4. Copy the .env.example to .env BEFORE running composer
# This ensures Laravel has a configuration file to read during optimization
RUN cp .env.example .env

# 5. Install composer packages without running post-install scripts (database check bypass)
RUN composer install --no-dev --no-scripts --optimize-autoloader

# 6. Run package discovery and key generation safely
RUN php artisan package:discover --ansi
RUN php artisan key:generate

# 7. Start container command
# We run migrations and seeders here at RUNTIME, then start the server
CMD php artisan migrate --seed --force && php artisan serve --host=0.0.0.0 --port=10000
