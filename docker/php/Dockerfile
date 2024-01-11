FROM php:7.4.3-fpm

RUN apt-get update && apt-get install -y \
        curl wget git
RUN apt-get update && apt-get install -y \
        libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev libfreetype6-dev \
        libonig-dev \
        zlib1g-dev libzip-dev \
        libmcrypt-dev \
        libicu-dev
RUN pecl install mcrypt-1.0.3 \
	&& docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    && docker-php-ext-configure intl \
        && docker-php-ext-install intl \
	&& docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg \
            && docker-php-ext-install gd  \
            && docker-php-ext-install exif \
        && docker-php-ext-enable exif

COPY --from=composer /usr/bin/composer /usr/bin/composer

ADD php.ini /usr/local/etc/php/conf.d/custom.ini