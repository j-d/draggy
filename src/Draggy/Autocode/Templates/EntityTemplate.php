<?php
// Draggy\Autocode\Templates\EntityTemplate.php

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
// </user-additions>

/**
 * Draggy\Autocode\Templates\Entity\EntityTemplate
 */
abstract class EntityTemplate extends EntityTemplateBase implements EntityTemplateInterface
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
     * @return ConcreteEntityTemplateInterface
     */
    public function getTemplate()
    {
        return parent::getTemplate();
    }
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    public function getDescriptionCode()
    {
        return $this->convertLinesToCode($this->getDescriptionCodeLines());
    }

    /**
     * @return string
     */
    public function getPathAndFilename()
    {
        return $this->getPath() . $this->getFilename();
    }

    /**
     * @return string
     */
    public function getFullPathAndFilename()
    {
        return $this->getPathAndFilename();
    }

    // </user-additions>
    // </editor-fold>
}
