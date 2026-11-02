# Production image for hosts that run containers (Render, Koyeb, Fly.io, Cloud Run...).
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

FROM php:8.3-apache
RUN apt-get update \
    && apt-get install -y --no-install-recommends libicu-dev libzip-dev libpq-dev unzip \
    && docker-php-ext-install -j"$(nproc)" intl zip pdo_mysql pdo_pgsql opcache \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && printf 'opcache.validate_timestamps=0\nexpose_php=Off\n' > /usr/local/etc/php/conf.d/app.ini

WORKDIR /var/www/html
COPY --from=vendor /app/vendor ./vendor
COPY --from=vendor /usr/bin/composer /usr/bin/composer
COPY . .
RUN composer dump-autoload --optimize --no-dev --no-interaction \
    && chown -R www-data:www-data storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

ENV APP_ENV=production APP_DEBUG=false LOG_CHANNEL=stderr PORT=8080
EXPOSE 8080
ENTRYPOINT ["entrypoint"]
