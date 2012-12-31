<?php
// Autocode\Base\Entity.php

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

namespace Autocode\Base;

use Autocode\Entity;
use Autocode\Attribute;
use Autocode\Project;

/**
 * Autocode\Entity\Base\Entity
 */
abstract class EntityCodeBase2
{
    // <editor-fold desc="Attributes">
    /**
     * @var string $namespace
     */
    protected $namespace;

    /**
     * @var string $module
     */
    protected $module;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $description
     */
    protected $description = null;

    /**
     * @var Attribute[] $attributes
     */
    protected $attributes = [];

    /**
     * @var string[] $attributeNames
     */
    protected $attributeNames = [];

    /**
     * @var Attribute[] $primaryAttributes
     */
    protected $primaryAttributes = [];

    /**
     * @var boolean $renderizable
     */
    protected $renderizable = true;

    /**
     * @var Attribute $toString
     */
    protected $toString = null;

    /**
     * @var Entity $parentEntity
     */
    protected $parentEntity = null;

    /**
     * @var Entity[] $childrenEntities
     */
    protected $childrenEntities = [];

    /**
     * @var boolean $hasRepository
     */
    protected $hasRepository = false;

    /**
     * @var boolean $hasForm
     */
    protected $hasForm = false;

    /**
     * @var boolean $hasController
     */
    protected $hasController = false;

    /**
     * @var boolean $hasFixtures
     */
    protected $hasFixtures = false;

    /**
     * @var string $crud
     */
    protected $crud = null;

    /**
     * @var Project $project
     */
    protected $project;

    // </editor-fold>

    // <editor-fold desc="Setters and getters">
    /**
     * Set namespace
     *
     * @param string $namespace
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setNamespace($namespace)
    {
        if (!is_string($namespace)) {
            throw new \InvalidArgumentException('The attribute namespace on the class Entity has to be a string.');
        } elseif (strlen($namespace) < 1) {
            throw new \InvalidArgumentException('On the attribute namespace, the length of the string ' . $namespace . ' is ' . strlen($namespace) . ' which is shorter than the minimum allowed (1).');
        }

        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set module
     *
     * @param string $module
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setModule($module)
    {
        if (!is_string($module)) {
            throw new \InvalidArgumentException('The attribute module on the class Entity has to be a string.');
        }

        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setName($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The attribute name on the class Entity has to be a string.');
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
     * Set description
     *
     * @param string $description
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setDescription($description)
    {
        if (!is_string($description)) {
            throw new \InvalidArgumentException('The attribute description on the class Entity has to be a string.');
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
     * Set attributes
     *
     * @param Attribute[] $attributes
     *
     * @return Entity
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Add attribute
     *
     * @param Attribute $attribute
     *
     * @return Entity
     */
    public function addAttribute(Attribute $attribute)
    {
        $this->attributes[] = $attribute;

        return $this;
    }

    /**
     * Add attributes
     *
     * @param Attribute[] $attributes
     *
     * @return Entity
     */
    public function addAttributes(array $attributes)
    {
        foreach ($attributes as $attribute) {
            $this->attributes[] = $attribute;
        }

        return $this;
    }

    /**
     * Remove attribute
     *
     * @param Attribute $attribute
     *
     * @return Entity
     */
    public function removeAttribute(Attribute $attribute)
    {
        foreach ($this->attributes as $key => $attributeElement) {
            if ($attributeElement === $attribute) {
                unset($this->attributes[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Remove attributes
     *
     * @param Attribute[] $attributes
     *
     * @return Entity
     */
    public function removeAttributes(array $attributes)
    {
        foreach ($attributes as $attribute) {
            $this->removeAttribute($attribute);
        }

        return $this;
    }

    /**
     * Get attributes
     *
     * @return Attribute[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set attributeNames
     *
     * @param string[] $attributeNames
     *
     * @return Entity
     */
    public function setAttributeNames(array $attributeNames)
    {
        $this->attributeNames = $attributeNames;

        return $this;
    }

    /**
     * Add attributeName
     *
     * @param string $attributeName
     *
     * @return Entity
     */
    public function addAttributeName($attributeName)
    {
        $this->attributeNames[] = $attributeName;

        return $this;
    }

    /**
     * Add attributeNames
     *
     * @param string[] $attributeNames
     *
     * @return Entity
     */
    public function addAttributeNames(array $attributeNames)
    {
        foreach ($attributeNames as $attributeName) {
            $this->attributeNames[] = $attributeName;
        }

        return $this;
    }

    /**
     * Remove attributeName
     *
     * @param string $attributeName
     *
     * @return Entity
     */
    public function removeAttributeName($attributeName)
    {
        foreach ($this->attributeNames as $key => $attributeNameElement) {
            if ($attributeNameElement === $attributeName) {
                unset($this->attributeNames[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Remove attributeNames
     *
     * @param string[] $attributeNames
     *
     * @return Entity
     */
    public function removeAttributeNames(array $attributeNames)
    {
        foreach ($attributeNames as $attributeName) {
            $this->removeAttributeName($attributeName);
        }

        return $this;
    }

    /**
     * Get attributeNames
     *
     * @return string[]
     */
    public function getAttributeNames()
    {
        return $this->attributeNames;
    }

    /**
     * Set primaryAttributes
     *
     * @param Attribute[] $primaryAttributes
     *
     * @return Entity
     */
    public function setPrimaryAttributes(array $primaryAttributes)
    {
        $this->primaryAttributes = $primaryAttributes;

        return $this;
    }

    /**
     * Add primaryAttribute
     *
     * @param Attribute $primaryAttribute
     *
     * @return Entity
     */
    public function addPrimaryAttribute(Attribute $primaryAttribute)
    {
        $this->primaryAttributes[] = $primaryAttribute;

        return $this;
    }

    /**
     * Add primaryAttributes
     *
     * @param Attribute[] $primaryAttributes
     *
     * @return Entity
     */
    public function addPrimaryAttributes(array $primaryAttributes)
    {
        foreach ($primaryAttributes as $primaryAttribute) {
            $this->primaryAttributes[] = $primaryAttribute;
        }

        return $this;
    }

    /**
     * Remove primaryAttribute
     *
     * @param Attribute $primaryAttribute
     *
     * @return Entity
     */
    public function removePrimaryAttribute(Attribute $primaryAttribute)
    {
        foreach ($this->primaryAttributes as $key => $primaryAttributeElement) {
            if ($primaryAttributeElement === $primaryAttribute) {
                unset($this->primaryAttributes[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Remove primaryAttributes
     *
     * @param Attribute[] $primaryAttributes
     *
     * @return Entity
     */
    public function removePrimaryAttributes(array $primaryAttributes)
    {
        foreach ($primaryAttributes as $primaryAttribute) {
            $this->removePrimaryAttribute($primaryAttribute);
        }

        return $this;
    }

    /**
     * Get primaryAttributes
     *
     * @return Attribute[]
     */
    public function getPrimaryAttributes()
    {
        return $this->primaryAttributes;
    }

    /**
     * Set renderizable
     *
     * @param boolean $renderizable
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setRenderizable($renderizable)
    {
        if (!is_bool($renderizable)) {
            throw new \InvalidArgumentException('The attribute renderizable on the class Entity has to be boolean.');
        }

        $this->renderizable = $renderizable;

        return $this;
    }

    /**
     * Get renderizable
     *
     * @return boolean
     */
    public function getRenderizable()
    {
        return $this->renderizable;
    }

    /**
     * Set toString
     *
     * @param Attribute|null $toString
     *
     * @return Entity
     */
    public function setToString($toString)
    {
        $this->toString = $toString;

        return $this;
    }

    /**
     * Get toString
     *
     * @return Attribute
     */
    public function getToString()
    {
        return $this->toString;
    }

    /**
     * Set parentEntity
     *
     * @param Entity|null $parentEntity
     *
     * @return Entity
     */
    public function setParentEntity($parentEntity)
    {
        $this->parentEntity = $parentEntity;

        return $this;
    }

    /**
     * Get parentEntity
     *
     * @return Entity
     */
    public function getParentEntity()
    {
        return $this->parentEntity;
    }

    /**
     * Set childrenEntities
     *
     * @param Entity[] $childrenEntities
     *
     * @return Entity
     */
    public function setChildrenEntities(array $childrenEntities)
    {
        $this->childrenEntities = $childrenEntities;

        return $this;
    }

    /**
     * Add childrenEntity
     *
     * @param Entity $childrenEntity
     *
     * @return Entity
     */
    public function addChildrenEntity(Entity $childrenEntity)
    {
        $this->childrenEntities[] = $childrenEntity;

        return $this;
    }

    /**
     * Add childrenEntities
     *
     * @param Entity[] $childrenEntities
     *
     * @return Entity
     */
    public function addChildrenEntities(array $childrenEntities)
    {
        foreach ($childrenEntities as $childrenEntity) {
            $this->childrenEntities[] = $childrenEntity;
        }

        return $this;
    }

    /**
     * Remove childrenEntity
     *
     * @param Entity $childrenEntity
     *
     * @return Entity
     */
    public function removeChildrenEntity(Entity $childrenEntity)
    {
        foreach ($this->childrenEntities as $key => $childrenEntityElement) {
            if ($childrenEntityElement === $childrenEntity) {
                unset($this->childrenEntities[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Remove childrenEntities
     *
     * @param Entity[] $childrenEntities
     *
     * @return Entity
     */
    public function removeChildrenEntities(array $childrenEntities)
    {
        foreach ($childrenEntities as $childrenEntity) {
            $this->removeChildrenEntity($childrenEntity);
        }

        return $this;
    }

    /**
     * Get childrenEntities
     *
     * @return Entity[]
     */
    public function getChildrenEntities()
    {
        return $this->childrenEntities;
    }

    /**
     * Set hasRepository
     *
     * @param boolean $hasRepository
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setHasRepository($hasRepository)
    {
        if (!is_bool($hasRepository)) {
            throw new \InvalidArgumentException('The attribute hasRepository on the class Entity has to be boolean.');
        }

        $this->hasRepository = $hasRepository;

        return $this;
    }

    /**
     * Get hasRepository
     *
     * @return boolean
     */
    public function getHasRepository()
    {
        return $this->hasRepository;
    }

    /**
     * Set hasForm
     *
     * @param boolean $hasForm
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setHasForm($hasForm)
    {
        if (!is_bool($hasForm)) {
            throw new \InvalidArgumentException('The attribute hasForm on the class Entity has to be boolean.');
        }

        $this->hasForm = $hasForm;

        return $this;
    }

    /**
     * Get hasForm
     *
     * @return boolean
     */
    public function getHasForm()
    {
        return $this->hasForm;
    }

    /**
     * Set hasController
     *
     * @param boolean $hasController
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setHasController($hasController)
    {
        if (!is_bool($hasController)) {
            throw new \InvalidArgumentException('The attribute hasController on the class Entity has to be boolean.');
        }

        $this->hasController = $hasController;

        return $this;
    }

    /**
     * Get hasController
     *
     * @return boolean
     */
    public function getHasController()
    {
        return $this->hasController;
    }

    /**
     * Set hasFixtures
     *
     * @param boolean $hasFixtures
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setHasFixtures($hasFixtures)
    {
        if (!is_bool($hasFixtures)) {
            throw new \InvalidArgumentException('The attribute hasFixtures on the class Entity has to be boolean.');
        }

        $this->hasFixtures = $hasFixtures;

        return $this;
    }

    /**
     * Get hasFixtures
     *
     * @return boolean
     */
    public function getHasFixtures()
    {
        return $this->hasFixtures;
    }

    /**
     * Set crud
     *
     * @param string $crud
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setCrud($crud)
    {
        if (!is_string($crud)) {
            throw new \InvalidArgumentException('The attribute crud on the class Entity has to be a string.');
        }

        $this->crud = $crud;

        return $this;
    }

    /**
     * Get crud
     *
     * @return string
     */
    public function getCrud()
    {
        return $this->crud;
    }

    /**
     * Set project
     *
     * @param Project $project
     *
     * @return Entity
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    // </editor-fold>

    // <editor-fold desc="Other methods">
    /**
     * Entity to string (Default)
     *
     * @return string
     */
    public function __toString()
    {
        return 'Entity';
    }
    // </editor-fold>
}