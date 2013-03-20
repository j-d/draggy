<?php
// Draggy\Autocode\Base\Attribute.php

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

namespace Draggy\Autocode\Base;

use Draggy\Autocode\Attribute;
use Draggy\Autocode\Entity;

/**
 * Draggy\Autocode\Entity\Base\Attribute
 */
abstract class AttributeBase
{
    // <editor-fold desc="Attributes">
    /**
     * @var Entity $entity
     */
    protected $entity;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $type
     */
    protected $type;

    /**
     * @var string $subtype
     */
    protected $subtype = null;

    /**
     * @var boolean $primary
     */
    protected $primary = false;

    /**
     * @var integer $size
     */
    protected $size = null;

    /**
     * @var integer $minSize
     */
    protected $minSize = null;

    /**
     * @var integer $min
     */
    protected $min = null;

    /**
     * @var integer $max
     */
    protected $max = null;

    /**
     * @var string $minSizeMessage
     */
    protected $minSizeMessage = '';

    /**
     * @var string $maxSizeMessage
     */
    protected $maxSizeMessage = '';

    /**
     * @var string $exactSizeMessage
     */
    protected $exactSizeMessage = '';

    /**
     * @var string $minMessage
     */
    protected $minMessage = '';

    /**
     * @var string $maxMessage
     */
    protected $maxMessage = '';

    /**
     * @var boolean $null
     */
    protected $null = false;

    /**
     * @var string $description
     */
    protected $description = null;

    /**
     * @var boolean $unique
     */
    protected $unique = false;

    /**
     * @var boolean $autoIncrement
     */
    protected $autoIncrement = false;

    /**
     * @var string $defaultValue
     */
    protected $defaultValue = null;

    /**
     * @var string $foreign
     */
    protected $foreign = null;

    /**
     * @var Entity $foreignEntity
     */
    protected $foreignEntity = null;

    /**
     * @var Attribute $foreignKey
     */
    protected $foreignKey = null;

    /**
     * @var boolean $foreignTick
     */
    protected $foreignTick = false;

    /**
     * @var string $manyToManyEntityName
     */
    protected $manyToManyEntityName = null;

    /**
     * @var boolean $getter
     */
    protected $getter = true;

    /**
     * @var boolean $setter
     */
    protected $setter = true;

    /**
     * @var boolean $email
     */
    protected $email = false;

    /**
     * @var boolean $ownerSide
     */
    protected $ownerSide = false;

    /**
     * @var Attribute $reverseAttribute
     */
    protected $reverseAttribute = null;

    /**
     * @var boolean $static
     */
    protected $static = false;

    /**
     * @var boolean $inverse
     */
    protected $inverse = false;

    // </editor-fold>

    // <editor-fold desc="Setters and getters">
    /**
     * Set entity
     *
     * @param Entity $entity
     *
     * @return Attribute
     */
    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setName($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The attribute name on the class Attribute has to be string (' . gettype($name) . ('object' === gettype($name) ? ' ' . get_class($name) : '') . ' given).');
        }

        if (strlen($name) < 1) {
            throw new \InvalidArgumentException('On the attribute name, the length of the string ' . $name . ' is ' . strlen($name) . ' which is shorter than the minimum allowed (1).');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setType($type)
    {
        if (!is_string($type)) {
            throw new \InvalidArgumentException('The attribute type on the class Attribute has to be string (' . gettype($type) . ('object' === gettype($type) ? ' ' . get_class($type) : '') . ' given).');
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set subtype
     *
     * @param string|null $subtype
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setSubtype($subtype)
    {
        if (!is_string($subtype) && null !== $subtype) {
            throw new \InvalidArgumentException('The attribute subtype on the class Attribute has to be string or null (' . gettype($subtype) . ('object' === gettype($subtype) ? ' ' . get_class($subtype) : '') . ' given).');
        }

        $this->subtype = $subtype;

        return $this;
    }

    /**
     * Get subtype
     *
     * @return string|null
     */
    public function getSubtype()
    {
        return $this->subtype;
    }

    /**
     * Set primary
     *
     * @param boolean $primary
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setPrimary($primary)
    {
        if (!is_bool($primary)) {
            throw new \InvalidArgumentException('The attribute primary on the class Attribute has to be boolean (' . gettype($primary) . ('object' === gettype($primary) ? ' ' . get_class($primary) : '') . ' given).');
        }

        $this->primary = $primary;

        return $this;
    }

    /**
     * Get primary
     *
     * @return boolean
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setSize($size)
    {
        if (!is_int($size)) {
            throw new \InvalidArgumentException('The attribute size on the class Attribute has to be integer (' . gettype($size) . ('object' === gettype($size) ? ' ' . get_class($size) : '') . ' given).');
        }

        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set minSize
     *
     * @param integer $minSize
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setMinSize($minSize)
    {
        if (!is_int($minSize)) {
            throw new \InvalidArgumentException('The attribute minSize on the class Attribute has to be integer (' . gettype($minSize) . ('object' === gettype($minSize) ? ' ' . get_class($minSize) : '') . ' given).');
        }

        $this->minSize = $minSize;

        return $this;
    }

    /**
     * Get minSize
     *
     * @return integer
     */
    public function getMinSize()
    {
        return $this->minSize;
    }

    /**
     * Set min
     *
     * @param integer $min
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setMin($min)
    {
        if (!is_int($min)) {
            throw new \InvalidArgumentException('The attribute min on the class Attribute has to be integer (' . gettype($min) . ('object' === gettype($min) ? ' ' . get_class($min) : '') . ' given).');
        }

        $this->min = $min;

        return $this;
    }

    /**
     * Get min
     *
     * @return integer
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set max
     *
     * @param integer $max
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setMax($max)
    {
        if (!is_int($max)) {
            throw new \InvalidArgumentException('The attribute max on the class Attribute has to be integer (' . gettype($max) . ('object' === gettype($max) ? ' ' . get_class($max) : '') . ' given).');
        }

        $this->max = $max;

        return $this;
    }

    /**
     * Get max
     *
     * @return integer
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Set minSizeMessage
     *
     * @param string $minSizeMessage
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setMinSizeMessage($minSizeMessage)
    {
        if (!is_string($minSizeMessage)) {
            throw new \InvalidArgumentException('The attribute minSizeMessage on the class Attribute has to be string (' . gettype($minSizeMessage) . ('object' === gettype($minSizeMessage) ? ' ' . get_class($minSizeMessage) : '') . ' given).');
        }

        $this->minSizeMessage = $minSizeMessage;

        return $this;
    }

    /**
     * Get minSizeMessage
     *
     * @return string
     */
    public function getMinSizeMessage()
    {
        return $this->minSizeMessage;
    }

    /**
     * Set maxSizeMessage
     *
     * @param string $maxSizeMessage
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setMaxSizeMessage($maxSizeMessage)
    {
        if (!is_string($maxSizeMessage)) {
            throw new \InvalidArgumentException('The attribute maxSizeMessage on the class Attribute has to be string (' . gettype($maxSizeMessage) . ('object' === gettype($maxSizeMessage) ? ' ' . get_class($maxSizeMessage) : '') . ' given).');
        }

        $this->maxSizeMessage = $maxSizeMessage;

        return $this;
    }

    /**
     * Get maxSizeMessage
     *
     * @return string
     */
    public function getMaxSizeMessage()
    {
        return $this->maxSizeMessage;
    }

    /**
     * Set exactSizeMessage
     *
     * @param string $exactSizeMessage
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setExactSizeMessage($exactSizeMessage)
    {
        if (!is_string($exactSizeMessage)) {
            throw new \InvalidArgumentException('The attribute exactSizeMessage on the class Attribute has to be string (' . gettype($exactSizeMessage) . ('object' === gettype($exactSizeMessage) ? ' ' . get_class($exactSizeMessage) : '') . ' given).');
        }

        $this->exactSizeMessage = $exactSizeMessage;

        return $this;
    }

    /**
     * Get exactSizeMessage
     *
     * @return string
     */
    public function getExactSizeMessage()
    {
        return $this->exactSizeMessage;
    }

    /**
     * Set minMessage
     *
     * @param string $minMessage
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setMinMessage($minMessage)
    {
        if (!is_string($minMessage)) {
            throw new \InvalidArgumentException('The attribute minMessage on the class Attribute has to be string (' . gettype($minMessage) . ('object' === gettype($minMessage) ? ' ' . get_class($minMessage) : '') . ' given).');
        }

        $this->minMessage = $minMessage;

        return $this;
    }

    /**
     * Get minMessage
     *
     * @return string
     */
    public function getMinMessage()
    {
        return $this->minMessage;
    }

    /**
     * Set maxMessage
     *
     * @param string $maxMessage
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setMaxMessage($maxMessage)
    {
        if (!is_string($maxMessage)) {
            throw new \InvalidArgumentException('The attribute maxMessage on the class Attribute has to be string (' . gettype($maxMessage) . ('object' === gettype($maxMessage) ? ' ' . get_class($maxMessage) : '') . ' given).');
        }

        $this->maxMessage = $maxMessage;

        return $this;
    }

    /**
     * Get maxMessage
     *
     * @return string
     */
    public function getMaxMessage()
    {
        return $this->maxMessage;
    }

    /**
     * Set null
     *
     * @param boolean $null
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setNull($null)
    {
        if (!is_bool($null)) {
            throw new \InvalidArgumentException('The attribute null on the class Attribute has to be boolean (' . gettype($null) . ('object' === gettype($null) ? ' ' . get_class($null) : '') . ' given).');
        }

        $this->null = $null;

        return $this;
    }

    /**
     * Get null
     *
     * @return boolean
     */
    public function getNull()
    {
        return $this->null;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setDescription($description)
    {
        if (!is_string($description)) {
            throw new \InvalidArgumentException('The attribute description on the class Attribute has to be string (' . gettype($description) . ('object' === gettype($description) ? ' ' . get_class($description) : '') . ' given).');
        }

        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set unique
     *
     * @param boolean $unique
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setUnique($unique)
    {
        if (!is_bool($unique)) {
            throw new \InvalidArgumentException('The attribute unique on the class Attribute has to be boolean (' . gettype($unique) . ('object' === gettype($unique) ? ' ' . get_class($unique) : '') . ' given).');
        }

        $this->unique = $unique;

        return $this;
    }

    /**
     * Get unique
     *
     * @return boolean
     */
    public function getUnique()
    {
        return $this->unique;
    }

    /**
     * Set autoIncrement
     *
     * @param boolean $autoIncrement
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setAutoIncrement($autoIncrement)
    {
        if (!is_bool($autoIncrement)) {
            throw new \InvalidArgumentException('The attribute autoIncrement on the class Attribute has to be boolean (' . gettype($autoIncrement) . ('object' === gettype($autoIncrement) ? ' ' . get_class($autoIncrement) : '') . ' given).');
        }

        $this->autoIncrement = $autoIncrement;

        return $this;
    }

    /**
     * Get autoIncrement
     *
     * @return boolean
     */
    public function getAutoIncrement()
    {
        return $this->autoIncrement;
    }

    /**
     * Set defaultValue
     *
     * @param string $defaultValue
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setDefaultValue($defaultValue)
    {
        if (!is_string($defaultValue)) {
            throw new \InvalidArgumentException('The attribute defaultValue on the class Attribute has to be string (' . gettype($defaultValue) . ('object' === gettype($defaultValue) ? ' ' . get_class($defaultValue) : '') . ' given).');
        }

        $this->defaultValue = $defaultValue;

        return $this;
    }

    /**
     * Get defaultValue
     *
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Set foreign
     *
     * @param string|null $foreign
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setForeign($foreign)
    {
        if (!is_string($foreign) && null !== $foreign) {
            throw new \InvalidArgumentException('The attribute foreign on the class Attribute has to be string or null (' . gettype($foreign) . ('object' === gettype($foreign) ? ' ' . get_class($foreign) : '') . ' given).');
        }

        $this->foreign = $foreign;

        return $this;
    }

    /**
     * Get foreign
     *
     * @return string|null
     */
    public function getForeign()
    {
        return $this->foreign;
    }

    /**
     * Get foreignEntity
     *
     * @return Entity|null
     */
    public function getForeignEntity()
    {
        return $this->foreignEntity;
    }

    /**
     * Set foreignKey
     *
     * @param Attribute|null $foreignKey
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setForeignKey($foreignKey)
    {
        if (!$foreignKey instanceof Attribute && null !== $foreignKey) {
            throw new \InvalidArgumentException('The attribute foreignKey on the class Attribute has to be Attribute or null (' . gettype($foreignKey) . ('object' === gettype($foreignKey) ? ' ' . get_class($foreignKey) : '') . ' given).');
        }

        $this->foreignKey = $foreignKey;

        return $this;
    }

    /**
     * Get foreignKey
     *
     * @return Attribute|null
     */
    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    /**
     * Set foreignTick
     *
     * @param boolean $foreignTick
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setForeignTick($foreignTick)
    {
        if (!is_bool($foreignTick)) {
            throw new \InvalidArgumentException('The attribute foreignTick on the class Attribute has to be boolean (' . gettype($foreignTick) . ('object' === gettype($foreignTick) ? ' ' . get_class($foreignTick) : '') . ' given).');
        }

        $this->foreignTick = $foreignTick;

        return $this;
    }

    /**
     * Get foreignTick
     *
     * @return boolean
     */
    public function getForeignTick()
    {
        return $this->foreignTick;
    }

    /**
     * Set manyToManyEntityName
     *
     * @param string $manyToManyEntityName
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setManyToManyEntityName($manyToManyEntityName)
    {
        if (!is_string($manyToManyEntityName)) {
            throw new \InvalidArgumentException('The attribute manyToManyEntityName on the class Attribute has to be string (' . gettype($manyToManyEntityName) . ('object' === gettype($manyToManyEntityName) ? ' ' . get_class($manyToManyEntityName) : '') . ' given).');
        }

        $this->manyToManyEntityName = $manyToManyEntityName;

        return $this;
    }

    /**
     * Get manyToManyEntityName
     *
     * @return string
     */
    public function getManyToManyEntityName()
    {
        return $this->manyToManyEntityName;
    }

    /**
     * Set getter
     *
     * @param boolean $getter
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setGetter($getter)
    {
        if (!is_bool($getter)) {
            throw new \InvalidArgumentException('The attribute getter on the class Attribute has to be boolean (' . gettype($getter) . ('object' === gettype($getter) ? ' ' . get_class($getter) : '') . ' given).');
        }

        $this->getter = $getter;

        return $this;
    }

    /**
     * Get getter
     *
     * @return boolean
     */
    public function getGetter()
    {
        return $this->getter;
    }

    /**
     * Set setter
     *
     * @param boolean $setter
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setSetter($setter)
    {
        if (!is_bool($setter)) {
            throw new \InvalidArgumentException('The attribute setter on the class Attribute has to be boolean (' . gettype($setter) . ('object' === gettype($setter) ? ' ' . get_class($setter) : '') . ' given).');
        }

        $this->setter = $setter;

        return $this;
    }

    /**
     * Get setter
     *
     * @return boolean
     */
    public function getSetter()
    {
        return $this->setter;
    }

    /**
     * Set email
     *
     * @param boolean $email
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setEmail($email)
    {
        if (!is_bool($email)) {
            throw new \InvalidArgumentException('The attribute email on the class Attribute has to be boolean (' . gettype($email) . ('object' === gettype($email) ? ' ' . get_class($email) : '') . ' given).');
        }

        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return boolean
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set ownerSide
     *
     * @param boolean $ownerSide
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setOwnerSide($ownerSide)
    {
        if (!is_bool($ownerSide)) {
            throw new \InvalidArgumentException('The attribute ownerSide on the class Attribute has to be boolean (' . gettype($ownerSide) . ('object' === gettype($ownerSide) ? ' ' . get_class($ownerSide) : '') . ' given).');
        }

        $this->ownerSide = $ownerSide;

        return $this;
    }

    /**
     * Get ownerSide
     *
     * @return boolean
     */
    public function getOwnerSide()
    {
        return $this->ownerSide;
    }

    /**
     * Get reverseAttribute
     *
     * @return Attribute|null
     */
    public function getReverseAttribute()
    {
        return $this->reverseAttribute;
    }

    /**
     * Set static
     *
     * @param boolean $static
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setStatic($static)
    {
        if (!is_bool($static)) {
            throw new \InvalidArgumentException('The attribute static on the class Attribute has to be boolean (' . gettype($static) . ('object' === gettype($static) ? ' ' . get_class($static) : '') . ' given).');
        }

        $this->static = $static;

        return $this;
    }

    /**
     * Get static
     *
     * @return boolean
     */
    public function getStatic()
    {
        return $this->static;
    }

    /**
     * Set inverse
     *
     * @param boolean $inverse
     *
     * @return Attribute
     *
     * @throws \InvalidArgumentException
     */
    public function setInverse($inverse)
    {
        if (!is_bool($inverse)) {
            throw new \InvalidArgumentException('The attribute inverse on the class Attribute has to be boolean (' . gettype($inverse) . ('object' === gettype($inverse) ? ' ' . get_class($inverse) : '') . ' given).');
        }

        $this->inverse = $inverse;

        return $this;
    }

    /**
     * Get inverse
     *
     * @return boolean
     */
    public function getInverse()
    {
        return $this->inverse;
    }

    // </editor-fold>

    // <editor-fold desc="Other methods">
    /**
     * Attribute to string (Default)
     *
     * @return string
     */
    public function __toString()
    {
        return 'Attribute';
    }
    // </editor-fold>
}