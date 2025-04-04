FROM php:8.3-apache

# Installeer vereiste PHP-extensies (pas aan indien nodig)
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

# Schakel Apache mod_rewrite in (vaak nodig voor PHP apps)
RUN a2enmod rewrite

# Stel de werkdirectory in
WORKDIR /var/www/html

# Zorg ervoor dat Apache de juiste rechten heeft
RUN chown -R www-data:www-data /var/www/html
