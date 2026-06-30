FROM dunglas/frankenphp:php8.2

# Install PHP extensions
RUN install-php-extensions \
    pdo_mysql \
    mysqli \
    mbstring \
    xml \
    curl \
    dom \
    fileinfo \
    zip \
    opcache \
    intl \
    bcmath

WORKDIR /app

# Copy Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application
COPY . .

# Install PHP dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Create Laravel directories
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Railway listens on 8080
ENV SERVER_NAME=:8080

EXPOSE 8080

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]