FROM php:8.2-apache

# install pdo_mysql and a couple of useful extensions
RUN docker-php-ext-install pdo pdo_mysql

# turn on mod_rewrite so our .htaccess works
RUN a2enmod rewrite

# drop in our apache vhost (DocumentRoot + AllowOverride All)
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# copy app code into the image
COPY MVC/ /var/www/html/

# uploads need to be writable by the apache user (www-data)
RUN mkdir -p /var/www/html/public/uploads/menu /var/www/html/public/uploads/profiles \
    && chown -R www-data:www-data /var/www/html/public/uploads

EXPOSE 80
