# Gunakan image PHP dengan Apache
FROM php:8.2-apache

# Install sistem dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql zip

# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Ganti DocumentRoot ke folder public Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy semua file ke dalam container
COPY . /var/www/html

# Set permission
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install dependencies (Composer)
RUN composer install --no-dev --optimize-autoloader

# Expose port 80
EXPOSE 80