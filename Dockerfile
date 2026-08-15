FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip git curl libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

# .env is intentionally gitignored, so it doesn't exist in this container
# yet — build it here from .env.example, which IS committed.
RUN cp .env.example .env

EXPOSE 10000

CMD php artisan key:generate --force && \
    touch database/database.sqlite && \
    php artisan migrate --force && \
    php artisan db:seed --class=Database\\Seeders\\SupportDataSeeder --force && \
    php artisan db:seed --class=Database\\Seeders\\ProductStockSeeder --force && \
    php artisan db:seed --class=Database\\Seeders\\FaqSeeder --force && \
    php artisan serve --host 0.0.0.0 --port 10000
