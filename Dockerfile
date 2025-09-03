# Use official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies and Composer
# Install system dependencies
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*
   
# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    zip \
    gd \
    pdo_mysql

# RUN apt-get update && \
#     apt-get install -y libzip-dev unzip && \
#     docker-php-ext-install zip && \
#     curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Configure Apache to allow .htaccess overrides
RUN echo "<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/allow-overrides.conf

RUN a2enconf allow-overrides

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Install Composer dependencies (if composer.json exists)
RUN if [ -f "composer.json" ]; then \
    composer install --no-dev --optimize-autoloader; \
    fi

# Set proper permissions (after copying files)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 755 /var/www/html/assets

# Expose port 80
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]