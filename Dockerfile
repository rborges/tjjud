FROM php:8.3-cli

# Instala extensões e dependências
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

# Copia arquivos do projeto
COPY . .

# Instala dependências PHP
RUN composer install

# Permissão para o entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expõe porta 8000
EXPOSE 8000

# Executa script de entrada
CMD ["/entrypoint.sh"]
