# syntax=docker/dockerfile:1.7
#
# Production image for the Measuring Well-Being application.
# Multi-stage: composer deps -> node build -> FrankenPHP runtime.
# The same image runs the web server, the queue worker and the scheduler
# (selected with the CONTAINER_ROLE environment variable).

ARG PHP_VERSION=8.3

# ---------- 1. PHP dependencies ----------
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN --mount=type=cache,target=/tmp/cache \
    composer install --no-dev --no-interaction --no-scripts --no-progress --prefer-dist --optimize-autoloader

# ---------- 2. Front-end build ----------
FROM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN --mount=type=cache,target=/root/.npm npm ci --no-audit --no-fund
COPY vite.config.js ./
COPY resources ./resources
COPY public ./public
COPY --from=vendor /app/vendor/tightenco/ziggy ./vendor/tightenco/ziggy
RUN npm run build

# ---------- 3. Runtime ----------
FROM dunglas/frankenphp:1-php${PHP_VERSION}-bookworm AS runtime

ENV SERVER_NAME=":8080" \
    APP_ENV=production \
    APP_DEBUG=false \
    CONTAINER_ROLE=web \
    OCTANE_SERVER=frankenphp

RUN install-php-extensions pdo_mysql intl zip gd bcmath opcache pcntl redis \
    && apt-get update && apt-get install -y --no-install-recommends default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

COPY docker/php/production.ini /usr/local/etc/php/conf.d/zz-production.ini
COPY docker/Caddyfile /etc/caddy/Caddyfile
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /app
COPY --chown=www-data:www-data . /app
COPY --from=vendor --chown=www-data:www-data /app/vendor /app/vendor
COPY --from=assets --chown=www-data:www-data /app/public/build /app/public/build

RUN rm -rf /app/legacy /app/mobile /app/node_modules /app/tests /app/.env \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && php artisan package:discover --ansi

USER www-data
EXPOSE 8080
HEALTHCHECK --interval=30s --timeout=5s --start-period=30s --retries=3 \
    CMD curl -fsS http://localhost:8080/up || exit 1

ENTRYPOINT ["entrypoint.sh"]
