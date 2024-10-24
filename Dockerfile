FROM php:8.2-apache

# Install the PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Optionally, install other dependencies like libpng or libjpeg
# RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev \
#     && docker-php-ext-configure gd --with-jpeg-dir=/usr/include/ \
#     && docker-php-ext-install gd
