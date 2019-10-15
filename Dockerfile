FROM php:7.2-fpm

# Copy composer.lock and composer.json
#COPY composer.lock composer.json /var/www/

# Set working directory
#WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    default-mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    avr-libc \
    binutils-arm-none-eabi \
    binutils-avr \
	gcc-arm-none-eabi \
    libnewlib-arm-none-eabi \
    gcc-avr \
    uisp \
    avrdude \
    flex \
    byacc \
    bison \
    openocd \
    wget

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install -j8 pdo_mysql mbstring zip exif pcntl gd

# Install composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer



# Installing Composer
RUN printf "\nInstalling Composer\n\n"; \
    EXPECTED_SIGNATURE=$(wget -q -O - https://composer.github.io/installer.sig); \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"; \
    ACTUAL_SIGNATURE=$(php -r "echo hash_file('SHA384', 'composer-setup.php');"); \
    if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]; \
    then \
      >&2 echo 'ERROR: Invalid installer signature'; \
      exit 1; \
    else \
      php composer-setup.php --install-dir=/usr/local/bin --filename=composer; \
    fi; \
    rm composer-setup.php

RUN composer global require "hirak/prestissimo" && \
    rm -rf /root/.composer/cache

#RUN composer update && composer upgrade




# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
#COPY ./ /var/www

# Copy existing application directory permissions
#COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
