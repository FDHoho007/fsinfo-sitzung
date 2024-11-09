FROM php:8-apache
RUN a2enmod rewrite
RUN apt-get update && \
    apt-get install -y libldap2-dev && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu && \
    docker-php-ext-install ldap && \
    apt-get clean && rm -rf /var/lib/apt/lists/*
COPY data/ /var/www/html/api/
COPY .htaccess /var/www/html
COPY api/ /var/www/html/api/
COPY assets/ /var/www/html/api/
COPY index.html /var/www/html
COPY admin.html /var/www/html
COPY sina.html /var/www/html
RUN chmod -R www-data:www-data /var/www/html/{data,assets/img}