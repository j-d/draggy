<?php
// Autocode\Templates\EntityTemplate.php

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

namespace Draggy\Autocode\Templates;

use Draggy\Autocode\Templates\Base\EntityTemplateBase;
// <user-additions part="use">
use Draggy\Autocode\Entity;
// </user-additions>

/**
 * Autocode\Templates\Entity\EntityTemplate
 */
abstract class EntityTemplate extends EntityTemplateBase
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
    public static function getUseLine(Entity $entity)
    {
        $ret = 'use ' . $entity->getNamespace();

        if ($entity->getProject()->getFramework() === 'Symfony2') {
            $ret .= '\\Entity';
        }

        $ret .= '\\' . $entity->getName() . ';' . "\n";

        return $ret;
    }

    protected function getDescriptionCode()
    {
        $entity = $this->getEntity();

        if ( trim($entity->getDescription()) !== '' ) {
            return  '/*' . "\n" .
                ' * ' . trim($entity->getDescription()) . "\n" .
                ' */' . "\n" .
                "\n";
        } else {
            return '';
        }
    }
    // </user-additions>
    // </editor-fold>
}