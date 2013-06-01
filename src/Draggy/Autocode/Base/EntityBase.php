<?php
// Draggy\Autocode\Base\Entity.php

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

use Draggy\Autocode\Entity;
use Draggy\Autocode\Attribute;
use Draggy\Autocode\Project;

/**
 * Draggy\Autocode\Entity\Base\Entity
 */
abstract class EntityBase
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
     * @var string $toString
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
     * @var boolean $hasRoutes
     */
    protected $hasRoutes = false;

    /**
     * @var Project $project
     */
    protected $project;

    /**
     * @var boolean $hasConstructor
     */
    protected $hasConstructor = false;

    /**
     * @var boolean $arrayAccess
     */
    protected $arrayAccess;

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
            throw new \InvalidArgumentException('The attribute namespace on the class Entity has to be string (' . gettype($namespace) . ('object' === gettype($namespace) ? ' ' . get_class($namespace) : '') . ' given).');
        }

        if (strlen($namespace) < 1) {
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
            throw new \InvalidArgumentException('The attribute module on the class Entity has to be string (' . gettype($module) . ('object' === gettype($module) ? ' ' . get_class($module) : '') . ' given).');
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
            throw new \InvalidArgumentException('The attribute name on the class Entity has to be string (' . gettype($name) . ('object' === gettype($name) ? ' ' . get_class($name) : '') . ' given).');
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
            throw new \InvalidArgumentException('The attribute description on the class Entity has to be string (' . gettype($description) . ('object' === gettype($description) ? ' ' . get_class($description) : '') . ' given).');
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
     * Contains attribute
     *
     * @param Attribute $attribute
     *
     * @return bool
     */
    public function containsAttribute(Attribute $attribute)
    {
        return $this->attributes->contains($attribute);
    }

    /**
     * Contains attributes
     *
     * @param Attribute[] $attributes
     *
     * @return bool
     */
    public function containsAttributes(array $attributes)
    {
        foreach ($attributes as $attribute) {
            if (!$this->attributes->contains($attribute)) {
                return false;
            }
        }

        return true;
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
     * Contains attributeName
     *
     * @param string $attributeName
     *
     * @return bool
     */
    public function containsAttributeName($attributeName)
    {
        return $this->attributeNames->contains($attributeName);
    }

    /**
     * Contains attributeNames
     *
     * @param string[] $attributeNames
     *
     * @return bool
     */
    public function containsAttributeNames(array $attributeNames)
    {
        foreach ($attributeNames as $attributeName) {
            if (!$this->attributeNames->contains($attributeName)) {
                return false;
            }
        }

        return true;
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
     * Contains primaryAttribute
     *
     * @param Attribute $primaryAttribute
     *
     * @return bool
     */
    public function containsPrimaryAttribute(Attribute $primaryAttribute)
    {
        return $this->primaryAttributes->contains($primaryAttribute);
    }

    /**
     * Contains primaryAttributes
     *
     * @param Attribute[] $primaryAttributes
     *
     * @return bool
     */
    public function containsPrimaryAttributes(array $primaryAttributes)
    {
        foreach ($primaryAttributes as $primaryAttribute) {
            if (!$this->primaryAttributes->contains($primaryAttribute)) {
                return false;
            }
        }

        return true;
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
            throw new \InvalidArgumentException('The attribute renderizable on the class Entity has to be boolean (' . gettype($renderizable) . ('object' === gettype($renderizable) ? ' ' . get_class($renderizable) : '') . ' given).');
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
     * @param string|null $toString
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setToString($toString)
    {
        if (!is_string($toString) && null !== $toString) {
            throw new \InvalidArgumentException('The attribute toString on the class Entity has to be string or null (' . gettype($toString) . ('object' === gettype($toString) ? ' ' . get_class($toString) : '') . ' given).');
        }

        $this->toString = $toString;

        return $this;
    }

    /**
     * Get toString
     *
     * @return string|null
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
     *
     * @throws \InvalidArgumentException
     */
    public function setParentEntity($parentEntity)
    {
        if (!$parentEntity instanceof Entity && null !== $parentEntity) {
            throw new \InvalidArgumentException('The attribute parentEntity on the class Entity has to be Entity or null (' . gettype($parentEntity) . ('object' === gettype($parentEntity) ? ' ' . get_class($parentEntity) : '') . ' given).');
        }

        $this->parentEntity = $parentEntity;

        return $this;
    }

    /**
     * Get parentEntity
     *
     * @return Entity|null
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
     * Contains childrenEntity
     *
     * @param Entity $childrenEntity
     *
     * @return bool
     */
    public function containsChildrenEntity(Entity $childrenEntity)
    {
        return $this->childrenEntities->contains($childrenEntity);
    }

    /**
     * Contains childrenEntities
     *
     * @param Entity[] $childrenEntities
     *
     * @return bool
     */
    public function containsChildrenEntities(array $childrenEntities)
    {
        foreach ($childrenEntities as $childrenEntity) {
            if (!$this->childrenEntities->contains($childrenEntity)) {
                return false;
            }
        }

        return true;
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
            throw new \InvalidArgumentException('The attribute hasRepository on the class Entity has to be boolean (' . gettype($hasRepository) . ('object' === gettype($hasRepository) ? ' ' . get_class($hasRepository) : '') . ' given).');
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
            throw new \InvalidArgumentException('The attribute hasForm on the class Entity has to be boolean (' . gettype($hasForm) . ('object' === gettype($hasForm) ? ' ' . get_class($hasForm) : '') . ' given).');
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
            throw new \InvalidArgumentException('The attribute hasController on the class Entity has to be boolean (' . gettype($hasController) . ('object' === gettype($hasController) ? ' ' . get_class($hasController) : '') . ' given).');
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
            throw new \InvalidArgumentException('The attribute hasFixtures on the class Entity has to be boolean (' . gettype($hasFixtures) . ('object' === gettype($hasFixtures) ? ' ' . get_class($hasFixtures) : '') . ' given).');
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
            throw new \InvalidArgumentException('The attribute crud on the class Entity has to be string (' . gettype($crud) . ('object' === gettype($crud) ? ' ' . get_class($crud) : '') . ' given).');
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
     * Set hasRoutes
     *
     * @param boolean $hasRoutes
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setHasRoutes($hasRoutes)
    {
        if (!is_bool($hasRoutes)) {
            throw new \InvalidArgumentException('The attribute hasRoutes on the class Entity has to be boolean (' . gettype($hasRoutes) . ('object' === gettype($hasRoutes) ? ' ' . get_class($hasRoutes) : '') . ' given).');
        }

        $this->hasRoutes = $hasRoutes;

        return $this;
    }

    /**
     * Get hasRoutes
     *
     * @return boolean
     */
    public function getHasRoutes()
    {
        return $this->hasRoutes;
    }

    /**
     * Set project
     *
     * @param Project $project
     *
     * @return Entity
     */
    public function setProject(Project $project)
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

    /**
     * Set hasConstructor
     *
     * @param boolean $hasConstructor
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setHasConstructor($hasConstructor)
    {
        if (!is_bool($hasConstructor)) {
            throw new \InvalidArgumentException('The attribute hasConstructor on the class Entity has to be boolean (' . gettype($hasConstructor) . ('object' === gettype($hasConstructor) ? ' ' . get_class($hasConstructor) : '') . ' given).');
        }

        $this->hasConstructor = $hasConstructor;

        return $this;
    }

    /**
     * Get hasConstructor
     *
     * @return boolean
     */
    public function getHasConstructor()
    {
        return $this->hasConstructor;
    }

    /**
     * Set arrayAccess
     *
     * @param boolean $arrayAccess
     *
     * @return Entity
     *
     * @throws \InvalidArgumentException
     */
    public function setArrayAccess($arrayAccess)
    {
        if (!is_bool($arrayAccess)) {
            throw new \InvalidArgumentException('The attribute arrayAccess on the class Entity has to be boolean (' . gettype($arrayAccess) . ('object' === gettype($arrayAccess) ? ' ' . get_class($arrayAccess) : '') . ' given).');
        }

        $this->arrayAccess = $arrayAccess;

        return $this;
    }

    /**
     * Get arrayAccess
     *
     * @return boolean
     */
    public function getArrayAccess()
    {
        return $this->arrayAccess;
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
