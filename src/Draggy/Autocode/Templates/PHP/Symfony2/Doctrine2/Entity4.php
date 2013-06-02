<?php
// Draggy\Autocode\Templates\PHP\Symfony2\Doctrine2\Entity4.php

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

namespace Draggy\Autocode\Templates\PHP\Symfony2\Doctrine2;

use Draggy\Autocode\Templates\PHP\Symfony2\Doctrine2\Base\Entity4Base;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Symfony2\Doctrine2\Entity\Entity4
 */
class Entity4 extends Entity4Base
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
    public function getUseLines()
    {
        $lines = [];

        $lines[] = 'use Doctrine\\ORM\\Mapping as ORM;';

        $useArrayCollection = false;
        foreach ($this->getEntity()->getAttributes() as $attr) {
            if (null !== $attr->getForeign()) {
                $useArrayCollection = true;
                break;
            }
        }

        if ($useArrayCollection) {
            $lines[] = 'use Doctrine\\Common\\Collections\\Collection;';
            $lines[] = 'use Doctrine\\Common\\Collections\\ArrayCollection;'; // Is needed when doing new ArrayCollection();
        }

        $lines = array_merge($lines, parent::getUseLines());

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}