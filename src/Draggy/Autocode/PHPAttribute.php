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
        'string' => 'string',
        'boolean' => 'boolean',
        'integer' => 'integer',
        'smallint' => 'integer',
        'bigint' => 'integer',
        'text' => 'string',
        'date' => '\\DateTime',
        'time' => '\\DateTime',
        'datetime' => '\\DateTime',
        'array' => 'array',
        'decimal' => 'float',
        'object' => 'ERROR'
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
    // </user-additions>
    // </editor-fold>
}