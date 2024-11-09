FROM php:8-apache
RUN a2enmod rewrite
RUN apt-get update && \
    apt-get install -y libldap2-dev && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu && \
    docker-php-ext-install ldap && \
    apt-get clean && rm -rf /var/lib/apt/lists/* \
COPY .htaccess /var/www/html
COPY data /var/www/html
COPY meme /var/www/html
COPY api /var/www/html
COPY assets /var/www/html
COPY lib /var/www/html
COPY *.php /var/www/html
RUN chown -R www-data:www-data /var/www/html/{data,meme}