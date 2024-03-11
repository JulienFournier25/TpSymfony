# Use an official PHP runtime as a parent image
FROM php:8.1-fpm

# Install the PHP extensions we need
RUN apt-get update && apt-get install -y \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libssl-dev \
        libmcrypt-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip

# Install MySQL client
RUN apt-get update && \
    apt-get install -y default-mysql-client

# Install mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Set working directory
WORKDIR /var/www

COPY . /var/www

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
