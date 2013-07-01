<?php
// Draggy\Autocode\PHPEntity.php

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

namespace Draggy\Autocode;

use Draggy\Autocode\Base\PHPEntityBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Entity\PHPEntity
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

    /**
     * @return PHPAttribute[]
     */
    public function getFormAttributes()
    {
        return parent::getFormAttributes();
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

    public function getFullyQualifiedRepositoryName()
    {
        return $this->getProject()->getRepositoryTemplate()->setEntity($this)->getFullyQualifiedName();
    }

    public function getFullyQualifiedFormName()
    {
        return $this->getProject()->getFormTemplate()->setEntity($this)->getFullyQualifiedName();
    }

    public function getFullyQualifiedFormBaseName()
    {
        return $this->getProject()->getFormBaseTemplate()->setEntity($this)->getFullyQualifiedName();
    }
    // </user-additions>
    // </editor-fold>
}
