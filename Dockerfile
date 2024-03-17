FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        zip \
        unzip

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) pdo_mysql zip pcntl bcmath && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install -j$(nproc) gd

# Set timezone
RUN ln -snf /usr/share/zoneinfo/UTC /etc/localtime && echo "UTC" > /etc/timezone

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy composer.lock and composer.json
COPY composer.lock composer.json /app/

# Install dependencies
RUN composer install --no-autoloader --no-scripts

# Copy everything else
COPY . /app/

# Create a link to the public directory
RUN ln -s /app/public /app/html

# Run composer dump-autoload
RUN composer dump-autoload --optimize --no-scripts

# Expose port 80
EXPOSE 80

# Set environment variables
ENV APP_ENV production
ENV APP_DEBUG 0
ENV LOG_CHANNEL daily
ENV BROADCAST_DRIVER log
ENV CACHE_DRIVER redis
ENV SESSION_DRIVER database
ENV QUEUE_DRIVER database

# Removedefault Apache configuration
RUN rm /etc/apache2/sites-available/000-default.conf

# Copy Apache configuration
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache modules
RUN a2enmod rewrite headers

# Start Apache server
CMD ["httpd", "-D", "FOREGROUND"]