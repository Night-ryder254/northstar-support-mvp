FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip git curl libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Build .env from the committed example (gitignored .env doesn't exist
# in this container), then force every DB-related line to SQLite
# directly in the file itself — no reliance on ENV var precedence.
RUN cp .env.example .env \
    && sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env \
    && sed -i '/^DB_HOST=/d' .env \
    && sed -i '/^DB_PORT=/d' .env \
    && sed -i '/^DB_DATABASE=.*/d' .env \
    && sed -i '/^DB_USERNAME=/d' .env \
    && sed -i '/^DB_PASSWORD=/d' .env \
    && echo "DB_DATABASE=/app/database/database.sqlite" >> .env \
    && echo "SESSION_DRIVER=file" >> .env

EXPOSE 10000

CMD php artisan config:clear && \
    php artisan key:generate --force && \
    touch database/database.sqlite && \
    php artisan migrate --force && \
    php artisan db:seed --class=Database\\Seeders\\SupportDataSeeder --force && \
    php artisan db:seed --class=Database\\Seeders\\ProductStockSeeder --force && \
    php artisan db:seed --class=Database\\Seeders\\FaqSeeder --force && \
    php artisan serve --host 0.0.0.0 --port 10000
