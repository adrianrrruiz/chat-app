FROM php:8.2-cli

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip libsqlite3-dev sqlite3 libicu-dev libzip-dev \
    && docker-php-ext-install pdo pdo_sqlite intl zip

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia el código
WORKDIR /app
COPY ./chat-backend /app

# Instala dependencias Symfony
RUN composer install --no-interaction

# Exponer puerto del WebSocket
EXPOSE 8080

# Comando por defecto
CMD ["php", "bin/chat-server.php"]

