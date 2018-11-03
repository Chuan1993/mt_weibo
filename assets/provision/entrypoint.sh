#!/bin/bash

echo "Configuring mt_demo Develop Environment..."

echo "export MY_ENV=\"rd-common\"" >> /etc/bashrc

mkdir -p /www/privdata
mkdir -p /www/arachnia_log
ln -s /www/demo.meitu.com/assets/provision/privdata /www/privdata/demo.meitu.com
ln -s /www/demo.meitu.com/assets/provision/behavior_log /www/arachnia_log/app-server-demo


echo "Configuring Nginx"
cp /www/demo.meitu.com/assets/provision/config/sites/*    /usr/local/nginx/conf/server/

service nginx restart > /dev/null

echo "Configuring Hosts"
# 增加美图账号本地开发环境host
echo "172.16.30.2 api.account.meitu.com api.account.meitu.com internal.account.m.com safety.account.meitu.com devapi.account.m.com devinternal.account.m.com devsafety.account.meitu.com" >> /etc/hosts
echo "Using Composer to pull relative Project"
composer config -g repo.packagist composer https://packagist.phpcomposer.com && composer config -g secure-http false && cd /www/demo.meitu.com && composer update -o --no-dev --no-plugins --no-scripts

if [ -f "/usr/local/php7/sbin/www-fpm" ]
then
	/usr/local/php7/sbin/www-fpm start
else
	/usr/local/php/sbin/www-fpm start
fi

/etc/init.d/supervisord start
/etc/init.d/rsyslog start
/etc/init.d/crond start
while true
do
    echo "hello world" > /dev/null
    sleep 6s
done


