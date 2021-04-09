FROM php:7.4-fpm

LABEL author="Laurent BRAU"
RUN apt-get update \
        && apt-get install -y --no-install-recommends vim curl debconf subversion git apt-transport-https apt-utils \
    build-essential locales acl mailutils wget zip unzip wget \
    gnupg gnupg1 gnupg2

RUN apt-get update && apt-get install -y librabbitmq-dev libssh-dev \
    && docker-php-ext-install opcache bcmath sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp

# COPY php.ini /etc/php/7.2.3/php.ini
COPY php.ini /usr/local/etc/php/php.ini

COPY php-fpm-pool.conf /etc/php/7.2.3/pool.d/www.conf

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

RUN wget https://s1.stackify.com/Account/AgentDownload/Linux --output-document=stackify.tar.gz \
         && tar -zxvf stackify.tar.gz stackify-agent-install-32bit && cd stackify-agent-install-32bit \
         && ./agent-install.sh --docker --key 4Vt6Lr1Ke3De2Wg7Wq4Ci3Yy8Sj8Mj8Du6Ge1Qu --environment Production

RUN docker-php-ext-install pdo pdo_mysql

# soap
RUN apt-get update && \
    apt-get install -y libxml2-dev && \
    docker-php-ext-install soap

RUN groupadd dev -g 999
RUN usermod -u 1000 www-data
RUN useradd dev -g dev -d /home/dev -m
# Change ownership of www-data root directory
# Add www-data to root group and viceversa

RUN rm -rf /var/lib/apt/lists/*sl
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

# Xdebug config
ENV APCU_VERSION 5.1.18
RUN pecl install xdebug-2.9.8 && docker-php-ext-enable xdebug
RUN pecl install apcu-$APCU_VERSION && docker-php-ext-enable --ini-name 05-opcache.ini opcache && docker-php-ext-enable --ini-name 20-apcu.ini apcu
COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY xdebug.ini /usr/local/etc/nginx/nginx.conf
ENV PHP_IDE_CONFIG serverName=teenkedin
# --------------------------------------
WORKDIR /srv

EXPOSE 9000
CMD ["php-fpm"]