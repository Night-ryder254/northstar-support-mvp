FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip git curl libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

# .env is gitignored, so build a base file from the committed example
RUN cp .env.example .env

# Override DB settings for this container ONLY — .env.example stays
# MySQL for local XAMPP development, unaffected by this.
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=/app/database/database.sqlite

EXPOSE 10000

CMD php artisan key:generate --force && \
    touch database/database.sqlite && \
    php artisan migrate --force && \
    php artisan db:seed --class=Database\\Seeders\\SupportDataSeeder --force && \
    php artisan db:seed --class=Database\\Seeders\\ProductStockSeeder --force && \
    php artisan db:seed --class=Database\\Seeders\\FaqSeeder --force && \
    php artisan serve --host 0.0.0.0 --port 10000
