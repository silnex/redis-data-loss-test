FROM php:8.3-cli

RUN pecl install redis \
    && docker-php-ext-enable redis

COPY index.php /app/index.php

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080" ,"-t", "/app"]