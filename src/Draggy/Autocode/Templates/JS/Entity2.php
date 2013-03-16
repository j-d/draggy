<?php
// Autocode\Templates\JS\Entity2.php

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

namespace Draggy\Autocode\Templates\JS;

use Draggy\Autocode\Templates\JS\Base\Entity2Base;
// <user-additions part="use">
use Draggy\Autocode\Attribute;
use Draggy\Autocode\JSAttribute;
// </user-additions>

/**
 * Autocode\Templates\JS\Entity\Entity2
 */
class Entity2 extends Entity2Base
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
    public function getAttribute(JSAttribute $attribute)
    {
        $ret = '';

        $ret .= '    /**' . "\n";

        if (!is_null($attribute->getDescription())) {
            $ret .= '     * ' . $attribute->getDescription() . "\n";
            $ret .= '     *' . "\n";
        }

        $ret .= '     * @protected' . "\n";
        $ret .= '     * @type {' . $attribute->getJSDocType() . '} ' . $attribute->getLowerName() . "\n";
        $ret .= '     */' . "\n";

        if ($attribute->getStatic()) {
            $ret .= $attribute->getEntity()->getName() . '.prototype.' . $attribute->getName() . (!is_null($attribute->getDefaultValue()) ? ' = ' . $attribute->getDefaultValue() . ';' : ';');
            return str_replace('    ', '', $ret);
        }

        if ($attribute->getEntity()->getProject()->getBase()) {
            if (is_null($attribute->getDefaultValue())) {
                $ret .= '    this.' . $attribute->getLowerName() . ' = undefined;' . "\n";
            }
            else {
                switch($attribute->getJSType()) {
                    case 'string':
                        if ($attribute->getDefaultValue() == 'null') {
                            $ret .= '    this.' . $attribute->getLowerName() . ' = null;' . "\n";
                        } elseif ($attribute->getDefaultValue() == '\'\'') {
                            $ret .= '    this.' . $attribute->getLowerName() . ' = \'\';' . "\n";
                        }
                        else {
                            $ret .= '    this.' . $attribute->getLowerName() . ' = \'' . str_replace('\'','\\\'',$attribute->getDefaultValue()) . '\';' . "\n";
                        }
                        break;
                    default:
                        $ret .= '    this.' . $attribute->getLowerName() . ' = ' . $attribute->getDefaultValue() . ';' . "\n";
                }

            }
        } else {
            if (is_null($attribute->getDefaultValue()))
                $ret .= '    private $' . $attribute->getLowerName() . ';' . "\n";
            else {
                switch($attribute->getJSType()) {
                    case 'string':
                        $ret .= '    private $' . $attribute->getLowerName() . ' = \'' . str_replace('\'','\\\'',$attribute->getDefaultValue()) . '\';' . "\n";
                        break;
                    default:
                        $ret .= '    private $' . $attribute->getLowerName() . ' = ' . $attribute->getDefaultValue() . ';' . "\n";
                }
            }
        }

        return $ret;
    }

    public function getSetterCode(JSAttribute $attribute)
    {
        $val = '';

        if ($attribute->getJSType() == 'boolean') {
            if (!$attribute->getNull()) {
                $val .= '        if (!is_bool($' . $attribute->getLowerName() . ')) {' . "\n";
                $val .= '            throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be boolean.\');' . "\n";
                $val .= '        }' . "\n";
            } else {
                $val .= '        if (!is_bool($' . $attribute->getLowerName() . ') && !is_null($' . $attribute->getLowerName() . ')) {' . "\n";
                $val .= '            throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be boolean or null.\');' . "\n";
                $val .= '        }' . "\n";
            }
            $val .= "\n";
        } elseif ($attribute->getJSType() == 'integer') {
            if (!$attribute->getNull()) {
                $val .= '        if (!is_int($' . $attribute->getLowerName() . ')) {' . "\n";
                $val .= '            throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be an integer.\');' . "\n";
                $val .= '        }' . "\n";
            } else {
                $val .= '        if (!is_int($' . $attribute->getLowerName() . ') && !is_null($' . $attribute->getLowerName() . ')) {' . "\n";
                $val .= '            throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be an integer or null.\');' . "\n";
                $val .= '        }' . "\n";
            }
            $val .= "\n";
        } elseif ($attribute->getJSType() == 'float') {
            if (!$attribute->getNull()) {
                $val .= '        if (!is_float($' . $attribute->getLowerName() . ')) {' . "\n";
                $val .= '            throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be a float.\');' . "\n";
                $val .= '        }' . "\n";
            } else {
                $val .= '        if (!is_float($' . $attribute->getLowerName() . ') && !is_null($' . $attribute->getLowerName() . ')) {' . "\n";
                $val .= '            throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be a float or null.\');' . "\n";
                $val .= '        }' . "\n";
            }
            $val .= "\n";
        } elseif ($attribute->getJSType() == 'string') {
            if ($attribute->getType() == 'string') {
                if (!$attribute->getNull()) {
                    $val .= '        if (!is_string($' . $attribute->getLowerName() . ')) {' . "\n";
                    $val .= '            throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be a string.\');' . "\n";
                    //$val .= '        } elseif (strlen($' . $attribute->getLowerName() . ') > ' . $this->size . ') {' . "\n";
                    //$val .= '            trigger_error(\'The length of the string \' . $' . $attribute->getLowerName() . ' . \' is \' . strlen($' . $attribute->getLowerName() . ') . \' which is longer than the maximum allowed (' . $this->size . '). Some information will not be saved.\', E_USER_NOTICE);' . "\n";
                    //$val .= '        }' . "\n";
                    if (!is_null($attribute->getMinSize())) {
                        $val .= '        } elseif (strlen($' . $attribute->getLowerName() . ') < ' . $attribute->getMinSize() . ') {' . "\n";
                        $val .= '            throw new \InvalidArgumentException(\'On the attribute ' . $attribute->getLowerName() . ', the length of the string \' . $' . $attribute->getLowerName() . ' . \' is \' . strlen($' . $attribute->getLowerName() . ') . \' which is shorter than the minimum allowed (' . $attribute->getMinSize() . ').\');' . "\n";
                        $val .= '        }' . "\n";
                    } else {
                        $val .= '        }' . "\n";
                    }
                } else {
                    $val .= '        if (!is_string($' . $attribute->getLowerName() . ')) {' . "\n";
                    $val .= '            if ( !is_null($' . $attribute->getLowerName() . ') ) {' . "\n";
                    $val .= '                throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be a string or null.\');' . "\n";
                    $val .= '            }' . "\n";
                    //$val .= '        } elseif (strlen($' . $attribute->getLowerName() . ') > ' . $this->size . ' ) {' . "\n";
                    //$val .= '            trigger_error(\'The length of the string \' . $' . $attribute->getLowerName() . ' . \' is \' . strlen($' . $attribute->getLowerName() . ') . \' which is longer than the maximum allowed (' . $this->size . '). Some information will not be saved.\', E_USER_NOTICE);' . "\n";
                    //$val .= '        }' . "\n";
                    if (!is_null($attribute->getMinSize())) {
                        $val .= '        } elseif (strlen($' . $attribute->getLowerName() . ') < ' . $attribute->getMinSize() . ') {' . "\n";
                        $val .= '            throw new \InvalidArgumentException(\'On the attribute ' . $attribute->getLowerName() . ', the length of the string \' . $' . $attribute->getLowerName() . ' . \' is \' . strlen($' . $attribute->getLowerName() . ') . \' which is shorter than the minimum allowed (' . $attribute->getMinSize() . ').\');' . "\n";
                        $val .= '        }' . "\n";
                    } else {
                        $val .= '        }' . "\n";
                    }
                }
                $val .= "\n";
            } elseif ($attribute->getType() == 'text') {
                if (!$attribute->getNull()) {
                    $val .= '        if (!is_string($' . $attribute->getLowerName() . ')) {' . "\n";
                    $val .= '            throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be a string.\');' . "\n";
                    $val .= '        }' . "\n";
                } else {
                    $val .= '        if (!is_string($' . $attribute->getLowerName() . ') && !is_null($' . $attribute->getLowerName() . ')) {' . "\n";
                    $val .= '            throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be a string or null.\');' . "\n";
                    $val .= '        }' . "\n";
                }
                $val .= "\n";
            }
        }

        $ret = '';

        $ret .= '/**' . "\n";
        $ret .= ' * Set ' . $attribute->getLowerName() . "\n";
        $ret .= ' *' . "\n";
        $ret .= ' * @param {' . $attribute->getJSType() . (!$attribute->getNull() ? '' : '|null}') . '} ' . $attribute->getLowerSafeName() . "\n";
        $ret .= ' *' . "\n";
        $ret .= ' * @return {' . $attribute->getEntity()->getName() . '}' . "\n";

        if ($val != '') {
            //$ret .= ' *' . "\n";
            //$ret .= ' * @throws \InvalidArgumentException' . "\n";
        }

        $ret .= ' */' . "\n";
        $ret .= $attribute->getEntity()->getName() . ($attribute->getEntity()->getProject()->getBase() ? 'Base' : '') . '.prototype.set' . $attribute->getUpperName() . ' = function (' . $attribute->getLowerSafeName() . ')' . "\n";
        $ret .= '{' . "\n";

        //$ret .= $val;

        $ret .= '    this.' . $attribute->getLowerName() . ' = ' . $attribute->getLowerSafeName() . ';' . "\n";

        $ret .= "\n";
        $ret .= '    return this;' . "\n";
        $ret .= '};' . "\n";

        return $ret;
    }

    public function getGetterCode(JSAttribute $attribute)
    {
        $ret = '';

        $ret .= '/**' . "\n";
        $ret .= ' * Get ' . $attribute->getLowerName() . "\n";
        $ret .= ' *' . "\n";
        $ret .= ' * @return {' . $attribute->getJSType() . '}' . "\n";
        $ret .= ' */' . "\n";
        $ret .= $attribute->getEntity()->getName() . ($attribute->getEntity()->getProject()->getBase() ? 'Base' : '') . '.prototype.get' . $attribute->getUpperName() . ' = function ()' . "\n";
        $ret .= '{' . "\n";
        $ret .= '    return this.' . $attribute->getLowerName() . ';' . "\n";
        $ret .= '};' . "\n";

        return $ret;
    }

    public function getAddersCode(JSAttribute $attribute)
    {
        return '';

        $ret = '';

        $ret .= '    /**' . "\n";
        $ret .= '     * Add ' . $attribute->getSingleName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @param ' . $attribute->getType() . ' $' . $attribute->getSingleName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @return ' . $attribute->getEntity()->getName() . "\n";
        $ret .= '     */' . "\n";
        $ret .= '    public function add' . $attribute->getSingleUpperName() . '(' . ( $attribute->getType() !== '' ? $attribute->getType() . ' ' : '' ) . '$' . $attribute->getSingleName() . ')' . "\n";
        $ret .= '    {' . "\n";

        if (!$attribute->getSettingFromInverse()) {
            $ret .= '        $this->' . $attribute->getLowerName() . '[] = $' . $attribute->getSingleName() . ';' . "\n";
        } else {
            $ret .= '        $' . $attribute->getSingleName() . '->add' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);' . "\n";
        }

        $ret .= "\n";
        $ret .= '        return $this;' . "\n";
        $ret .= '    }' . "\n";

        $ret .= "\n";

        $ret .= '    /**' . "\n";
        $ret .= '     * Add ' . $attribute->getLowerName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @param ' . $attribute->getType() . ' $' . $attribute->getLowerName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @return ' . $attribute->getEntity()->getName() . "\n";
        $ret .= '     */' . "\n";
        $ret .= '    public function add' . $attribute->getUpperName() . '(' . $attribute->getType() . ' ' . '$' . $attribute->getLowerName() . ')' . "\n";
        $ret .= '    {' . "\n";

        if (!$attribute->getSettingFromInverse()) {
            $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
            $ret .= '            $this->' . $attribute->getLowerName() . '[] = $' . $attribute->getSingleName() . ';' . "\n";
            $ret .= '        }' . "\n";
        } else {
            $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
            $ret .= '            $' . $attribute->getSingleName() . '->add' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);' . "\n";
            $ret .= '        }' . "\n";
        }

        $ret .= "\n";
        $ret .= '        return $this;' . "\n";
        $ret .= '    }' . "\n";

        return $ret;
    }

    public function getRemoversCode(JSAttribute $attribute)
    {
        return '';

        $ret = '';

        $ret .= '    /**' . "\n";
        $ret .= '     * Remove ' . $attribute->getSingleName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @param ' . $attribute->getType() /*. ($attribute->getEntity()->getProject()->getBase() ? 'Base' : '')*/ . ' $' . $attribute->getSingleName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @return ' . $attribute->getEntity()->getName() . "\n";
        $ret .= '     */' . "\n";
        $ret .= '    public function remove' . $attribute->getSingleUpperName() . '(' . ( $attribute->getType() !== '' ? $attribute->getType() . ' ' : '' ) . '$' . $attribute->getSingleName() . ')' . "\n";
        $ret .= '    {' . "\n";

        if ($attribute->getType() === 'array' && !is_null($attribute->getSubtype())) {
            $ret .= '        foreach ($this->' . $attribute->getLowerName() . ' as $key => $' . $attribute->getSingleName() . 'Element) {' . "\n";
            $ret .= '            if ($' . $attribute->getSingleName() . 'Element === $' . $attribute->getSingleName() . ') {' . "\n";
            $ret .= '                unset($this->' . $attribute->getLowerName() . '[$key]);' . "\n";
            $ret .= '                break;' . "\n";
            $ret .= '            }' . "\n";
            $ret .= '        }' . "\n";
        } else {
            if (!$attribute->getSettingFromInverse()) {
                $ret .= '        $this->' . $attribute->getLowerName() . '->removeElement($' . $attribute->getSingleName() . ');' . "\n";
            } else {
                $ret .= '        $' . $attribute->getSingleName() . '->remove' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);' . "\n";
            }
        }

        $ret .= "\n";
        $ret .= '        return $this;' . "\n";
        $ret .= '    }' . "\n";

        $ret .= "\n";

        $ret .= '    /**' . "\n";
        $ret .= '     * Remove ' . $attribute->getLowerName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @param ' . $attribute->getType() . ' $' . $attribute->getLowerName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @return ' . $attribute->getEntity()->getName() . "\n";
        $ret .= '     */' . "\n";
        $ret .= '    public function remove' . $attribute->getUpperName() . '(' . $attribute->getType() . ' ' . '$' . $attribute->getLowerName() . ')' . "\n";
        $ret .= '    {' . "\n";

        if ($attribute->getType() === 'array' && !is_null($attribute->getSubtype())) {
            $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
            $ret .= '            $this->remove' . $attribute->getSingleUpperName() . '($' . $attribute->getSingleName() . ');' . "\n";
            $ret .= '        }' . "\n";
        } else {
            if (!$attribute->getSettingFromInverse()) {
                $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
                $ret .= '            $this->' . $attribute->getLowerName() . '->removeElement($' . $attribute->getSingleName() . ');' . "\n";
                $ret .= '        }' . "\n";
            } else {
                $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
                $ret .= '            $' . $attribute->getSingleName() . '->remove' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);' . "\n";
                $ret .= '        }' . "\n";
            }
        }

        $ret .= "\n";
        $ret .= '        return $this;' . "\n";
        $ret .= '    }' . "\n";

        return $ret;
    }

    public function getSetterGetter(JSAttribute $attribute)
    {
        $retArray = [];

        if ($attribute->getSetter()) {
            $retArray[] = $this->getSetterCode($attribute);
        }

        if ($attribute->getJSType() === 'array') {
            $retArray[] = $this->getAddersCode($attribute);
            $retArray[] = $this->getRemoversCode($attribute);
        }

        if ($attribute->getGetter()) {
            $retArray[] = $this->getGetterCode($attribute);
        }

        return implode("\n",$retArray);
    }

    protected function entityToString() {
        $entity = $this->getEntity();

        $ret = '';

        $ret .= '/**' . "\n";
        $ret .= ' * ' . $entity->getName() . ' to string ' . (is_null($entity->getToString()) ? '(Default)' : '(' . $entity->getToString() . ')') . "\n";
        $ret .= ' *' . "\n";
        $ret .= ' * @return {string}' . "\n";
        $ret .= ' */' . "\n";

        $ret .= $entity->getName() . '.prototype.toString = function ()' . "\n";
        $ret .= '{' . "\n";

        if (is_null($entity->getToString())) {
            if ($entity->getProject()->getORM() !== '') {
                $ret .= '    return \'' . $entity->getName() . '(\' . this.' . $entity->getPrimaryAttribute()->getName() . ' . \')\';' . "\n";
            } else {
                $ret .= '    return \'' . $entity->getName() . '\';' . "\n";
            }
        } else {
            $ret .= '    return this.' . $entity->getAttributeByName($entity->getToString())->getName() . ';' . "\n";
        }

        $ret .= '};' . "\n";

        return $ret;
    }

    public function render()
    {
        $entity = $this->getEntity();

        $attributes       = [];
        $settersGetters   = [];
        $requiredEntities = [];

        foreach ($entity->getAttributes() as $attr) {
            if ( is_null($entity->getParentEntity()) || !in_array($attr->getName(),array_keys($entity->getParentEntity()->getAttributes())) ) {
                if (!$attr->getStatic()) {
                    $attributes[]     = $this->getAttribute($attr);
                }
                $settersGetters[] = $this->getSetterGetter($attr);
            }

            if (!is_null($attr->getForeignEntity())) {
                $foreignEntity = $attr->getForeignEntity()->getFullyQualifiedName();

                if (!in_array($foreignEntity, $requiredEntities)) {
                    $requiredEntities[] = $foreignEntity;
                    $requiredEntities[] = $attr->getForeignEntity()->getFullyQualifiedBaseName();
                }
            }
        }

        $file = '';

        $file .= '// ' . $entity->getNamespace() . '\\';

        if ($entity->getProject()->getBase()) {
            $file .= 'Base\\';
        }

        $file .= $entity->getName() . '.js' . "\n";

        $file .= $this->getDescriptionCode();

        $file .= $this->getBlurb();

        /** @var Attribute[] $uniqueAttributes */
        $uniqueAttributes = [];
        foreach ($entity->getAttributes() as $attr) {
            if ($attr->getUnique()) {
                $uniqueAttributes[] = $attr;
            }
        }

        if (!is_null($entity->getParentEntity())) {
            $file .= $entity->getName() . ($entity->getProject()->getBase() ? 'Base' : '') . '.prototype = new ' . $entity->getParentEntity()->getName() . '();' . "\n";
            $file .= $entity->getName() . ($entity->getProject()->getBase() ? 'Base' : '') . '.prototype.constructor = ' . $entity->getName() . ($entity->getProject()->getBase() ? 'Base' : '') . ';' . "\n";

            $file .= "\n";
        }

        $file .= '/**' . "\n";

        if (!$entity->getProject()->getBase()) {
            $file .= ' * ' . $entity->getNamespace() . '\\' . $entity->getName() . "\n";
        } else {
            $file .= ' * ' . $entity->getNamespace() . '\\Base\\' . $entity->getName() . "\n";
        }

        $file .= ' *' . "\n";
        $file .= ' * @constructor' . "\n";
        $file .= ' */' . "\n";
        $file .= 'function ' . $entity->getName() . ($entity->getProject()->getBase() ? 'Base' : '') . '()' . "\n";
        $file .= '{' . "\n";
        $file .= '    // <editor-fold desc="Attributes">' . "\n";

        if (count($attributes) != 0) {
            $file .= implode("\n", $attributes) . "\n";
        }

        $file .= '    // </editor-fold>' . "\n";
        $file .= '}' . "\n\n";

        $file .= '// <editor-fold desc="Setters and getters">' . "\n";
        $file .= implode("\n\n", $settersGetters);
        $file .= "\n";
        $file .= '// </editor-fold>' . "\n";
        $file .= "\n";
        $file .= '// <editor-fold desc="Other methods">' . "\n";
        $file .= $this->entityToString();
        $file .= '// </editor-fold>';

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}