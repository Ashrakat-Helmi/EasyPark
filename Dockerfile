FROM php:8.1.0-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        zip \
        unzip \
        git \
        curl \
        && docker-php-ext-install -j$(nproc) pdo_mysql zip pcntl bcmath gd \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application code
COPY . /app

# Set working directory
WORKDIR /app

# Install dependencies
RUN composer install --no-autoloader --no-scripts

# Install dependencies with autoloader and scripts
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# Clean up
RUN composer clear-cache

# Expose port
EXPOSE 9000

CMD ["/start.sh"]