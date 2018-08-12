FROM php:7.2
MAINTAINER SeaLife

EXPOSE 8000

COPY src /app

WORKDIR /app

ENTRYPOINT [ "php", "-S", "0.0.0.0:8000" ]
CMD []