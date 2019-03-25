FROM php:7.1.13-fpm
MAINTAINER Ryan Wu<946065221@qq.com>
RUN docker-php-source extract \
    && docker-php-ext-install \
        mysqli \
        pdo_mysql \
    && mkdir /DBDiff
COPY /DBDiff /DBDiff/
RUN chmod 777 /DBDiff/dbdiff.sh
WORKDIR /DBDiff
CMD ["./dbdiff.sh"]