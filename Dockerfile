FROM dunglas/frankenphp:1-php8.2-alpine

# Set server name (can be overridden at runtime)
ENV SERVER_NAME=:80

# Install php extensions needed for Laravel
RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache \
    redis \
    pcntl

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy dependency files first for caching
COPY composer.json composer.lock ./

# Install dependencies (without scripts and dev dependencies)
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction --no-progress

# Copy application source code
COPY . .

# Run composer dump-autoload and scripts
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Set directory permissions for Laravel
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache && \
    chmod -R 775 /app/storage /app/bootstrap/cache

# Copy and set up the entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port
EXPOSE 80

# Set entrypoint
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
