FROM php:7.2.10-fpm-alpine

# persistent / runtime deps
ENV DEPENDENCIES \
    autoconf \
    cmake \
    file \
    g++ \
    gcc \
    libc-dev \
    pcre-dev \
    make \
    git \
    pkgconf \
    re2c

RUN apk add --no-cache --virtual .persistent-deps \
    # for intl extension
    icu-dev \
    # for intl extension
    libintl gettext-dev libxslt \
    # etc
    bash nano

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN set -xe \
    && apk add --no-cache --virtual .build-deps \
        $DEPENDENCIES \
    && docker-php-ext-configure intl --enable-intl \
    && docker-php-ext-configure pdo_pgsql --with-pdo-pgsql \
    && docker-php-ext-configure mbstring --enable-mbstring \
    && docker-php-ext-install -j$(nproc) \
        intl \
        pdo_pgsql \
        mbstring \
        iconv

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN echo "Componer installed"
WORKDIR /var/www
