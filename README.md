draggy
======

Draggy project

Installation (if you know what you are doing)
---------------------------------------------
The easiest way to install dragyy is by using Composer:

    curl -s https://getcomposer.org/installer | php
    php composer.phar create-project jd/draggy /path/to/draggy master-dev

Installation (for dummies)
--------------------------
Make sure you have all the necessary dependencies installed

    sudo apt-get install subversion git apache2 php5 php5-sqlite php-apc php5-intl mysql-server php5-mysql phpmyadmin php5-xdebug php-apc php5-intl php5-xdebug curl
    
Configure a new site on apache

    echo date.timezone = Europe/London | sudo tee -a /etc/php5/cli/php.ini
    echo date.timezone = Europe/London | sudo tee -a /etc/php5/apache2/php.ini
    echo short_open_tag = Off | sudo tee -a /etc/php5/cli/php.ini
    echo short_open_tag = Off | sudo tee -a /etc/php5/apache2/php.ini
    
    echo 127.0.0.1 draggy.local | sudo tee -a /etc/hosts
    
    sudo tee /etc/apache2/sites-available/draggy << EOF
    <VirtualHost *:80>
      DocumentRoot "/var/www/draggy"
      DirectoryIndex d.php
      ServerName draggy.local
      <Directory "/var/www/draggy">
        AllowOverride All
        Allow from All
      </Directory>
    </VirtualHost>
    EOF
    
    sudo a2ensite draggy
    sudo service apache2 reload

Download composer and install draggy

    cd
    curl -s https://getcomposer.org/installer | php
    php composer.phar create-project jd/draggy /var/www/draggy master-dev
    
    
