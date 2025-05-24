FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    pkg-config \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libpq-dev \
    libzip-dev \
    libsqlite3-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    unzip \
    curl \
    git \
    netcat-openbsd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        pdo_sqlite \
        bcmath \
        mbstring \
        opcache \
        sockets \
        intl \
        zip \
        pcntl \
    && pecl install redis && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY project/composer.* ./

RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY project ./

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN composer dump-autoload --optimize

ENV APP_ENV=production
ENV APP_DEBUG=false

RUN echo "opcache.enable_cli=1" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini


COPY docker/laravel/entrypoint.sh /var/www/entrypoint.sh
RUN chmod +x /var/www/entrypoint.sh

CMD ["/var/www/entrypoint.sh", "php-fpm"]