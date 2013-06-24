Draggy
======

Draggy is a visual browser modelling tool that enables the user to create and maintain a functional
Skelleton of an application.

Installation (as a vendor)
--------------------------
Edit your `composer.json` file and add draggy as a dependency

    sudo nano composer.json

```json
    "require": {
        ...
        "jd/draggy": "dev-master"
        ...
```

Run `composer update` to download the recently added dependency

    sudo composer update

Copy the `parameters_draggy.yml.dist` file from `vendor/jd/draggy/app/config/` to `app/config/` as `parameters_draggy.yml`

    sudo cp vendor/jd/draggy/app/config/parameters_draggy.yml.dist app/config/parameters_draggy.yml

Edit your `parameters.yml` file to add an import of the `parameters_draggy.yml` file

    sudo nano app/config/parameters.yml

```yml
    imports:
        - { resource: parameters_draggy.yml }
        ...
    
    parameters:
    ...
```

Edit the `parameters_draggy.yml` and configure the model file name and other parameters

    sudo nano app/config/parameters_draggy.yml

```yml
parameters:
    draggy.model_filename:      <your_model_name>.xml
    draggy.model_path:          %kernel.root_dir%/../doc/
    draggy.model_history_path:  %kernel.root_dir%/../doc/history/
    draggy.model_xml_extension: .xml
    draggy.autocode.src_path:   %kernel.root_dir%/../src/
```

Create the folder where you are going to save the model, if it doesn't exist

    mkdir doc

Crate the path where you are going to save the model history, if it doesn't exist

    mkdir doc/history

Give write access to `www-data` to those folder

    sudo apt-get install acl
    
    sudo setfacl -R  -m u:www-data:rwx -m u:`whoami`:rwx doc doc/history
    sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx doc doc/history

Register the `DraggyBundle` in the `app\AppKernel.php` (it is recommended to add it on the `dev` section)

    sudo nano app/AppKernel.php

```yml
if (in_array($this->getEnvironment(), array('dev', 'test'))) {
    ...
    $bundles[] = new Draggy\Bundle\DraggyBundle\DraggyBundle();
    ...
```

Modify the `routing_dev.yml` file to add Draggy routes

    sudo nano app/config/routing_dev.yml

```yml
... 
_draggy:
    resource: "@DraggyBundle/Resources/config/routing.yml"
    prefix:   /_draggy/
```

Install the Draggy assets

    sudo php app/console assets:install --symlink

That's it! To use it just browse to the path you created, e.g. `http://myproject.local/app_dev.php/_draggy/`

Remember to start by configuring your project!

Happy Draggy-ing!

----------------------------------------------------------------------------------------

Installation (if you know what you are doing) (THIS IS CURRENTLY BROKEN)
------------------------------------------------------------------------
The easiest way to install dragyy is by using Composer:

    curl -s https://getcomposer.org/installer | php
    php composer.phar create-project jd/draggy /PATH/TO/DRAGGY master-dev

Installation (for dummies) (THIS IS CURRENTLY BROKEN)
-----------------------------------------------------
Make sure you have all the necessary dependencies installed:

    sudo apt-get install subversion git apache2 php5 php5-sqlite php-apc php5-intl mysql-server php5-mysql phpmyadmin php5-xdebug php-apc php5-intl php5-xdebug curl
    
Configure a new site on apache called draggy.local:

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

Download composer and install draggy:

    cd
    curl -s https://getcomposer.org/installer | php
    sudo php composer.phar create-project jd/draggy /var/www/draggy master-dev
    
It is now installed, now open:

    http://draggy.local/?f=test
    
To generate the entities:
    
    http://draggy.local/generateentities-test.php
    
Usage (THIS IS CURRENTLY BROKEN)
--------------------------------
Design phase:
* Create a project: http://draggy.local/?f=NAME_OF_PROJECT
* Click on Project properties and configure the type of project
* Add the modules and classes that you need
* Click Save (make sure that www-data has write access on the installation folder)

Auto-coding phase:
* Create a PHP to render the files
  * Look at /generateentities-test.php for inspiration
* Create the necessary bundles on Symfony first (if applicable)
* Open that PHP on your browser
