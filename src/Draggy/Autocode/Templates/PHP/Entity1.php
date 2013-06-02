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
     *
     * @return string
     *
     * @throws \RuntimeException if the allowedTypes array is not well formed
     */
    protected function getTypeCheckLines(PHPAttribute $attribute, array $allowedTypes)
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

        $lines[] = 'if (' . implode(' && ', $condition) . ') {';
        $lines[] =     'throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be ' . $types . ' (\' . gettype($' . $attribute->getLowerName() . ') . (\'object\' === gettype($' . $attribute->getLowerName() . ') ? \' \' . get_class($' . $attribute->getLowerName() . ') : \'\') . \' given).\');';
        $lines[] = '}';

        return $lines;
    }

    // <editor-fold desc="Attributes">
    public function getAttributeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        if (null !== $attribute->getDescription()) {
            $lines[] = $attribute->getDescription();
            $lines[] = '';
        }

        $lines[] = '@var ' . $attribute->getPhpType() . ' $' . $attribute->getLowerName();

        // ORM
        // <editor-fold desc="ORM">
        if ('Doctrine2' === $attribute->getEntity()->getProject()->getORM()) {
            $lines[] = '';

            if ($attribute->getPrimary()) {
                $lines[] = '@ORM\\Id';
            }

            // ORM
            if (null === $attribute->getForeign()) {
                $lines[] = '@ORM\\Column(name="' . $attribute->getName() . '", type="' . $attribute->getType() . '"' . ('string' === $attribute->getType() ? ', length=' . $attribute->getSize() : '') . ($attribute->getUnique() ? ', unique=true' : '') . ($attribute->getNull() ? ', nullable=true' : ($attribute->getPrimary() ? '' : ', nullable=false')) . ')';
            } else {
                switch ($attribute->getForeign()) {
                    case 'ManyToOne':
                        if ($attribute->getOwnerSide()) {
                            $lines[] = '@ORM\\ManyToOne(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $attribute->getEntity()->getPluralLowerName() . '", cascade={"persist", "remove"})';
                            $lines[] = '@ORM\\JoinColumn(name="' . $attribute->getName() . '", referencedColumnName="' . $attribute->getForeignKey()->getName() . '")';
                        } else {
                            $lines[] = '@ORM\\OneToMany(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $attribute->getForeignKey()->getName() . '")';
                        }
                        break;
                    case 'OneToOne':
                        if ($attribute->getOwnerSide()) {
                            $lines[] = '@ORM\\OneToOne(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $attribute->getEntity()->getLowerName() . '", cascade={"persist", "remove"})';
                            $lines[] = '@ORM\\JoinColumn(name="' . $attribute->getName() . '", referencedColumnName="' . $attribute->getForeignKey()->getName() . '")';
                        } else {
                            $lines[] = '@ORM\\OneToOne(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $attribute->getForeignKey()->getName() . '")';
                        }
                        break;
                    case 'ManyToMany':
                        if ($attribute->getOwnerSide()) {
                            $lines[] = '@ORM\\ManyToMany(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $attribute->getReverseAttribute()->getName() . '")';
                            $lines[] = '@ORM\JoinTable(';
                            $lines[] =     'name="' . $attribute->getManyToManyEntityName() . '",';
                            $lines[] =     'joinColumns={@ORM\JoinColumn(referencedColumnName="' . $attribute->getEntity()->getPrimaryAttribute()->getName() . '")},';
                            $lines[] =     'inverseJoinColumns={@ORM\JoinColumn(referencedColumnName="' . $attribute->getForeignKey()->getName() . '")}';
                            $lines[] = ')';
                        } else {
                            $lines[] = '@ORM\\ManyToMany(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $attribute->getReverseAttribute()->getName() . '")';
                        }
                        break;
                    default:
                        throw new \Exception('foreignMethod not implemented (' . $attribute->getForeign() . ')');
                }
            }

            if ($attribute->getAutoIncrement() && !$attribute->getForeignTick()) {
                $lines[] = '@ORM\GeneratedValue(strategy="AUTO")';
            }
        }
        // </editor-fold>

        // Asserts
        // <editor-fold desc="Asserts">
        if (!$attribute->getInverse() && $attribute->getEntity()->getProject()->getValidation()) {
            $assertLines = [];

            if(!$attribute->getAutoIncrement()) {
                if ('array' !== $attribute->getType()) {
                    $assertLines[] = '@Assert\\Type(type="' . $attribute->getSymfonyType() . '", message="' . $attribute->getTypeMessage() . '")';
                }

                if(!$attribute->getNull() && 'boolean' !== $attribute->getType()) {
                    $assertLines[] = '@Assert\\NotBlank(message="' . $attribute->getRequiredMessage() . '")';
                }

                if ('string' === $attribute->getType()) {
                    $assertLines[] = '@Assert\\Length(';

                    $assertsArray = [];

                    if (null !== $attribute->getMinSize()) {
                        $assertsArray[] =     'min = "' . $attribute->getMinSize() . '"';
                    }

                    $assertsArray[] =     'max = "' . $attribute->getSize() . '"';

                    if (null !== $attribute->getMinSize()) {
                        if ($attribute->getSize() !== $attribute->getMinSize()) {
                            $assertsArray[] =     'minMessage = "' . $attribute->getMinMessage() . '"';
                        } else {
                            $assertsArray[] =     'exactMessage = "' . $attribute->getExactMessage() . '"';
                        }
                    }

                    if ( null === $attribute->getMinSize() || $attribute->getSize() !== $attribute->getMinSize()) {
                        $assertsArray[] =     'maxMessage = "' . $attribute->getMaxMessage() . '"';
                    }

                    for ($i = 0; $i < count($assertsArray) - 1; $i++) {
                        $assertsArray[$i] .= ',';
                    }

                    $assertLines = array_merge($assertLines, $assertsArray);

                    $assertLines[] = ')';
                }

                if ($attribute->getEmail()) {
                    $assertLines[] = '@Assert\\Email()';
                }
            }

            if (0 !== count($assertLines)) {
                $lines[] = '';

                $lines = array_merge($lines, $assertLines);
            }
        }
        // </editor-fold>

        return $lines;
    }

    public function getAttributeLines(PHPAttribute $attribute)
    {
        if ('' !== $attribute->getEntity()->getProject()->getORM()) {
            if ('string' === $attribute->getType() && null === $attribute->getSize()) {
                throw new \RuntimeException('The attribute ' . $attribute->getName() . ' on the entity ' . $attribute->getEntity()->getName() . ' is a string but doesn\'t have size.');
            }
        }

        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getAttributeDocumentationLines($attribute)));

        if ($attribute->getEntity()->getProject()->getBase()) {
            if (!$attribute->getStatic()) {
                $line = 'protected $' . $attribute->getLowerName();
            } else {
                $line = 'protected static $' . $attribute->getName();
            }

            if (null === $attribute->getDefaultValue()) {
                $line .= ';';
            } else {
                $defaultAttributeInit = $attribute->getDefaultValueAttributeInit();

                if ('' !== $defaultAttributeInit) {
                    $line .= ' = ' . $attribute->getDefaultValueAttributeInit() . ';';
                } else {
                    $line .= ';';
                }
            }

            $lines[] = $line;
        } else {
            if (null === $attribute->getDefaultValue()) {
                $lines[] = 'private $' . $attribute->getLowerName() . ';';
            } else {
                switch($attribute->getPhpType()) {
                    case 'string':
                        $lines[] = 'private $' . $attribute->getLowerName() . ' = \'' . str_replace('\'','\\\'',$attribute->getDefaultValue()) . '\';';
                        break;
                    default:
                        $lines[] = 'private $' . $attribute->getLowerName() . ' = ' . $attribute->getDefaultValue() . ';';
                }
            }
        }

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Setters">
    public function getSetterInnerValidationCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        if ('boolean' === $attribute->getPhpType()) {
            if (!$attribute->getNull()) {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['boolean']));
            } else {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['boolean', 'null']));
            }
        } elseif ('integer' === $attribute->getPhpType()) {
            if (!$attribute->getNull()) {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['integer']));
            } else {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['integer', 'null']));
            }
        } elseif ('float' === $attribute->getPhpType()) {
            if (!$attribute->getNull()) {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['float']));
            } else {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['float', 'null']));
            }
        } elseif ('string' === $attribute->getPhpType()) {
            if ('string' === $attribute->getType()) {
                if (!$attribute->getNull()) {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['string']));

                    if (null !== $attribute->getMinSize()) {
                        $lines[] = '';

                        $lines[] = 'if (strlen($' . $attribute->getLowerName() . ') < ' . $attribute->getMinSize() . ') {';
                        $lines[] =     'throw new \InvalidArgumentException(\'On the attribute ' . $attribute->getLowerName() . ', the length of the string \' . $' . $attribute->getLowerName() . ' . \' is \' . strlen($' . $attribute->getLowerName() . ') . \' which is shorter than the minimum allowed (' . $attribute->getMinSize() . ').\');';
                        $lines[] = '}';
                    }
                } else {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['string', 'null']));

                    if (null !== $attribute->getMinSize()) {
                        $lines[] = '';

                        $lines[] = 'if (strlen($' . $attribute->getLowerName() . ') < ' . $attribute->getMinSize() . ') {';
                        $lines[] =     'throw new \InvalidArgumentException(\'On the attribute ' . $attribute->getLowerName() . ', the length of the string \' . $' . $attribute->getLowerName() . ' . \' is \' . strlen($' . $attribute->getLowerName() . ') . \' which is shorter than the minimum allowed (' . $attribute->getMinSize() . ').\');';
                        $lines[] = '}';
                    }
                }
            } elseif ('text' === $attribute->getType()) {
                if (!$attribute->getNull()) {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['string']));
                } else {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['string', 'null']));
                }
            }
        } elseif ('object' === $attribute->getType()) {
            if (null === $attribute->getSubtype()) {
                throw new \InvalidArgumentException('Attribute ' . $attribute->getName() . ' on the entity ' . $attribute->getEntity()->getName() . ' is marked as an object but doesn\'t have a subtype');
            }

            // The not null case doesn't make sense because it will go on the parameter line
            if ($attribute->getNull()) {
                $lines = array_merge($lines, $this->getTypeCheckLines($attribute, [['object'=>$attribute->getEntitySubtype()->getName()], 'null']));
            }
        }

        return $lines;
    }

    public function getSetterCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Set ' . $attribute->getLowerName();
        $lines[] = '';
        $lines[] = '@param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerName();

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '@return ' . $attribute->getEntity()->getName();
        }

        if (0 !== count($this->getSetterInnerValidationCodeLines($attribute))) {
            $lines[] = '';
            $lines[] = '@throws \InvalidArgumentException';
        }

        return $lines;
    }

    public function getSetterCodeLines(PHPAttribute $attribute)
    {
        $validationLines = $this->getSetterInnerValidationCodeLines($attribute);

        $settingFromInverse = $attribute->getSettingFromInverse();

        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getSetterCodeDocumentationLines($attribute)));

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

        $lines = array_merge($lines, $this->indentLines($validationLines));

        if (0 !== count($validationLines)) {
            $lines[] = '';
        }

        if (!$settingFromInverse) {
            if ('OneToOne' === $attribute->getForeign()) {
                if (!$attribute->getNull()) {
                    $lines[] = $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';';
                    $lines[] = 'if ($this !== $' . $attribute->getName() . '->get' . $this->getEntity()->getName() . '()) {';
                    $lines[] =     '$' . $attribute->getName() . '->set' . $this->getEntity()->getName() . '($this);';
                    $lines[] = '}';
                } else {
                    $lines[] = 'if (null !== $' . $attribute->getLowerName() . ') {';
                    $lines[] =     $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';';
                    $lines[] =     'if ($this !== $' . $attribute->getName() . '->get' . $this->getEntity()->getName() . '()) {';
                    $lines[] =         '$' . $attribute->getName() . '->set' . $this->getEntity()->getName() . '($this);';
                    $lines[] =     '}';
                    $lines[] = '} elseif (null !== ' . $attribute->getThisName() . ') {';

                    if ($attribute->getForeignKey()->getSetter()) {
                        $lines[] =     $attribute->getThisName() . '->set' . $attribute->getForeignKey()->getUpperName() . '(null);';
                    }

                    $lines[] =     $attribute->getThisName() . ' = null;';
                    $lines[] = '}';
                }
            } elseif ('ManyToOne' === $attribute->getForeign()) {
                $lines[] = $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';';
            } else {
                $lines[] = $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';';
            }
        } else {
            if ('ManyToMany' === $attribute->getForeign()) {
                $lines[] = 'foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] =     '/** @var ' . $attribute->getReverseAttribute()->getEntity()->getName() . ' $' . $attribute->getSingleName() . ' */';
                $lines[] =     '$' . $attribute->getSingleName() . '->set' . $attribute->getReverseAttribute()->getUpperName() . '(new ArrayCollection([$this]));';
                $lines[] = '}';
            } elseif ('OneToOne' === $attribute->getForeign()) {
                if (!$attribute->getNull()) {
                    $lines[] = $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';';
                    $lines[] = 'if ($this !== $' . $attribute->getName() . '->get' . $attribute->getForeignKey()->getUpperName() . '()) {';
                    $lines[] =     '$' . $attribute->getName() . '->set' . $attribute->getForeignKey()->getUpperName() . '($this);';
                    $lines[] = '}';
                } else {
                    $lines[] = 'if (null !== $' . $attribute->getLowerName() . ') {';
                    $lines[] =     $attribute->getThisName() . ' = $' . $attribute->getLowerName() . ';';
                    $lines[] =     'if ($this !== $' . $attribute->getName() . '->get' . $attribute->getForeignKey()->getUpperName() . '()) {';
                    $lines[] =         '$' . $attribute->getName() . '->set' . $attribute->getForeignKey()->getUpperName() . '($this);';
                    $lines[] =     '}';
                    $lines[] = '} elseif (null !== ' . $attribute->getThisName() . ') {';

                    if ($attribute->getForeignKey()->getSetter()) {
                        $lines[] =     $attribute->getThisName() . '->set' . $attribute->getForeignKey()->getUpperName() . '(null);';
                    }

                    $lines[] =     $attribute->getThisName() . ' = null;';
                    $lines[] = '}';
                }
            } else { // ManyToOne
                if ($attribute->getInverse()) {
                    $lines[] = 'foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                    $lines[] =     '/** @var ' . $attribute->getReverseAttribute()->getEntity()->getName() . ' $' . $attribute->getSingleName() . ' */';
                    $lines[] =     '$' . $attribute->getSingleName() . '->set' . $attribute->getReverseAttribute()->getUpperName() . '($this);';
                    $lines[] = '}';
                } else {
                    // Default normal setter
                    throw new \RuntimeException('Unknown scenario');
                }
            }
        }

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = 'return $this;';
        }

        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Getters">
    public function getGetterCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Get ' . $attribute->getLowerName();
        $lines[] = '';
        $lines[] = '@return ' . $attribute->getPhpAnnotationTypeBase();

        return $lines;
    }

    public function getGetterCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getGetterCodeDocumentationLines($attribute)));

        $lines[] = $attribute->getStatic()
            ? 'public static function ' . $attribute->getGetterName() . '()'
            : 'public function ' . $attribute->getGetterName() . '()';

        $lines[] = '{';
        $lines[] = 'return ' . $attribute->getThisName() . ';';
        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Adders">
    public function getSingleAdderCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Add ' . $attribute->getSingleName();
        $lines[] = '';
        $lines[] = '@param ' . $attribute->getPhpSingleTypeBase() . ' $' . $attribute->getSingleName();

        if ('ManyToMany' === $attribute->getForeign()) {
            $lines[] = '@param bool $allowRepeatedValues';
        }

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '@return ' . $attribute->getEntity()->getName();
        }

        return $lines;
    }

    public function getSingleAdderCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getSingleAdderCodeDocumentationLines($attribute)));

        $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function add' . $attribute->getSingleUpperName() . '(' . ( '' !== $attribute->getPhpSingleParameterType() ? $attribute->getPhpSingleParameterType() . ' ' : '' ) . '$' . $attribute->getSingleName() . ('ManyToMany' === $attribute->getForeign() ? ', $allowRepeatedValues = true' : '') . ')';
        $lines[] = '{';

        if ('ManyToMany' === $attribute->getForeign()) {
            if (!$attribute->getSettingFromInverse()) {
                $lines[] = 'if ($allowRepeatedValues || !' . $attribute->getThisName() . '->contains($' . $attribute->getSingleName() . ')) {';
                $lines[] =     $attribute->getThisName() . '[] = $' . $attribute->getSingleName() . ';';
                $lines[] = '}';
            } else {
                $lines[] = 'if ($allowRepeatedValues || !$' . $attribute->getSingleName() . '->contains' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this)) {';
                $lines[] =     '$' . $attribute->getSingleName() . '->add' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);';
                $lines[] = '}';
            }
        } else { // ManyToOne
            if ('Doctrine2' === $attribute->getEntity()->getProject()->getORM()) { // TODO: Double check this
                $lines[] = '$' . $attribute->getSingleName() . '->set' . $attribute->getReverseAttribute()->getUpperName() . '($this);';
                $lines[] = '';
            }

            $lines[] = $attribute->getThisName() . '[] = $' . $attribute->getSingleName() . ';';
        }

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = 'return $this;';
        }

        $lines[] = '}';

        return $lines;
    }

    public function getMultipleAdderCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Add ' . $attribute->getLowerName();
        $lines[] = '';
        $lines[] = '@param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerName();

        if ('ManyToMany' === $attribute->getForeign()) {
            $lines[] = '@param bool $allowRepeatedValues';
        }

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '@return ' . $attribute->getEntity()->getName();
        }

        return $lines;
    }

    public function getMultipleAdderCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getMultipleAdderCodeDocumentationLines($attribute)));

        $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function add' . $attribute->getUpperName() . '(' . $attribute->getPhpParameterTypeBase() . ' ' . '$' . $attribute->getLowerName() . ('ManyToMany' === $attribute->getForeign() ? ', $allowRepeatedValues = true' : '') . ')';
        $lines[] = '{';

        if ('ManyToMany' === $attribute->getForeign()) {
            if (!$attribute->getSettingFromInverse()) {
                $lines[] = 'foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] =     'if ($allowRepeatedValues || !' . $attribute->getThisName() . '->contains($' . $attribute->getSingleName() . ')) {';
                $lines[] =         $attribute->getThisName() . '[] = $' . $attribute->getSingleName() . ';';
                $lines[] =      '}';
                $lines[] = '}';
            } else {
                $lines[] = 'foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] =     'if ($allowRepeatedValues || !$' . $attribute->getSingleName() . '->contains' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this)) {';
                $lines[] =         '$' . $attribute->getSingleName() . '->add' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);';
                $lines[] =     '}';
                $lines[] = '}';
            }
        } else { // ManyToOne
            if ('Doctrine2' === $attribute->getEntity()->getProject()->getORM()) { // TODO: Double check this
                $lines[] = 'foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] =     '$' . $attribute->getSingleName() . '->set' . $attribute->getReverseAttribute()->getUpperName() . '($this);';
                $lines[] = '}';
            } else {
                $lines[] = 'foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] =     $attribute->getThisName() . '[] = $' . $attribute->getSingleName() . ';';
                $lines[] = '}';
            }
        }

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = 'return $this;';
        }

        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Contains">
    public function getSingleContainsCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Contains ' . $attribute->getSingleName();
        $lines[] = '';
        $lines[] = '@param ' . $attribute->getPhpSingleTypeBase() /*. ($attribute->getEntity()->getProject()->getBase() ? 'Base' : '')*/ . ' $' . $attribute->getSingleName();
        $lines[] = '';
        $lines[] = '@return bool';

        return $lines;
    }

    public function getSingleContainsCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getSingleContainsCodeDocumentationLines($attribute)));

        $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function contains' . $attribute->getSingleUpperName() . '(' . ( '' !== $attribute->getPhpSingleParameterType() ? $attribute->getPhpSingleParameterType() . ' ' : '' ) . '$' . $attribute->getSingleName() . ')';
        $lines[] = '{';

        $lines[] = !$attribute->getSettingFromInverse()
            ? 'return ' . $attribute->getThisName() . '->contains($' . $attribute->getSingleName() . ');'
            : 'return $' . $attribute->getSingleName() . '->contains' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);';

        $lines[] = '}';

        return $lines;
    }

    public function getMultipleContainsCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Contains ' . $attribute->getLowerName();
        $lines[] = '';
        $lines[] = '@param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerName();
        $lines[] = '';
        $lines[] = '@return bool';

        return $lines;
    }

    public function getMultipleContainsCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getMultipleContainsCodeDocumentationLines($attribute)));

        $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function contains' . $attribute->getUpperName() . '(' . $attribute->getPhpParameterTypeBase() . ' ' . '$' . $attribute->getLowerName() . ')';
        $lines[] = '{';

        if (!$attribute->getSettingFromInverse()) {
            $lines[] = 'foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
            $lines[] =     'if (!' . $attribute->getThisName() . '->contains($' . $attribute->getSingleName() . ')) {';
            $lines[] =         'return false;';
            $lines[] =     '}';
            $lines[] = '}';
        } else {
            $lines[] = 'foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
            $lines[] =     'if (!$' . $attribute->getSingleName() . '->contains' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this)) {';
            $lines[] =         'return false;';
            $lines[] =     '}';
            $lines[] = '}';
        }

        $lines[] = '';
        $lines[] = 'return true;';

        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Removers">
    public function getSingleRemoverCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Remove ' . $attribute->getSingleName();
        $lines[] = '';
        $lines[] = '@param ' . $attribute->getPhpSingleTypeBase() /*. ($attribute->getEntity()->getProject()->getBase() ? 'Base' : '')*/ . ' $' . $attribute->getSingleName();

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '@return ' . $attribute->getEntity()->getName();
        }

        return $lines;
    }

    public function getSingleRemoverCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getSingleRemoverCodeDocumentationLines($attribute)));

        $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function remove' . $attribute->getSingleUpperName() . '(' . ( '' !== $attribute->getPhpSingleParameterType() ? $attribute->getPhpSingleParameterType() . ' ' : '' ) . '$' . $attribute->getSingleName() . ')';
        $lines[] = '{';

        if ('array' === $attribute->getType() && null !== $attribute->getSubtype()) {
            $lines[] = 'foreach (' . $attribute->getThisName() . ' as $key => $' . $attribute->getSingleName() . 'Element) {';
            $lines[] =     'if ($' . $attribute->getSingleName() . 'Element === $' . $attribute->getSingleName() . ') {';
            $lines[] =         'unset(' . $attribute->getThisName() . '[$key]);';
            $lines[] =         'break;';
            $lines[] =     '}';
            $lines[] = '}';
        } else {
            $lines[] = !$attribute->getSettingFromInverse()
                ? $attribute->getThisName() . '->removeElement($' . $attribute->getSingleName() . ');'
                : '$' . $attribute->getSingleName() . '->remove' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);';
        }

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = 'return $this;';
        }

        $lines[] = '}';

        return $lines;
    }

    public function getMultipleRemoverCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Remove ' . $attribute->getLowerName();
        $lines[] = '';
        $lines[] = '@param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerName();

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '@return ' . $attribute->getEntity()->getName();
        }

        return $lines;
    }

    public function getMultipleRemoverCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getMultipleRemoverCodeDocumentationLines($attribute)));

        $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function remove' . $attribute->getUpperName() . '(' . $attribute->getPhpParameterTypeBase() . ' ' . '$' . $attribute->getLowerName() . ')';
        $lines[] = '{';

        if ('array' === $attribute->getType() && null !== $attribute->getSubtype()) {
            $lines[] = 'foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';

            $lines[] = !$attribute->getStatic()
                ? '$this->remove' . $attribute->getSingleUpperName() . '($' . $attribute->getSingleName() . ');'
                : 'self::remove' . $attribute->getSingleUpperName() . '($' . $attribute->getSingleName() . ');';

            $lines[] = '}';
        } else {
            if (!$attribute->getSettingFromInverse()) {
                $lines[] = 'foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] =     $attribute->getThisName() . '->removeElement($' . $attribute->getSingleName() . ');';
                $lines[] = '}';
            } else {
                $lines[] = 'foreach ($' . $attribute->getLowerName() . ' as $' . $attribute->getSingleName() . ') {';
                $lines[] =     '$' . $attribute->getSingleName() . '->remove' . $attribute->getReverseAttribute()->getSingleUpperName() . '($this);';
                $lines[] = '}';
            }
        }

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = 'return $this;';
        }

        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    public function getSetterGetterLines(PHPAttribute $attribute)
    {
        $lines = [];

        if ($attribute->getSetter()) {
            $lines = array_merge($lines, $this->getSetterCodeLines($attribute));
        }

        if ('Collection' === $attribute->getPhpParameterType() || 'array' === $attribute->getType()) {
            if (0 !== count($lines)) {
                $lines[] = '';
            }

            $lines = array_merge($lines, $this->getSingleAdderCodeLines($attribute));

            $lines[] = '';

            $lines = array_merge($lines, $this->getMultipleAdderCodeLines($attribute));

            if ('ManyToOne' !== $attribute->getForeign()) {
                $lines[] = '';

                $lines = array_merge($lines, $this->getSingleContainsCodeLines($attribute));

                $lines[] = '';

                $lines = array_merge($lines, $this->getMultipleContainsCodeLines($attribute));
            }

            $lines[] = '';

            $lines = array_merge($lines, $this->getSingleRemoverCodeLines($attribute));

            $lines[] = '';

            $lines = array_merge($lines, $this->getMultipleRemoverCodeLines($attribute));
        }

        if ($attribute->getGetter()) {
            if (0 !== count($lines)) {
                $lines[] = '';
            }

            $lines = array_merge($lines, $this->getGetterCodeLines($attribute));
        }

        return $lines;
    }

    // <editor-fold desc="toString">
    public function getEntityToStringDocumentationLines()
    {
        $lines = [];


        $line = $this->getEntity()->getName() . ' to string ';

        $line .= null === $this->getEntity()->getToString()
            ? '(Default)'
            : '(' . $this->getEntity()->getToString() . ')';

        $lines[] = $line;

        $lines[] = '';
        $lines[] = '@return string';

        return $lines;
    }

    public function getEntityToStringLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getEntityToStringDocumentationLines()));

        $lines[] = 'public function __toString()';
        $lines[] = '{';

        if (null === $this->getEntity()->getToString()) {
            $lines[] = '' !== $this->getEntity()->getProject()->getORM()
                ? 'return \'' . $this->getEntity()->getName() . '(\' . $this->' . $this->getEntity()->getPrimaryAttribute()->getName() . ' . \')\';'
                : 'return \'' . $this->getEntity()->getName() . '\';';
        } else {
            $lines[] = 'return strval($this->' . $this->getEntity()->getAttributeByName($this->getEntity()->getToString())->getName() . ');';
        }

        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Array access">
    public function getArrayAccessOffsetSetCodeDocumentationLines()
    {
        $lines = [];

        $lines[] = 'OffsetSet implementation of the \\ArrayAccess interface';
        $lines[] = '';
        $lines[] = '@param string $offset';
        $lines[] = '@param mixed  $value';
        $lines[] = '';
        $lines[] = '@throws \\InvalidArgumentException if the offset doesn\'t exist on this entity or doesn\'t allow to be set';

        return $lines;
    }

    public function getArrayAccessOffsetSetCodeLines()
    {
        $noOffsetMessage = 'Tried to access the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but that offset doesn\\\'t exist.';
        $noSetterMessage = 'Tried to set the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but is set to not allow setter access.';

        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getArrayAccessOffsetSetCodeDocumentationLines()));

        $lines[] = 'public function offsetSet($offset, $value)';
        $lines[] = '{';
        $lines[] = 'if (!$this->offsetExists($offset)) {' ;
        $lines[] =     'throw new \\InvalidArgumentException(\'' . $noOffsetMessage . '\');';
        $lines[] = '}';
        $lines[] = '';
        $lines[] = 'switch ($offset) {';

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ($attr->getSetter()) {
                $lines[] = 'case \'' . $attr->getName() . '\':';
                $lines[] =     '$this->' . $attr->getSetterName() . '($value);';
                $lines[] =     'break;';
            }
        }

        $lines[] = 'default:';
        $lines[] =     'throw new \\InvalidArgumentException(\'' . $noSetterMessage . '\');';
        $lines[] = '}';

        $lines[] = '}';

        return $lines;
    }

    public function getArrayAccessOffsetExitsCodeDocumentationLines()
    {
        $lines = [];

        $lines[] = 'OffsetExists implementation of the \\ArrayAccess interface';
        $lines[] = '';
        $lines[] = '@param string $offset';
        $lines[] = '';
        $lines[] = '@return bool';

        return $lines;
    }

    public function getArrayAccessOffsetExitsCodeLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getArrayAccessOffsetExitsCodeDocumentationLines()));

        $lines[] = 'public function offsetExists($offset)';
        $lines[] = '{';

        $attributes = [];
        foreach ($this->getEntity()->getAttributes() as $attr) {
            $attributes[] = '\'' . $attr->getName() . '\'';
        }

        $lines[] =     'return in_array($offset, [' . implode(', ', $attributes) . ']);';

        $lines[] = '}';

        return $lines;
    }

    public function getArrayAccessOffsetUnsetCodeDocumentationLines()
    {
        $lines = [];

        $lines[] = 'OffsetUnset implementation of the \\ArrayAccess interface';
        $lines[] = '';
        $lines[] = '@param string $offset';
        $lines[] = '';
        $lines[] = '@throws \\InvalidArgumentException if the offset doesn\'t exist on this entity or doesn\'t allow to be set';

        return $lines;
    }

    public function getArrayAccessOffsetUnsetCodeLines()
    {
        $noOffsetMessage = 'Tried to access the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but that offset doesn\\\'t exist.';
        $noSetterMessage = 'Tried to unset the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but is set to not allow setter access.';

        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getArrayAccessOffsetUnsetCodeDocumentationLines()));

        $lines[] = 'public function offsetUnset($offset)';
        $lines[] = '{';

        $lines[] = 'if (!$this->offsetExists($offset)) {' ;
        $lines[] =     'throw new \\InvalidArgumentException(\'' . $noOffsetMessage . '\');';
        $lines[] = '}';
        $lines[] = '';

        $lines[] = 'switch ($offset) {';

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ($attr->getSetter()) {
                $lines[] = 'case \'' . $attr->getName() . '\':';

                if ('' != $attr->getDefaultValueAttributeInit()) {
                    $lines[] = '$this->' . $attr->getSetterName() . '(' . $attr->getDefaultValueAttributeInit() . ');';
                } elseif ('' != $attr->getDefaultValueConstructorInit()) {
                    $lines[] = '$this->' . $attr->getSetterName() . '(' . $attr->getDefaultValueConstructorInit() . ');';
                } else {
                    $lines[] = '$this->' . $attr->getName() . ' = null;';
                }

                $lines[] = 'break;';
            }
        }

        $lines[] = 'default:';
        $lines[] =     'throw new \\InvalidArgumentException(\'' . $noSetterMessage . '\');';
        $lines[] = '}';

        $lines[] = '}';

        return $lines;
    }

    public function getArrayAccessOffsetGetCodeDocumentationLines()
    {
        $lines = [];

        $lines[] = 'OffsetGet implementation of the \\ArrayAccess interface';
        $lines[] = '';
        $lines[] = '@param string $offset';
        $lines[] = '';
        $lines[] = '@return mixed'; // TODO: Improve this
        $lines[] = '';
        $lines[] = '@throws \\InvalidArgumentException if the offset doesn\'t exist on this entity or doesn\'t allow to be retrieved';

        return $lines;
    }


    public function getArrayAccessOffsetGetCodeLines()
    {
        $noOffsetMessage = 'Tried to access the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but that offset doesn\\\'t exist.';
        $noGetterMessage = 'Tried to get the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but is set to not allow getter access.';

        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getArrayAccessOffsetGetCodeDocumentationLines()));

        $lines[] = 'public function offsetGet($offset)';
        $lines[] = '{';

        $lines[] = 'if (!$this->offsetExists($offset)) {' ;
        $lines[] =     'throw new \\InvalidArgumentException(\'' . $noOffsetMessage . '\');';
        $lines[] = '}';
        $lines[] = '';

        $lines[] = 'switch ($offset) {';

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ($attr->getSetter()) {
                $lines[] = 'case \'' . $attr->getName() . '\':';
                $lines[] =     'return $this->' . $attr->getGetterName() . '();';
            }
        }

        $lines[] = 'default:';
        $lines[] =     'throw new \\InvalidArgumentException(\'' . $noGetterMessage . '\');';
        $lines[] = '}';

        $lines[] = '}';

        return $lines;
    }

    public function getArrayAccessCodeLines()
    {
        $lines = [];

        $lines[] = '// <editor-fold desc="ArrayAccess">';

        $lines = array_merge($lines, $this->getArrayAccessOffsetSetCodeLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getArrayAccessOffsetExitsCodeLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getArrayAccessOffsetUnsetCodeLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getArrayAccessOffsetGetCodeLines());

        $lines[] = '// </editor-fold>';

        return $lines;
    }
    // </editor-fold>

    public function getFilenameLine()
    {
        $line = '// ' . $this->getEntity()->getNamespace() . '\\';

        if ($this->getEntity()->getProject()->getBase()) {
            $line .= 'Base\\';
        }

        $line .= $this->getEntity()->getName() . '.php';

        return $line;
    }

    public function getNamespaceLine()
    {
        $line = 'namespace ' . $this->getEntity()->getNamespace();

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

    public function getUseLines()
    {
        $lines = [];

        if ( $this->getEntity()->getProject()->getBase() && $this->getEntity()->hasSetters() ) {
            $lines[] = $this->getEntityUseLine($this->getEntity());
        }

        if (null !== $this->getEntity()->getParentEntity()) {
            $lines[] = 'use ' . $this->getEntity()->getParentEntity()->getFullyQualifiedName() . ';';
        }

        foreach ($this->getRequiredEntities() as $requiredEntity) {
            if (substr($requiredEntity, 0, strlen($this->getEntity()->getNamespace())) !== $this->getEntity()->getNamespace()) {
                $lines[] = 'use ' . $requiredEntity . ';';
            }
        }

        if ($this->getEntity()->getProject()->getBase()) {
            foreach ($this->getEntity()->getAttributes() as $attr) {
                if (null !== $attr->getForeignEntity()) {
                    $lines[] = 'use ' . $attr->getForeignEntity()->getFullyQualifiedName() . ';';
                }

                if ($attr->isEntitySubtype()) {
                    $lines[] = $this->getEntityUseLine($this->getEntity()->getProject()->getEntityByFullyQualifiedName($attr->getSubtype()));
                }
            }
        }

        return array_unique($lines, SORT_STRING);
    }

    public function getEntityDocumentationLines()
    {
        $lines = [];

        $lines[] = !$this->getEntity()->getProject()->getBase()
            ? $this->getEntity()->getNamespace() . '\\Entity\\' . $this->getEntity()->getName()
            : $this->getEntity()->getNamespace() . '\\Entity\\Base\\' . $this->getEntity()->getName();

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
                $lines = array_merge($lines, $this->getAttributeLines($attr));
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

        $setterGetterLines = [];

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ( null === $this->getEntity()->getParentEntity() || !in_array($attr->getName(), array_keys($this->getEntity()->getParentEntity()->getAttributes())) ) {
                if (0 !== count($setterGetterLines)) {
                    $setterGetterLines[] = '';
                }

                $setterGetterLines = array_merge($setterGetterLines, $this->getSetterGetterLines($attr));
            }
        }

        $lines = array_merge($lines, $setterGetterLines);

        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getOtherMethodLines()
    {
        $lines = [];

        $lines[] = '';
        $lines[] = '// <editor-fold desc="Other methods">';

        $lines = array_merge($lines, $this->getEntityToStringLines());

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

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getEntityDocumentationLines()));

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