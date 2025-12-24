FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev \
  && docker-php-ext-install pdo pdo_pgsql bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock* ./
RUN composer install --no-interaction --prefer-dist --no-progress || true

# Copy app code
COPY . .

# Run migrations (set APP_ENV for no interaction)
RUN php artisan migrate --force --no-interaction

EXPOSE 8000