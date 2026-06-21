# BookStore Laravel production image
# PHP-FPM app container. Nginx runs in a separate container.

FROM node:22-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.* ./
RUN npm run build

FROM php:8.3-fpm-alpine AS vendor
WORKDIR /app

RUN apk add --no-cache \
    bash \
    icu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pcntl \
        pdo_mysql \
        zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

FROM php:8.3-fpm-alpine AS app
WORKDIR /var/www/html

RUN apk add --no-cache \
    bash \
    icu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    mysql-client \
    curl \
    tzdata \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pcntl \
        pdo_mysql \
        zip

COPY docker/php/production.ini /usr/local/etc/php/conf.d/production.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

COPY docker/entrypoint.sh /usr/local/bin/bookstore-entrypoint

RUN sed -i 's/\r$//' /usr/local/bin/bookstore-entrypoint \
    && chown root:root /usr/local/bin/bookstore-entrypoint \
    && chmod 755 /usr/local/bin/bookstore-entrypoint \
    && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache public \
    && chmod -R a+rX app bootstrap config database public resources routes vendor \
    && chmod a+r artisan composer.json composer.lock package.json vite.config.js \
    && chmod -R ug+rwX storage bootstrap/cache

USER www-data

ENTRYPOINT ["bookstore-entrypoint"]
CMD ["php-fpm"]
