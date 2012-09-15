#!/bin/sh
echo copied from my other project, not yet working... use at yoour own risk or ask Riccardo
exit 1

#!/bin/sh

set -x

VER=1.4
MYSQL_ROOT_PWD='Ch4ng3me1fUD0ntM1nd'

GOLIARDIA_USER='goluser'
GOLIARDIA_PASS='InBr4gh3'
GOLIARDIA_DB='github_goliardia'
GOLIARDIA_DIR=/var/www/goliardia/

apt-get install -y git mysql-server apache2 apache2-mpm-prefork apache2-utils apache2.2-common libapache2-mod-php5 libapr1 libaprutil1 libdbd-mysql-perl libdbi-perl  libnet-daemon-perl libplrpc-perl libpq5 mysql-client mysql-common mysql-server mysql-server php5-common php5-mysql

# no hurry for this :)
service apache2 restart &

# ugly but it tends to work :)
echo "<a href='/goliardia/'>GitHub Goliardia</a> (See <a href='http://'>project on GitHub</a>)" >> /var/www/index.html


git clone git://github.com/palladius/goliardia $GOLIARDIA_DIR

#See https://help.ubuntu.com/community/MysqlPasswordReset
#apt-get --purge remove mysql-server mysql-common mysql-client -y
#apt-get install -y mysql-server mysql-common mysql-client

# TODO move this to the script init...
(
echo "CREATE DATABASE $GOLIARDIA_DB ;"
echo " grant usage on *.* to $GOLIARDIA_USER@localhost identified by '$GOLIARDIA_PASS';"
echo " grant all privileges on $GOLIARDIA_DB.* to $GOLIARDIA_USER@localhost ;"
echo "FLUSH PRIVILEGES;"
) | tee /root/goliardia-privileges.sql | mysql -u root

# puplate DB
cat $GOLIARDIA_DIR/db/opengoliardia_sample.sql | mysql -u $GOLIARDIA_USER -p"$GOLIARDIA_PASS" $GOLIARDIA_DB
# create setup.php configured with proper MySQL stuff.-
cat $GOLIARDIA_DIR/conf/setup.php.dist | 
  sed -e "s/{{db_user}}/$GOLIARDIA_USER/" |
  sed -e "s/{{db_pass}}/$GOLIARDIA_PASS/" |
  sed -e "s/{{db_name}}/$GOLIARDIA_DB/" |
  tee $GOLIARDIA_DIR/conf/setup.php 

# after doing my stuff
mysqladmin -u root password "$MYSQL_ROOT_PWD"
sudo /etc/init.d/mysql restart

######################################################
# change mysql root password if it exists
#/etc/init.d/mysql stop
# mysqld --skip-grant-tables &
#/usr/sbin/mysqld --skip-grant-tables --skip-networking &
#sleep 5
#mysql -u root mysql
#UPDATE user SET Password=PASSWORD('YOURNEWPASSWORD') WHERE User='root'; FLUSH PRIVILEGES; exit;
# Replace YOURNEWPASSWORD with your new password!
#echo "UPDATE user SET Password=PASSWORD('$MYSQL_ROOT_PWD') WHERE User='root'; FLUSH PRIVILEGES" | mysql -u root mysql -p
# now you have to kill it and restart the normal service
######################################################


touch /root/i-am-a-goliardic-webserver-v$VER.touch


