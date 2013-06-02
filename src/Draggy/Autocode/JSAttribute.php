<?php
// Draggy\Autocode\JSAttribute.php

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

use Draggy\Autocode\Base\JSAttributeBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Entity\JSAttribute
 */
class JSAttribute extends JSAttributeBase
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    public static $JS_VARS = ['string'   => 'string',
                              'boolean'  => 'boolean',
                              'integer'  => 'number',
                              'smallint' => 'number',
                              'bigint'   => 'number',
                              'text'     => 'string',
                              'date'     => 'string',
                              'time'     => 'string',
                              'datetime' => 'string',
                              'array'    => 'array',
                              'decimal'  => 'number',
                              'object'   => 'object'];
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    public function getJSType()
    {
        return self::$JS_VARS[$this->getType()];
    }

    public function getJSDocType()
    {
        if ($this->getJSType() === 'array') {
            return 'Array' . (!is_null($this->getSubtype()) ? '.<' . (isset(self::$JS_VARS[$this->getSubtype()]) ? self::$JS_VARS[$this->getSubtype()] : '') . '>' : '');
        } else {
            return self::$JS_VARS[$this->getType()];
        }
    }

    public function getSafeName()
    {
        if (in_array(strtolower($this->getName()),['null','default','static'])) {
            return $this->getName() . 'Attribute';
        } else {
            return $this->getName();
        }
    }

    public function getLowerSafeName()
    {
        return strtolower($this->getSafeName()[0]) . substr($this->getSafeName(), 1);
    }
    // </user-additions>
    // </editor-fold>
}
