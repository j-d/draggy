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
        'boolean'  => 'boolean',
        'integer'  => 'integer',
        'smallint' => 'integer',
        'bigint'   => 'integer',
        'text'     => 'string',
        'date'     => 'object',
        'time'     => 'object',
        'datetime' => 'object',
        'array'    => 'array',
        'decimal'  => 'float',
        'object'   => 'ERROR'
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
    public function getFullName()
    {
        return $this->getName() . $this->getSuffix();
    }

    public function getLowerName()
    {
        return lcfirst($this->name);
    }

    public function getLowerFullName()
    {
        return lcfirst($this->getFullName());
    }

    public function getUpperName()
    {
        return ucfirst($this->name);
    }

    public function getUpperFullName()
    {
        return ucfirst($this->getFullName());
    }

    public function getHumanName()
    {
        return strtoupper($this->name[0]) . substr(preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $' . '0', $this->name), 1);
    }

    public function getSingleName()
    {
        return Project::singlelise($this->getName());
    }

    public function getSingleUpperName()
    {
        return ucfirst($this->getSingleName());
    }

    public function getPluralName()
    {
        return Project::pluralise($this->getName());
    }

    public function getPluralUpperName()
    {
        return ucfirst($this->getPluralName());
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
                $type = 'Date';
                break;
            case 'datetime':
                $type = 'DateTime';
                break;
            case 'time':
                $type = 'Time';
                break;
            case 'text':
                $type = 'Textarea';
                break;
            default:
                $type = 'Input';
        }

        if ($this->getEmail()) {
            $type = 'Email';
        }

        if (null !== $this->foreignEntity) {
            $type = $this->getOwnerSide()
                ? 'Entity'
                : 'Collection';
        }

        return $type;
    }

    public function getFormClassTypeBasic()
    {
        switch ($this->type) {
            case 'boolean':
                $type = 'checkbox';
                break;
            case 'integer':
            case 'smallint':
                $type = 'number';
                break;
            case 'date':
                $type = 'date';
                break;
            case 'datetime':
                $type = 'datetime';
                break;
            case 'time':
                $type = 'time';
                break;
            case 'text':
                $type = 'textarea';
                break;
            default:
                $type = 'text';
        }

        if ($this->getEmail()) {
            $type = 'email';
        }

        if (null !== $this->foreignEntity) {
            $type = $this->getOwnerSide()
                ? 'entity'
                : 'collection';
        }

        return $type;
    }

    public function getSetterName()
    {
        return 'set' . $this->getUpperName() . $this->getSuffix();
    }

    public function getClearName()
    {
        return 'clear' . $this->getUpperName() . $this->getSuffix();
    }

    public function getGetterName()
    {
        return 'get' . $this->getUpperName() . $this->getSuffix();
    }

    public function getSingleAdderName()
    {
        return 'add' . $this->getSingleUpperName() . $this->getSuffix();
    }

    public function getMultipleAdderName()
    {
        return 'add' . $this->getUpperName() . $this->getSuffix();
    }

    public function getSingleRemoverName()
    {
        return 'remove' . $this->getSingleUpperName() . $this->getSuffix();
    }

    public function getMultipleRemoverName()
    {
        return 'remove' . $this->getUpperName() . $this->getSuffix();
    }

    public function getSingleContainsName()
    {
        return 'contains' . $this->getSingleUpperName() . $this->getSuffix();
    }

    public function getMultipleContainsName()
    {
        return 'contains' . $this->getUpperName() . $this->getSuffix();
    }
    // </user-additions>
    // </editor-fold>
}
