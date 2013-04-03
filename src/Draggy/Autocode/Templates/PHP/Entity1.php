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
    public function getAttribute(PHPAttribute $attribute)
    {
        if ($attribute->getEntity()->getProject()->getORM() !== '') {
            if ($attribute->getType() == 'string' && is_null($attribute->getSize())) {
                throw new \RuntimeException('The attribute ' . $attribute->getName() . ' on the entity ' . $attribute->getEntity()->getName() . ' is a string but doesn\'t have size.');
            }
        }

        $ret = '';

        $ret .= '    /**' . "\n";

        if (!is_null($attribute->getDescription())) {
            $ret .= '     * ' . $attribute->getDescription() . "\n";
            $ret .= '     *' . "\n";
        }

        $ret .= '     * @var ' . $attribute->getPhpType() . ' $' . $attribute->getLowerName() . "\n";

        // ORM
        // <editor-fold desc="ORM">
        if ($attribute->getEntity()->getProject()->getORM() === 'Doctrine2') {
            $ret .= '     *' . "\n";
            $ret .= ($attribute->getPrimary() ? '     * @ORM\\Id' . "\n" : '');

            // ORM
            if (is_null($attribute->getForeign())) {
                $ret .= '     * @ORM\\Column(name="' . $attribute->getName() . '", type="' . $attribute->getType() . '"' . ($attribute->getType() == 'string' ? ', length=' . $attribute->getSize() : '') . ($attribute->getUnique() ? ', unique=true' : '') . ($attribute->getNull() ? ', nullable=true' : ($attribute->getPrimary() ? '' : ', nullable=false')) . ')' . "\n";
            } else {
                switch ($attribute->getForeign()) {
                    case 'ManyToOne':
                        if ($attribute->getOwnerSide()) {
                            $ret .= '     * @ORM\\ManyToOne(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $attribute->getEntity()->getPluralLowerName() . '", cascade={"persist"})' . "\n";
                            $ret .= '     * @ORM\\JoinColumn(name="' . $attribute->getName() . '",referencedColumnName="' . $attribute->getForeignKey()->getName() . '")' . "\n";
                        } else {
                            $ret .= '     * @ORM\\OneToMany(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $attribute->getForeignKey()->getName() . '")' . "\n";
                        }
                        break;
                    case 'OneToOne':
                        if ($attribute->getOwnerSide()) {
                            $ret .= '     * @ORM\\OneToOne(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $attribute->getEntity()->getLowerName() . '", cascade={"persist"})' . "\n";
                            $ret .= '     * @ORM\\JoinColumn(name="' . $attribute->getName() . '",referencedColumnName="' . $attribute->getForeignKey()->getName() . '")' . "\n";
                        } else {
                            $ret .= '     * @ORM\\OneToOne(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $attribute->getForeignKey()->getName() . '")' . "\n";
                        }
                        break;
                    case 'ManyToMany':
                        if ($attribute->getOwnerSide()) {
                            $ret .= '     * @ORM\\ManyToMany(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $attribute->getReverseAttribute()->getName() . '")' . "\n"; //, cascade={"all"}
                            $ret .= '     * @ORM\JoinTable(' . "\n";
                            $ret .= '     *      name="' . $attribute->getManyToManyEntityName() . '",' . "\n";
                            $ret .= '     *      joinColumns={@ORM\JoinColumn(referencedColumnName="' . $attribute->getEntity()->getPrimaryAttribute()->getName() . '")},' . "\n";
                            $ret .= '     *      inverseJoinColumns={@ORM\JoinColumn(referencedColumnName="' . $attribute->getForeignKey()->getName() . '")}' . "\n";
                            $ret .= '     *      )' . "\n";
                        } else {
                            $ret .= '     * @ORM\\ManyToMany(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $attribute->getReverseAttribute()->getName() . '")' . "\n"; //, cascade={"all"}
                        }
                        break;
                    default:
                        throw new \Exception('foreignMethod not implemented (' . $attribute->getForeign() . ')');
                }
            }
            $ret .= ($attribute->getAutoIncrement() && !$attribute->getForeignTick() ? '     * @ORM\GeneratedValue(strategy="AUTO")' . "\n" : '');
        }
        // </editor-fold>

        // Asserts
        // <editor-fold desc="Asserts">
        if (!$attribute->getInverse()) {
            if ($attribute->getEntity()->getProject()->getValidation()) {
                $asserts = '';
                if(!$attribute->getAutoIncrement()) {
                    if ($attribute->getType() !== 'array') {
                        $asserts .= '     * @Assert\\Type(type="' . $attribute->getSymfonyType() . '", message="' . $attribute->getTypeMessage() . '")' . "\n";
                    }

                    if(!$attribute->getNull() && $attribute->getType() !== 'boolean') {
                        $asserts .= '     * @Assert\\NotBlank(message="' . $attribute->getRequiredMessage() . '")' . "\n";
                    }

                    if ($attribute->getType() == 'string') {
                        $asserts .= '     * @Assert\\Length(' . "\n";

                        $assertsArray = [];
                        if (!is_null($attribute->getMinSize())) {
                            $assertsArray[] = '     *     min = "' . $attribute->getMinSize() . '"';
                        }

                        $assertsArray[] = '     *     max = "' . $attribute->getSize() . '"';

                        if (!is_null($attribute->getMinSize())) {
                            if ($attribute->getSize() !== $attribute->getMinSize()) {
                                $assertsArray[] = '     *     minMessage = "' . $attribute->getMinMessage() . '"';
                            }
                            else {
                                $assertsArray[] = '     *     exactMessage = "' . $attribute->getExactMessage() . '"';
                            }
                        }

                        if ( is_null($attribute->getMinSize()) || $attribute->getSize() !== $attribute->getMinSize()) {
                            $assertsArray[] = '     *     maxMessage = "' . $attribute->getMaxMessage() . '"';
                        }

                        $asserts .= implode(',' . "\n", $assertsArray) . "\n";
                        $asserts .= '     * )' . "\n";
                    }

                    if ($attribute->getEmail()) {
                        $asserts .= '     * @Assert\\Email()' . "\n";
                    }
                }

                if ($asserts != '')
                    $ret .= "     *\n" . $asserts;
            }
        }
        // </editor-fold>

        $ret .= '     */' . "\n";

        if ($attribute->getEntity()->getProject()->getBase()) {
            if (!$attribute->getStatic()) {
                $ret .= '    protected $' . $attribute->getLowerName();
            } else {
                $ret .= '    protected static $' . $attribute->getName();
            }

            if (is_null($attribute->getDefaultValue())) {
                $ret .= ';' . "\n";
            }
            else {
                switch($attribute->getPhpType()) {
                    case 'string':
                        if ($attribute->getDefaultValue() == 'null') {
                            $ret .= ' = null;' . "\n";
                        } elseif ($attribute->getDefaultValue() == '\'\'') {
                            $ret .= ' = \'\';' . "\n";
                        }
                        else {
                            $ret .= ' = \'' . str_replace('\'','\\\'',$attribute->getDefaultValue()) . '\';' . "\n";
                        }
                        break;
                    case 'integer':
                        $ret .= ' = ' . $attribute->getDefaultValue() . ';' . "\n";
                        break;
                    case '\\DateTime':
                        if ($attribute->getDefaultValue() == 'null') {
                            $ret .= ' = null;' . "\n";
                        } else {
                            $ret .= ';' . "\n"; // Can't initialise here
                        }
                        break;
                    case 'boolean':
                        if (in_array($attribute->getDefaultValue(), ['null', 'true', 'false'])) {
                            $ret .= ' = ' . $attribute->getDefaultValue() . ';' . "\n";
                        }
                        break;
                    default:
                        switch ($attribute->getType()) {
                            case 'array':
                                $ret .= ' = ' . $attribute->getDefaultValue() . ';' . "\n";
                                break;
                            case 'object':
                                if ($attribute->getDefaultValue() == 'null') {
                                    $ret .= ' = null;' . "\n";
                                } else {
                                    $ret .= ' = ' . $attribute->getDefaultValue() . ';' . "\n";
                                }
                                break;
                            default:
                                throw new \RuntimeException('Found a default value (\'' . $attribute->getDefaultValue() . '\') in a parameter of type \'' . $attribute->getType() . '\' / \'' . $attribute->getPhpType() . '\' that doesn\'t know how to process.');
                        }
                }

            }
        } else {
            if (is_null($attribute->getDefaultValue()))
                $ret .= '    private $' . $attribute->getLowerName() . ';' . "\n";
            else {
                switch($attribute->getPhpType()) {
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
    private function getTypeCheck(PHPAttribute $attribute, array $allowedTypes, $padding = 8, $paddingIncrement = 4, $paddingCharacter = ' ')
    {
        $phpTypes     = ['boolean', 'integer', 'float', 'string', 'array', 'object', 'null', 'NULL'];
        $phpFunctions = ['boolean' => 'is_bool', 'integer' => 'is_int', 'float' => 'is_float', 'string' => 'is_string', 'array' => 'is_array'];

        $names = [];
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

                if ($type === 'null' || $type === 'NULL') {
                    $condition[] = 'null !== $' . $attribute->getLowerName();
                } else {
                    $condition[] = '!' . $phpFunctions[$type] . '($' . $attribute->getLowerName() . ')';
                }
            }
        }

        if (count($names) > 2) {
            $types = implode(' or ', [implode(', ', array_slice($names,0,-1)), end($names)]);
        } else {
            $types = implode(' or ', $names);
        }

        return  str_repeat($paddingCharacter, $padding) . 'if (' . implode(' && ', $condition) . ') {' . "\n" .
                str_repeat($paddingCharacter, $padding + $paddingIncrement) . 'throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be ' . $types . ' (\' . gettype($' . $attribute->getLowerName() . ') . (\'object\' === gettype($' . $attribute->getLowerName() . ') ? \' \' . get_class($' . $attribute->getLowerName() . ') : \'\') . \' given).\');' . "\n" .
                str_repeat($paddingCharacter, $padding) . '}' . "\n";
    }

    public function getSetterInnerValidationCode(PHPAttribute $attribute)
    {
        $val = '';

        if ($attribute->getPhpType() === 'boolean') {
            if (!$attribute->getNull()) {
                $val .= $this->getTypeCheck($attribute, ['boolean']);
            } else {
                $val .= $this->getTypeCheck($attribute, ['boolean', 'null']);
            }
            $val .= "\n";
        } elseif ($attribute->getPhpType() === 'integer') {
            if (!$attribute->getNull()) {
                $val .= $this->getTypeCheck($attribute, ['integer']);
            } else {
                $val .= $this->getTypeCheck($attribute, ['integer', 'null']);
            }
            $val .= "\n";
        } elseif ($attribute->getPhpType() === 'float') {
            if (!$attribute->getNull()) {
                $val .= $this->getTypeCheck($attribute, ['float']);
            } else {
                $val .= $this->getTypeCheck($attribute, ['float', 'null']);
            }
            $val .= "\n";
        } elseif ($attribute->getPhpType() === 'string') {
            if ($attribute->getType() == 'string') {
                if (!$attribute->getNull()) {
                    $val .= $this->getTypeCheck($attribute, ['string']);
                    $val .= "\n";
                    //$val .= '        if (strlen($' . $attribute->getLowerName() . ') > ' . $this->size . ') {' . "\n";
                    //$val .= '            trigger_error(\'The length of the string \' . $' . $attribute->getLowerName() . ' . \' is \' . strlen($' . $attribute->getLowerName() . ') . \' which is longer than the maximum allowed (' . $this->size . '). Some information will not be saved.\', E_USER_NOTICE);' . "\n";
                    //$val .= '        }' . "\n";
                    if (!is_null($attribute->getMinSize())) {
                        $val .= '        if (strlen($' . $attribute->getLowerName() . ') < ' . $attribute->getMinSize() . ') {' . "\n";
                        $val .= '            throw new \InvalidArgumentException(\'On the attribute ' . $attribute->getLowerName() . ', the length of the string \' . $' . $attribute->getLowerName() . ' . \' is \' . strlen($' . $attribute->getLowerName() . ') . \' which is shorter than the minimum allowed (' . $attribute->getMinSize() . ').\');' . "\n";
                        $val .= '        }' . "\n";
                        $val .= "\n";
                    }
                } else {
                    $val .= $this->getTypeCheck($attribute, ['string', 'null']);
                    $val .= "\n";
                    //$val .= '        if (strlen($' . $attribute->getLowerName() . ') > ' . $this->size . ' ) {' . "\n";
                    //$val .= '            trigger_error(\'The length of the string \' . $' . $attribute->getLowerName() . ' . \' is \' . strlen($' . $attribute->getLowerName() . ') . \' which is longer than the maximum allowed (' . $this->size . '). Some information will not be saved.\', E_USER_NOTICE);' . "\n";
                    //$val .= '        }' . "\n";
                    if (!is_null($attribute->getMinSize())) {
                        $val .= '        if (strlen($' . $attribute->getLowerName() . ') < ' . $attribute->getMinSize() . ') {' . "\n";
                        $val .= '            throw new \InvalidArgumentException(\'On the attribute ' . $attribute->getLowerName() . ', the length of the string \' . $' . $attribute->getLowerName() . ' . \' is \' . strlen($' . $attribute->getLowerName() . ') . \' which is shorter than the minimum allowed (' . $attribute->getMinSize() . ').\');' . "\n";
                        $val .= '        }' . "\n";
                        $val .= "\n";
                    }
                }
            } elseif ($attribute->getType() === 'text') {
                if (!$attribute->getNull()) {
                    $val .= $this->getTypeCheck($attribute, ['string']);
                } else {
                    $val .= $this->getTypeCheck($attribute, ['string', 'null']);
                }
                $val .= "\n";
            }
        } elseif ($attribute->getType() === 'object') {
            if (null === $attribute->getSubtype()) {
                throw new \InvalidArgumentException('Attribute ' . $attribute->getName() . ' on the entity ' . $attribute->getEntity()->getName() . ' is marked as an object but doesn\'t have a subtype');
            }

            // The not null case doesn't make sense because it will go on the parameter line
            if ($attribute->getNull()) {
                $val .= $this->getTypeCheck($attribute, [['object'=>$attribute->getEntitySubtype()->getName()], 'null']);
                $val .= "\n";
            }
        }

        return $val;
    }

    public function getSetterCode(PHPAttribute $attribute)
    {
        $validation = $this->getSetterInnerValidationCode($attribute);

        $settingFromInverse = $attribute->getSettingFromInverse();

        $ret = '';

        $ret .= '    /**' . "\n";
        $ret .= '     * Set ' . $attribute->getLowerName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerName() . "\n";

        if (!$attribute->getStatic()) {
            $ret .= '     *' . "\n";
            $ret .= '     * @return ' . $attribute->getEntity()->getName() . "\n";
        }

        if ($validation != '') {
            $ret .= '     *' . "\n";
            $ret .= '     * @throws \InvalidArgumentException' . "\n";
        }

        $ret .= '     */' . "\n";

        if ($attribute->getStatic()) {
            $ret .= '    public static function ' . $attribute->getSetterName() . '(';
        } else {
            $ret .= '    public function ' . $attribute->getSetterName() . '(';
        }

        if (null === $attribute->getPhpParameterType()) {
            $ret .= '$' . $attribute->getLowerName() . ')' . "\n";
        } else {
            $ret .= $attribute->getPhpParameterType() . ' $' . $attribute->getLowerName() . ')' . "\n";
        }

        $ret .= '    {' . "\n";

        $ret .= $validation;

        if (!$settingFromInverse) {
            if ($attribute->getForeign() === 'OneToOne') {
                if (!$attribute->getNull()) {
                    $ret .= '        ' . $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';' . "\n";
                    $ret .= '        if ($this !== $' . $attribute->getName() . '->get' . $this->getEntity()->getName() . '()) {' . "\n";
                    $ret .= '            $' . $attribute->getName() . '->set' . $this->getEntity()->getName() . '($this);' . "\n";
                    $ret .= '        }' . "\n";
                } else {
                    $ret .= '        if (null !== $' . $attribute->getLowerName() . ') {' . "\n";
                    $ret .= '            ' . $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';' . "\n";
                    $ret .= '            if ($this !== $' . $attribute->getName() . '->get' . $this->getEntity()->getName() . '()) {' . "\n";
                    $ret .= '                $' . $attribute->getName() . '->set' . $this->getEntity()->getName() . '($this);' . "\n";
                    $ret .= '            }' . "\n";
                    $ret .= '        } elseif (null !== ' . $attribute->getThisName() . ') {' . "\n";
                    if ($attribute->getForeignKey()->getSetter()) {
                        $ret .= '            ' . $attribute->getThisName() . '->set' . $attribute->getForeignKey()->getUpperName() . '(null);' . "\n";
                    }
                    $ret .= '            ' . $attribute->getThisName() . ' = null;' . "\n";
                    $ret .= '        }' . "\n";
                }
            } elseif ($attribute->getForeign() === 'ManyToOne') {
                // TODO: Does it need to do the inverse???
                //$ret .= '        $' . $attribute->getName() . '->add' . $attribute->getEntity()->getName() . '($this);' . "\n";
                $ret .= '        ' . $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';' . "\n";
            } else {
                $ret .= '        ' . $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';' . "\n";
            }
        } else {
            if ($attribute->getForeign() === 'ManyToMany') {
                $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
                $ret .= '            /** @var ' . $attribute->getReverseAttribute()->getEntity()->getName() . ' $' . $attribute->getSingleName() . ' */' . "\n";
                $ret .= '            $' . $attribute->getSingleName() . '->set' . $attribute->getReverseAttribute()->getUpperName() . '(new ArrayCollection([$this]));' . "\n";
                $ret .= '        }' . "\n";
            } elseif ($attribute->getForeign() === 'OneToOne') {
                if (!$attribute->getNull()) {
                    $ret .= '        ' . $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';' . "\n";
                    $ret .= '        if ($this !== $' . $attribute->getName() . '->get' . $attribute->getForeignKey()->getUpperName() . '()) {' . "\n";
                    $ret .= '            $' . $attribute->getName() . '->set' . $attribute->getForeignKey()->getUpperName() . '($this);' . "\n";
                    $ret .= '        }' . "\n";
                } else {
                    $ret .= '        if (null !== $' . $attribute->getLowerName() . ') {' . "\n";
                    $ret .= '            ' . $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';' . "\n";
                    $ret .= '            if ($this !== $' . $attribute->getName() . '->get' . $attribute->getForeignKey()->getUpperName() . '()) {' . "\n";
                    $ret .= '                $' . $attribute->getName() . '->set' . $attribute->getForeignKey()->getUpperName() . '($this);' . "\n";
                    $ret .= '            }' . "\n";
                    $ret .= '        } elseif (null !== ' . $attribute->getThisName() . ') {' . "\n";
                    if ($attribute->getForeignKey()->getSetter()) {
                        $ret .= '            ' . $attribute->getThisName() . '->set' . $attribute->getForeignKey()->getUpperName() . '(null);' . "\n";
                    }
                    $ret .= '            ' . $attribute->getThisName() . ' = null;' . "\n";
                    $ret .= '        }' . "\n";
                }
            } else { // ManyToOne
                if ($attribute->getInverse()) {
                    $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
                    $ret .= '            /** @var ' . $attribute->getReverseAttribute()->getEntity()->getName() . ' $' . $attribute->getSingleName() . ' */' . "\n";
                    $ret .= '            $' . $attribute->getSingleName() . '->set' . $attribute->getReverseAttribute()->getUpperName() . '($this);' . "\n";
                    $ret .= '        }' . "\n";
                } else {
                    // Default normal setter
                    throw new \RuntimeException('Unknown scenario');
                    //$ret .= '        ' . $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';' . "\n";
                }
            }
        }

        if (!$attribute->getStatic()) {
            $ret .= "\n";
            $ret .= '        return $this;' . "\n";
        }
        $ret .= '    }' . "\n";

        return $ret;
    }

    public function getGetterCode(PHPAttribute $attribute)
    {
        $ret = '';

        $ret .= '    /**' . "\n";
        $ret .= '     * Get ' . $attribute->getLowerName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @return ' . $attribute->getPhpAnnotationTypeBase() . "\n";
        $ret .= '     */' . "\n";
        if ($attribute->getStatic()) {
            $ret .= '    public static function ' . $attribute->getGetterName() . '()' . "\n";
        } else {
            $ret .= '    public function ' . $attribute->getGetterName() . '()' . "\n";
        }
        $ret .= '    {' . "\n";
        $ret .= '        return ' . $attribute->getThisName() . ';' . "\n";
        $ret .= '    }' . "\n";

        return $ret;
    }

    public function getAddersCode(PHPAttribute $attribute)
    {
        $ret = '';

        $ret .= '    /**' . "\n";
        $ret .= '     * Add ' . $attribute->getSingleName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @param ' . $attribute->getPhpSingleTypeBase() /*. ($attribute->getEntity()->getProject()->getBase() ? 'Base' : '')*/ . ' $' . $attribute->getSingleName() . "\n";
        if ($attribute->getForeign() === 'ManyToMany') {
            $ret .= '     * @param bool $allowRepeatedValues' . "\n";
        }

        if (!$attribute->getStatic()) {
            $ret .= '     *' . "\n";
            $ret .= '     * @return ' . $attribute->getEntity()->getName() . "\n";
        }

        $ret .= '     */' . "\n";
        $ret .= '    public ' . ($attribute->getStatic() ? 'static ' : '') . 'function add' . $attribute->getSingleUpperName() . '(' . ( $attribute->getPhpSingleParameterType() !== '' ? $attribute->getPhpSingleParameterType() . ' ' : '' ) . '$' . $attribute->getSingleName() . ($attribute->getForeign() === 'ManyToMany' ? ', $allowRepeatedValues = true' : '') . ')' . "\n";
        $ret .= '    {' . "\n";

        if ($attribute->getForeign() === 'ManyToMany') {
            if (!$attribute->getSettingFromInverse()) {
                $ret .= '        if ($allowRepeatedValues || !' . $attribute->getThisName() . '->contains($' . $attribute->getSingleName() . ')) {' . "\n";
                $ret .= '            ' . $attribute->getThisName() . '[] = $' . $attribute->getSingleName() . ';' . "\n";
                $ret .= '        }' . "\n";
            } else {
                $ret .= '        if ($allowRepeatedValues || !$' . $attribute->getSingleName() . '->contains' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this)) {' . "\n";
                $ret .= '            $' . $attribute->getSingleName() . '->add' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);' . "\n";
                $ret .= '        }' . "\n";
            }
        } else { // ManyToOne
            if ($attribute->getEntity()->getProject()->getORM() === 'Doctrine2') { // TODO: Double check this
                $ret .= '        $' . $attribute->getSingleName() . '->set' . $attribute->getReverseAttribute()->getUpperName() . '($this);' . "\n";
                $ret .= '        ' . "\n";
                $ret .= '        ' . $attribute->getThisName() . '[] = $' . $attribute->getSingleName() . ';' . "\n";
            }
        }

        if (!$attribute->getStatic()) {
            $ret .= "\n";
            $ret .= '        return $this;' . "\n";
        }
        $ret .= '    }' . "\n";

        $ret .= "\n";

        $ret .= '    /**' . "\n";
        $ret .= '     * Add ' . $attribute->getLowerName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerName() . "\n";
        if ($attribute->getForeign() === 'ManyToMany') {
            $ret .= '     * @param bool $allowRepeatedValues' . "\n";
        }

        if (!$attribute->getStatic()) {
            $ret .= '     *' . "\n";
            $ret .= '     * @return ' . $attribute->getEntity()->getName() . "\n";
        }

        $ret .= '     */' . "\n";
        $ret .= '    public ' . ($attribute->getStatic() ? 'static ' : '') . 'function add' . $attribute->getUpperName() . '(' . $attribute->getPhpParameterTypeBase() . ' ' . '$' . $attribute->getLowerName() . ($attribute->getForeign() === 'ManyToMany' ? ', $allowRepeatedValues = true' : '') . ')' . "\n";
        $ret .= '    {' . "\n";

        if ($attribute->getForeign() === 'ManyToMany') {
            if (!$attribute->getSettingFromInverse()) {
                $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
                $ret .= '            if ($allowRepeatedValues || !' . $attribute->getThisName() . '->contains($' . $attribute->getSingleName() . ')) {' . "\n";
                $ret .= '                ' . $attribute->getThisName() . '[] = $' . $attribute->getSingleName() . ';' . "\n";
                $ret .= '            }' . "\n";
                $ret .= '        }' . "\n";
            } else {
                $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
                $ret .= '            if ($allowRepeatedValues || !$' . $attribute->getSingleName() . '->contains' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this)) {' . "\n";
                $ret .= '                $' . $attribute->getSingleName() . '->add' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);' . "\n";
                $ret .= '            }' . "\n";
                $ret .= '        }' . "\n";
            }
        } else { // ManyToOne
            if ($attribute->getEntity()->getProject()->getORM() === 'Doctrine2') { // TODO: Double check this
                $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
                $ret .= '            $' . $attribute->getSingleName() . '->set' . $attribute->getReverseAttribute()->getUpperName() . '($this);' . "\n";
                $ret .= '        }' . "\n";
            }
        }

        if (!$attribute->getStatic()) {
            $ret .= "\n";
            $ret .= '        return $this;' . "\n";
        }
        $ret .= '    }' . "\n";

        $ret .= "\n";

        if ($attribute->getForeign() !== 'ManyToOne') {
            $ret .= '    /**' . "\n";
            $ret .= '     * Contains ' . $attribute->getSingleName() . "\n";
            $ret .= '     *' . "\n";
            $ret .= '     * @param ' . $attribute->getPhpSingleTypeBase() /*. ($attribute->getEntity()->getProject()->getBase() ? 'Base' : '')*/ . ' $' . $attribute->getSingleName() . "\n";
            $ret .= '     *' . "\n";
            $ret .= '     * @return bool' . "\n";
            $ret .= '     */' . "\n";
            $ret .= '    public ' . ($attribute->getStatic() ? 'static ' : '') . 'function contains' . $attribute->getSingleUpperName() . '(' . ( $attribute->getPhpSingleParameterType() !== '' ? $attribute->getPhpSingleParameterType() . ' ' : '' ) . '$' . $attribute->getSingleName() . ')' . "\n";
            $ret .= '    {' . "\n";

            if (!$attribute->getSettingFromInverse()) {
                $ret .= '        return ' . $attribute->getThisName() . '->contains($' . $attribute->getSingleName() . ');' . "\n";
            } else {
                $ret .= '        return $' . $attribute->getSingleName() . '->contains' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);' . "\n";
            }
            $ret .= '    }' . "\n";

            $ret .= "\n";

            $ret .= '    /**' . "\n";
            $ret .= '     * Contains ' . $attribute->getLowerName() . "\n";
            $ret .= '     *' . "\n";
            $ret .= '     * @param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerName() . "\n";
            $ret .= '     *' . "\n";
            $ret .= '     * @return bool' . "\n";
            $ret .= '     */' . "\n";
            $ret .= '    public ' . ($attribute->getStatic() ? 'static ' : '') . 'function contains' . $attribute->getUpperName() . '(' . $attribute->getPhpParameterTypeBase() . ' ' . '$' . $attribute->getLowerName() . ')' . "\n";
            $ret .= '    {' . "\n";

            if (!$attribute->getSettingFromInverse()) {
                $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
                $ret .= '            if (!' . $attribute->getThisName() . '->contains($' . $attribute->getSingleName() . ')) {' . "\n";
                $ret .= '                return false;' . "\n";
                $ret .= '            }' . "\n";
                $ret .= '        }' . "\n";
            } else {
                $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
                $ret .= '            if (!$' . $attribute->getSingleName() . '->contains' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this)) {' . "\n";
                $ret .= '                return false;' . "\n";
                $ret .= '            }' . "\n";
                $ret .= '        }' . "\n";
            }

            $ret .= "\n";
            $ret .= '        return true;' . "\n";
            $ret .= '    }' . "\n";
        }

        return $ret;
    }

    public function getRemoversCode(PHPAttribute $attribute)
    {
        $ret = '';

        $ret .= '    /**' . "\n";
        $ret .= '     * Remove ' . $attribute->getSingleName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @param ' . $attribute->getPhpSingleTypeBase() /*. ($attribute->getEntity()->getProject()->getBase() ? 'Base' : '')*/ . ' $' . $attribute->getSingleName() . "\n";

        if (!$attribute->getStatic()) {
            $ret .= '     *' . "\n";
            $ret .= '     * @return ' . $attribute->getEntity()->getName() . "\n";
        }

        $ret .= '     */' . "\n";
        $ret .= '    public ' . ($attribute->getStatic() ? 'static ' : '') . 'function remove' . $attribute->getSingleUpperName() . '(' . ( $attribute->getPhpSingleParameterType() !== '' ? $attribute->getPhpSingleParameterType() . ' ' : '' ) . '$' . $attribute->getSingleName() . ')' . "\n";
        $ret .= '    {' . "\n";

        if ($attribute->getType() === 'array' && !is_null($attribute->getSubtype())) {
            $ret .= '        foreach (' . $attribute->getThisName() . ' as $key => $' . $attribute->getSingleName() . 'Element) {' . "\n";
            $ret .= '            if ($' . $attribute->getSingleName() . 'Element === $' . $attribute->getSingleName() . ') {' . "\n";
            $ret .= '                unset(' . $attribute->getThisName() . '[$key]);' . "\n";
            $ret .= '                break;' . "\n";
            $ret .= '            }' . "\n";
            $ret .= '        }' . "\n";
        } else {
            if (!$attribute->getSettingFromInverse()) {
                $ret .= '        ' . $attribute->getThisName() . '->removeElement($' . $attribute->getSingleName() . ');' . "\n";
            } else {
                $ret .= '        $' . $attribute->getSingleName() . '->remove' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);' . "\n";
            }
        }

        if (!$attribute->getStatic()) {
            $ret .= "\n";
            $ret .= '        return $this;' . "\n";
        }
        $ret .= '    }' . "\n";

        $ret .= "\n";

        $ret .= '    /**' . "\n";
        $ret .= '     * Remove ' . $attribute->getLowerName() . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerName() . "\n";

        if (!$attribute->getStatic()) {
            $ret .= '     *' . "\n";
            $ret .= '     * @return ' . $attribute->getEntity()->getName() . "\n";
        }

        $ret .= '     */' . "\n";
        $ret .= '    public ' . ($attribute->getStatic() ? 'static ' : '') . 'function remove' . $attribute->getUpperName() . '(' . $attribute->getPhpParameterTypeBase() . ' ' . '$' . $attribute->getLowerName() . ')' . "\n";
        $ret .= '    {' . "\n";

        if ($attribute->getType() === 'array' && !is_null($attribute->getSubtype())) {
            $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";

            if (!$attribute->getStatic()) {
                $ret .= '            $this->remove' . $attribute->getSingleUpperName() . '($' . $attribute->getSingleName() . ');' . "\n";
            } else {
                $ret .= '            self::remove' . $attribute->getSingleUpperName() . '($' . $attribute->getSingleName() . ');' . "\n";
            }

            $ret .= '        }' . "\n";
        } else {
            if (!$attribute->getSettingFromInverse()) {
                $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
                $ret .= '            ' . $attribute->getThisName() . '->removeElement($' . $attribute->getSingleName() . ');' . "\n";
                $ret .= '        }' . "\n";
            } else {
                $ret .= '        foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {' . "\n";
                $ret .= '            $' . $attribute->getSingleName() . '->remove' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);' . "\n";
                $ret .= '        }' . "\n";
            }
        }

        if (!$attribute->getStatic()) {
            $ret .= "\n";
            $ret .= '        return $this;' . "\n";
        }
        $ret .= '    }' . "\n";

        return $ret;
    }

    public function getSetterGetter(PHPAttribute $attribute)
    {
        $retArray = [];

        if ($attribute->getSetter()) {
            $retArray[] = $this->getSetterCode($attribute);
        }

        if ($attribute->getPhpParameterType() === 'Collection' || $attribute->getType() === 'array') {
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

        $ret .= '    /**' . "\n";
        $ret .= '     * ' . $entity->getName() . ' to string ' . (is_null($entity->getToString()) ? '(Default)' : '(' . $entity->getToString() . ')') . "\n";
        $ret .= '     *' . "\n";
        $ret .= '     * @return string' . "\n";
        $ret .= '     */' . "\n";

        $ret .= '    public function __toString()' . "\n";
        $ret .= '    {' . "\n";

        if (is_null($entity->getToString())) {
            if ($entity->getProject()->getORM() !== '') {
                $ret .= '        return \'' . $entity->getName() . '(\' . $this->' . $entity->getPrimaryAttribute()->getName() . ' . \')\';' . "\n";
            } else {
                $ret .= '        return \'' . $entity->getName() . '\';' . "\n";
            }
        } else {
            $ret .= '        return strval($this->' . $entity->getAttributeByName($entity->getToString())->getName() . ');' . "\n";
        }

        $ret .= '    }' . "\n";

        return $ret;
    }

    public function render()
    {
        $entity = $this->getEntity();

        // Check that it has a primary key
        if (count($entity->getPrimaryAttributes()) == 0) {
            if ($entity->getProject()->getORM() !== '') {
                throw new \RuntimeException( 'The entity ' . $entity->getName() . ' doesn\'t have a primary key.' );
            }
        }

        $attributes       = [];
        $settersGetters   = [];
        $requiredEntities = [];

        $file = '';
        $file .= '<?php' . "\n";

        foreach ($entity->getAttributes() as $attr) {
            //$file .= '// ' . $attr->getName() . "\n";
            if ( is_null($entity->getParentEntity()) || !in_array($attr->getName(),array_keys($entity->getParentEntity()->getAttributes())) ) {
                $attributes[]     = $this->getAttribute($attr);
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

        $file .= '// ' . $entity->getNamespace() . '\\';

        if ($entity->getProject()->getFramework() === 'Symfony2') {
            $file .= 'Entity\\';
        }

        if ($entity->getProject()->getBase()) {
            $file .= 'Base\\';
        }

        $file .= $entity->getName() . '.php' . "\n";

        $file .= $this->getDescriptionCode();

        $file .= $this->getBlurb();

        $file .= 'namespace ' . $entity->getNamespace();

        if ($entity->getProject()->getFramework() === 'Symfony2') {
            $file .= '\\Entity';
        }

        if ($entity->getProject()->getBase()) {
            $file .= '\\Base';
        }

        $file .= ';' . "\n";

        $file .= "\n";

        if ($entity->getProject()->getORM() === 'Doctrine2') {
            $file .= 'use Doctrine\\ORM\\Mapping as ORM;' . "\n";

            $useArrayCollection = false;
            foreach ($entity->getAttributes() as $attr) {
                if (!is_null($attr->getForeign())) {
                    $useArrayCollection = true;
                    break;
                }
            }

            if ($useArrayCollection) {
                $file .= 'use Doctrine\\Common\\Collections\\Collection;' . "\n";
                $file .= 'use Doctrine\\Common\\Collections\\ArrayCollection;' . "\n"; // Is needed when doing new ArrayCollection();
            }
        }

        if ($entity->getProject()->getValidation()) {
            $file .= 'use Symfony\\Component\\Validator\\Constraints as Assert;' . "\n";
        }

        /** @var Attribute[] $uniqueAttributes */
        $uniqueAttributes = [];
        foreach ($entity->getAttributes() as $attr) {
            if ($attr->getUnique()) {
                $uniqueAttributes[] = $attr;
            }
        }

        if ($entity->getProject()->getValidation() && count($uniqueAttributes) > 0) {
            $file .= 'use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;' . "\n";
        }

        $uses = [];

        if ( $entity->getProject()->getBase() && $entity->hasSetters() ) {
            $uses[] = $this->getUseLine($entity);
        }

        if (!is_null($entity->getParentEntity())) {
            $uses[] = 'use ' . $entity->getParentEntity()->getFullyQualifiedName() . ';' . "\n";
        }

        if (count($requiredEntities) > 0) {
            foreach ($requiredEntities as $requiredEntity) {
                if (substr($requiredEntity, 0, strlen($entity->getNamespace())) !== $entity->getNamespace()) {
                    $uses[] = 'use ' . $requiredEntity . ';' . "\n";
                }
            }
        }

        if ($entity->getProject()->getBase()) {
            foreach ($entity->getAttributes() as $attr) {
                if (!is_null($attr->getForeignEntity())) {
                    $uses[] = 'use ' . $attr->getForeignEntity()->getFullyQualifiedName() . ';' . "\n";
                }

                if ($attr->isEntitySubtype()) {
                    $uses[] = $this->getUseLine($entity->getProject()->getEntityByFullyQualifiedName($attr->getSubtype()));
                }
            }
        }

        $file .= implode('',array_unique($uses,SORT_STRING));

        $file .= "\n";
        $file .= '/**' . "\n";

        if (!$entity->getProject()->getBase()) {
            $file .= ' * ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . "\n";
        } else {
            $file .= ' * ' . $entity->getNamespace() . '\\Entity\\Base\\' . $entity->getName() . "\n";
        }

        if ($entity->getProject()->getORM() === 'Doctrine2') {
            $file .= ' *' . "\n";

            if ( $entity->getProject()->getBase() || !is_null($entity->getParentEntity()) ) {
                $file .= ' * @ORM\\MappedSuperclass' . "\n";
            } else {
                $file .= ' * @ORM\\Entity' . "\n";
            }
        }

        if ($entity->getProject()->getValidation()) {
            if (count($uniqueAttributes) > 0) {
                $file .= ' *' . "\n";

                foreach ($uniqueAttributes as $attr) {
                    $file .= ' * @DoctrineAssert\\UniqueEntity(fields="' . $attr->getName() . '", message="' . $attr->getUniqueMessage() . '")' . "\n";
                }
            }
        }

        $file .= ' */' . "\n";

        if (!$entity->getProject()->getBase()) {
            $file .= 'class ' . $entity->getName() . (!is_null($entity->getParentEntity()) ? ' extends ' . $entity->getParentEntity()->getName() : '') . "\n";
        } else {
            $file .= 'abstract class ' . $entity->getNameBase() . (!is_null($entity->getParentEntity()) ? ' extends ' . $entity->getParentEntity()->getName() : '') . "\n";
        }

        $file .= '{' . "\n";
        $file .= '    // <editor-fold desc="Attributes">' . "\n";

        if (count($attributes) != 0) {
            $file .= implode("\n", $attributes) . "\n";
        }

        $file .= '    // </editor-fold>' . "\n";

        if (!$entity->getHasConstructor() && $entity->shouldHaveConstructor()) {
            $file .= "\n";
            $file .= '    // <editor-fold desc="Constructor">' . "\n";
            $file .= '    public function __construct()' . "\n";
            $file .= '    {' . "\n";

            $file .= $this->getConstructorDefaultValuesPart();

            $file .= '    }' . "\n";
            $file .= '    // </editor-fold>' . "\n";
        }

        $file .= "\n";
        $file .= '    // <editor-fold desc="Setters and getters">' . "\n";
        $file .= implode("\n", $settersGetters);

        if (count($settersGetters) > 0) {
            $file .= "\n";
        }

        $file .= '    // </editor-fold>' . "\n";
        $file .= "\n";
        $file .= '    // <editor-fold desc="Other methods">' . "\n";
        $file .= $this->entityToString();

// isNotDefault
//        $file .= "\n";
//        $file .= '//    public function isNotDefault() {' . "\n";
//        $file .= '//    return ' . "\n";
//        foreach ($entity->getAttributes() as $attr) {
//            $file .= '//    ' . "\n";
//            $file .= '//    ' . "\n";
//        }
//        $file .= '//    }' . "\n";

        $file .= '    // </editor-fold>' . "\n";
        $file .= '}';

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}