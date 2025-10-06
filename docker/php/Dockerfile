FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip libsqlite3-dev sqlite3 libicu-dev libzip-dev \
    && docker-php-ext-install pdo pdo_sqlite intl zip

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar solo composer.json y lock para cachear dependencias
COPY chat-backend/composer.json chat-backend/composer.lock* ./

# Instalar dependencias (incluye ReactPHP)
RUN composer install --no-interaction --no-scripts --no-progress --prefer-dist \
    && composer require react/http:"^3.0" react/socket:"^1.16" --with-all-dependencies --no-interaction

# Ahora sí, copiar el resto del código
COPY chat-backend/ /app/

EXPOSE 8080 8081

CMD bash -c "php -S 0.0.0.0:8080 -t public & php bin/chat-server.php"

