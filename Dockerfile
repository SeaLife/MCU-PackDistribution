FROM php:7.2
MAINTAINER SeaLife

RUN apt update
RUN apt install zip unzip libzip-dev -y
RUN docker-php-ext-install zip
RUN docker-php-ext-enable zip

EXPOSE 8000

COPY src/ /app

WORKDIR /app

ENTRYPOINT [ "php", "-S", "0.0.0.0:8000" ]
CMD []