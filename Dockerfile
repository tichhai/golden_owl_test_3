FROM php:8.2-fpm

# Cài các extension PHP và công cụ hệ thống
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl mariadb-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Thiết lập thư mục làm việc
WORKDIR /var/www

# Copy code vào container
COPY . .

# Cài đặt package Laravel
RUN composer install --optimize-autoloader --no-dev

# Phân quyền cho Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose cổng
EXPOSE 8000

# Lệnh khởi động server
CMD php artisan serve --host=0.0.0.0 --port=8000
