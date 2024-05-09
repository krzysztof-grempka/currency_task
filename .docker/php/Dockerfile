FROM php:8.3-fpm-alpine

# Define build arguments
ARG TIMEZONE
ARG WORKDIR
ARG PHP_UPLOAD_LIMIT
ARG PHP_MEMORY_LIMIT

# Set environment variables
ENV TZ=$TIMEZONE

# Set working directory
WORKDIR $WORKDIR

# Add nginx user and group
RUN addgroup -g 101 -S nginx && adduser -u 101 -S -H -D -G nginx nginx

# Install necessary packages and PHP extensions
RUN apk add --no-cache \
        bash \
        tzdata \
        supervisor \
        libzip-dev \
        icu-dev \
        nano \
        htop \
        rabbitmq-c-dev \
        git \
    && docker-php-ext-install zip pdo_mysql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && apk add --no-cache --update --virtual .phpize-deps $PHPIZE_DEPS \
    && pecl install -o -f amqp \
    && docker-php-ext-enable amqp \
    && apk del .phpize-deps

# Set timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Configure PHP settings
RUN printf 'date.timezone = "%s"\n' $TZ > /usr/local/etc/php/conf.d/timezone.ini \
    && printf 'upload_max_filesize = %s\n' $PHP_UPLOAD_LIMIT > /usr/local/etc/php/conf.d/upload.ini \
    && printf 'memory_limit = %s\n' $PHP_MEMORY_LIMIT > /usr/local/etc/php/conf.d/memory.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Run supervisor
CMD ["/usr/bin/supervisord"]
