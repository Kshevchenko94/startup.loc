FROM nginx

ADD docker/conf/startup.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/startup.loc