FROM dunglas/frankenphp:1.9.1-php8.3-alpine AS base
RUN set -eux; \
    install-php-extensions mysqli pdo_mysql bcmath mbstring \
        exif pcntl gd opcache ldap zip redis
RUN apk add curl

RUN rm -rf /tmp/* /var/cache/apk/*

FROM base AS builder
RUN  apk add npm make zip tar
RUN set -eux; \
	install-php-extensions @composer 

FROM builder AS build

COPY ./ /build

WORKDIR /build

RUN make install-deps package

FROM base AS runner

COPY --from=build /build/target/leantime/ /app
COPY .docker/Caddyfile /etc/caddy/Caddyfile

RUN rm -rf /app/*.zip
RUN rm -rf /app/*.tar.gz

HEALTHCHECK  --interval=30s --timeout=10s --retries=5 CMD curl -f http://localhost:2019/metrics || exit 1

ENV SERVER_NAME=:8080
ENV SERVER_ROOT=/app/public


RUN /usr/local/bin/frankenphp && \
	frankenphp version && \
	frankenphp build-info