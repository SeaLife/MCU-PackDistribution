FROM php:7.2
MAINTAINER SeaLife

RUN apt update
RUN apt install zip unzip libzip-dev -y
RUN docker-php-ext-install zip
RUN docker-php-ext-enable zip

ENV APP_MASTER_PASSWORD KmSDUJrhS366FY5a
ENV APP_THEME sealife.xsl
ENV BASE_URL https://localhost:8000

ENV COMPOSER_LOCATION /app-dependencies/

EXPOSE 8000

## create directories
RUN mkdir /app
RUN mkdir /app-dependencies

## prepare dependencies
WORKDIR /app-dependencies
COPY install-twig.sh /app-dependencies
RUN /app-dependencies/install-twig.sh

## install app
COPY src/ /app

## entrypoint
WORKDIR /app
ENTRYPOINT [ "php", "-S", "0.0.0.0:8000" ]
CMD []