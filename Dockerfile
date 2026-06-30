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

RUN mkdir -p storage/framework/{cache,sessions,views}
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]