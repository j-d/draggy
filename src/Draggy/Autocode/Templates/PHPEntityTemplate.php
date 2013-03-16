<?php
// Autocode\Templates\PHPEntityTemplate.php

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

namespace Autocode\Templates;

use Autocode\Templates\Base\PHPEntityTemplateBase;
// <user-additions part="use">
use Autocode\PHPEntity;
// </user-additions>

/**
 * Autocode\Templates\Entity\PHPEntityTemplate
 */
abstract class PHPEntityTemplate extends PHPEntityTemplateBase
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
    /**
     * Get entity
     *
     * @return PHPEntity
     */
    public function getEntity()
    {
        return $this->entity;
    }
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    public function getConstructorDefaultValuesPart()
    {
        $file = '';

        foreach ($this->getEntity()->getAttributes() as $a) {
            if ($a->getPhpType() === '\\DateTime') {
                if ($a->getDefaultValue() !== 'null') {
                    $file .= '        $this->' . $a->getLowerName() . ' = new \\DateTime(\'' . str_replace('\'', '\\\'', $a->getDefaultValue()) . '\');' . "\n";
                }
            } elseif ($a->getForeign() === 'ManyToMany' && null === $a->getDefaultValue()) {
                $file .= '        $this->' . $a->getLowerName() . ' = new ArrayCollection();' . "\n";
            }
        }

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}