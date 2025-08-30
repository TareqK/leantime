FROM dunglas/frankenphp:1-php8.3-alpine AS base
RUN set -eux; \
    install-php-extensions mysqli pdo_mysql bcmath mbstring \
        exif pcntl gd opcache ldap zip 
RUN apk add wget

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
RUN rm -rf /app/*.zip
RUN rm -rf /app/*.tar.gz
COPY --from=build /build/target/leantime/ /app
ENV SERVER_NAME=:8080
HEALTHCHECK --interval=30s --timeout=10s --retries=3 \
    CMD  wget --spider http://localhost:8080/index.php > /dev/null 2>&1 || exit 1