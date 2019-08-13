# Derived from official mysql image (our base image)
FROM mysql
# Add a database
ENV MYSQL_DATABASE arquivei
ENV MYSQL_USER=root
ENV MYSQL_PASSWORD=root
ENV MYSQL_ROOT_PASSWORD=root
# Add the content of the sql-scripts/ directory to your image
# All scripts in docker-entrypoint-initdb.d/ are automatically
# executed during container startup
COPY ./sql-scripts/ /docker-entrypoint-initdb.d/

FROM php:7
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mbstring pdo_mysql
WORKDIR /app
COPY . /app
RUN composer install

RUN php artisan migrate
RUN php artisan serve --host=127.0.0.1 --port=8080
EXPOSE 8080