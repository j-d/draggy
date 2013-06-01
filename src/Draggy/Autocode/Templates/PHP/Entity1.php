<?php
// Draggy\Autocode\Templates\PHP\Entity1.php

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

use Draggy\Autocode\Templates\PHP\Base\Entity1Base;
// <user-additions part="use">
use Draggy\Autocode\Attribute;
use Draggy\Autocode\PHPAttribute;
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\Entity1
 */
class Entity1 extends Entity1Base
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
    /**
     * Returns a condition to check for the $attribute type. It allows for one or more types, including objects.
     *
     * @param PHPAttribute $attribute
     * @param string[]     $allowedTypes     An array with the basic types, or a sub array in case of objects. E.g. ['integer', ['object'=>'MyClass']]
     * @param int          $padding          Amount of padding characters
     * @param int          $paddingIncrement Increment on the padding characters
     * @param string       $paddingCharacter Specified padding character
     *
     * @return string
     *
     * @throws \RuntimeException if the allowedTypes array is not well formed
     */
    private function getTypeCheckLines (PHPAttribute $attribute, array $allowedTypes, $padding = 8, $paddingIncrement = 4, $paddingCharacter = ' ')
    {
        $phpTypes     = ['boolean', 'integer', 'float', 'string', 'array', 'object', 'null', 'NULL'];
        $phpFunctions = [
            'boolean' => 'is_bool',
            'integer' => 'is_int',
            'float'   => 'is_float',
            'string'  => 'is_string',
            'array'   => 'is_array'
        ];

        $names     = [];
        $condition = [];

        foreach ($allowedTypes as $type) {
            if ((!is_array($type) && !in_array($type, $phpTypes)) || (is_array($type) && !isset($type['object']))) {
                throw new \RuntimeException('Invalid allowedTypes passed to getTypeCheck (' . (!is_array($type) ? $type : current(array_keys($type))) . ').');
            }

            if (is_array($type)) {
                $names[] = $type['object'];

                $condition[] = '!$' . $attribute->getName() . ' instanceof ' . $type['object'];
            } else {
                /** @var string $type */
                $names[] = $type;

                if ('null' === $type || 'NULL' === $type) {
                    $condition[] = 'null !== $' . $attribute->getLowerName();
                } else {
                    $condition[] = '!' . $phpFunctions[$type] . '($' . $attribute->getLowerName() . ')';
                }
            }
        }

        if (count($names) > 2) {
            $types = implode(' or ', [implode(', ', array_slice($names, 0, -1)), end($names)]);
        } else {
            $types = implode(' or ', $names);
        }

        $lines = [];

        $lines[] = str_repeat($paddingCharacter, $padding) . 'if (' . implode(' && ', $condition) . ') {';
        $lines[] = str_repeat($paddingCharacter, $padding + $paddingIncrement) . 'throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be ' . $types . ' (\' . gettype($' . $attribute->getLowerName() . ') . (\'object\' === gettype($' . $attribute->getLowerName() . ') ? \' \' . get_class($' . $attribute->getLowerName() . ') : \'\') . \' given).\');';
        $lines[] = str_repeat($paddingCharacter, $padding) . '}';

        return $lines;
    }

    public function getSetterInnerValidationCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        if ('boolean' === $attribute->getPhpType()) {
            if (!$attribute->getNull()) {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['boolean']));
            } else {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['boolean', 'null']));
            }

            $lines[] = '';
        } elseif ('integer' === $attribute->getPhpType()) {
            if (!$attribute->getNull()) {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['integer']));
            } else {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['integer', 'null']));
            }

            $lines[] = '';
        } elseif ('float' === $attribute->getPhpType()) {
            if (!$attribute->getNull()) {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['float']));
            } else {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['float', 'null']));
            }

            $lines[] = '';
        } elseif ('string' === $attribute->getPhpType()) {
            if ('string' === $attribute->getType()) {
                if (!$attribute->getNull()) {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['string']));

                    $lines[] = '';

                    if (null !== $attribute->getMinSize()) {
                        $lines[] = '        if (strlen($' . $attribute->getLowerName() . ') < ' . $attribute->getMinSize() . ') {';
                        $lines[] = '            throw new \InvalidArgumentException(\'On the attribute ' . $attribute->getLowerName() . ', the length of the string \' . $' . $attribute->getLowerName() . ' . \' is \' . strlen($' . $attribute->getLowerName() . ') . \' which is shorter than the minimum allowed (' . $attribute->getMinSize() . ').\');';
                        $lines[] = '        }';
                        $lines[] = '';
                    }
                } else {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['string', 'null']));

                    $lines[] = '';

                    if (null !== $attribute->getMinSize()) {
                        $lines[] = '        if (strlen($' . $attribute->getLowerName() . ') < ' . $attribute->getMinSize() . ') {';
                        $lines[] = '            throw new \InvalidArgumentException(\'On the attribute ' . $attribute->getLowerName() . ', the length of the string \' . $' . $attribute->getLowerName() . ' . \' is \' . strlen($' . $attribute->getLowerName() . ') . \' which is shorter than the minimum allowed (' . $attribute->getMinSize() . ').\');';
                        $lines[] = '        }';
                        $lines[] = '';
                    }
                }
            } elseif ('text' === $attribute->getType()) {
                if (!$attribute->getNull()) {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['string']));
                } else {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['string', 'null']));
                }

                $lines[] = '';
            }
        } elseif ('object' === $attribute->getType()) {
            if (null === $attribute->getSubtype()) {
                throw new \InvalidArgumentException('Attribute ' . $attribute->getName() . ' on the entity ' . $attribute->getEntity()->getName() . ' is marked as an object but doesn\'t have a subtype');
            }

            // The not null case doesn't make sense because it will go on the parameter line
            if ($attribute->getNull()) {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, [['object'=>$attribute->getEntitySubtype()->getName()], 'null']));

                $lines[] = '';
            }
        }

        return $lines;
    }

    public function getSetterCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * Set ' . $attribute->getLowerName();
        $lines[] = ' *';
        $lines[] = ' * @param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerName();

        if (!$attribute->getStatic()) {
            $lines[] = ' *';
            $lines[] = ' * @return ' . $attribute->getEntity()->getName();
        }

        if (0 !== count($this->getSetterInnerValidationCodeLines($attribute))) {
            $lines[] = ' *';
            $lines[] = ' * @throws \InvalidArgumentException';
        }

        $lines[] = ' */';

        return $lines;
    }

    public function getSetterCodeLines(PHPAttribute $attribute)
    {
        $validationLines = $this->getSetterInnerValidationCodeLines($attribute);

        $settingFromInverse = $attribute->getSettingFromInverse();

        $lines = [];

        $lines = array_merge($lines, $this->getSetterCodeDocumentationLines($attribute));

        if ($attribute->getStatic()) {
            $line = 'public static function ' . $attribute->getSetterName() . '(';
        } else {
            $line = 'public function ' . $attribute->getSetterName() . '(';
        }

        if (null === $attribute->getPhpParameterType()) {
            $line .= '$' . $attribute->getLowerName() . ')';
        } else {
            $line .= $attribute->getPhpParameterType() . ' $' . $attribute->getLowerName() . ')';
        }

        $lines[] = $line;

        $lines[] = '{';

        $lines = array_merge($lines, $validationLines);

        if (!$settingFromInverse) {
            if ('OneToOne' === $attribute->getForeign()) {
                if (!$attribute->getNull()) {
                    $lines[] = '    ' . $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';';
                    $lines[] = '    if ($this !== $' . $attribute->getName() . '->get' . $this->getEntity()->getName() . '()) {';
                    $lines[] = '        $' . $attribute->getName() . '->set' . $this->getEntity()->getName() . '($this);';
                    $lines[] = '    }';
                } else {
                    $lines[] = '    if (null !== $' . $attribute->getLowerName() . ') {';
                    $lines[] = '        ' . $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';';
                    $lines[] = '        if ($this !== $' . $attribute->getName() . '->get' . $this->getEntity()->getName() . '()) {';
                    $lines[] = '            $' . $attribute->getName() . '->set' . $this->getEntity()->getName() . '($this);';
                    $lines[] = '        }';
                    $lines[] = '    } elseif (null !== ' . $attribute->getThisName() . ') {';
                    if ($attribute->getForeignKey()->getSetter()) {
                        $lines[] = '        ' . $attribute->getThisName() . '->set' . $attribute->getForeignKey()->getUpperName() . '(null);';
                    }
                    $lines[] = '        ' . $attribute->getThisName() . ' = null;';
                    $lines[] = '    }';
                }
            } elseif ('ManyToOne' === $attribute->getForeign()) {
                $lines[] = '    ' . $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';';
            } else {
                $lines[] = '    ' . $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';';
            }
        } else {
            if ('ManyToMany' === $attribute->getForeign()) {
                $lines[] = '    foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] = '        /** @var ' . $attribute->getReverseAttribute()->getEntity()->getName() . ' $' . $attribute->getSingleName() . ' */';
                $lines[] = '        $' . $attribute->getSingleName() . '->set' . $attribute->getReverseAttribute()->getUpperName() . '(new ArrayCollection([$this]));';
                $lines[] = '    }';
            } elseif ('OneToOne' === $attribute->getForeign()) {
                if (!$attribute->getNull()) {
                    $lines[] = '    ' . $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';';
                    $lines[] = '    if ($this !== $' . $attribute->getName() . '->get' . $attribute->getForeignKey()->getUpperName() . '()) {';
                    $lines[] = '        $' . $attribute->getName() . '->set' . $attribute->getForeignKey()->getUpperName() . '($this);';
                    $lines[] = '    }';
                } else {
                    $lines[] = '    if (null !== $' . $attribute->getLowerName() . ') {';
                    $lines[] = '        ' . $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';';
                    $lines[] = '        if ($this !== $' . $attribute->getName() . '->get' . $attribute->getForeignKey()->getUpperName() . '()) {';
                    $lines[] = '            $' . $attribute->getName() . '->set' . $attribute->getForeignKey()->getUpperName() . '($this);';
                    $lines[] = '        }';
                    $lines[] = '    } elseif (null !== ' . $attribute->getThisName() . ') {';
                    if ($attribute->getForeignKey()->getSetter()) {
                        $lines[] = '        ' . $attribute->getThisName() . '->set' . $attribute->getForeignKey()->getUpperName() . '(null);';
                    }
                    $lines[] = '        ' . $attribute->getThisName() . ' = null;';
                    $lines[] = '    }';
                }
            } else { // ManyToOne
                if ($attribute->getInverse()) {
                    $lines[] = '    foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                    $lines[] = '        /** @var ' . $attribute->getReverseAttribute()->getEntity()->getName() . ' $' . $attribute->getSingleName() . ' */';
                    $lines[] = '        $' . $attribute->getSingleName() . '->set' . $attribute->getReverseAttribute()->getUpperName() . '($this);';
                    $lines[] = '    }';
                } else {
                    // Default normal setter
                    throw new \RuntimeException('Unknown scenario');
                }
            }
        }

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '    return $this;';
        }

        $lines[] = '}';

        return $lines;
    }

    public function getGetterCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * Get ' . $attribute->getLowerName();
        $lines[] = ' *';
        $lines[] = ' * @return ' . $attribute->getPhpAnnotationTypeBase();
        $lines[] = ' */';

        if ($attribute->getStatic()) {
            $lines[] = 'public static function ' . $attribute->getGetterName() . '()';
        } else {
            $lines[] = 'public function ' . $attribute->getGetterName() . '()';
        }

        $lines[] = '{';
        $lines[] = '    return ' . $attribute->getThisName() . ';';
        $lines[] = '}';

        return $lines;
    }

    public function getAddersCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * Add ' . $attribute->getSingleName();
        $lines[] = ' *';
        $lines[] = ' * @param ' . $attribute->getPhpSingleTypeBase() . ' $' . $attribute->getSingleName();
        if ('ManyToMany' === $attribute->getForeign()) {
            $lines[] = ' * @param bool $allowRepeatedValues';
        }

        if (!$attribute->getStatic()) {
            $lines[] = ' *';
            $lines[] = ' * @return ' . $attribute->getEntity()->getName();
        }

        $lines[] = ' */';
        $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function add' . $attribute->getSingleUpperName() . '(' . ( $attribute->getPhpSingleParameterType() !== '' ? $attribute->getPhpSingleParameterType() . ' ' : '' ) . '$' . $attribute->getSingleName() . ($attribute->getForeign() === 'ManyToMany' ? ', $allowRepeatedValues = true' : '') . ')';
        $lines[] = '{';

        if ($attribute->getForeign() === 'ManyToMany') {
            if (!$attribute->getSettingFromInverse()) {
                $lines[] = '    if ($allowRepeatedValues || !' . $attribute->getThisName() . '->contains($' . $attribute->getSingleName() . ')) {';
                $lines[] = '        ' . $attribute->getThisName() . '[] = $' . $attribute->getSingleName() . ';';
                $lines[] = '    }';
            } else {
                $lines[] = '    if ($allowRepeatedValues || !$' . $attribute->getSingleName() . '->contains' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this)) {';
                $lines[] = '        $' . $attribute->getSingleName() . '->add' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);';
                $lines[] = '    }';
            }
        } else { // ManyToOne
            if ($attribute->getEntity()->getProject()->getORM() === 'Doctrine2') { // TODO: Double check this
                $lines[] = '    $' . $attribute->getSingleName() . '->set' . $attribute->getReverseAttribute()->getUpperName() . '($this);';
                $lines[] = '    ';
            }

            $lines[] = '    ' . $attribute->getThisName() . '[] = $' . $attribute->getSingleName() . ';';
        }

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '    return $this;';
        }
        $lines[] = '}';

        $lines[] = '';

        $lines[] = '/**';
        $lines[] = ' * Add ' . $attribute->getLowerName();
        $lines[] = ' *';
        $lines[] = ' * @param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerName();
        if ('ManyToMany' === $attribute->getForeign()) {
            $lines[] = ' * @param bool $allowRepeatedValues';
        }

        if (!$attribute->getStatic()) {
            $lines[] = ' *';
            $lines[] = ' * @return ' . $attribute->getEntity()->getName();
        }

        $lines[] = ' */';
        $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function add' . $attribute->getUpperName() . '(' . $attribute->getPhpParameterTypeBase() . ' ' . '$' . $attribute->getLowerName() . ($attribute->getForeign() === 'ManyToMany' ? ', $allowRepeatedValues = true' : '') . ')';
        $lines[] = '{';

        if ('ManyToMany' === $attribute->getForeign()) {
            if (!$attribute->getSettingFromInverse()) {
                $lines[] = '    foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] = '        if ($allowRepeatedValues || !' . $attribute->getThisName() . '->contains($' . $attribute->getSingleName() . ')) {';
                $lines[] = '            ' . $attribute->getThisName() . '[] = $' . $attribute->getSingleName() . ';';
                $lines[] = '        }';
                $lines[] = '    }';
            } else {
                $lines[] = '    foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] = '        if ($allowRepeatedValues || !$' . $attribute->getSingleName() . '->contains' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this)) {';
                $lines[] = '            $' . $attribute->getSingleName() . '->add' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);';
                $lines[] = '        }';
                $lines[] = '    }';
            }
        } else { // ManyToOne
            if ($attribute->getEntity()->getProject()->getORM() === 'Doctrine2') { // TODO: Double check this
                $lines[] = '    foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] = '        $' . $attribute->getSingleName() . '->set' . $attribute->getReverseAttribute()->getUpperName() . '($this);';
                $lines[] = '    }';
            } else {
                $lines[] = '    foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] = '        ' . $attribute->getThisName() . '[] = $' . $attribute->getSingleName() . ';';
                $lines[] = '    }';
            }
        }

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '    return $this;';
        }
        $lines[] = '}';

        $lines[] = '';

        if ('ManyToOne' !== $attribute->getForeign()) {
            $lines[] = '/**';
            $lines[] = ' * Contains ' . $attribute->getSingleName();
            $lines[] = ' *';
            $lines[] = ' * @param ' . $attribute->getPhpSingleTypeBase() /*. ($attribute->getEntity()->getProject()->getBase() ? 'Base' : '')*/ . ' $' . $attribute->getSingleName();
            $lines[] = ' *';
            $lines[] = ' * @return bool';
            $lines[] = ' */';
            $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function contains' . $attribute->getSingleUpperName() . '(' . ( $attribute->getPhpSingleParameterType() !== '' ? $attribute->getPhpSingleParameterType() . ' ' : '' ) . '$' . $attribute->getSingleName() . ')';
            $lines[] = '{';

            if (!$attribute->getSettingFromInverse()) {
                $lines[] = '    return ' . $attribute->getThisName() . '->contains($' . $attribute->getSingleName() . ');';
            } else {
                $lines[] = '    return $' . $attribute->getSingleName() . '->contains' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);';
            }
            $lines[] = '}';

            $lines[] = '';

            $lines[] = '/**';
            $lines[] = ' * Contains ' . $attribute->getLowerName();
            $lines[] = ' *';
            $lines[] = ' * @param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerName();
            $lines[] = ' *';
            $lines[] = ' * @return bool';
            $lines[] = ' */';
            $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function contains' . $attribute->getUpperName() . '(' . $attribute->getPhpParameterTypeBase() . ' ' . '$' . $attribute->getLowerName() . ')';
            $lines[] = '{';

            if (!$attribute->getSettingFromInverse()) {
                $lines[] = '    foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] = '        if (!' . $attribute->getThisName() . '->contains($' . $attribute->getSingleName() . ')) {';
                $lines[] = '            return false;';
                $lines[] = '        }';
                $lines[] = '    }';
            } else {
                $lines[] = '    foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] = '        if (!$' . $attribute->getSingleName() . '->contains' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this)) {';
                $lines[] = '            return false;';
                $lines[] = '        }';
                $lines[] = '    }';
            }

            $lines[] = '';
            $lines[] = '    return true;';
            $lines[] = '}';
        }

        return $lines;
    }

    public function getRemoversCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * Remove ' . $attribute->getSingleName();
        $lines[] = ' *';
        $lines[] = ' * @param ' . $attribute->getPhpSingleTypeBase() /*. ($attribute->getEntity()->getProject()->getBase() ? 'Base' : '')*/ . ' $' . $attribute->getSingleName();

        if (!$attribute->getStatic()) {
            $lines[] = ' *';
            $lines[] = ' * @return ' . $attribute->getEntity()->getName();
        }

        $lines[] = ' */';
        $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function remove' . $attribute->getSingleUpperName() . '(' . ( $attribute->getPhpSingleParameterType() !== '' ? $attribute->getPhpSingleParameterType() . ' ' : '' ) . '$' . $attribute->getSingleName() . ')';
        $lines[] = '{';

        if ('array' === $attribute->getType() && null !== $attribute->getSubtype()) {
            $lines[] = '    foreach (' . $attribute->getThisName() . ' as $key => $' . $attribute->getSingleName() . 'Element) {';
            $lines[] = '        if ($' . $attribute->getSingleName() . 'Element === $' . $attribute->getSingleName() . ') {';
            $lines[] = '            unset(' . $attribute->getThisName() . '[$key]);';
            $lines[] = '            break;';
            $lines[] = '        }';
            $lines[] = '    }';
        } else {
            if (!$attribute->getSettingFromInverse()) {
                $lines[] = '    ' . $attribute->getThisName() . '->removeElement($' . $attribute->getSingleName() . ');';
            } else {
                $lines[] = '    $' . $attribute->getSingleName() . '->remove' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);';
            }
        }

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '    return $this;';
        }
        $lines[] = '}';

        $lines[] = '';

        $lines[] = '/**';
        $lines[] = ' * Remove ' . $attribute->getLowerName();
        $lines[] = ' *';
        $lines[] = ' * @param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerName();

        if (!$attribute->getStatic()) {
            $lines[] = ' *';
            $lines[] = ' * @return ' . $attribute->getEntity()->getName();
        }

        $lines[] = ' */';
        $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function remove' . $attribute->getUpperName() . '(' . $attribute->getPhpParameterTypeBase() . ' ' . '$' . $attribute->getLowerName() . ')';
        $lines[] = '{';

        if ('array' === $attribute->getType() && null !== $attribute->getSubtype()) {
            $lines[] = '    foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';

            if (!$attribute->getStatic()) {
                $lines[] = '        $this->remove' . $attribute->getSingleUpperName() . '($' . $attribute->getSingleName() . ');';
            } else {
                $lines[] = '        self::remove' . $attribute->getSingleUpperName() . '($' . $attribute->getSingleName() . ');';
            }

            $lines[] = '    }';
        } else {
            if (!$attribute->getSettingFromInverse()) {
                $lines[] = '    foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] = '        ' . $attribute->getThisName() . '->removeElement($' . $attribute->getSingleName() . ');';
                $lines[] = '    }';
            } else {
                $lines[] = '    foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] = '        $' . $attribute->getSingleName() . '->remove' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);';
                $lines[] = '    }';
            }
        }

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '    return $this;';
        }
        $lines[] = '}';

        return $lines;
    }

    public function getSetterGetterLines(PHPAttribute $attribute)
    {
        $lines = [];

        if ($attribute->getSetter()) {
            $lines = array_merge($lines, $this->getSetterCodeLines($attribute));
        }

        if ('Collection' === $attribute->getPhpParameterType() || 'array' === $attribute->getType()) {
            $lines = array_merge($lines, $this->getAddersCodeLines($attribute), $this->getRemoversCodeLines($attribute));
        }

        if ($attribute->getGetter()) {
            $lines = array_merge($this->getGetterCodeLines($attribute));
        }

        return $lines;
    }

    protected function entityToStringLines()
    {
        $entity = $this->getEntity();

        $lines = '';

        $lines[] = '/**';
        $lines[] = ' * ' . $entity->getName() . ' to string ' . (is_null($entity->getToString()) ? '(Default)' : '(' . $entity->getToString() . ')');
        $lines[] = ' *';
        $lines[] = ' * @return string';
        $lines[] = ' */';

        $lines[] = 'public function __toString()';
        $lines[] = '{';

        if (null === $entity->getToString()) {
            if ($entity->getProject()->getORM() !== '') {
                $lines[] = '    return \'' . $entity->getName() . '(\' . $this->' . $entity->getPrimaryAttribute()->getName() . ' . \')\';';
            } else {
                $lines[] = '    return \'' . $entity->getName() . '\';';
            }
        } else {
            $lines[] = '    return strval($this->' . $entity->getAttributeByName($entity->getToString())->getName() . ');';
        }

        $lines[] = '}';

        return $lines;
    }

    public function getArrayAccessOffsetSetCodeLines()
    {
        $noOffsetMessage = 'Tried to access the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but that offset doesn\\\'t exist.';

        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * OffsetSet implementation of the \\ArrayAccess interface';
        $lines[] = ' *';
        $lines[] = ' * @param string $offset';
        $lines[] = ' * @param mixed  $value';
        $lines[] = ' *';
        $lines[] = ' * @throws \\InvalidArgumentException if the offset doesn\'t exist on this entity or doesn\'t allow to be set';
        $lines[] = ' */';
        $lines[] = 'public function offsetSet($offset, $value)';
        $lines[] = '{';
        $lines[] = '    if (!$this->offsetExists($offset)) {' ;
        $lines[] = '        throw new \\InvalidArgumentException(\'' . $noOffsetMessage . '\');';
        $lines[] = '    }';
        $lines[] = '    ';

        $lines[] = '    switch ($offset) {';

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ($attr->getSetter()) {
                $lines[] = '        case \'' . $attr->getName() . '\':';
                $lines[] = '            $this->' . $attr->getSetterName() . '($value);';
                $lines[] = '            break;';
            }
        }

        $lines[] = '        default:';
        $lines[] = '            throw new \\InvalidArgumentException(\'Tried to set the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but is set to not allow setter access.\');';

        $lines[] = '    }';
        $lines[] = '}';

        return $lines;
    }

    public function getArrayAccessOffsetExitsCodeLines()
    {
        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * OffsetExists implementation of the \\ArrayAccess interface';
        $lines[] = ' *';
        $lines[] = ' * @param string $offset';
        $lines[] = ' *';
        $lines[] = ' * @return bool';
        $lines[] = ' */';
        $lines[] = 'public function offsetExists($offset)';
        $lines[] = '{';

        $attributes = [];
        foreach ($this->getEntity()->getAttributes() as $attr) {
            $attributes[] = '\'' . $attr->getName() . '\'';
        }

        $lines[] = '    return in_array($offset, [' . implode(', ', $attributes) . ']);';

        $lines[] = '}';

        return $lines;
    }

    public function getArrayAccessOffsetUnsetCodeLines()
    {
        $noOffsetMessage = 'Tried to access the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but that offset doesn\\\'t exist.';

        $lines = '';

        $lines[] = '/**';
        $lines[] = ' * OffsetUnset implementation of the \\ArrayAccess interface';
        $lines[] = ' *';
        $lines[] = ' * @param string $offset';
        $lines[] = ' *';
        $lines[] = ' * @throws \\InvalidArgumentException if the offset doesn\'t exist on this entity or doesn\'t allow to be set';
        $lines[] = ' */';
        $lines[] = 'public function offsetUnset($offset)';
        $lines[] = '{';
        $lines[] = '    if (!$this->offsetExists($offset)) {' ;
        $lines[] = '        throw new \\InvalidArgumentException(\'' . $noOffsetMessage . '\');';
        $lines[] = '    }';
        $lines[] = '    ';

        $lines[] = '    switch ($offset) {';

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ($attr->getSetter()) {
                $lines[] = '        case \'' . $attr->getName() . '\':';

                if ($attr->getDefaultValueAttributeInit() != '') {
                    $lines[] = '            $this->' . $attr->getSetterName() . '(' . $attr->getDefaultValueAttributeInit() . ');';
                } elseif ($attr->getDefaultValueConstructorInit() != '') {
                    $lines[] = '            $this->' . $attr->getSetterName() . '(' . $attr->getDefaultValueConstructorInit() . ');';
                } else {
                    $lines[] = '            $this->' . $attr->getName() . ' = null;';
                }

                $lines[] = '            break;';
            }
        }

        $lines[] = '        default:';
        $lines[] = '            throw new \\InvalidArgumentException(\'Tried to unset the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but is set to not allow setter access.\');';

        $lines[] = '    }';
        $lines[] = '}';

        return $lines;
    }

    public function getArrayAccessOffsetGetCodeLines()
    {
        $noOffsetMessage = 'Tried to access the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but that offset doesn\\\'t exist.';

        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * OffsetGet implementation of the \\ArrayAccess interface';
        $lines[] = ' *';
        $lines[] = ' * @param string $offset';
        $lines[] = ' *';
        $lines[] = ' * @return mixed'; // TODO: Improve this
        $lines[] = ' *';
        $lines[] = ' * @throws \\InvalidArgumentException if the offset doesn\'t exist on this entity or doesn\'t allow to be retrieved';
        $lines[] = ' */';
        $lines[] = 'public function offsetGet($offset)';
        $lines[] = '{';
        $lines[] = '    if (!$this->offsetExists($offset)) {' ;
        $lines[] = '        throw new \\InvalidArgumentException(\'' . $noOffsetMessage . '\');';
        $lines[] = '    }';
        $lines[] = '    ';

        $lines[] = '    switch ($offset) {';

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ($attr->getSetter()) {
                $lines[] = '        case \'' . $attr->getName() . '\':';
                $lines[] = '            return $this->' . $attr->getGetterName() . '();';
            }
        }

        $lines[] = '        default:';
        $lines[] = '            throw new \\InvalidArgumentException(\'Tried to get the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but is set to not allow getter access.\');';

        $lines[] = '    }';
        $lines[] = '}';

        return $lines;
    }

    public function getArrayAccessCodeLines()
    {
        $lines = '';

        $lines[] = '// <editor-fold desc="ArrayAccess">';

        array_merge($lines, $this->getArrayAccessOffsetSetCodeLines());

        $lines[] = '';

        array_merge($lines, $this->getArrayAccessOffsetExitsCodeLines());

        $lines[] = '';

        array_merge($lines, $this->getArrayAccessOffsetUnsetCodeLines());

        $lines[] = '';

        array_merge($lines, $this->getArrayAccessOffsetGetCodeLines());

        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getFilenameLine()
    {
        $line = '// ' . $this->getEntity()->getNamespace() . '\\';

        if ($this->getEntity()->getProject()->getFramework() === 'Symfony2') {
            $line .= 'Entity\\';
        }

        if ($this->getEntity()->getProject()->getBase()) {
            $line .= 'Base\\';
        }

        $line .= $this->getEntity()->getName() . '.php';

        return $line;
    }

    public function getNamespaceLine()
    {
        $line = 'namespace ' . $this->getEntity()->getNamespace();

        if ('Symfony2' === $this->getEntity()->getProject()->getFramework()) {
            $line .= '\\Entity';
        }

        if ($this->getEntity()->getProject()->getBase()) {
            $line .= '\\Base';
        }

        $line .= ';';

        return $line;
    }

    public function getRequiredEntities()
    {
        $requiredEntities = [];

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if (!is_null($attr->getForeignEntity())) {
                $foreignEntity = $attr->getForeignEntity()->getFullyQualifiedName();

                if (!in_array($foreignEntity, $requiredEntities)) {
                    $requiredEntities[] = $foreignEntity;
                    $requiredEntities[] = $attr->getForeignEntity()->getFullyQualifiedBaseName();
                }
            }
        }

        return $requiredEntities;
    }

    public function getDoctrineUseLines()
    {
        $lines = [];

        if ('Doctrine2' === $this->getEntity()->getProject()->getORM()) {
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
        }

        return $lines;
    }

    public function getUseLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->getDoctrineUseLines());

        if ($this->getEntity()->getProject()->getValidation()) {
            $lines[] = 'use Symfony\\Component\\Validator\\Constraints as Assert;';
        }

        if (count($this->getEntity()->getUniqueAttributes()) > 0) {
            $lines[] = 'use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;';
        }

        $entityUses = [];

        if ( $this->getEntity()->getProject()->getBase() && $this->getEntity()->hasSetters() ) {
            $entityUses[] = $this->getEntityUseLine($this->getEntity());
        }

        if (null !== $this->getEntity()->getParentEntity()) {
            $entityUses[] = 'use ' . $this->getEntity()->getParentEntity()->getFullyQualifiedName() . ';';
        }

        foreach ($this->getRequiredEntities() as $requiredEntity) {
            if (substr($requiredEntity, 0, strlen($this->getEntity()->getNamespace())) !== $this->getEntity()->getNamespace()) {
                $entityUses[] = 'use ' . $requiredEntity . ';';
            }
        }

        if ($this->getEntity()->getProject()->getBase()) {
            foreach ($this->getEntity()->getAttributes() as $attr) {
                if (null !== $attr->getForeignEntity()) {
                    $entityUses[] = 'use ' . $attr->getForeignEntity()->getFullyQualifiedName() . ';';
                }

                if ($attr->isEntitySubtype()) {
                    $entityUses[] = $this->getEntityUseLine($this->getEntity()->getProject()->getEntityByFullyQualifiedName($attr->getSubtype()));
                }
            }
        }

        $entityUseLines = array_unique($entityUses, SORT_STRING);

        $lines = array_merge($lines, $entityUseLines);

        $lines[] = '';

        return $lines;
    }

    public function getEntityDocumentationLines()
    {
        $lines = [];

        $lines[] = '/**';

        if (!$this->getEntity()->getProject()->getBase()) {
            $lines[] = ' * ' . $this->getEntity()->getNamespace() . '\\Entity\\' . $this->getEntity()->getName();
        } else {
            $lines[] = ' * ' . $this->getEntity()->getNamespace() . '\\Entity\\Base\\' . $this->getEntity()->getName();
        }

        if ($this->getEntity()->getProject()->getORM() === 'Doctrine2') {
            $lines[] = ' *';

            if ( $this->getEntity()->getProject()->getBase() || !is_null($this->getEntity()->getParentEntity()) ) {
                $lines[] = ' * @ORM\\MappedSuperclass';
            } else {
                $lines[] = ' * @ORM\\Entity';
            }
        }

        if ($this->getEntity()->getProject()->getValidation()) {
            $uniqueAttributes = $this->getEntity()->getUniqueAttributes();

            if (count($uniqueAttributes) > 0) {
                $lines[] = ' *';

                foreach ($uniqueAttributes as $attr) {
                    $lines[] = ' * @DoctrineAssert\\UniqueEntity(fields="' . $attr->getName() . '", message="' . $attr->getUniqueMessage() . '")';
                }
            }
        }

        $lines[] = ' */';

        return $lines;
    }

    public function getEntityDeclarationLine()
    {
        $line = '';

        if (!$this->getEntity()->getProject()->getBase()) {
            $line .= 'class ' . $this->getEntity()->getName();
        } else {
            $line .= 'abstract class ' . $this->getEntity()->getNameBase();
        }

        if (null !== $this->getEntity()->getParentEntity()) {
            $line .= ' extends ' . $this->getEntity()->getParentEntity()->getName();
        }

        return $line;
    }

    public function getImplementLines()
    {
        $lines = [];

        $implements = [];

        if ($this->getEntity()->getArrayAccess()) {
            $implements[] = '\\ArrayAccess';
        }

        if (count($implements) > 0) {
            $lines[] = 'implements ' . implode(', ', $implements);
        }

        return $lines;
    }

    /**
     * @return PHPAttribute[]
     */
    public function getRenderAttributes()
    {
        $renderAttributes = [];

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ( null === $this->getEntity()->getParentEntity() || !in_array($attr->getName(), array_keys($this->getEntity()->getParentEntity()->getAttributes())) ) {
                $renderAttributes[] = $attr;
            }
        }

        return $renderAttributes;
    }

    public function getAllAttributeLines()
    {
        $lines = [];

        $renderAttributes = $this->getRenderAttributes();

        $lines[] = '// <editor-fold desc="Attributes">';

        if (0 !== count($renderAttributes)) {
            foreach ($renderAttributes as $attr) {
                $lines = array_merge($lines, $attr->getEntityAttributeLines());
                $lines[] = '';
            }
        }

        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getConstructorLines()
    {
        $lines = [];

        if (!$this->getEntity()->getHasConstructor() && $this->getEntity()->shouldHaveConstructor()) {
            $lines[] = '';
            $lines[] = '// <editor-fold desc="Constructor">';
            $lines[] = 'public function __construct()';
            $lines[] = '{';

            foreach ($this->getEntity()->getAttributes() as $attr) {
                $attributeDefaultValueConstructor = $attr->getDefaultValueConstructorInit();

                if ('' !== $attributeDefaultValueConstructor) {
                    $lines[] = $this->indent('$this->' . $attr->getLowerName() . ' = ' . $attributeDefaultValueConstructor . ';');
                }
            }

            $lines[] = '}';
            $lines[] = '// </editor-fold>';
        }

        return $lines;
    }

    public function getAllSetterGetterLines()
    {
        $lines = [];

        $lines[] = '';
        $lines[] = '// <editor-fold desc="Setters and getters">';

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ( null === $this->getEntity()->getParentEntity() || !in_array($attr->getName(), array_keys($this->getEntity()->getParentEntity()->getAttributes())) ) {
                $lines = array_merge($lines, $this->getSetterGetterLines($attr));
            }
        }

        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getOtherMethodLines()
    {
        $lines = [];

        $lines[] = '';
        $lines[] = '// <editor-fold desc="Other methods">';

        $lines = array_merge($lines, $this->entityToStringLines());

        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getArrayAccessLines()
    {
        $lines = [];

        if ($this->getEntity()->getArrayAccess()) {
            $lines[] = '';

            $lines = array_merge($lines, $this->getArrayAccessCodeLines());
        }

        return $lines;
    }

    public function getEntityLines()
    {
        $lines = [];

        $lines[] = $this->getEntityDeclarationLine();

        $lines = array_merge($lines, $this->indentLines($this->getImplementLines()));

        $lines[] = '{';

        $this->increaseIndentation();
        $lines = array_merge($lines, $this->indentLines($this->getAllAttributeLines()));
        $lines = array_merge($lines, $this->indentLines($this->getConstructorLines()));
        $lines = array_merge($lines, $this->indentLines($this->getAllSetterGetterLines()));
        $lines = array_merge($lines, $this->indentLines($this->getOtherMethodLines()));
        $lines = array_merge($lines, $this->indentLines($this->getArrayAccessLines()));
        $this->decreaseIndentation();

        $lines[] = '}';

        return $lines;
    }

    public function render()
    {
        if (0 === count($this->getEntity()->getPrimaryAttributes())) {
            if ('' !== $this->getEntity()->getProject()->getORM()) {
                throw new \RuntimeException( 'The entity ' . $this->getEntity()->getName() . ' doesn\'t have a primary key.' );
            }
        }

        return parent::render();
    }
    // </user-additions>
    // </editor-fold>
}