# FROM php:8.4-apache
FROM php:8.4-cli
SHELL ["/bin/bash", "-c"]
ADD --chmod=+x https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN apt update && apt full-upgrade -y\
    && apt install nodejs git 7zip -y\
    && apt clean
# install php extensions
RUN install-php-extensions pdo pdo_mysql xdebug