FROM php:7.3-apache

RUN apt update && apt-get install -y supervisor

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY ./app /var/www/html

RUN mkdir /var/www/html/will
RUN mkdir /var/www/html/users

COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["sh", "/entrypoint.sh"]