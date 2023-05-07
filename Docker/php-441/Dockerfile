FROM centos:centos7

ENV TZ Asia/Tokyo

RUN yum install -y flex gcc libxml2-devel make
WORKDIR /usr/local/src
RUN curl -o php-4.4.1.tar.gz https://museum.php.net/php4/php-4.4.1.tar.gz \
    && tar zxf php-4.4.1.tar.gz \
    && rm -f php-4.4.1.tar.gz
WORKDIR /usr/local/src/php-4.4.1
RUN ./configure --enable-fastcgi
RUN make && make install

EXPOSE 9000
ENTRYPOINT ["php", "-b", "*:9000"]
