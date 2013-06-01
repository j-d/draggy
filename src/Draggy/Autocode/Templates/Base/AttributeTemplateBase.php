<?php
// Draggy\Autocode\Templates\Base\AttributeTemplate.php

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

namespace Draggy\Autocode\Templates\Base;

use Draggy\Autocode\Templates\AttributeTemplate;
use Draggy\Autocode\Templates\Template;
use Draggy\Autocode\Attribute;

/**
 * Draggy\Autocode\Templates\Entity\Base\AttributeTemplate
 */
abstract class AttributeTemplateBase extends Template
{
    // <editor-fold desc="Attributes">
    /**
     * @var Attribute $attribute
     */
    protected $attribute;

    // </editor-fold>

    // <editor-fold desc="Setters and getters">
    /**
     * Set attribute
     *
     * @param Attribute $attribute
     *
     * @return AttributeTemplate
     */
    public function setAttribute(Attribute $attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get attribute
     *
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
    // </editor-fold>

    // <editor-fold desc="Other methods">
    /**
     * AttributeTemplate to string (Default)
     *
     * @return string
     */
    public function __toString()
    {
        return 'AttributeTemplate';
    }
    // </editor-fold>
}
