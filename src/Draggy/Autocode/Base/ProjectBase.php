<?php
// Draggy\Autocode\Base\Project.php

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

use Draggy\Autocode\Project;
use Draggy\Autocode\Entity;
use Draggy\Autocode\Templates\EntityTemplate;
use Draggy\Autocode\Templates\PHPEntityTemplate;

/**
 * Draggy\Autocode\Entity\Base\Project
 */
abstract class ProjectBase
{
    // <editor-fold desc="Attributes">
    /**
     * @var Entity[] $entities
     */
    protected $entities = [];

    /**
     * @var string $log
     */
    protected $log = '';

    /**
     * @var string[] $modules
     */
    protected $modules = [];

    /**
     * @var string[] $moduleEntities
     */
    protected $moduleEntities = [];

    /**
     * @var string[] $moduleNamespaces
     */
    protected $moduleNamespaces = [];

    /**
     * @var string $language
     */
    protected $language = 'php';

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var string $orm
     */
    protected $orm = 'doctrine2';

    /**
     * @var string $framework
     */
    protected $framework = 'symfony2';

    /**
     * @var string $attributeClass
     */
    protected $attributeClass = '';

    /**
     * @var string $entityClass
     */
    protected $entityClass = '';
    // </editor-fold>

    // <editor-fold desc="Setters and getters">
    /**
     * Set entities
     *
     * @param Entity[] $entities
     *
     * @return Project
     */
    public function setEntities(array $entities)
    {
        $this->entities = $entities;

        return $this;
    }

    /**
     * Add entity
     *
     * @param Entity $entity
     *
     * @return Project
     */
    public function addEntity(Entity $entity)
    {
        $this->entities[] = $entity;

        return $this;
    }

    /**
     * Add entities
     *
     * @param Entity[] $entities
     *
     * @return Project
     */
    public function addEntities(array $entities)
    {
        foreach ($entities as $entity) {
            $this->entities[] = $entity;
        }

        return $this;
    }

    /**
     * Contains entity
     *
     * @param Entity $entity
     *
     * @return bool
     */
    public function containsEntity(Entity $entity)
    {
        return $this->entities->contains($entity);
    }

    /**
     * Contains entities
     *
     * @param Entity[] $entities
     *
     * @return bool
     */
    public function containsEntities(array $entities)
    {
        foreach ($entities as $entity) {
            if (!$this->entities->contains($entity)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Remove entity
     *
     * @param Entity $entity
     *
     * @return Project
     */
    public function removeEntity(Entity $entity)
    {
        foreach ($this->entities as $key => $entityElement) {
            if ($entityElement === $entity) {
                unset($this->entities[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Remove entities
     *
     * @param Entity[] $entities
     *
     * @return Project
     */
    public function removeEntities(array $entities)
    {
        foreach ($entities as $entity) {
            $this->removeEntity($entity);
        }

        return $this;
    }

    /**
     * Get entities
     *
     * @return Entity[]
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * Set log
     *
     * @param string $log
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setLog($log)
    {
        if (!is_string($log)) {
            throw new \InvalidArgumentException('The attribute log on the class Project has to be string (' . gettype($log) . ('object' === gettype($log) ? ' ' . get_class($log) : '') . ' given).');
        }

        $this->log = $log;

        return $this;
    }

    /**
     * Get log
     *
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set modules
     *
     * @param string[] $modules
     *
     * @return Project
     */
    public function setModules(array $modules)
    {
        $this->modules = $modules;

        return $this;
    }

    /**
     * Add module
     *
     * @param string $module
     *
     * @return Project
     */
    public function addModule($module)
    {
        $this->modules[] = $module;

        return $this;
    }

    /**
     * Add modules
     *
     * @param string[] $modules
     *
     * @return Project
     */
    public function addModules(array $modules)
    {
        foreach ($modules as $module) {
            $this->modules[] = $module;
        }

        return $this;
    }

    /**
     * Contains module
     *
     * @param string $module
     *
     * @return bool
     */
    public function containsModule($module)
    {
        return $this->modules->contains($module);
    }

    /**
     * Contains modules
     *
     * @param string[] $modules
     *
     * @return bool
     */
    public function containsModules(array $modules)
    {
        foreach ($modules as $module) {
            if (!$this->modules->contains($module)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Remove module
     *
     * @param string $module
     *
     * @return Project
     */
    public function removeModule($module)
    {
        foreach ($this->modules as $key => $moduleElement) {
            if ($moduleElement === $module) {
                unset($this->modules[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Remove modules
     *
     * @param string[] $modules
     *
     * @return Project
     */
    public function removeModules(array $modules)
    {
        foreach ($modules as $module) {
            $this->removeModule($module);
        }

        return $this;
    }

    /**
     * Get modules
     *
     * @return string[]
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Set moduleEntities
     *
     * @param string[] $moduleEntities
     *
     * @return Project
     */
    public function setModuleEntities(array $moduleEntities)
    {
        $this->moduleEntities = $moduleEntities;

        return $this;
    }

    /**
     * Add moduleEntity
     *
     * @param string $moduleEntity
     *
     * @return Project
     */
    public function addModuleEntity($moduleEntity)
    {
        $this->moduleEntities[] = $moduleEntity;

        return $this;
    }

    /**
     * Add moduleEntities
     *
     * @param string[] $moduleEntities
     *
     * @return Project
     */
    public function addModuleEntities(array $moduleEntities)
    {
        foreach ($moduleEntities as $moduleEntity) {
            $this->moduleEntities[] = $moduleEntity;
        }

        return $this;
    }

    /**
     * Contains moduleEntity
     *
     * @param string $moduleEntity
     *
     * @return bool
     */
    public function containsModuleEntity($moduleEntity)
    {
        return $this->moduleEntities->contains($moduleEntity);
    }

    /**
     * Contains moduleEntities
     *
     * @param string[] $moduleEntities
     *
     * @return bool
     */
    public function containsModuleEntities(array $moduleEntities)
    {
        foreach ($moduleEntities as $moduleEntity) {
            if (!$this->moduleEntities->contains($moduleEntity)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Remove moduleEntity
     *
     * @param string $moduleEntity
     *
     * @return Project
     */
    public function removeModuleEntity($moduleEntity)
    {
        foreach ($this->moduleEntities as $key => $moduleEntityElement) {
            if ($moduleEntityElement === $moduleEntity) {
                unset($this->moduleEntities[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Remove moduleEntities
     *
     * @param string[] $moduleEntities
     *
     * @return Project
     */
    public function removeModuleEntities(array $moduleEntities)
    {
        foreach ($moduleEntities as $moduleEntity) {
            $this->removeModuleEntity($moduleEntity);
        }

        return $this;
    }

    /**
     * Get moduleEntities
     *
     * @return string[]
     */
    public function getModuleEntities()
    {
        return $this->moduleEntities;
    }

    /**
     * Set moduleNamespaces
     *
     * @param string[] $moduleNamespaces
     *
     * @return Project
     */
    public function setModuleNamespaces(array $moduleNamespaces)
    {
        $this->moduleNamespaces = $moduleNamespaces;

        return $this;
    }

    /**
     * Add moduleNamespace
     *
     * @param string $moduleNamespace
     *
     * @return Project
     */
    public function addModuleNamespace($moduleNamespace)
    {
        $this->moduleNamespaces[] = $moduleNamespace;

        return $this;
    }

    /**
     * Add moduleNamespaces
     *
     * @param string[] $moduleNamespaces
     *
     * @return Project
     */
    public function addModuleNamespaces(array $moduleNamespaces)
    {
        foreach ($moduleNamespaces as $moduleNamespace) {
            $this->moduleNamespaces[] = $moduleNamespace;
        }

        return $this;
    }

    /**
     * Contains moduleNamespace
     *
     * @param string $moduleNamespace
     *
     * @return bool
     */
    public function containsModuleNamespace($moduleNamespace)
    {
        return $this->moduleNamespaces->contains($moduleNamespace);
    }

    /**
     * Contains moduleNamespaces
     *
     * @param string[] $moduleNamespaces
     *
     * @return bool
     */
    public function containsModuleNamespaces(array $moduleNamespaces)
    {
        foreach ($moduleNamespaces as $moduleNamespace) {
            if (!$this->moduleNamespaces->contains($moduleNamespace)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Remove moduleNamespace
     *
     * @param string $moduleNamespace
     *
     * @return Project
     */
    public function removeModuleNamespace($moduleNamespace)
    {
        foreach ($this->moduleNamespaces as $key => $moduleNamespaceElement) {
            if ($moduleNamespaceElement === $moduleNamespace) {
                unset($this->moduleNamespaces[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Remove moduleNamespaces
     *
     * @param string[] $moduleNamespaces
     *
     * @return Project
     */
    public function removeModuleNamespaces(array $moduleNamespaces)
    {
        foreach ($moduleNamespaces as $moduleNamespace) {
            $this->removeModuleNamespace($moduleNamespace);
        }

        return $this;
    }

    /**
     * Get moduleNamespaces
     *
     * @return string[]
     */
    public function getModuleNamespaces()
    {
        return $this->moduleNamespaces;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setLanguage($language)
    {
        if (!is_string($language)) {
            throw new \InvalidArgumentException('The attribute language on the class Project has to be string (' . gettype($language) . ('object' === gettype($language) ? ' ' . get_class($language) : '') . ' given).');
        }

        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setDescription($description)
    {
        if (!is_string($description)) {
            throw new \InvalidArgumentException('The attribute description on the class Project has to be string (' . gettype($description) . ('object' === gettype($description) ? ' ' . get_class($description) : '') . ' given).');
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
     * Set orm
     *
     * @param string $orm
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setOrm($orm)
    {
        if (!is_string($orm)) {
            throw new \InvalidArgumentException('The attribute orm on the class Project has to be string (' . gettype($orm) . ('object' === gettype($orm) ? ' ' . get_class($orm) : '') . ' given).');
        }

        $this->orm = $orm;

        return $this;
    }

    /**
     * Get orm
     *
     * @return string
     */
    public function getOrm()
    {
        return $this->orm;
    }

    /**
     * Set framework
     *
     * @param string $framework
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setFramework($framework)
    {
        if (!is_string($framework)) {
            throw new \InvalidArgumentException('The attribute framework on the class Project has to be string (' . gettype($framework) . ('object' === gettype($framework) ? ' ' . get_class($framework) : '') . ' given).');
        }

        $this->framework = $framework;

        return $this;
    }

    /**
     * Get framework
     *
     * @return string
     */
    public function getFramework()
    {
        return $this->framework;
    }

    /**
     * Set attributeClass
     *
     * @param string $attributeClass
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setAttributeClass($attributeClass)
    {
        if (!is_string($attributeClass)) {
            throw new \InvalidArgumentException('The attribute attributeClass on the class Project has to be string (' . gettype($attributeClass) . ('object' === gettype($attributeClass) ? ' ' . get_class($attributeClass) : '') . ' given).');
        }

        $this->attributeClass = $attributeClass;

        return $this;
    }

    /**
     * Get attributeClass
     *
     * @return string
     */
    public function getAttributeClass()
    {
        return $this->attributeClass;
    }

    /**
     * Set entityClass
     *
     * @param string $entityClass
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setEntityClass($entityClass)
    {
        if (!is_string($entityClass)) {
            throw new \InvalidArgumentException('The attribute entityClass on the class Project has to be string (' . gettype($entityClass) . ('object' === gettype($entityClass) ? ' ' . get_class($entityClass) : '') . ' given).');
        }

        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * Get entityClass
     *
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }
    // </editor-fold>

    // <editor-fold desc="Other methods">
    /**
     * Project to string (Default)
     *
     * @return string
     */
    public function __toString()
    {
        return 'Project';
    }
    // </editor-fold>
}
