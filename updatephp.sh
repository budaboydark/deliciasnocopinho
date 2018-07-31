#!/bin/bash
echo "1 = php5.6 ";
echo "2 = php7.2 ";
echo "3 = php7.0 ";

read version;
case $version in
 "1")
#MODIFICANDO PHP PARA 5.6
sudo update-alternatives --set php /usr/bin/php5.6
#DESABILITANDO MODULO PHP 7.2
sudo a2dismod php7.2
#REINICIANDO APACHE
sudo service apache2 restart
#DESABILITANDO MODULO PHP 7.2
sudo a2dismod php7.0
#REINICIANDO APACHE
sudo service apache2 restart
#ATUALIZANDO MODULO PHP 5.6
sudo a2enmod php5.6
#REINICIA APACHE 
sudo service apache2 restart
#FIM
;; 
"2")

#MODIFICANDO PHP PARA 7.2
sudo update-alternatives --set php /usr/bin/php7.2
#DESABILITANDO MODULO PHP 5.6
sudo a2dismod php5.6
#REINICIANDO APACHE
sudo service apache2 restart
#ATUALIZANDO MODULO PHP 7.0
sudo a2dismod php7.0
#REINICIANDO APACHE
sudo service apache2 restart
#ATUALIZANDO MODULO PHP 7.2
sudo a2enmod php7.2
#REINICIA APACHE 
sudo service apache2 restart
#FIM
;;
"3")

#MODIFICADO PHP PARA 7.0
sudo update-alternatives --set php /usr/bin/php7.0
#DESABILITANDO MODULOS PHP 7.2
sudo a2dismod php7.2
#REINICIANDO APACHE
sudo service apache2 restart
#ATUALIZANDO MODULO PHP 5.6
sudo a2dismod php5.6
#REINICIANDO APACHE
sudo service apache2 restart
#ATUALIZANDO MODULO PHP 7.0
sudo a2enmod php7.0
#REINICIANDO APACHE
sudo service apache2 restart
;;
esac

