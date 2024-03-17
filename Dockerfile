FROM php:8.2-fpm-alpine

# sets up the server Nginx
RUN apk add --no-cache nginx

# Copy Nginx configuration file
COPY nginx.conf ./nginx.conf

# Copy Laravel application files
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies
RUN composer install

# Set Nginx user and group
RUN addgroup -S nginx && adduser -S -G nginx www

# Set the permissions for the Laravel application files
RUN chown -R www:nginx /var/www/html

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]