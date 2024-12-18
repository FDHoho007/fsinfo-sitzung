FROM php:8-apache
RUN a2enmod rewrite proxy proxy_http ssl
RUN apt-get update && \
    apt-get install -y libldap2-dev && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu && \
    docker-php-ext-install ldap && \
    apt-get clean && rm -rf /var/lib/apt/lists/*
COPY apache.conf /etc/apache2/sites-available/000-default.conf
COPY data /var/www/html/data
COPY meme /var/www/html/meme
COPY api /var/www/html/api
COPY assets /var/www/html/assets
COPY lib /var/www/html/lib
COPY *.php /var/www/html
RUN chown -R www-data:www-data /var/www/html/data
RUN chown -R www-data:www-data /var/www/html/meme