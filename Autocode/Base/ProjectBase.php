<?php
// Autocode\Base\Project.php

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

use Autocode\Project;
use Autocode\Entity;
use Autocode\Templates\EntityTemplate;

/**
 * Autocode\Entity\Base\Project
 */
abstract class ProjectBase
{
    // <editor-fold desc="Attributes">
    /**
     * @var string $namespace
     */
    protected $namespace;

    /**
     * @var Entity[] $entities
     */
    protected $entities = [];

    /**
     * @var string $log
     */
    protected $log = '';

    /**
     * @var boolean $base
     */
    protected $base = false;

    /**
     * @var boolean $overwrite
     */
    protected $overwrite = false;

    /**
     * @var boolean $deleteUnmapped
     */
    protected $deleteUnmapped = false;

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
    protected $language = 'PHP';

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var string $orm
     */
    protected $orm = 'Doctrine2';

    /**
     * @var string $framework
     */
    protected $framework;

    /**
     * @var boolean $validation
     */
    protected $validation;

    /**
     * @var string $attributeClass
     */
    protected $attributeClass = '';

    /**
     * @var string $entityClass
     */
    protected $entityClass = '';

    /**
     * @var EntityTemplate $entityTemplate
     */
    protected $entityTemplate = null;

    /**
     * @var EntityTemplate $entityBaseTemplate
     */
    protected $entityBaseTemplate = null;

    /**
     * @var EntityTemplate $repositoryTemplate
     */
    protected $repositoryTemplate = null;

    /**
     * @var EntityTemplate $formTemplate
     */
    protected $formTemplate = null;

    /**
     * @var EntityTemplate $formBaseTemplate
     */
    protected $formBaseTemplate = null;

    /**
     * @var EntityTemplate $controllerTemplate
     */
    protected $controllerTemplate = null;

    /**
     * @var EntityTemplate $fixturesTemplate
     */
    protected $fixturesTemplate = null;

    /**
     * @var EntityTemplate $routesTemplate
     */
    protected $routesTemplate = null;

    /**
     * @var EntityTemplate $routesRoutingTemplate
     */
    protected $routesRoutingTemplate = null;

    /**
     * @var EntityTemplate $crudCreateTwigTemplate
     */
    protected $crudCreateTwigTemplate = null;

    /**
     * @var EntityTemplate $crudReadTwigTemplate
     */
    protected $crudReadTwigTemplate = null;

    /**
     * @var EntityTemplate $crudUpdateTwigTemplate
     */
    protected $crudUpdateTwigTemplate = null;

    // </editor-fold>

    // <editor-fold desc="Setters and getters">
    /**
     * Set namespace
     *
     * @param string $namespace
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setNamespace($namespace)
    {
        if (!is_string($namespace)) {
            throw new \InvalidArgumentException('The attribute namespace on the class Project has to be string (' . gettype($namespace) . ('object' === gettype($namespace) ? ' ' . get_class($namespace) : '') . ' given).');
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
     * Set entities
     *
     * @param array $entities
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
     * @param bool $allowRepeatedValues
     *
     * @return Project
     */
    public function addEntity(Entity $entity, $allowRepeatedValues = true)
    {
        if ($allowRepeatedValues || !$this->entities->contains($entity)) {
            $this->entities[] = $entity;
        }

        return $this;
    }

    /**
     * Add entities
     *
     * @param Entity[] $entities
     * @param bool $allowRepeatedValues
     *
     * @return Project
     */
    public function addEntities(array $entities, $allowRepeatedValues = true)
    {
        foreach ($entities as $entity) {
            if ($allowRepeatedValues || !$this->entities->contains($entity)) {
                $this->entities[] = $entity;
            }
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
     * @return array
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
     * Set base
     *
     * @param boolean $base
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setBase($base)
    {
        if (!is_bool($base)) {
            throw new \InvalidArgumentException('The attribute base on the class Project has to be boolean (' . gettype($base) . ('object' === gettype($base) ? ' ' . get_class($base) : '') . ' given).');
        }

        $this->base = $base;

        return $this;
    }

    /**
     * Get base
     *
     * @return boolean
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Set overwrite
     *
     * @param boolean $overwrite
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setOverwrite($overwrite)
    {
        if (!is_bool($overwrite)) {
            throw new \InvalidArgumentException('The attribute overwrite on the class Project has to be boolean (' . gettype($overwrite) . ('object' === gettype($overwrite) ? ' ' . get_class($overwrite) : '') . ' given).');
        }

        $this->overwrite = $overwrite;

        return $this;
    }

    /**
     * Get overwrite
     *
     * @return boolean
     */
    public function getOverwrite()
    {
        return $this->overwrite;
    }

    /**
     * Set deleteUnmapped
     *
     * @param boolean $deleteUnmapped
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setDeleteUnmapped($deleteUnmapped)
    {
        if (!is_bool($deleteUnmapped)) {
            throw new \InvalidArgumentException('The attribute deleteUnmapped on the class Project has to be boolean (' . gettype($deleteUnmapped) . ('object' === gettype($deleteUnmapped) ? ' ' . get_class($deleteUnmapped) : '') . ' given).');
        }

        $this->deleteUnmapped = $deleteUnmapped;

        return $this;
    }

    /**
     * Get deleteUnmapped
     *
     * @return boolean
     */
    public function getDeleteUnmapped()
    {
        return $this->deleteUnmapped;
    }

    /**
     * Set modules
     *
     * @param array $modules
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
     * @param bool $allowRepeatedValues
     *
     * @return Project
     */
    public function addModule($module, $allowRepeatedValues = true)
    {
        if ($allowRepeatedValues || !$this->modules->contains($module)) {
            $this->modules[] = $module;
        }

        return $this;
    }

    /**
     * Add modules
     *
     * @param string[] $modules
     * @param bool $allowRepeatedValues
     *
     * @return Project
     */
    public function addModules(array $modules, $allowRepeatedValues = true)
    {
        foreach ($modules as $module) {
            if ($allowRepeatedValues || !$this->modules->contains($module)) {
                $this->modules[] = $module;
            }
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
     * @return array
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Set moduleEntities
     *
     * @param array $moduleEntities
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
     * @param bool $allowRepeatedValues
     *
     * @return Project
     */
    public function addModuleEntity($moduleEntity, $allowRepeatedValues = true)
    {
        if ($allowRepeatedValues || !$this->moduleEntities->contains($moduleEntity)) {
            $this->moduleEntities[] = $moduleEntity;
        }

        return $this;
    }

    /**
     * Add moduleEntities
     *
     * @param string[] $moduleEntities
     * @param bool $allowRepeatedValues
     *
     * @return Project
     */
    public function addModuleEntities(array $moduleEntities, $allowRepeatedValues = true)
    {
        foreach ($moduleEntities as $moduleEntity) {
            if ($allowRepeatedValues || !$this->moduleEntities->contains($moduleEntity)) {
                $this->moduleEntities[] = $moduleEntity;
            }
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
     * @return array
     */
    public function getModuleEntities()
    {
        return $this->moduleEntities;
    }

    /**
     * Set moduleNamespaces
     *
     * @param array $moduleNamespaces
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
     * @param bool $allowRepeatedValues
     *
     * @return Project
     */
    public function addModuleNamespace($moduleNamespace, $allowRepeatedValues = true)
    {
        if ($allowRepeatedValues || !$this->moduleNamespaces->contains($moduleNamespace)) {
            $this->moduleNamespaces[] = $moduleNamespace;
        }

        return $this;
    }

    /**
     * Add moduleNamespaces
     *
     * @param string[] $moduleNamespaces
     * @param bool $allowRepeatedValues
     *
     * @return Project
     */
    public function addModuleNamespaces(array $moduleNamespaces, $allowRepeatedValues = true)
    {
        foreach ($moduleNamespaces as $moduleNamespace) {
            if ($allowRepeatedValues || !$this->moduleNamespaces->contains($moduleNamespace)) {
                $this->moduleNamespaces[] = $moduleNamespace;
            }
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
     * @return array
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
     * Set validation
     *
     * @param boolean $validation
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setValidation($validation)
    {
        if (!is_bool($validation)) {
            throw new \InvalidArgumentException('The attribute validation on the class Project has to be boolean (' . gettype($validation) . ('object' === gettype($validation) ? ' ' . get_class($validation) : '') . ' given).');
        }

        $this->validation = $validation;

        return $this;
    }

    /**
     * Get validation
     *
     * @return boolean
     */
    public function getValidation()
    {
        return $this->validation;
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

    /**
     * Set entityTemplate
     *
     * @param EntityTemplate|null $entityTemplate
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setEntityTemplate($entityTemplate)
    {
        if (!$entityTemplate instanceof EntityTemplate && null !== $entityTemplate) {
            throw new \InvalidArgumentException('The attribute entityTemplate on the class Project has to be EntityTemplate or null (' . gettype($entityTemplate) . ('object' === gettype($entityTemplate) ? ' ' . get_class($entityTemplate) : '') . ' given).');
        }

        $this->entityTemplate = $entityTemplate;

        return $this;
    }

    /**
     * Get entityTemplate
     *
     * @return EntityTemplate|null
     */
    public function getEntityTemplate()
    {
        return $this->entityTemplate;
    }

    /**
     * Set entityBaseTemplate
     *
     * @param EntityTemplate|null $entityBaseTemplate
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setEntityBaseTemplate($entityBaseTemplate)
    {
        if (!$entityBaseTemplate instanceof EntityTemplate && null !== $entityBaseTemplate) {
            throw new \InvalidArgumentException('The attribute entityBaseTemplate on the class Project has to be EntityTemplate or null (' . gettype($entityBaseTemplate) . ('object' === gettype($entityBaseTemplate) ? ' ' . get_class($entityBaseTemplate) : '') . ' given).');
        }

        $this->entityBaseTemplate = $entityBaseTemplate;

        return $this;
    }

    /**
     * Get entityBaseTemplate
     *
     * @return EntityTemplate|null
     */
    public function getEntityBaseTemplate()
    {
        return $this->entityBaseTemplate;
    }

    /**
     * Set repositoryTemplate
     *
     * @param EntityTemplate|null $repositoryTemplate
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setRepositoryTemplate($repositoryTemplate)
    {
        if (!$repositoryTemplate instanceof EntityTemplate && null !== $repositoryTemplate) {
            throw new \InvalidArgumentException('The attribute repositoryTemplate on the class Project has to be EntityTemplate or null (' . gettype($repositoryTemplate) . ('object' === gettype($repositoryTemplate) ? ' ' . get_class($repositoryTemplate) : '') . ' given).');
        }

        $this->repositoryTemplate = $repositoryTemplate;

        return $this;
    }

    /**
     * Get repositoryTemplate
     *
     * @return EntityTemplate|null
     */
    public function getRepositoryTemplate()
    {
        return $this->repositoryTemplate;
    }

    /**
     * Set formTemplate
     *
     * @param EntityTemplate|null $formTemplate
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setFormTemplate($formTemplate)
    {
        if (!$formTemplate instanceof EntityTemplate && null !== $formTemplate) {
            throw new \InvalidArgumentException('The attribute formTemplate on the class Project has to be EntityTemplate or null (' . gettype($formTemplate) . ('object' === gettype($formTemplate) ? ' ' . get_class($formTemplate) : '') . ' given).');
        }

        $this->formTemplate = $formTemplate;

        return $this;
    }

    /**
     * Get formTemplate
     *
     * @return EntityTemplate|null
     */
    public function getFormTemplate()
    {
        return $this->formTemplate;
    }

    /**
     * Set formBaseTemplate
     *
     * @param EntityTemplate|null $formBaseTemplate
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setFormBaseTemplate($formBaseTemplate)
    {
        if (!$formBaseTemplate instanceof EntityTemplate && null !== $formBaseTemplate) {
            throw new \InvalidArgumentException('The attribute formBaseTemplate on the class Project has to be EntityTemplate or null (' . gettype($formBaseTemplate) . ('object' === gettype($formBaseTemplate) ? ' ' . get_class($formBaseTemplate) : '') . ' given).');
        }

        $this->formBaseTemplate = $formBaseTemplate;

        return $this;
    }

    /**
     * Get formBaseTemplate
     *
     * @return EntityTemplate|null
     */
    public function getFormBaseTemplate()
    {
        return $this->formBaseTemplate;
    }

    /**
     * Set controllerTemplate
     *
     * @param EntityTemplate|null $controllerTemplate
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setControllerTemplate($controllerTemplate)
    {
        if (!$controllerTemplate instanceof EntityTemplate && null !== $controllerTemplate) {
            throw new \InvalidArgumentException('The attribute controllerTemplate on the class Project has to be EntityTemplate or null (' . gettype($controllerTemplate) . ('object' === gettype($controllerTemplate) ? ' ' . get_class($controllerTemplate) : '') . ' given).');
        }

        $this->controllerTemplate = $controllerTemplate;

        return $this;
    }

    /**
     * Get controllerTemplate
     *
     * @return EntityTemplate|null
     */
    public function getControllerTemplate()
    {
        return $this->controllerTemplate;
    }

    /**
     * Set fixturesTemplate
     *
     * @param EntityTemplate|null $fixturesTemplate
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setFixturesTemplate($fixturesTemplate)
    {
        if (!$fixturesTemplate instanceof EntityTemplate && null !== $fixturesTemplate) {
            throw new \InvalidArgumentException('The attribute fixturesTemplate on the class Project has to be EntityTemplate or null (' . gettype($fixturesTemplate) . ('object' === gettype($fixturesTemplate) ? ' ' . get_class($fixturesTemplate) : '') . ' given).');
        }

        $this->fixturesTemplate = $fixturesTemplate;

        return $this;
    }

    /**
     * Get fixturesTemplate
     *
     * @return EntityTemplate|null
     */
    public function getFixturesTemplate()
    {
        return $this->fixturesTemplate;
    }

    /**
     * Set routesTemplate
     *
     * @param EntityTemplate|null $routesTemplate
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setRoutesTemplate($routesTemplate)
    {
        if (!$routesTemplate instanceof EntityTemplate && null !== $routesTemplate) {
            throw new \InvalidArgumentException('The attribute routesTemplate on the class Project has to be EntityTemplate or null (' . gettype($routesTemplate) . ('object' === gettype($routesTemplate) ? ' ' . get_class($routesTemplate) : '') . ' given).');
        }

        $this->routesTemplate = $routesTemplate;

        return $this;
    }

    /**
     * Get routesTemplate
     *
     * @return EntityTemplate|null
     */
    public function getRoutesTemplate()
    {
        return $this->routesTemplate;
    }

    /**
     * Set routesRoutingTemplate
     *
     * @param EntityTemplate|null $routesRoutingTemplate
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setRoutesRoutingTemplate($routesRoutingTemplate)
    {
        if (!$routesRoutingTemplate instanceof EntityTemplate && null !== $routesRoutingTemplate) {
            throw new \InvalidArgumentException('The attribute routesRoutingTemplate on the class Project has to be EntityTemplate or null (' . gettype($routesRoutingTemplate) . ('object' === gettype($routesRoutingTemplate) ? ' ' . get_class($routesRoutingTemplate) : '') . ' given).');
        }

        $this->routesRoutingTemplate = $routesRoutingTemplate;

        return $this;
    }

    /**
     * Get routesRoutingTemplate
     *
     * @return EntityTemplate|null
     */
    public function getRoutesRoutingTemplate()
    {
        return $this->routesRoutingTemplate;
    }

    /**
     * Set crudCreateTwigTemplate
     *
     * @param EntityTemplate|null $crudCreateTwigTemplate
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setCrudCreateTwigTemplate($crudCreateTwigTemplate)
    {
        if (!$crudCreateTwigTemplate instanceof EntityTemplate && null !== $crudCreateTwigTemplate) {
            throw new \InvalidArgumentException('The attribute crudCreateTwigTemplate on the class Project has to be EntityTemplate or null (' . gettype($crudCreateTwigTemplate) . ('object' === gettype($crudCreateTwigTemplate) ? ' ' . get_class($crudCreateTwigTemplate) : '') . ' given).');
        }

        $this->crudCreateTwigTemplate = $crudCreateTwigTemplate;

        return $this;
    }

    /**
     * Get crudCreateTwigTemplate
     *
     * @return EntityTemplate|null
     */
    public function getCrudCreateTwigTemplate()
    {
        return $this->crudCreateTwigTemplate;
    }

    /**
     * Set crudReadTwigTemplate
     *
     * @param EntityTemplate|null $crudReadTwigTemplate
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setCrudReadTwigTemplate($crudReadTwigTemplate)
    {
        if (!$crudReadTwigTemplate instanceof EntityTemplate && null !== $crudReadTwigTemplate) {
            throw new \InvalidArgumentException('The attribute crudReadTwigTemplate on the class Project has to be EntityTemplate or null (' . gettype($crudReadTwigTemplate) . ('object' === gettype($crudReadTwigTemplate) ? ' ' . get_class($crudReadTwigTemplate) : '') . ' given).');
        }

        $this->crudReadTwigTemplate = $crudReadTwigTemplate;

        return $this;
    }

    /**
     * Get crudReadTwigTemplate
     *
     * @return EntityTemplate|null
     */
    public function getCrudReadTwigTemplate()
    {
        return $this->crudReadTwigTemplate;
    }

    /**
     * Set crudUpdateTwigTemplate
     *
     * @param EntityTemplate|null $crudUpdateTwigTemplate
     *
     * @return Project
     *
     * @throws \InvalidArgumentException
     */
    public function setCrudUpdateTwigTemplate($crudUpdateTwigTemplate)
    {
        if (!$crudUpdateTwigTemplate instanceof EntityTemplate && null !== $crudUpdateTwigTemplate) {
            throw new \InvalidArgumentException('The attribute crudUpdateTwigTemplate on the class Project has to be EntityTemplate or null (' . gettype($crudUpdateTwigTemplate) . ('object' === gettype($crudUpdateTwigTemplate) ? ' ' . get_class($crudUpdateTwigTemplate) : '') . ' given).');
        }

        $this->crudUpdateTwigTemplate = $crudUpdateTwigTemplate;

        return $this;
    }

    /**
     * Get crudUpdateTwigTemplate
     *
     * @return EntityTemplate|null
     */
    public function getCrudUpdateTwigTemplate()
    {
        return $this->crudUpdateTwigTemplate;
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