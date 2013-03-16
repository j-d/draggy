<?php
// Autocode\PHPEntity.php

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

namespace Autocode;

use Autocode\Base\PHPEntityBase;
// <user-additions part="use">
// </user-additions>

/**
 * Autocode\Entity\PHPEntity
 */
class PHPEntity extends PHPEntityBase
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
     * Get attributes
     *
     * @return PHPAttribute[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    public function shouldHaveConstructor()
    {
        return $this->getHasConstructor() || $this->getHasConstructorDefaultValuesPart();
    }

    public function getHasConstructorDefaultValuesPart()
    {
        foreach ($this->getAttributes() as $a) {
            if (
                $a->getPhpType() === '\\DateTime' ||
                $a->getForeign() === 'ManyToMany' && null === $a->getDefaultValue()
            ) {
                return true;
            }
        }

        return false;
    }

    public function getListRoute()
    {
        return strtolower($this->getModuleNoBundle()) . '_' . strtolower($this->getName());
    }

    public function getAddRoute()
    {
        return strtolower($this->getModuleNoBundle()) . '_' . strtolower($this->getName()) . '_add';
    }

    public function getEditRoute()
    {
        return strtolower($this->getModuleNoBundle()) . '_' . strtolower($this->getName()) . '_edit';
    }

    public function getDeleteRoute()
    {
        return strtolower($this->getModuleNoBundle()) . '_' . strtolower($this->getName()) . '_delete';
    }

    public function getEnableRoute()
    {
        return strtolower($this->getModuleNoBundle()) . '_' . strtolower($this->getName()) . '_enable';
    }

    public function getDisableRoute()
    {
        return strtolower($this->getModuleNoBundle()) . '_' . strtolower($this->getName()) . '_disable';
    }
    // </user-additions>
    // </editor-fold>
}