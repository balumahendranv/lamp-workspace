FROM php:8.2-apache

ARG DOCKER_GID=109

# Install required packages including Docker CLI
RUN apt-get update && apt-get install -y \
    docker.io \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip mariadb-client && \
    docker-php-ext-install mysqli && \
    groupmod -g ${DOCKER_GID} docker && \
    usermod -aG docker www-data

# Enable Apache rewrite
RUN a2enmod rewrite

# Copy app code and fix permissions
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html/

