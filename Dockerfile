FROM dunglas/frankenphp:php8.2

RUN install-php-extensions \
    pdo_mysql \
    mysqli \
    mbstring \
    xml \
    curl \
    dom \
    fileinfo \
    zip \
    opcache

WORKDIR /app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

ENV SERVER_NAME=:8080

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]