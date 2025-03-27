FROM php:8.2-fpm

# Alapvető csomagok telepítése
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip

# PostgreSQL és egyéb szükséges kiterjesztések
RUN docker-php-ext-install pdo pdo_pgsql zip

# Composer telepítése
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Projekt másolása
WORKDIR /var/www
COPY . /var/www


# Jogosultságok beállítása
RUN chown -R www-data:www-data /var/www

# Laravel cache optimalizálás
RUN composer install --no-dev --optimize-autoloader


# Indítás
CMD php artisan serve --host=0.0.0.0 --port=8000
