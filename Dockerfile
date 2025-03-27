FROM php:8.2-fpm

# Telepítjük a szükséges csomagokat
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    && apt-get clean

# A PHP kiterjesztések telepítése
RUN docker-php-ext-install pdo pdo_pgsql pgsql zip

# Composer telepítése
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Projekt másolása
WORKDIR /var/www
COPY . /var/www


# Jogosultságok beállítása
RUN chown -R www-data:www-data /var/www

# Laravel cache optimalizálás
RUN composer install --no-dev --optimize-autoloader


COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]
# Indítás
#CMD php artisan serve --host=0.0.0.0 --port=8000
