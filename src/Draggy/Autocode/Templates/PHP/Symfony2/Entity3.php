<?php
// Draggy\Autocode\Templates\PHP\Symfony2\Entity3.php

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

use Draggy\Autocode\Templates\PHP\Symfony2\Base\Entity3Base;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Symfony2\Entity\Entity3
 */
class Entity3 extends Entity3Base
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
    public function getFilenameLine()
    {
        $line = '// ' . $this->getEntity()->getNamespace() . '\\Entity\\';

        if ($this->getEntity()->getProject()->getBase()) {
            $line .= 'Base\\';
        }

        $line .= $this->getEntity()->getName() . '.php';

        return $line;
    }

    public function getNamespaceLine()
    {
        $line = 'namespace ' . $this->getEntity()->getNamespace() . '\\Entity';

        if ($this->getEntity()->getProject()->getBase()) {
            $line .= '\\Base';
        }

        $line .= ';';

        return $line;
    }

    public function getUseLines()
    {
        $lines = [];

        if ($this->getEntity()->getProject()->getValidation()) {
            $lines[] = 'use Symfony\\Component\\Validator\\Constraints as Assert;';
        }

        if (count($this->getEntity()->getUniqueAttributes()) > 0) {
            $lines[] = 'use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;';
        }

        $lines = array_merge($lines, parent::getUseLines());

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}