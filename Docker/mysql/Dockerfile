FROM mysql:8-debian

ENV TZ Asia/Tokyo

ADD ./Docker/mysql/conf.d/my.cnf /etc/mysql/conf.d/my.cnf

RUN apt-get update && \
    apt-get -y install locales && \
    sed -i -e 's/# \(ja_JP.UTF-8\)/\1/' /etc/locale.gen && \
    locale-gen ja_JP.UTF-8 && \
    mkdir /var/log/mysql && \
    chown mysql. /var/log/mysql

ENV LC_ALL ja_JP.UTF-8
