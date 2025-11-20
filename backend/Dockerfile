FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libpng-dev libjpeg-dev libonig-dev libxml2-dev \
    libssl-dev pkg-config \
    && docker-php-ext-install pdo zip && docker-php-ext-install pdo pdo_mysql zip

RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --prefer-dist

RUN apt-get update && apt-get upgrade -y && apt-get clean && rm -rf /var/lib/apt/lists/*

EXPOSE 9000

CMD ["php-fpm"]
