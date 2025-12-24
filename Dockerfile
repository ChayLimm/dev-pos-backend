FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev \
  && docker-php-ext-install pdo pdo_pgsql bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock* ./
RUN composer install --no-interaction --prefer-dist --no-progress || true

COPY . .

RUN mkdir -p storage/framework/{sessions,views,cache} && \
    chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["sh", "-c", "chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]