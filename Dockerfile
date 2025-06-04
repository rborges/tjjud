FROM php:8.3-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    zip unzip curl git mariadb-client libzip-dev \
    libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
