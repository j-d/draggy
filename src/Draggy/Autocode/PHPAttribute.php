<?php
// Draggy\Autocode\PHPAttribute.php

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

use Draggy\Autocode\Base\PHPAttributeBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Entity\PHPAttribute
 */
class PHPAttribute extends PHPAttributeBase
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    public static $PHP_VARS = [
        'string'   => 'string',
        'boolean'  => 'boolean',
        'integer'  => 'integer',
        'smallint' => 'integer',
        'bigint'   => 'integer',
        'text'     => 'string',
        'date'     => '\\DateTime',
        'time'     => '\\DateTime',
        'datetime' => '\\DateTime',
        'array'    => 'array',
        'decimal'  => 'float',
        'object'   => 'ERROR'
    ];
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
    public function getPhpType()
    {
        if ($this->type === 'object') {
            if (is_null($this->getSubtype())) {
                throw new \InvalidArgumentException('Attribute ' . $this->getName() . ' on the entity ' . $this->getEntity()->getName() . ' is marked as an object but doesn\'t have a subtype');
            }

            if ($this->isEntitySubtype()) {
                return $this->getEntitySubtype()->getName();
            } else {
                return $this->getSubtype();
            }
        } elseif ($this->type === 'array' && null !== $this->getSubtype()) {
            if ($this->isEntitySubtype()) {
                return $this->getEntitySubtype()->getName() . '[]';
            } else {
                return $this->getSubtype() . '[]';
            }
        } else {
            if (is_null($this->getForeign())) {
                return self::$PHP_VARS[$this->getType()];
            } else {
                if ($this->getForeign() === 'OneToOne' || $this->getForeign() === 'ManyToOne' && !$this->getInverse()) {
                    return $this->getForeignEntity()->getName();
                } else {
                    return $this->getForeignEntity()->getName() . '[]|Collection';
                }
            }
        }
    }

    public function getPhpParameterType()
    {
        // If it is nullable, then nothing could go on the parameter line and it has to be inner validation
        if ($this->getNull()) {
            return null;
        }

        if (is_null($this->getForeign())) {
            if ($this->type === 'object') {
                if (is_null($this->getSubtype())) {
                    throw new \InvalidArgumentException('Attribute ' . $this->getName() . ' on the entity ' . $this->getEntity()->getName() . ' is marked as an object but doesn\'t have a subtype');
                }

                if ($this->isEntitySubtype()) {
                    return $this->getEntitySubtype()->getName();
                } else {
                    return $this->getSubtype();
                }
            } elseif ($this->getType() === 'array') {
                return 'array';
            } else {
                // Other types cannot go on the parameter line
                return null;
            }
        } else {
            if ($this->getForeign() === 'OneToOne' || $this->getForeign() === 'ManyToOne' && !$this->getInverse()) {
                return $this->getForeignEntity()->getName();
            } else {
                return 'Collection';
            }
        }
    }

    public function getPhpAnnotationType()
    {
        if (null === $this->getForeign()) {
            if ($this->type === 'object') {
                if (is_null($this->getSubtype())) {
                    throw new \InvalidArgumentException('Attribute ' . $this->getName() . ' on the entity ' . $this->getEntity()->getName() . ' is marked as an object but doesn\'t have a subtype');
                }

                if ($this->isEntitySubtype()) {
                    $ret = $this->getEntitySubtype()->getName();
                } else {
                    $ret = $this->getSubtype();
                }
            } elseif ($this->getType() === 'array') {
                // TODO: REMOVE THIS NOTE
                // Addition on 6th Jan, it was $ret = 'array';
                if (null !== $this->getSubtype()) {
                    if ($this->isEntitySubtype()) {
                        return $this->getEntitySubtype()->getName() . '[]';
                    } else {
                        return $this->getSubtype() . '[]';
                    }
                } else {
                    $ret = 'array';
                }
                // End of Addition
            } else {
                $ret = self::$PHP_VARS[$this->getType()];
            }
        } else {
            if ($this->getForeign() === 'OneToOne' || $this->getForeign() === 'ManyToOne' && !$this->getInverse()) {
                $ret = $this->getForeignEntity()->getName();
            } else {
                $ret = $this->getForeignEntity()->getName() . '[]|Collection';
            }
        }

        if ($this->getNull()) {
            return $ret . '|null';
        } else {
            return $ret;
        }
    }

    public function getPhpTypeBase()
    {
        if ($this->getEntity()->getProject()->getBase() && null !== $this->getForeign()) {
            if ($this->getForeign() === 'OneToOne' || $this->getForeign() === 'ManyToOne' && !$this->getInverse()) {
                return $this->getForeignEntity()->getName() . 'Base|' . $this->getPhpType();
            } else {
                return $this->getForeignEntity()->getName() . 'Base[]|' . $this->getPhpType();
            }
        } else {
            return $this->getPhpType();
        }
    }

    public function getPhpParameterTypeBase()
    {
        if ($this->getEntity()->getProject()->getBase() && null !== $this->getForeign()) {
            if ($this->getForeign() === 'OneToOne' || $this->getForeign() === 'ManyToOne' && !$this->getInverse()) {
                return $this->getForeignEntity()->getName() . 'Base|' . $this->getPhpParameterType();
            } else {
                return $this->getPhpParameterType();
            }
        } else {
            return $this->getPhpParameterType();
        }
    }

    public function getPhpAnnotationTypeBase()
    {
        if ($this->getEntity()->getProject()->getBase() && null !== $this->getForeign()) {
            if ($this->getForeign() === 'OneToOne' || $this->getForeign() === 'ManyToOne' && !$this->getInverse()) {
                return $this->getForeignEntity()->getName() . 'Base|' . $this->getPhpAnnotationType();
            } else {
                return $this->getForeignEntity()->getName() . 'Base[]|' . $this->getPhpAnnotationType();
            }
        } else {
            return $this->getPhpAnnotationType();
        }
    }

    public function getPhpSingleType()
    {
        if (is_null($this->getForeign())) {
            return null;
        } else {
            if ($this->getForeign() === 'OneToOne' || $this->getForeign() === 'ManyToOne' && !$this->getInverse()) {
                return ($this->getEntity()->getProject()->getBase() ? $this->getForeignEntity()->getName() . 'Base|' : '') . $this->getForeignEntity()->getName();
            } else {
                return $this->getForeignEntity()->getName();
            }
        }
    }

    public function getPhpSingleParameterType()
    {
        if ($this->type === 'array' && null !== $this->getSubtype()) {
            if ($this->isEntitySubtype()) {
                return $this->getEntitySubtype()->getName();
            } else {
                return '';
            }
        } else {
            if (is_null($this->getForeign())) {
                return 'array';
            } else {
                if ($this->getForeign() === 'OneToOne' || $this->getForeign() === 'ManyToOne' && !$this->getInverse()) {
                    return ($this->getEntity()->getProject()->getBase() ? $this->getForeignEntity()->getName() . 'Base|' : '') . $this->getForeignEntity()->getName();
                } else {
                    return $this->getForeignEntity()->getName();
                }
            }
        }
    }

    public function getPhpSingleTypeBase()
    {
        if ($this->type === 'object') {
            if (is_null($this->getSubtype())) {
                throw new \InvalidArgumentException('Attribute ' . $this->getName() . ' on the entity ' . $this->getEntity()->getName() . ' is marked as an object but doesn\'t have a subtype');
            }

            if ($this->isEntitySubtype()) {
                return $this->getEntitySubtype()->getName();
            } else {
                return $this->getSubtype();
            }
        } elseif ($this->type === 'array' && null !== $this->getSubtype()) {
            if ($this->isEntitySubtype()) {
                return $this->getEntitySubtype()->getName();
            } else {
                return $this->getSubtype();
            }
        } else {
            if (is_null($this->getForeign())) {
                return self::$PHP_VARS[$this->getType()];
            } else {
                return ($this->getEntity()->getProject()->getBase() ? $this->getForeignEntity()->getName() . 'Base|' : '') . $this->getForeignEntity()->getName();
            }
        }
    }

    public function getPhpSingleParameterTypeBase()
    {
        if (is_null($this->getForeign())) {
            return null;
        } else {
            if ($this->getForeign() === 'OneToOne' || $this->getForeign() === 'ManyToOne' && !$this->getInverse()) {
                return ($this->getEntity()->getProject()->getBase() ? $this->getForeignEntity()->getName() . 'Base|' : '') . $this->getForeignEntity()->getName();
            } else {
                return $this->getForeignEntity()->getName() . ($this->getEntity()->getProject()->getBase() ? 'Base' : '');
            }
        }
    }

    public function getTypeMessage()
    {
        return $this->getHumanName() . ' should be of type ' . $this->getPhpType() . '.';
    }

    public function getThisName()
    {
        if (!$this->getStatic()) {
            return '$this->' . $this->getLowerName();
        } else {
            return 'self::$' . $this->getName();
        }
    }
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    public function describe()
    {
        $ret = '';

        $ret .= 'PHPType = ' . $this->getPhpType() . "\n";
        $ret .= 'PHPParameterType = ' . $this->getPhpParameterType() . "\n";

        return parent::describe() . $ret;
    }

    public function getDefaultValueAttributeInit()
    {
        if (null === $this->getDefaultValue()) {
            return null;
        }

        switch ($this->getPhpType()) {
            case 'string':
                if ($this->getDefaultValue() == 'null') {
                    return 'null';
                } elseif ($this->getDefaultValue() == '\'\'') {
                    return '\'\'';
                } else {
                    return '\'' . str_replace('\'', '\\\'', $this->getDefaultValue()) . '\'';
                }
                break;
            case 'integer':
                return $this->getDefaultValue();
                break;
            case '\\DateTime':
                if ($this->getDefaultValue() == 'null') {
                    return 'null';
                } else {
                    return ''; // Can't initialise here
                }
                break;
            case 'boolean':
                if (in_array($this->getDefaultValue(), ['null', 'true', 'false'])) {
                    return $this->getDefaultValue();
                } else {
                    return '';
                }
                break;
            default:
                switch ($this->getType()) {
                    case 'array':
                        return $this->getDefaultValue();
                        break;
                    case 'object':
                        if ($this->getDefaultValue() == 'null') {
                            return 'null';
                        } else {
                            return $this->getDefaultValue();
                        }
                        break;
                    default:
                        throw new \RuntimeException('Found a default value (\'' . $this->getDefaultValue() . '\') in a parameter of type \'' . $this->getType() . '\' (PHP Type: \'' . $this->getPhpType() . '\') on the entity \'' . $this->getEntity()->getFullyQualifiedName() . '\' that doesn\'t know how to process.');
                }
        }
    }

    public function getDefaultValueConstructorInit()
    {
        if ($this->getPhpType() === '\\DateTime') {
            if ($this->getDefaultValue() !== 'null' && null !== $this->getDefaultValue()) {
                if ('\'\'' === $this->getDefaultValue()) {
                    return 'new \\DateTime(\'\')';
                } else {
                    return 'new \\DateTime(\'' . str_replace('\'', '\\\'', $this->getDefaultValue()) . '\')';
                }
            }
        } elseif ($this->getForeign() === 'ManyToMany' && null === $this->getDefaultValue()) {
            return 'new ArrayCollection()';
        }

        return '';
    }

    public function getEntityAttributeDocumentationLines()
    {
        $lines = [];

        $lines[] = '/**';

        if (null !== $this->getDescription()) {
            $lines[] = ' * ' . $this->getDescription();
            $lines[] = ' *';
        }

        $lines[] = ' * @var ' . $this->getPhpType() . ' $' . $this->getLowerName();

        // ORM
        // <editor-fold desc="ORM">
        if ('Doctrine2' === $this->getEntity()->getProject()->getORM()) {
            $lines[] = ' *';

            if ($this->getPrimary()) {
                $lines[] = ' * @ORM\\Id';
            }

            // ORM
            if (null === $this->getForeign()) {
                $lines[] = ' * @ORM\\Column(name="' . $this->getName() . '", type="' . $this->getType() . '"' . ($this->getType() == 'string' ? ', length=' . $this->getSize() : '') . ($this->getUnique() ? ', unique=true' : '') . ($this->getNull() ? ', nullable=true' : ($this->getPrimary() ? '' : ', nullable=false')) . ')';
            } else {
                switch ($this->getForeign()) {
                    case 'ManyToOne':
                        if ($this->getOwnerSide()) {
                            $lines[] = ' * @ORM\\ManyToOne(targetEntity="' . $this->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $this->getEntity()->getPluralLowerName() . '", cascade={"persist", "remove"})';
                            $lines[] = ' * @ORM\\JoinColumn(name="' . $this->getName() . '", referencedColumnName="' . $this->getForeignKey()->getName() . '")';
                        } else {
                            $lines[] = ' * @ORM\\OneToMany(targetEntity="' . $this->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $this->getForeignKey()->getName() . '")';
                        }
                        break;
                    case 'OneToOne':
                        if ($this->getOwnerSide()) {
                            $lines[] = ' * @ORM\\OneToOne(targetEntity="' . $this->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $this->getEntity()->getLowerName() . '", cascade={"persist", "remove"})';
                            $lines[] = ' * @ORM\\JoinColumn(name="' . $this->getName() . '", referencedColumnName="' . $this->getForeignKey()->getName() . '")';
                        } else {
                            $lines[] = ' * @ORM\\OneToOne(targetEntity="' . $this->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $this->getForeignKey()->getName() . '")';
                        }
                        break;
                    case 'ManyToMany':
                        if ($this->getOwnerSide()) {
                            $lines[] = ' * @ORM\\ManyToMany(targetEntity="' . $this->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $this->getReverseAttribute()->getName() . '")';
                            $lines[] = ' * @ORM\JoinTable(';
                            $lines[] = ' *      name="' . $this->getManyToManyEntityName() . '",';
                            $lines[] = ' *      joinColumns={@ORM\JoinColumn(referencedColumnName="' . $this->getEntity()->getPrimaryAttribute()->getName() . '")},';
                            $lines[] = ' *      inverseJoinColumns={@ORM\JoinColumn(referencedColumnName="' . $this->getForeignKey()->getName() . '")}';
                            $lines[] = ' *      )';
                        } else {
                            $lines[] = ' * @ORM\\ManyToMany(targetEntity="' . $this->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $this->getReverseAttribute()->getName() . '")';
                        }
                        break;
                    default:
                        throw new \Exception('foreignMethod not implemented (' . $this->getForeign() . ')');
                }
            }

            if ($this->getAutoIncrement() && !$this->getForeignTick()) {
                $lines[] = ' * @ORM\GeneratedValue(strategy="AUTO")';
            }
        }
        // </editor-fold>

        // Asserts
        // <editor-fold desc="Asserts">
        if (!$this->getInverse() && $this->getEntity()->getProject()->getValidation()) {
            $asserts = '';
            if(!$this->getAutoIncrement()) {
                if ('array' !== $this->getType()) {
                    $asserts .= ' * @Assert\\Type(type="' . $this->getSymfonyType() . '", message="' . $this->getTypeMessage() . '")';
                }

                if(!$this->getNull() && 'boolean' !== $this->getType()) {
                    $asserts .= ' * @Assert\\NotBlank(message="' . $this->getRequiredMessage() . '")';
                }

                if ('string' === $this->getType()) {
                    $asserts .= ' * @Assert\\Length(';

                    $assertsArray = [];
                    if (null !== $this->getMinSize()) {
                        $assertsArray[] = ' * min = "' . $this->getMinSize() . '"';
                    }

                    $assertsArray[] = ' * max = "' . $this->getSize() . '"';

                    if (null !== $this->getMinSize()) {
                        if ($this->getSize() !== $this->getMinSize()) {
                            $assertsArray[] = ' *     minMessage = "' . $this->getMinMessage() . '"';
                        } else {
                            $assertsArray[] = ' *     exactMessage = "' . $this->getExactMessage() . '"';
                        }
                    }

                    if ( null === $this->getMinSize() || $this->getSize() !== $this->getMinSize()) {
                        $assertsArray[] = ' *     maxMessage = "' . $this->getMaxMessage() . '"';
                    }

                    $asserts .= implode(',', $assertsArray);
                    $asserts .= ' * )';
                }

                if ($this->getEmail()) {
                    $asserts .= ' * @Assert\\Email()';
                }
            }

            if ('' !== $asserts) {
                $lines[] = ' *';
                $lines[] = $asserts;
            }
        }
        // </editor-fold>

        $lines[] = ' */';

        return $lines;
    }

    public function getEntityAttributeLines()
    {
        if ('' !== $this->getEntity()->getProject()->getORM()) {
            if ('string' === $this->getType() && null === $this->getSize()) {
                throw new \RuntimeException('The attribute ' . $this->getName() . ' on the entity ' . $this->getEntity()->getName() . ' is a string but doesn\'t have size.');
            }
        }

        $lines = [];

        $lines = array_merge($lines, $this->getEntityAttributeDocumentationLines());

        if ($this->getEntity()->getProject()->getBase()) {
            if (!$this->getStatic()) {
                $line = 'protected $' . $this->getLowerName();
            } else {
                $line = 'protected static $' . $this->getName();
            }

            if (null === $this->getDefaultValue()) {
                $line .= ';';
            } else {
                $defaultAttributeInit = $this->getDefaultValueAttributeInit();

                if ('' !== $defaultAttributeInit) {
                    $line .= ' = ' . $this->getDefaultValueAttributeInit() . ';';
                } else {
                    $line .= ';';
                }
            }

            $lines[] = $line;
        } else {
            if (null === $this->getDefaultValue()) {
                $lines[] = 'private $' . $this->getLowerName() . ';';
            } else {
                switch($this->getPhpType()) {
                    case 'string':
                        $lines[] = 'private $' . $this->getLowerName() . ' = \'' . str_replace('\'','\\\'',$this->getDefaultValue()) . '\';';
                        break;
                    default:
                        $lines[] = 'private $' . $this->getLowerName() . ' = ' . $this->getDefaultValue() . ';';
                }
            }
        }

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}