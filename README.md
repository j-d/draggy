Draggy
======

Draggy is a code development tool and template engine that enables the user to create and maintain a functional
Skelleton of an application.

The installation instructions here are for installing Draggy as a vendor on an existing Symfony2 installation.
If you are starting a new project, there is an easier way to get started by downloading a Symfony2 installation 
that already has Draggy bundled. For details please go to https://github.com/j-d/symfony-standard-draggy

Downloading that bundle package is the same as creating a new Symfony2 project and following the steps below.

If you want to see a demo, you can download one from here: https://github.com/j-d/draggy-demo

Installation (as a vendor on an existing Symfony2 installation)
---------------------------------------------------------------
Edit your `composer.json` file and add draggy as a dependency

    sudo nano composer.json

```json
    "require-dev": {
        ...
        "jd/draggy": "dev-master"
        ...
```

Change the version of the Incenteev dependency as it doesn't currently (2.3) support additional parameters on the `parameters.yml` file:

```json
    "require": {
        ...
        "incenteev/composer-parameter-handler": "2.1.*@dev"
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

Add `doc/history` to the .gitignore

    sudo nano .gitignore

```
...
/doc/history/*
!.gitkeep
```

Register the `DraggyBundle` in the `app\AppKernel.php` (it is recommended to add it on the `dev` section)

    sudo nano app/AppKernel.php

```yml
if (in_array($this->getEnvironment(), array('dev', 'test'))) {
    ...
    $bundles[] = new Draggy\Bundle\DraggyBundle\DraggyBundle();
    $bundles[] = new Draggy\Bundle\MockBundle\MockBundle();
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

If you are going to use the default Draggy mock templates, copy the custom `form_div_layout.html.twig` into the resources folder:

    mkdir app/Resources/views/Form
    cp vendor/jd/draggy/src/Draggy/Bundle/MockBundle/Resources/views/Form/form_div_layout.html.twig app/Resources/views/Form/form_div_layout.html.twig

and amend your `config.yml` file to use this twig template and add the MockBundle to assetic:

    sudo nano app/config/config.yml

```yml
... 
twig:
    ...
    form:
        resources:
            - ':Form:form_div_layout.html.twig'
...
assetic:
    ...
    bundles:        [MockBundle]
    ...
```

Install the Draggy assets

    sudo php app/console assets:install --symlink

That's it! To use it just browse to the path you created, e.g. `http://myproject.local/app_dev.php/_draggy/`

Happy Draggy-ing!
