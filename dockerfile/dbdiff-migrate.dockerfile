FROM php:7.1.13-fpm
MAINTAINER Ryan Wu<946065221@qq.com>
ENV DATABASE_HOST 127.0.0.1
ENV DATABASE_PORT 3306
ENV DATABASE_USER root
ENV DATABASE_PASSWORD 0000
ENV DATABASE_NAME test
RUN apt-get update \
    && apt-get install -y python python-pip python-mysqldb \
    && pip install simple-db-migrate \
    && docker-php-source extract \
    && docker-php-ext-install \
        mysqli \
        pdo_mysql \
RUN mkdir /DBDiff
COPY /DBDiff /DBDiff/
RUN chmod 777 /DBDiff/dbdiff-migrate.sh
WORKDIR /DBDiff
CMD ["./dbdiff-migrate.sh"]