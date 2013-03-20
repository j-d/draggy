<?php
// Autocode\Templates\PHP\Entity1.php

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

namespace Draggy\Autocode\Templates\PHP;

use Draggy\Autocode\Templates\PHP\Base\TraitTBase;
// <user-additions part="use">
use Draggy\Autocode\Attribute;
use Draggy\Autocode\PHPAttribute;
// </user-additions>

/**
 * Autocode\Templates\PHP\Entity\Entity1
 */
class TraitT extends TraitTBase
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

        $file .= 'trait ' . $entity->getName() . ' {' . "\n";
        $file .= '{' . "\n";
        $file .= '    // <editor-fold desc="Attributes">' . "\n";
        $file .= '    // <user-additions' . ' part="attributes">' . "\n";
        $file .= '    // </user-additions' . '>' . "\n";
        $file .= '    // </editor-fold>' . "\n";
        $file .= "\n";
        $file .= '    // <editor-fold desc="Setters and Getters">' . "\n";
        $file .= '    // <user-additions' . ' part="settersAndGetters">' . "\n";
        $file .= '    // </user-additions' . '>' . "\n";
        $file .= '    // </editor-fold>' . "\n";
        $file .= "\n";
        $file .= '    // <editor-fold desc="Other methods">' . "\n";
        $file .= '    // <user-additions' . ' part="otherMethods">' . "\n";
        $file .= '    // </user-additions' . '>' . "\n";
        $file .= '    // </editor-fold>' . "\n";
        $file .= '}';

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}