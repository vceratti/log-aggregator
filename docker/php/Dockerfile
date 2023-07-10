FROM php:8.2-alpine3.18 as app-base



ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
  install-php-extensions pcntl mysqli pdo_mysql sockets

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /app

FROM app-base as app-dev

ARG USER_ID
ARG GROUP_ID

ENV DEV_USER=dev
ENV HOME=/home/$DEV_USER
ENV COMPOSER_HOME=${HOME}/composer

RUN addgroup -S $DEV_USER -g ${GROUP_ID} && adduser -S -D $DEV_USER -G $DEV_USER -u ${USER_ID}
USER $DEV_USER
RUN mkdir -p $COMPOSER_HOME
#
#
#
#WORKDIR /app
#
#FROM app-base as app-dev
#
#USER root
#
#COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN install-php-extensions xdebug
#
#RUN mkdir -p /opt/phpstorm-coverage && chmod a+rw /opt/phpstorm-coverage
#
#USER $DEV_USER
