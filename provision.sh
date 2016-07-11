#!/usr/bin/env bash

#sudo apt-get update

# Apache
#sudo apt-get -y install apache2
#sudo a2enmod rewrite

# PHP
#sudo apt-get -y install php5
#sudo apt-get -y install php5-mcrypt
#sudo php5enmod mcrypt
#sudo apt-get -y install php5-mysql

# MySQL
#sudo apt-get -y install mysql-server
#mysql -uroot -proot -e "CREATE DATABASE protocol"

# PHPMyAdmin
#sudo apt-get -y install phpmyadmin
#sudo ln -s /usr/share/phpmyadmin /var/www/html

# Composer
#php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
#php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
#php composer-setup.php
#php -r "unlink('composer-setup.php');"
#sudo mv composer.phar /usr/local/bin/composer

#sudo service apache2 restart