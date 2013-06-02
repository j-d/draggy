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
    public function render()
    {
        $entity = $this->getEntity();

        $file = '';

        $file .= '### ' . $entity->getName() . ' ###' . "\n";
        $file .= $entity->getModule() . '_' . $entity->getName() . ':' . "\n";
        $file .= '    resource: "@' . $entity->getModule() . '/Resources/config/auto_' . $entity->getLowerName() . '.yml"' . "\n";
        $file .= '    prefix:   /' . "\n";

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}
