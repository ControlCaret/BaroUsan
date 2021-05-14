FROM ubuntu:20.04

LABEL maintainer = "Heejae Kwak <controlcaret@gmail.com>"

# Avoiding user interaction with tzdata
ARG DEBIAN_FRONTEND=noninteractive
ENV TZ=Asia/Seoul

RUN apt-get update -y
RUN apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get install -y apache2
RUN apt-get install -y php7.3
RUN apt-get install -y php7.3-mysqli

EXPOSE 80

CMD echo "ServerName localhost" >> /etc/apache2/apache2.conf
CMD ["apachectl", "-D", "FOREGROUND"]
