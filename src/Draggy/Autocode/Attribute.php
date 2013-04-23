<?php
// Draggy\Autocode\Attribute.php

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

use Draggy\Autocode\Base\AttributeBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Entity\Attribute
 */
abstract class Attribute extends AttributeBase
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    public static $SYMFONY_VARS = [
        'string'   => 'string',
        'boolean' => 'boolean',
        'integer' => 'integer',
        'smallint' => 'integer',
        'bigint' => 'integer',
        'text' => 'string',
        'date' => 'object',
        'time' => 'object',
        'datetime' => 'object',
        'array' => 'array',
        'decimal' => 'float',
        'object' => 'ERROR'
    ];

    public static $BASIC_TYPES = [
        'string',
        'boolean',
        'integer',
        'smallint',
        'bigint',
        'text',
        'date',
        'time',
        'datetime',
        'array',
        'decimal',
        'object',
    ];
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Constructor">
    // <user-additions part="constructorDeclaration">
    public function __construct(Entity $entity, $name, $type)
    // </user-additions>
    {
        // <user-additions part="constructor">
        if (!$entity->getProject()->isValidAttributeName($name)) {
            throw new \RuntimeException('The column name \'' . $name . '\' on the entity ' . $entity->getName() . ' cannot be used because is a reserved word.');
        }

        if (!is_string($name) || strlen($name) < 1) {
            throw new \InvalidArgumentException('Attribute name on the entity ' . $entity->getName() . ' has to be a string and can\'t be the empty string');
        }

        if (!isset(self::$SYMFONY_VARS[$type])) {
            throw new \InvalidArgumentException('Type of the column ' . $name . ' is not known (' . $type . ')');
        }

        $this->setEntity($entity);
        $this->setName($name);
        $this->setType($type);
        // </user-additions>
    }
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
    public function getLowerName()
    {
        return strtolower($this->name[0]) . substr($this->name, 1);
    }

    public function getUpperName()
    {
        return strtoupper($this->name[0]) . substr($this->name, 1);
    }

    public function getHumanName()
    {
        return strtoupper($this->name[0]) . substr(preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $' . '0', $this->name), 1);
    }

    public function getSingleName()
    {
        if (substr($this->getName(),-3) == 'ies')
            return substr($this->getName(),0,-3) . 'y';
        elseif (substr($this->getName(),-3) == 'ves')
            return substr($this->getName(),0,-3) . 'f';
        elseif (substr($this->getName(),-1) == 's')
            return substr($this->getName(),0,-1);
        else
            return $this->getName() . 'Single';
        //throw new \RuntimeException('Doesn\'t know how to calculate the singular of ' . $this->getName());
    }

    public function getSingleUpperName()
    {
        $upperName = $this->getSingleName();

        return strtoupper($upperName[0]) . substr($upperName,1);
    }

    public function getMaxMessage()
    {
        return $this->getHumanName() . ' is too long. It should have ' . $this->getSize() . ' characters or less.';
    }

    public function getMinMessage()
    {
        return $this->getHumanName() . ' is too short. It should have ' . $this->getMinSize() . ' characters or more.';
    }

    public function getExactMessage()
    {
        return $this->getHumanName() . ' should have exactly ' . $this->getSize() . ' characters.';
    }

    public function getRequiredMessage()
    {
        return $this->getHumanName() . ' should not be blank.';
    }

    public function getTypeMessage()
    {
        return $this->getHumanName() . ' should be of type ' . $this->getType() . '.';
    }

    public function getUniqueMessage()
    {
        return 'That ' . $this->getHumanName() . ' is not valid because has already been used.';
    }

    public function setForeign($foreign)
    {
        if (!in_array($foreign, ['ManyToOne', 'OneToOne', 'ManyToMany']))
            throw new \InvalidArgumentException('Foreign has to be one of the preset values');

        $this->foreign = $foreign;

        return $this;
    }

    /**
     * @return Entity
     */
    public function &getForeignEntity()
    {
        return $this->foreignEntity;
    }

    public function getSymfonyType()
    {
        if (is_null($this->getForeign())) {
            return self::$SYMFONY_VARS[$this->getType()];
        } else {
            if ($this->getForeign() !== 'ManyToMany') {
                return 'object';
            } else {
                return 'array'; // TODO: Check
            }
        }
    }

    public function setReverseAttribute(Attribute &$reverseAttribute)
    {
        $this->reverseAttribute = $reverseAttribute;

        return $this;
    }
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    public function isEntitySubtype()
    {
        return $this->getSubtype() !== null && !in_array($this->getSubtype(), self::$BASIC_TYPES);
    }

    public function getEntitySubtype()
    {
        if ($this->isEntitySubtype()) {
            return $this->getEntity()->getProject()->getEntityByFullyQualifiedName($this->getSubtype());
        } else {
            throw new \RuntimeException('Tried to get a class subtype when is not a class subtype.');
        }
    }

    public function setForeignEntity(Entity &$foreignEntity)
    {
        $this->foreignEntity = $foreignEntity;

        return $this;
    }

    public function getSettingFromInverse()
    {
        return null !== $this->getForeign() && !$this->getOwnerSide();
    }

    public function describe()
    {
        $ret = $this->entity->getName() . '\\' . $this->name . "\n";

        $ret .= 'UpperName = ' . $this->getUpperName() . "\n";
        $ret .= 'LowerName = ' . $this->getLowerName() . "\n";
        $ret .= 'Type = ' . $this->type . "\n";

        $ret .= 'Primary? ' . ($this->primary ? 'Yes' : 'No') . "\n";
        $ret .= 'Null? ' . ($this->null ? 'Yes' : 'No') . "\n";
        $ret .= 'Unique? ' . ($this->unique ? 'Yes' : 'No') . "\n";
        $ret .= 'AutoIncrement? ' . ($this->autoIncrement ? 'Yes' : 'No') . "\n";
        $ret .= 'ForeignTick? ' . ($this->foreignTick ? 'Yes' : 'No') . "\n";
        $ret .= 'Getter? ' . ($this->getter ? 'Yes' : 'No') . "\n";
        $ret .= 'Setter? ' . ($this->setter ? 'Yes' : 'No') . "\n";
        $ret .= 'OwnerSide? ' . ($this->ownerSide ? 'Yes' : 'No') . "\n";

        $ret .= 'Size = ' . $this->size . "\n";
        $ret .= 'Description = ' . $this->description . "\n";
        $ret .= 'DefaultValue = ' . $this->defaultValue . "\n";
        $ret .= 'Foreign = ' . $this->foreign . "\n";
        $ret .= 'ForeignEntity = ' . ($this->foreignEntity == null ? '' : $this->foreignEntity->getName()) . "\n";
        $ret .= 'ForeignKey = ' . ($this->foreignKey == null ? '' : $this->foreignKey->getName()) . "\n";
        $ret .= 'ReverseAttribute = ' . ($this->reverseAttribute == null ? '' : $this->reverseAttribute->getName()) . "\n";

        return $ret;
    }

    public function getFormClassType()
    {
        switch ($this->type) {
            case 'boolean':
                $type = 'Checkbox';
                break;
            case 'integer':
            case 'smallint':
                $type = 'Number';
                break;
            case 'date':
            case 'datetime':
                $type = 'Date';
                break;
            default:
                $type = 'Input';
        }

        if ($this->email) {
            $type = 'Email';
        }

        if (null !== $this->foreignEntity) {
            $type = $this->getOwnerSide()
                ? 'Entity'
                : 'Collection';
        }

        return $type;
    }

    public function getFormClass($formName)
    {
        $ret = '';

        $ret .= '    /**' . "\n";
        $ret .= '     * @return ' . $this->getFormClassType() . "\n";
        $ret .= '     */' . "\n";
        $ret .= '    public function get' . $this->getUpperName() . 'Field()' . "\n";
        $ret .= '    {' . "\n";
        $ret .= '        return new ' . $this->getFormClassType() . '(\'' . $this->name . '\'';

        $properties = [];

        $properties[] = '            [\'id\' => \'' . $formName . '_' . $this->name . '\']';
        $properties[] = '            [\'renderMode\' => \'twig\']';

        if(!$this->autoIncrement) {
            if(!$this->null && $this->type !== 'boolean' && $this->getFormClassType() !== 'Collection') {
                $properties[] = '            [\'required\' => \'' . $this->getRequiredMessage() . '\']';
            }

            if (!is_null($this->minSize)) {
                if ($this->size != $this->minSize) {
                    $properties[] = '            [\'minSize\' => ' . $this->minSize . ']';
                    $properties[] = '            [\'minSizeMessage\' => \'' . $this->getMinMessage() . '\']';
                } else {
                    $properties[] = '            [\'exactSize\' => ' . $this->size . ']';
                    $properties[] = '            [\'exactSize\' => \'' . $this->getExactMessage() . '\']';
                }
            }

            if ( (is_null($this->minSize) && !is_null($this->size)) || $this->size != $this->minSize) {
                $properties[] = '            [\'maxSize\' => ' . $this->size . ']';
                $properties[] = '            [\'maxSizeMessage\' => \'' . $this->getMaxMessage() . '\']';
            }

            if ($this->getFormClassType() === 'Entity' && null !== $this->getForeignEntity()) {
                if ($this->getForeign() == 'ManyToMany') {
                    $properties[] = '            [\'symfonyMultiple\' => true] // ' . $this->getForeign();
                } elseif ($this->getForeign() == 'ManyToOne') {
                    $properties[] = '            [\'symfonyMultiple\' => false] // ' . $this->getForeign();
                }
            }

            // Is already done on the type collection by default
            //if ($this->getFormClassType() === 'Collection') {
            //    $properties[] = '                [\'symfonyByReference\' => false]';
            //}

            if (!is_null($this->min)) {
                $properties[] = '        [\'min\' => ' . $this->min . ']';
            }

            if (!is_null($this->max)) {
                $properties[] = '        [\'max\' => ' . $this->max . ']';
            }
        }

        if (count($properties) > 0) {
            switch ($this->getFormClassType()) {
                case 'Entity':
                    $ret .= ', \'' . $this->getForeignEntity()->getModule() . ':' . $this->getForeignEntity()->getName() . '\', ' . ($this->getForeignEntity()->getHasForm() ? 'new ' . $this->getForeignEntity()->getName() . 'Type()' : 'null') . ',' . "\n";
                    break;
                case 'Collection':
                    $ret .= ', new ' . $this->getForeignEntity()->getName() . 'Type(),' . "\n";
                    break;
                default:
                    $ret .= ', null,' . "\n";
                    break;
            }

            $ret .= implode(',' . "\n", $properties);
            $ret .= "\n";
            $ret .= '        ';
        }

        $ret .= ');' . "\n";
        $ret .= '    }' . "\n";


        return $ret;
    }

    public function getSetterName()
    {
        return 'set' . $this->getUpperName();
    }

    public function getGetterName()
    {
        return 'get' . $this->getUpperName();
    }
    // </user-additions>
    // </editor-fold>
}