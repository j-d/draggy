<?php
// Draggy\Autocode\Templates\PHP\Symfony2\RoutesRouting.php

/************************************************************************************************
 **  THIS IS AN AUTOMATICALLY GENERATED BASE FILE AND SHOULD NOT BE MANUALLY EDITED            **
 **  All user content should be placed within <user-additions part="(name)"></user-additions>  **
 ************************************************************************************************/

/*
 * This file was automatically generated with 'Autocode'
 * by Jose Diaz-Angulo <jose@diazangulo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the package's source code.
 */

namespace Draggy\Autocode\Templates\PHP\Symfony2;

use Draggy\Autocode\Entity;
use Draggy\Autocode\Templates\PHP\Symfony2\Base\RoutesRoutingBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Symfony2\Entity\RoutesRouting
 */
class RoutesRouting extends RoutesRoutingBase
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    public function getTemplateName()
    {
        return 'routes-routing';
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        return 'Resources/config/';
    }

    public function getName()
    {
        return 'routing';
    }

    /**
     * {@inheritDoc}
     */
    public function getFilename()
    {
        return $this->getName() . '.yml';
    }

    public function render()
    {
        $routesArray = [];

        foreach ($this->getProject()->getModuleEntities()[$this->getModule()] as $entity) {
            /** @var Entity $entity */

            if ($entity->getHasRoutes()) {

                $file = '';

                $file .= '### ' . $entity->getName() . ' ###' . "\n";
                $file .= $entity->getModule() . '_' . $entity->getName() . ':' . "\n";
                $file .= '    resource: "@' . $entity->getModule() . '/Resources/config/auto_' . $entity->getLowerName() . '.yml"' . "\n";
                $file .= '    prefix:   /' . "\n";

                $routesArray[] = $file;
            }
        }

        $routes =   '# <system-additions part="routes">' . PHP_EOL .
                    implode(PHP_EOL,$routesArray) .
                    '# </system-additions>' . PHP_EOL;

        return $routes;
    }
    // </user-additions>
    // </editor-fold>
}
