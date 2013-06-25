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
use Draggy\Autocode\Templates\PHPEntityTemplate;
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

        if (null === $this->getForeign()) {
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
            if ('OneToOne' === $this->getForeign()) {
                return $this->getForeignEntity()->getName();
            } elseif ('ManyToOne' === $this->getForeign()) {
                if ($this->getOwnerSide()) {
                    return null;
                } else {
                    return 'Collection';
                }
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
        return $this->getStatic()
            ? 'self::$' . $this->getName()
            : '$this->' . $this->getLowerName();
    }

    private function getThisFunctionAssistant($name)
    {
        return $this->getStatic()
            ? 'self::' . $name
            : '$this->' . $name;
    }

    public function getThisSingleAdderName()
    {
        return $this->getThisFunctionAssistant($this->getSingleAdderName());
    }

    public function getThisMultipleAdderName()
    {
        return $this->getThisFunctionAssistant($this->getMultipleAdderName());
    }

    public function getThisSingleRemoverName()
    {
        return $this->getThisFunctionAssistant($this->getSingleRemoverName());
    }

    public function getThisMultipleRemoverName()
    {
        return $this->getThisFunctionAssistant($this->getMultipleRemoverName());
    }

    public function getThisSingleContainsName()
    {
        return $this->getThisFunctionAssistant($this->getSingleContainsName());
    }

    public function getThisMultipleContainsName()
    {
        return $this->getThisFunctionAssistant($this->getMultipleContainsName());
    }

    /**
     * @return PHPEntity
     */
    public function &getForeignEntity()
    {
        return parent::getForeignEntity();
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
        if ('\\DateTime' === $this->getPhpType()) {
            if ($this->getDefaultValue() !== 'null' && null !== $this->getDefaultValue()) {
                if ('\'\'' === $this->getDefaultValue()) {
                    return 'new \\DateTime(\'\')';
                } else {
                    return 'new \\DateTime(\'' . str_replace('\'', '\\\'', $this->getDefaultValue()) . '\')';
                }
            }
        } elseif (null === $this->getDefaultValue()) {
            if ('ManyToMany' === $this->getForeign() || ('ManyToOne' === $this->getForeign() && $this->getInverse())) {
                return 'new ArrayCollection()';
            }
        }

        return '';
    }

    public function getFormClassLines($formName)
    {
        $lines = [];

        if ('Entity' === $this->getFormClassType() || 'Collection' === $this->getFormClassType()) {
            $lines[] = '/**';
            $lines[] = ' * @param array $arguments Arguments to pass down to the ParentFormConstructor method';
            $lines[] = ' * ';
            $lines[] = ' * @return ' . ($this->getForeignEntity()->getHasForm() ? $this->getForeignEntity()->getName() . 'Type' : 'null');
            $lines[] = ' */';
            $lines[] = 'protected function get' . $this->getUpperName() . 'FieldParentFormConstructor($arguments)';
            $lines[] = '{';

            if ('Entity' === $this->getFormClassType()) {
                $lines[] = 'return ' . ($this->getForeignEntity()->getHasForm() ? 'new ' . $this->getForeignEntity()->getName() . 'Type()' : 'null') . ';';
            } elseif ('Collection' === $this->getFormClassType()) {
                $lines[] = 'return new ' . $this->getForeignEntity()->getName() . 'Type();';
            }

            $lines[] = '}';
            $lines[] = '';
        }

        $lines[] = '    /**';

        if ('Entity' === $this->getFormClassType() || 'Collection' === $this->getFormClassType()) {
            $lines[] = ' * @param array $arguments Arguments to pass down to the ParentFormConstructor method';
            $lines[] = ' * ';
        }

        $lines[] = ' * @return ' . $this->getFormClassType() . "\n";
        $lines[] = ' */';
        $lines[] = 'public function get' . $this->getUpperName() . 'Field(' . ('Entity' === $this->getFormClassType() || 'Collection' === $this->getFormClassType() ? '$arguments = []' : '') . ')';
        $lines[] = '{';
        $lines[] =     'return new ' . $this->getFormClassType() . '(';
        $lines[] =         '\'' . $this->name . '\'';

        $properties = [];

        $properties[] = '[\'id\' => \'' . $formName . '_' . $this->getName() . '\']';
        $properties[] = '[\'renderEngine\' => \'twig\']';

        if(!$this->autoIncrement) {
            if(!$this->getNull() && $this->type !== 'boolean' && $this->getFormClassType() !== 'Collection') {
                $properties[] = '[\'required\' => \'' . $this->getRequiredMessage() . '\']';
            }

            if (null !== $this->minSize) {
                if ($this->size != $this->minSize) {
                    $properties[] = '[\'minSize\' => ' . $this->getMinSize() . ']';
                    $properties[] = '[\'minSizeMessage\' => \'' . $this->getMinMessage() . '\']';
                } else {
                    $properties[] = '[\'exactSize\' => ' . $this->getSize() . ']';
                    $properties[] = '[\'exactSize\' => \'' . $this->getExactMessage() . '\']';
                }
            }

            if ( (null === $this->getMinSize() && null !== $this->getSize()) || $this->getSize() !== $this->getMinSize()) {
                $properties[] = '[\'maxSize\' => ' . $this->getSize() . ']';
                $properties[] = '[\'maxSizeMessage\' => \'' . $this->getMaxMessage() . '\']';
            }

            if ('Entity' === $this->getFormClassType() && null !== $this->getForeignEntity()) {
                if ('ManyToMany' === $this->getForeign()) {
                    $properties[] = '[\'symfonyMultiple\' => true] // ' . $this->getForeign();
                } elseif ('ManyToOne' === $this->getForeign()) {
                    $properties[] = '[\'symfonyMultiple\' => false] // ' . $this->getForeign();
                }
            }

            if (null !== $this->getMin()) {
                $properties[] = '[\'min\' => ' . $this->getMin() . ']';
            }

            if (null !== $this->getMax()) {
                $properties[] = '[\'max\' => ' . $this->getMax() . ']';
            }
        }

        if (count($properties) > 0) {
            $lines[count($lines) - 1] .= ',';

            switch ($this->getFormClassType()) {
                case 'Entity':
                    $lines[] = '\'' . $this->getForeignEntity()->getModule() . ':' . $this->getForeignEntity()->getName() . '\',';
                    $lines[] = '$this->get' . $this->getUpperName() . 'FieldParentFormConstructor($arguments),';
                    break;
                case 'Collection':
                    $lines[] = '$this->get' . $this->getUpperName() . 'FieldParentFormConstructor($arguments),';
                    break;
                default:
                    $lines[] = 'null,';
                    break;
            }

            for ($i = 0; $i < count($properties) - 1; $i++) {
                $properties[$i] .= ',';
            }

            $lines = array_merge($lines, $properties);

            $lines[] = '';
        }

        $lines[] =     ');';
        $lines[] = '}';

        return $lines;
    }

    public function getFormClassLinesBasic($formName)
    {
        $lines = [];

        if ('Entity' === $this->getFormClassType() || 'Collection' === $this->getFormClassType()) {
            $lines[] = '/**';
            $lines[] = ' * @param array $arguments Arguments to pass down to the ParentFormConstructor method';
            $lines[] = ' * ';
            $lines[] = ' * @return ' . ($this->getForeignEntity()->getHasForm() ? $this->getForeignEntity()->getName() . 'Type' : 'null');
            $lines[] = ' */';
            $lines[] = 'protected function get' . $this->getUpperName() . 'FieldParentFormConstructor($arguments)';
            $lines[] = '{';

            if ('Entity' === $this->getFormClassType()) {
                $lines[] = 'return ' . ($this->getForeignEntity()->getHasForm() ? 'new ' . $this->getForeignEntity()->getName() . 'Type()' : 'null') . ';';
            } elseif ('Collection' === $this->getFormClassType()) {
                $lines[] = 'return new ' . $this->getForeignEntity()->getName() . 'Type();';
            }

            $lines[] = '}';
            $lines[] = '';
        }

        $lines[] = '    /**';

        if ('Entity' === $this->getFormClassType() || 'Collection' === $this->getFormClassType()) {
            $lines[] = ' * @param array $arguments Arguments to pass down to the ParentFormConstructor method';
            $lines[] = ' * ';
        }

        $lines[] = ' * @return array';
        $lines[] = ' */';
        $lines[] = 'public function get' . $this->getUpperName() . 'Field(' . ('Entity' === $this->getFormClassType() || 'Collection' === $this->getFormClassType() ? '$arguments = []' : '') . ')';
        $lines[] = '{';
        $lines[] =     'return [';
        $lines[] =         '\'name\' => \'' . $this->getName() . '\',';

        $lines[] = '\'type\' => \'' . $this->getFormClassTypeBasic() . '\',';

        $properties = [];

        if(!$this->autoIncrement) {
            if(!$this->getNull() && $this->type !== 'boolean' && $this->getFormClassType() !== 'Collection') {
                $properties[] = '\'required\' => true,';
            }

//            if (null !== $this->minSize) {
//                if ($this->size != $this->minSize) {
//                    $properties[] = '\'min_length\' => ' . $this->getMinSize() . ',';
//                } else {
//                    $properties[] = '\'exactSize\' => ' . $this->getSize() . ',';
//                }
//            }

            if ( (null === $this->getMinSize() && null !== $this->getSize()) || $this->getSize() !== $this->getMinSize()) {
                $properties[] = '\'max_length\' => ' . $this->getSize() . ',';
            }

            if ('Entity' === $this->getFormClassType() && null !== $this->getForeignEntity()) {
                if ('ManyToMany' === $this->getForeign()) {
                    $properties[] = '\'multiple\' => true, // ' . $this->getForeign();
                } elseif ('ManyToOne' === $this->getForeign()) {
                    $properties[] = '\'multiple\' => false, // ' . $this->getForeign();
                }
            }

//            if (null !== $this->getMin()) {
//                $properties[] = '\'min\' => ' . $this->getMin() . ',';
//            }
//
//            if (null !== $this->getMax()) {
//                $properties[] = '\'max\' => ' . $this->getMax() . ',';
//            }
        }


//        switch ($this->getFormClassType()) {
//            case 'Entity':
//                $lines[] = '\'' . $this->getForeignEntity()->getModule() . ':' . $this->getForeignEntity()->getName() . '\',';
//                $lines[] = '$this->get' . $this->getUpperName() . 'FieldParentFormConstructor($arguments),';
//                break;
//            case 'Collection':
//                $lines[] = '$this->get' . $this->getUpperName() . 'FieldParentFormConstructor($arguments),';
//                break;
//            default:
//                $lines[] = 'null,';
//                break;
//        }

        $lines[] = '\'options\' => [';

        $lines = array_merge($lines, $properties);

        $lines[] = '\'error_bubbling\' => true';

        $lines[] = ']';

        $lines[] =     '];';
        $lines[] = '}';

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
