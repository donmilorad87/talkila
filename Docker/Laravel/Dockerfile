FROM php:8.4-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    supervisor \
    cron \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql \
        mbstring \
        zip \
        gd \
        bcmath \
        opcache \
        pcntl \
        sockets \
        xml \
        curl \
        exif \
        intl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js 20 LTS (for frontend assets)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# PHP configuration
COPY Docker/Laravel/php.ini /usr/local/etc/php/conf.d/custom.ini

# Supervisord configuration
COPY Docker/Laravel/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Laravel scheduler cron
COPY Docker/Laravel/scheduler-cron /etc/cron.d/laravel-scheduler
RUN chmod 0644 /etc/cron.d/laravel-scheduler && crontab /etc/cron.d/laravel-scheduler

WORKDIR /var/www/html

# Install dependencies (cached layer - only re-runs when composer files change)
COPY talkila.backend/composer.json talkila.backend/composer.lock* ./
RUN composer install --no-scripts --no-autoloader --prefer-dist 2>/dev/null || true

# Copy application code
COPY talkila.backend/ .

# Finalize composer
RUN composer dump-autoload --optimize 2>/dev/null || true

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/assets/images 2>/dev/null || true \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/assets/images 2>/dev/null || true

EXPOSE 9000 9001 6001

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
