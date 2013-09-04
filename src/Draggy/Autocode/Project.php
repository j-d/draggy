<?php
// Draggy\Autocode\Project.php

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

use Draggy\Autocode\Base\ProjectBase;
// <user-additions part="use">
use Draggy\Autocode\Templates\EntityTemplate;
use Draggy\Autocode\Templates\PHP as PHPTemplates;
use Draggy\Autocode\Templates\JS as JSTemplates;
use Draggy\Autocode\Templates\Template;
use Draggy\Log;
use Draggy\Utils\Yaml\YamlLoader;
// </user-additions>

/**
 * Draggy\Autocode\Entity\Project
 */
class Project extends ProjectBase
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    /**
     * @var Log
     */
    protected $log;

    /**
     * @var array
     */
    protected $filesToProcess = [];

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @var bool[]
     */
    protected $autocodeProperties;

    /**
     * @var string[]
     */
    protected $autocodeConfigurations;

    /**
     * @var string[]
     */
    protected $autocodeTemplates;
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Constructor">
    // <user-additions part="constructorDeclaration">
    public function __construct()
    // </user-additions>
    {
        // <user-additions part="constructor">
        $this->log = new Log();
        // </user-additions>
    }
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
    /**
     * @inheritDoc
     */
    public function setNamespace($namespace) {
        if (substr($namespace, 0, -1) == '\\') {
            $namespace = substr($namespace, 0, -1);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addEntity(Entity $entity, $allowRepeatedValues = true)
    {
        if (isset( $this->entities[$entity->getName()] )) {
            throw new \RuntimeException( 'Tried to add an entity with the name \'' . $entity->getName() . '\' but there was already an entity by that name.' );
        }

        $this->entities[$entity->getRelativePathName()] = $entity;

        $module = $entity->getModule();

        if ('' !== $module) {
            if (!in_array($module, $this->modules)) {
                $this->modules[]                 = $module;
                $this->moduleNamespaces[$module] = $entity->getNamespace();
            }

            $this->moduleEntities[$module][] = $entity;
        }

        return $this;
    }

    public function getAttribute($str)
    {
        list($ent,$attr) = explode(':',$str);

        return $this->getEntityByFullyQualifiedName($ent)->getAttributeByName($attr);
    }

    public function setToString($str)
    {
        list($ent,$attr) = explode(':',$str);

        return $this->getEntityByFullyQualifiedName($ent)->setToString($attr);
    }

    /**
     * @inheritDoc
     */
    public function getLog()
    {
        $log = $this->log->getLog();

        if (null === $log) {
            return '--There are no messages--';
        } else {
            return $log;
        }
    }

    /**
     * Set the files that are going to be processed (all others will be ignored)
     *
     * @param $filesToProcess
     *
     * @return $this
     */
    public function setFilesToProcess($filesToProcess)
    {
        $this->filesToProcess = $filesToProcess;

        return $this;
    }

    /**
     * @return array
     */
    public function getFilesToProcess()
    {
        return $this->filesToProcess;
    }
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    public function &getEntityByFullyQualifiedName($name)
    {
        if (!isset( $this->entities[$name] )) {
            throw new \RuntimeException( 'An entity by the name of ' . $name . ' could not be located.' );
        }

        return $this->entities[$name];
    }

    public function isValidEntityName($term)
    {
        return !array_key_exists(strtolower($term), array_flip($this->getReservedWords()));
    }

    public function isValidAttributeName($term)
    {
        return !array_key_exists(strtolower($term), array_flip($this->getReservedWords()));
    }

    private function xmlEntityToEntity(\SimpleXMLElement $class, $moduleName = '')
    {
        $classAttributes = (array)$class->attributes();
        $classAttributes = $classAttributes['@attributes'];
        $entityName      = $classAttributes['name'];

        $entityClass = $this->getEntityClass();

        /** @var Entity $entity */
        if ($moduleName !== '') {
            $entity = new $entityClass( $this, $this->getNamespace() . '\\' . $moduleName, $moduleName, $entityName );
        } else {
            $entity = new $entityClass( $this, $this->getNamespace(), '', $entityName );
        }

        foreach ($classAttributes as $classAttributeName => $classAttributeValue)
            switch ($classAttributeName) {
                case 'name':
                    break; // Already dealt with
                case 'constructor':
                    $entity->setHasConstructor($classAttributeValue == 'true');
                    break;
                case 'repository':
                    $entity->setHasRepository($classAttributeValue == 'true');
                    break;
                case 'form':
                    $entity->setHasForm($classAttributeValue == 'true');
                    break;
                case 'controller':
                    $entity->setHasController($classAttributeValue == 'true');
                    break;
                case 'fixtures':
                    $entity->setHasFixtures($classAttributeValue == 'true');
                    break;
                case 'crud':
                    $entity->setCrud($classAttributeValue);
                    break;
                case 'routes':
                    $entity->setHasRoutes($classAttributeValue == 'true');
                    break;
                case 'arrayAccess':
                    $entity->setArrayAccess($classAttributeValue == 'true');
                    break;
                case 'toString':
                    $entity->setToString($classAttributeValue);
                    break;
                case 'description':
                    $entity->setDescription($classAttributeValue);
                    break;
                case 'top':                 // Screen positioning - irrelevant
                case 'left':
                    break;
                case 'inheritingFrom':      // Dealt later on, when all entities are created
                case 'manyToMany':
                    break;
                case 'fullyQualifiedName':   // Virtual
                    break;
                default:
                    throw new \Exception( 'On the entity ' . $entity->getName() . ' there is an unknown attribute (' . $classAttributeName . ')' );
            }

        if ($moduleName !== '') {
            $this->log->appendExtended('Found entity: ' . $moduleName . '\\' . $entityName);
        } else {
            $this->log->appendExtended('Found entity: ' . $entityName);
        }

        if ( ($entity->getCrudCreate() || $entity->getCrudUpdate()) && !$entity->getHasForm() ) {
            throw new \Exception( 'On the entity ' . $entity->getName() . ' you have enabled CRUD (C or U) but it is not set to have a Form' );
        }

        // This is wrong and there could be an entity with CRUD without a controller (composed form)
        // TODO: Remove this
//        if ( !is_null($entity->getCrud()) && !$entity->getHasController() ) {
//            throw new \Exception( 'On the entity ' . $entity->getName() . ' you have enabled CRUD but it is not set to have a Controller' );
//        }

        return $entity;
    }

    public function loadFile($file)
    {
        if (!is_file($file)) {
            throw new \Exception( 'Not valid model file provided (' . $file . ')' );
        }

        $xmlDesign = simplexml_load_file($file);

        $this->loadDesign($xmlDesign);

        return $this;
    }

    protected function calculateConfiguration()
    {
        $configuration   = YamlLoader::loadConfiguration();
        $myConfiguration = $configuration;

        $language  = $this->getLanguage();
        $framework = $this->getFramework();
        $orm       = $this->getOrm();

        if (!empty($language) && isset($myConfiguration['languages'][$language])) {
            $myConfiguration = YamlLoader::mergeConfigurations($myConfiguration, $myConfiguration['languages'][$language]);
        }

        if (!empty($framework) && isset($myConfiguration['frameworks'][$framework])) {
            $myConfiguration = YamlLoader::mergeConfigurations($myConfiguration, $myConfiguration['frameworks'][$framework]);
        }

        if (!empty($orm) && isset($myConfiguration['orms'][$orm])) {
            $myConfiguration = YamlLoader::mergeConfigurations($myConfiguration, $myConfiguration['orms'][$orm]);
        }

        return $myConfiguration;
    }

    public function getAutocodeProperties()
    {
        $configuration = $this->getConfiguration();

        $properties = [];

        foreach ($configuration['autocode']['properties'] as $propertyName => $propertyValue) {
            if ($propertyValue['enabled']) {
                $properties[$propertyName] = $propertyValue;
            }
        }

        return $properties;
    }

    public function getAttributeTypes()
    {
        $configuration = $this->getConfiguration();

        $types = [];

        foreach ($configuration['attributes']['types'] as $attributeName => $attributeValue) {
            if ($attributeValue['enabled']) {
                $types[$attributeName] = $attributeValue;
            }
        }

        return $types;
    }

    public function getReservedWords()
    {
        $words = [];

        foreach ($this->getConfiguration()['reserved-words'] as $word) {
            $words[] = strtolower($word);
        }

        return $words;
    }

    /**
     * @return array
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param string $property
     * @param bool   $value
     *
     * @return $this
     */
    public function setAutocodeProperty($property, $value)
    {
        $this->autocodeProperties[$property] = $value;

        return $this;
    }

    /**
     * @param $property
     *
     * @return bool
     */
    public function getAutocodeProperty($property)
    {
        return isset($this->autocodeProperties[$property])
            ? $this->autocodeProperties[$property]
            : null;
    }

    /**
     * @param string $configuration
     * @param bool   $value
     *
     * @return $this
     */
    public function setAutocodeConfiguration($configuration, $value)
    {
        $this->autocodeConfigurations[$configuration] = $value;

        return $this;
    }

    /**
     * @param string $configuration
     *
     * @return string
     */
    public function getAutocodeConfiguration($configuration)
    {
        return $this->autocodeConfigurations[$configuration];
    }

    /**
     * @param string $template
     * @param Template $value
     *
     * @return $this
     */
    public function setAutocodeTemplate($template, Template $value)
    {
        $this->autocodeTemplates[$template] = $value;

        return $this;
    }

    /**
     * @param string $template
     *
     * @return Template
     */
    public function getAutocodeTemplate($template)
    {
        return $this->autocodeTemplates[$template];
    }

    // <editor-fold desc="Deprecated methods">
    /**
     * @deprecated
     *
     * @return string
     */
    public function getNamespace()
    {
        if (array_key_exists('namespace', $this->getConfiguration()['autocode'])) {
            return $this->getAutocodeConfiguration('namespace');
        } else {
            return null;
        }
    }

    /**
     * @deprecated
     *
     * @return bool
     */
    public function getBase()
    {
        return $this->getAutocodeProperty('base');
    }

    /**
     * @deprecated
     *
     * @return bool
     */
    public function getOverwrite()
    {
        return $this->getAutocodeProperty('overwrite');
    }

    /**
     * @deprecated
     *
     * @return bool
     */
    public function getDeleteUnmapped()
    {
        return $this->getAutocodeProperty('delete-unmapped');
    }

    /**
     * @deprecated
     *
     * @return bool
     */
    public function getValidation()
    {
        return $this->getAutocodeProperty('validation');
    }

    /**
     * @deprecated
     *
     * @return EntityTemplate
     */
    public function getEntityTemplate()
    {
        return $this->getAutocodeTemplate('entity');
    }

    /**
     * @deprecated
     *
     * @return EntityTemplate
     */
    public function getEntityBaseTemplate()
    {
        return $this->getAutocodeTemplate('entity-base');
    }

    /**
     * @deprecated
     *
     * @return EntityTemplate
     */
    public function getRepositoryTemplate()
    {
        return $this->getAutocodeTemplate('repository');
    }

    /**
     * @deprecated
     *
     * @return EntityTemplate
     */
    public function getFormTemplate()
    {
        return $this->getAutocodeTemplate('form');
    }

    /**
     * @deprecated
     *
     * @return EntityTemplate
     */
    public function getFormBaseTemplate()
    {
        return $this->getAutocodeTemplate('form-base');
    }

    /**
     * @deprecated
     *
     * @return EntityTemplate
     */
    public function getControllerTemplate()
    {
        return $this->getAutocodeTemplate('controller');
    }

    /**
     * @deprecated
     *
     * @return EntityTemplate
     */
    public function getFixturesTemplate()
    {
        return $this->getAutocodeTemplate('fixtures');
    }

    /**
     * @deprecated
     *
     * @return EntityTemplate
     */
    public function getRoutesTemplate()
    {
        return $this->getAutocodeTemplate('routes');
    }

    /**
     * @deprecated
     *
     * @return EntityTemplate
     */
    public function getRoutesRoutingTemplate()
    {
        return $this->getAutocodeTemplate('routes-routing');
    }

    /**
     * @deprecated
     *
     * @return EntityTemplate
     */
    public function getCrudCreateTwigTemplate()
    {
        return $this->getAutocodeTemplate('crud-create');
    }

    /**
     * @deprecated
     *
     * @return EntityTemplate
     */
    public function getCrudReadTwigTemplate()
    {
        return $this->getAutocodeTemplate('crud-read');
    }

    /**
     * @deprecated
     *
     * @return EntityTemplate
     */
    public function getCrudUpdateTwigTemplate()
    {
        return $this->getAutocodeTemplate('crud-update');
    }
    // </editor-fold>

    /**
     * Loads the XML design to the project
     *
     * @param \SimpleXMLElement $xmlDesign
     *
     * @return $this
     *
     * @throws \RuntimeException
     * @throws \Exception
     */
    public function loadDesign(\SimpleXMLElement $xmlDesign)
    {
        // Load project properties
        $projectProperties = (array) $xmlDesign->xpath('project')[0];

        $this->setLanguage((string) $projectProperties['language']);
        $this->setFramework((string) $projectProperties['framework']);
        $this->setOrm((string) $projectProperties['orm']);
        $this->setDescription((string) $projectProperties['description']);

        $this->configuration = $this->calculateConfiguration();

        if ($this->getLanguage() === 'php') {
            $this->setAttributeClass('Draggy\\Autocode\\PHPAttribute');
            $this->setEntityClass('Draggy\\Autocode\\PHPEntity');
        } elseif ($this->getLanguage() === 'js') {
            $this->setAttributeClass('Draggy\\Autocode\\JSAttribute');
            $this->setEntityClass('Draggy\\Autocode\\Entity');
        } elseif ($this->getLanguage() === 'java') {
            $this->setAttributeClass('Draggy\\Autocode\\JavaAttribute');
            $this->setEntityClass('Draggy\\Autocode\\Entity');
        } elseif ($this->getLanguage() === 'cpp') {
            $this->setAttributeClass('Draggy\\Autocode\\CPPAttribute');
            $this->setEntityClass('Draggy\\Autocode\\Entity');
        }

        $attributeClass = $this->getAttributeClass();

        // Load autocode settings
        $autocode = (array) $xmlDesign->xpath('autocode')[0];

        $autocodeProperties     = (array)$autocode['properties'];
        $autocodeConfigurations = (array)$autocode['configurations'];
        $autocodeTemplates      = (array)$autocode['templates'];

        foreach ($autocodeProperties as $propertyName => $propertyValue) {
            $this->setAutocodeProperty($propertyName, 'true' === $propertyValue);
        }

        foreach ($autocodeConfigurations as $configurationName => $configurationValue) {
            $this->setAutocodeConfiguration($configurationName, $configurationValue);
        }

        foreach ($autocodeTemplates as $templateName => $templateValue) {
            if (!is_string($templateValue)) {
                // Use the default template
                $template = $this->getConfiguration()['autocode']['templates'][$templateName]['template'];
            } else {
                $template = $templateValue;
            }

            if (!class_exists($template)) {
                throw new \RuntimeException(sprintf('The specified class file \'%s\' cannot be loaded', $template));
            }

            $this->setAutocodeTemplate($templateName, new $template);
        }

        // Process entities

        $modules = $xmlDesign->xpath('module');

        // Process in three steps. First create all the entities, second add all the attributes, and finally link the foreign entities.
        // This way it can reference foreign entities and attributes because they will exist.

        // First step: Add the entities (Classes or Abstracts)
        foreach ($modules as $module) {
            $moduleName = (string)$module->attributes()->name;

            $this->log->appendExtended('Found module: ' . $moduleName);

            // Classes
            $classes = $module->xpath('*[self::class]');

            foreach ($classes as $class) {
                $class->addAttribute('fullyQualifiedName', $moduleName . '\\' . $class->attributes()->name);
                $entity = $this->xmlEntityToEntity($class, $moduleName);
                $entity->setType('class');
                $this->addEntity($entity);
            }

            // Abstracts
            $abstracts = $module->xpath('*[self::abstract]');

            foreach ($abstracts as $abstract) {
                $abstract->addAttribute('fullyQualifiedName', $moduleName . '\\' . $abstract->attributes()->name);
                $entity = $this->xmlEntityToEntity($abstract, $moduleName);
                $entity->setType('abstract');
                $this->addEntity($entity);
            }
        }

        // Add loose entities
        $loose = $xmlDesign->xpath('loose')[0];

        $classes = $loose->xpath('*[self::class]');

        foreach ($classes as $class) {
            $class->addAttribute('fullyQualifiedName', $class->attributes()->name); // Add fully qualified name
            $entity = $this->xmlEntityToEntity($class);
            $entity->setType('class');
            $this->addEntity($entity);
        }

        $abstracts = $loose->xpath('*[self::abstract]');

        foreach ($abstracts as $abstract) {
            $abstract->addAttribute('fullyQualifiedName', $abstract->attributes()->name); // Add fully qualified name
            $entity = $this->xmlEntityToEntity($abstract);
            $entity->setType('abstract');
            $this->addEntity($entity);
        }

        // Second step: Add all non-inherited attributes

        $classes = $xmlDesign->xpath('*[self::module or self::loose]/*[self::class or self::abstract]');

        foreach ($classes as $class) {
            $classAttributes          = (array)$class->attributes();
            $classAttributes          = $classAttributes['@attributes'];
            $entityName               = $classAttributes['name'];
            $entityFullyQualifiedName = $classAttributes['fullyQualifiedName'];

            $entity = $this->getEntityByFullyQualifiedName($entityFullyQualifiedName);

            $attributes = $class->xpath('attribute[not(@inherited=\'true\')]');

            foreach ($attributes as $attribute) {
                $attributeAttributes = (array)$attribute->attributes();
                $attributeAttributes = $attributeAttributes['@attributes'];
                $attributeName       = $attributeAttributes['name'];

                if (!isset( $attributeAttributes['type'] ))
                    throw new \Exception( 'The attribute ' . $attributeName . ' on the entity ' . $entityName . ' doesn\'t have a type' );

                /** @var Attribute $attribute */
                $attribute = new $attributeClass( $entity, $attributeName, $attributeAttributes['type']);

                foreach ($attributeAttributes as $attributeName => $attributeValue) {
                    switch ($attributeName) {
                        case 'autoincrement':
                            $attribute->setAutoIncrement($attributeValue === 'true');
                            break;
                        case 'primary':
                            $attribute->setPrimary($attributeValue === 'true');
                            break;
                        case 'name':
                        case 'type':
                        case 'id':
                            break; // Already dealt with
                        case 'subtype':
                            $attribute->setSubtype($attributeValue);
                            break;
                        case 'description':
                            $attribute->setDescription($attributeValue);
                            break;
                        case 'size':
                            $attribute->setSize((int)$attributeValue);
                            break;
                        case 'minSize':
                            $attribute->setMinSize((int)$attributeValue);
                            break;
                        case 'min':
                            $attribute->setMin((int)$attributeValue);
                            break;
                        case 'max':
                            $attribute->setMax((int)$attributeValue);
                            break;
                        case 'null':
                            $attribute->setNull($attributeValue === 'true');
                            break;
                        case 'unique':
                            $attribute->setUnique($attributeValue === 'true');
                            break;
                        case 'default':
                            $attribute->setDefaultValue($attributeValue);
                            break;
                        case 'foreign':
                            $attribute->setForeignTick($attributeValue === 'true');
                            break;
                        case 'setter':
                            $attribute->setSetter($attributeValue === 'true');
                            break;
                        case 'getter':
                            $attribute->setGetter($attributeValue === 'true');
                            break;
                        case 'email':
                            $attribute->setEmail($attributeValue === 'true');
                            break;
                        case 'static':
                            $attribute->setStatic($attributeValue === 'true');
                            break;
                        default:
                            throw new \Exception( 'The attribute ' . $attributeAttributes['name'] . ' on the entity ' . $entityName . ' has an unknown attribute (' . $attributeName . ')' );
                    }
                }

                if ($attribute->getAutoIncrement() && !$attribute->getForeignTick())
                    $attribute->setSetter(false);       // If it is autoincrement, can't have a setter unless is a foreign key

                $entity->addAttribute($attribute);
            }
        }

        // Find inherited classes and mark their parent entities
        $childClasses = $xmlDesign->xpath('*[self::module or self::loose]/*[@inheritingFrom and (self::abstract)]');

        foreach ($childClasses as $childClass) {
            $childClassAttributes         = (array)$childClass->attributes();
            $childClassAttributes         = $childClassAttributes['@attributes'];
            $childClassFullyQualifiedName = $childClassAttributes['fullyQualifiedName'];

            $parentName = $childClassAttributes['inheritingFrom'];

            $child = &$this->getEntityByFullyQualifiedName($childClassFullyQualifiedName);
            $parent = &$this->getEntityByFullyQualifiedName($parentName);

            $child->setParentEntity($parent);
            $parent->addChildrenEntity($child);

            foreach ($parent->getAttributes() as $attrNode) {
                $child->addAttributeReference($attrNode);
            }

            unset($child,$parent);
        }

        $childClasses = $xmlDesign->xpath('*[self::module or self::loose]/*[@inheritingFrom and (self::class)]');

        foreach ($childClasses as $childClass) {
            $childClassAttributes         = (array)$childClass->attributes();
            $childClassAttributes         = $childClassAttributes['@attributes'];
            $childClassFullyQualifiedName = $childClassAttributes['fullyQualifiedName'];

            $parentName = $childClassAttributes['inheritingFrom'];

            $child = &$this->getEntityByFullyQualifiedName($childClassFullyQualifiedName);
            $parent = &$this->getEntityByFullyQualifiedName($parentName);

            $child->setParentEntity($parent);
            $parent->addChildrenEntity($child);

            foreach ($parent->getAttributes() as $attrNode) {
                $child->addAttributeReference($attrNode);
            }

            unset($child,$parent);
        }

        // Fix ManyToMany relationships without attributes
        $manyToManyRelationships = $xmlDesign->xpath('*[self::module or self::loose]/class[@manyToMany=\'true\']');

        // Mark many to many virtual entities
        foreach ($manyToManyRelationships as $manyToManyRelationship) {
            $manyToManyEntityName = (array)$manyToManyRelationship->attributes();
            $manyToManyEntityFullyQualifiedName = $manyToManyEntityName['@attributes']['fullyQualifiedName'];

            $manyToManyEntity = &$this->getEntityByFullyQualifiedName($manyToManyEntityFullyQualifiedName);

            $manyToManyEntityAttributes = $manyToManyEntity->getAttributes();

            if (count($manyToManyEntityAttributes) == 2) { // If it is not 2, is not a proper ManyToMany relationship
                $manyToManyEntity->setRenderizable(false);
            }
        }

        // Find and map foreign keys (OneToMany, ManyToOne or OneToOne)
        $foreignKeys = $xmlDesign->xpath('relationships/relation[@type=\'one-to-one\' or @type=\'one-to-many\']');

        foreach ($foreignKeys as $foreignKey) {
            $sourceEntityName    = (string)$foreignKey->attributes()->from;
            $sourceAttributeName = (string)$foreignKey->attributes()->fromAttribute;

            $targetEntityName    = (string)$foreignKey->attributes()->to;
            $targetAttributeName = (string)$foreignKey->attributes()->toAttribute;

            $sourceEntity    = &$this->getEntityByFullyQualifiedName($sourceEntityName);
            $sourceAttribute = &$sourceEntity->getAttributeByName($sourceAttributeName);

            $targetEntity    = &$this->getEntityByFullyQualifiedName($targetEntityName);
            $targetAttribute = &$targetEntity->getAttributeByName($targetAttributeName);

            //echo 'source attr: ' . $sourceEntityName . '\\' . $sourceAttribute->getName() . '<br>';
            //echo 'target attr: ' . $targetEntityName . '\\' . $targetAttribute->getName() . '<br><br>';
            /*if ($sourceAttribute->getUnique())  // ???
                $sourceAttribute->setForeign('OneToOne');
            else
                $sourceAttribute->setForeign('ManyToOne');
	        */

            $type = (string)$foreignKey->attributes()->type;

            // Backwards compatibility
            if ($type == 'one-to-one') {
                $type = 'OneToOne';
            } elseif ($type == 'many-to-one') {
                $type = 'ManyToOne';
            }
            // End of backwards compatibility

            if ($type === 'OneToOne') {
                $targetAttribute->setForeign('OneToOne');
            } else { // ManyToOne
                $targetAttribute->setForeign('ManyToOne');
            }

            $targetAttribute->setOwnerSide(true);

            //$sourceAttribute->setForeignEntity($targetEntity);
            //$sourceAttribute->setForeignKey($targetAttribute);

            $targetAttribute->setForeignEntity($sourceEntity);
            $targetAttribute->setForeignKey($sourceAttribute);
        }

        $attributesToBeAdded = [];

        foreach ($manyToManyRelationships as $manyToManyRelationship) {
            $manyToManyEntityNameArray          = (array)$manyToManyRelationship->attributes();
            $manyToManyEntityName               = $manyToManyEntityNameArray['@attributes']['name'];
            $manyToManyEntityFullyQualifiedName = $manyToManyEntityNameArray['@attributes']['fullyQualifiedName'];

            $manyToManyEntity = & $this->getEntityByFullyQualifiedName($manyToManyEntityFullyQualifiedName);

            $manyToManyEntityAttributes = $manyToManyEntity->getAttributes();

            if (count($manyToManyEntityAttributes) == 2) { // If it is not 2, is not a proper ManyToMany relationship
                $manyToManyOwnerAttribute = $manyToManyEntity->getAttribute(0);
                $manyToManyTargetAttribute = $manyToManyEntity->getAttribute(1);

                $ownerEntity  = &$manyToManyOwnerAttribute->getForeignEntity();
                $targetEntity = &$manyToManyTargetAttribute->getForeignEntity();

                /** @var Attribute $manyToManyAttributeOwner */
                $manyToManyAttributeOwner = new $attributeClass( $ownerEntity, $manyToManyTargetAttribute->getName(), 'array' );
                $manyToManyAttributeOwner
                    ->setOwnerSide(true)
                    ->setForeign('ManyToMany')
                    ->setForeignEntity($targetEntity)
                    ->setForeignKey($targetEntity->getPrimaryAttribute())
                    ->setNull($manyToManyTargetAttribute->getNull())
                    ->setManyToManyEntityName($manyToManyEntityName);

                /** @var Attribute $manyToManyAttributeTarget */
                $manyToManyAttributeTarget = new $attributeClass( $targetEntity, $manyToManyOwnerAttribute->getName(), 'array' );
                $manyToManyAttributeTarget
                    ->setForeign('ManyToMany')
                    ->setForeignEntity($ownerEntity)
                    ->setForeignKey($ownerEntity->getPrimaryAttribute())
                    ->setNull($manyToManyOwnerAttribute->getNull())
                    ->setManyToManyEntityName($manyToManyEntityName);

                $manyToManyAttributeTarget->setReverseAttribute($manyToManyAttributeOwner);
                $manyToManyAttributeOwner->setReverseAttribute($manyToManyAttributeTarget);

                $ownerEntity->addAttribute($manyToManyAttributeOwner);
                $targetEntity->addAttribute($manyToManyAttributeTarget);

                if (!isset($attributesToBeAdded[$ownerEntity->getFullyQualifiedName()][$manyToManyTargetAttribute->getName()])) {
                    $attributesToBeAdded[$ownerEntity->getFullyQualifiedName()][$manyToManyTargetAttribute->getName()] = 1;
                } else {
                    $attributesToBeAdded[$ownerEntity->getFullyQualifiedName()][$manyToManyTargetAttribute->getName()]++;
                }

                if (!isset($attributesToBeAdded[$targetEntity->getFullyQualifiedName()][$manyToManyOwnerAttribute->getName()])) {
                    $attributesToBeAdded[$targetEntity->getFullyQualifiedName()][$manyToManyOwnerAttribute->getName()] = 1;
                } else {
                    $attributesToBeAdded[$targetEntity->getFullyQualifiedName()][$manyToManyOwnerAttribute->getName()]++;
                }
                // $manyToManyEntity->setRenderizable(false);
            }
        }

        // Add OneToOne and OneToMany inverse attributes
        $foreignKeys = $xmlDesign->xpath('relationships/relation[@type=\'one-to-one\' or @type=\'one-to-many\']');

        // Find ideal new attribute counters
        foreach ($foreignKeys as $foreignKey) {
            $relationAttributes = (array)$foreignKey->attributes();
            $relationAttributes = $relationAttributes['@attributes'];

            $type = $relationAttributes['type'];

            // Backwards compatibility
            if ($type == 'one-to-one') {
                $type = 'OneToOne';
            } elseif ($type == 'many-to-one') {
                $type = 'ManyToOne';
            }
            // End of backwards compatibility

            $sourceEntityName = (string)$foreignKey->attributes()->from;
            $targetEntityName = (string)$foreignKey->attributes()->to;

            $sourceEntity = &$this->getEntityByFullyQualifiedName($sourceEntityName);
            $targetEntity = & $this->getEntityByFullyQualifiedName($targetEntityName);

            if ('OneToOne' === $type) {
                $desiredName = $targetEntity->getLowerName();
            } else {
                $desiredName = $targetEntity->getPluralLowerName();
            }

            if (!isset($attributesToBeAdded[$sourceEntity->getFullyQualifiedName()][$desiredName])) {
                $attributesToBeAdded[$sourceEntity->getFullyQualifiedName()][$desiredName] = 1;
            } else {
                $attributesToBeAdded[$sourceEntity->getFullyQualifiedName()][$desiredName]++;
            }
        }

        // Actually add the attributes
        foreach ($foreignKeys as $foreignKey) {
            $relationAttributes = (array)$foreignKey->attributes();
            $relationAttributes = $relationAttributes['@attributes'];

            $sourceEntityName    = (string)$foreignKey->attributes()->from;
            $sourceAttributeName = (string)$foreignKey->attributes()->fromAttribute;

            $targetEntityName    = (string)$foreignKey->attributes()->to;
            $targetAttributeName = (string)$foreignKey->attributes()->toAttribute;

            $sourceEntity    = &$this->getEntityByFullyQualifiedName($sourceEntityName);
            $sourceAttribute = &$sourceEntity->getAttributeByName($sourceAttributeName);

            $targetEntity    = &$this->getEntityByFullyQualifiedName($targetEntityName);
            $targetAttribute = &$targetEntity->getAttributeByName($targetAttributeName);

            $type = $relationAttributes['type'];

            // Backwards compatibility
            if ($type == 'one-to-one') {
                $type = 'OneToOne';
            } elseif ($type == 'many-to-one') {
                $type = 'ManyToOne';
            }
            // End of backwards compatibility

            if ($targetEntity->getRenderizable()) {
                if ('OneToOne' === $type) {
                    $desiredName = $targetEntity->getLowerName();
                } else {
                    $desiredName = $targetEntity->getPluralLowerName();
                }

                list($attributeName, $attributeSuffix) = 1 === $attributesToBeAdded[$sourceEntity->getFullyQualifiedName()][$desiredName]
                    ? $this->getActualAttributeName($sourceEntity, $desiredName)
                    : $this->getActualAttributeName($sourceEntity, $desiredName, $targetAttribute->getUpperName(), true);

                if ($type === 'OneToOne') {
                    /** @var Attribute $inverseAttribute */
                    $inverseAttribute = new $attributeClass($sourceEntity, $attributeName, 'object');
                    $inverseAttribute
                        ->setSuffix($attributeSuffix)
                        ->setInverse(true)
                        ->setSubtype($targetEntity->getRelativePathName())
                        ->setForeign('OneToOne')
                        ->setForeignEntity($targetEntity)
                        ->setForeignKey($targetAttribute)
                        ->setNull($targetAttribute->getNull()) // TODO: CHECK
                        ->setReverseAttribute($targetAttribute);

                    $targetAttribute->setReverseAttribute($inverseAttribute);
                } else { // ManyToOne
                    /** @var Attribute $inverseAttribute */
                    $inverseAttribute = new $attributeClass($sourceEntity, $attributeName, 'array');
                    $inverseAttribute
                        ->setSuffix($attributeSuffix)
                        ->setInverse(true)
                        ->setSubtype($targetEntity->getRelativePathName())
                        ->setForeign('ManyToOne')
                        ->setForeignEntity($targetEntity)
                        ->setForeignKey($targetAttribute)
                        ->setNull($targetAttribute->getNull()) // TODO: CHECK
                        ->setReverseAttribute($targetAttribute);

                    $targetAttribute->setReverseAttribute($inverseAttribute);
                }

                if ($sourceEntity->hasAttributeByName($desiredName . $attributeSuffix)) {
                    $this->log->prepend('*** The ' . $type . ' inverse attribute \'' . $inverseAttribute->getLowerName() . '\' could not be added to the Entity \'' . $sourceEntity->getName() . '\' because there is an attribute with that name already there. It had to be renamed to \'' . $attributeName . '\'.');
                }

                $sourceEntity->addAttribute($inverseAttribute);

                $targetAttribute->setCascadePersist('both'); // Backwards compatibility
                $targetAttribute->setCascadeRemove('both'); // Backwards compatibility

                foreach ($relationAttributes as $attributeName => $attributeValue) {
                    switch ($attributeName) {
                        case 'broken':
                            break; // Already dealt with
                        case 'from':
                            break; // Already dealt with
                        case 'fromAttribute':
                            break; // Already dealt with
                        case 'persist':
                            $targetAttribute->setCascadePersist($attributeValue);
                            break;
                        case 'remove':
                            $targetAttribute->setCascadeRemove($attributeValue);
                            break;
                        case 'to':
                            break; // Already dealt with
                        case 'toAttribute':
                            break; // Already dealt with
                        case 'type':
                            break; // Already dealt with
                        default:
                            throw new \Exception( 'The relation from the entity ' . $sourceEntity->getName() . ' to the entity ' . $targetEntity->getName() . ' has an unknown attribute (' . $attributeName . ')' );
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Sometimes the automatic name cannot be used because the entity already has an attribute with that name or because is linked many times.
     * This method gives an actual final name that will be unique.
     *
     * @param Entity  $entity
     * @param string  $name
     * @param string  $hint
     * @param boolean $force If it should force the use of the hint
     *
     * @return array
     */
    public function getActualAttributeName(Entity $entity, $name, $hint = '', $force = false)
    {
        if ($entity->hasAttributeByName($name) || $force) {
            if (!$entity->hasAttributeByName($name . $hint)) {
                return [$name, $hint];
            }

            $append = 1;

            while ($entity->hasAttributeByName($name . $append . $hint)) {
                $append++;
            }

            return [$name . $append, $hint];
        }

        return [$name, ''];
    }

    private function findExistingExtraFiles($path)
    {
        $path = str_replace('\\', '/', $path . $this->getNamespace() . '/');

        $fileCollection = new FileCollection();

        if (is_dir($path)) {
            foreach (scandir($path) as $folder) {
                if (is_dir($path . '/' . $folder . '/Entity/') && !in_array($folder, ['.', '..'])) {
                    foreach (scandir($path . '/' . $folder . '/Entity/') as $file) {
                        if (!is_dir($path . '/' . $folder . '/Entity/' . $file)) {
                            $file = str_replace('Repository.php','.php',$file); // Repositories are allowed

                            try {
                                $entity = $this->getEntityByFullyQualifiedName($folder . '\\' .  substr($file, 0, -4));

                                if (!$entity->getRenderizable()) {
                                    $this->log->prepend('*** Perhaps the file ' . $folder . '/Entity/' . $file . ' should not be there as there is not an it belongs to an implicit ManyToMany relationship.');
                                }

                                if ($entity->getModule() != $folder) {
                                    $this->log->prepend('*** Perhaps the file ' . $folder . '/Entity/' . $file . ' should be in the module ' . $entity->getModule() . '.');
                                }
                            } catch (\RuntimeException $e) {
                                if (!$this->getDeleteUnmapped()) {
                                    $this->log->prepend('*** Perhaps the file ' . $folder . '/Entity/' . $file . ' should not be there as there is not an entity linked to it.');
                                } else {
                                    if (file_exists($path . '/' . $folder . '/Entity/' . $file)) {
                                        $fileCollection->add(new NoFile($path . '/' . $folder . '/Entity/', $file, sprintf('There \'%s\' has been deleted as there is no entity linked to it.', $file)));
                                    }
                                    if ($this->getBase()) {
                                        $baseFileName = str_replace('.php','Base.php',$file);

                                        $baseFile = $path . '/' . $folder . '/Entity/Base/' . $baseFileName;

                                        if (file_exists($baseFile)) {
                                            $fileCollection->add(new NoFile($path . '/' . $folder . '/Entity/Base/', $baseFileName, sprintf('There \'%s\' has been deleted as there is no entity linked to it.', $baseFileName)));
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $fileCollection;
    }

    public function getChanges($path)
    {
        if ('java' === $this->getLanguage()) {
            $path = $this->getAutocodeConfiguration('target-path');
        }

        $fileCollection = $this->getModelFiles($path);
        $fileCollection->setOverwrite($this->getOverwrite());

        $diffArray = $fileCollection->getDiff();

        return $diffArray;
    }

    public function saveTo($path)
    {
        if ('java' === $this->getLanguage()) {
            $path = $this->getAutocodeConfiguration('target-path');
        }

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $fileCollection = $this->getModelFiles($path);

        $filteredFileCollection = new FileCollection();

        foreach ($fileCollection->getFiles() as $file) {
            if (in_array($file->getFullName(), $this->filesToProcess)) {
                $filteredFileCollection->add($file);
            }
        }

        $filteredFileCollection
            ->setOverwrite($this->getAutocodeProperty('overwrite'))
            ->save();

        $this->log->append($fileCollection->getLog());
    }

    /**
     * Returns a collection of files
     *
     * @param string $path The path where they would be saved
     *
     * @return FileCollection
     */
    public function getModelFiles($path)
    {
        $fileCollection = new FileCollection();

        $fileCollection->add($this->findExistingExtraFiles($path));

        $namespacePath = str_replace('\\', '/', $path . $this->getNamespace() . '/');

        foreach ($this->getEntities() as $entity) {
            if ($entity->getRenderizable()) {
                if ($this->getLanguage() === 'php') {
                    if ($entity->getNamespace() === '') {
                        $targetPath = $namespacePath;
                    } else {
                        $targetPath = $path . str_replace('\\', '/', $entity->getNamespace()) . '/';
                    }

                    $fileCollection->add($this->getPHPEntityFile($entity, $targetPath));
                    $fileCollection->add($this->getRepositoryFile($entity, $targetPath));
                    $fileCollection->add($this->getFormFile($entity, $targetPath));
                    $fileCollection->add($this->getControllerFile($entity, $targetPath));
                    $fileCollection->add($this->getFixturesFile($entity, $targetPath));
                    $fileCollection->add($this->getRoutesFile($entity, $targetPath));
                    $fileCollection->add($this->getTwigCreateFile($entity, $targetPath));
                    $fileCollection->add($this->getTwigReadFile($entity, $targetPath));
                    $fileCollection->add($this->getTwigUpdateFile($entity, $targetPath));
                } elseif ($this->getLanguage() === 'js') {
                    $fileCollection->add($this->getJSEntityFile($entity, $targetPath));
                } elseif ($this->getLanguage() === 'java') {
                    if ($entity->getModule() === '') {
                        $targetPath = $namespacePath;
                    } else {
                        $targetPath = $path . '/' . $this->getAutocodeConfiguration('package') . '/' . str_replace('.', '/', $entity->getModule()) . '/';
                    }

                    $fileCollection->add($this->getJavaEntityFile($entity, $targetPath));
                } elseif ($this->getLanguage() === 'cpp') {
                    $fileCollection->add($this->getCPPEntityFile($entity, $targetPath));
                }

            }
        }

        if ($this->getLanguage() === 'php') {
            foreach ($this->modules as $module) {
                $targetPath = $path . str_replace('\\', '/', $this->moduleNamespaces[$module]) . '/';

                $fileCollection->add($this->getRoutesRoutingFile($module, $targetPath));
            }
        }

        return $fileCollection;
    }

    /**
     * @param Entity $entity
     * @param string $path

     * @return FileInterface
     */
    private function getPHPEntityFile(Entity $entity, $path)
    {
        $fileCollection = new FileCollection();

        $entityTemplate     = $this->getEntityTemplate()->setEntity($entity);
        $entityBaseTemplate = $this->getEntityBaseTemplate()->setEntity($entity);

        $entityPath = $path . $entityTemplate->getPath();
        $basePath   = $path . $entityBaseTemplate->getPath();

        $entityName     = $entityTemplate->getFilename();
        $entityBaseName = $entityBaseTemplate->getFilename();

        $fileCollection->add(new File($basePath, $entityBaseName, $entityBaseTemplate->render()));

        if ($this->getBase()) {
            $fileCollection->add(new File($entityPath, $entityName, $entityTemplate->render()));
        } else {
            $fileCollection->add(new NoFile($entityPath, $entityName, sprintf('The entity \'%s\' is not marked to inherit from a base.', $entity->getFullyQualifiedName())));
        }

        return $fileCollection;
    }

    /**
     * @param Entity $entity
     * @param string $path

     * @return FileInterface
     */
    private function getJSEntityFile(Entity $entity, $path)
    {
        $fileCollection = new FileCollection();

        $basePath = $path;

        if ($this->getBase()) {
            $basePath .= 'Base/';
        }

        $fileCollection->add(new File($basePath, $entity->getNameBase() . '.js', $this->getEntityTemplate()->setEntity($entity)->render()));

        if ($this->getBase()) {
            $fileCollection->add(new File($path, $entity->getName() . '.js', $this->getEntityBaseTemplate()->setEntity($entity)->render()));
        } else {
            // NoFile
        }

        return $fileCollection;
    }

    /**
     * @param Entity $entity
     * @param string $path

     * @return FileInterface
     */
    private function getJavaEntityFile(Entity $entity, $path)
    {
        $fileCollection = new FileCollection();

        $entityTemplate     = $this->getAutocodeTemplate('entity')->setEntity($entity);
        $entityBaseTemplate = $this->getAutocodeTemplate('entity-base')->setEntity($entity);

        $entityPath = $path . $entityTemplate->getPath();
        $basePath   = $path . $entityBaseTemplate->getPath();

        $entityName     = $entityTemplate->getFilename();
        $entityBaseName = $entityBaseTemplate->getFilename();

        $fileCollection->add(new File($basePath, $entityBaseName, $entityBaseTemplate->render()));

        if ($this->getAutocodeProperty('base')) {
            $fileCollection->add(new File($entityPath, $entityName, $entityTemplate->render()));
        } else {
            $fileCollection->add(new NoFile($entityPath, $entityName, sprintf('The entity \'%s\' is not marked to inherit from a base.', $entity->getFullyQualifiedName())));
        }

        return $fileCollection;
    }

    /**
     * @param Entity $entity
     * @param string $path

     * @return FileInterface
     */
    private function getRepositoryFile(Entity $entity, $path)
    {
        $repositoryTemplate = $this->getRepositoryTemplate()->setEntity($entity);

        $repositoryPath = $path . $repositoryTemplate->getPath();
        $repositoryName = $repositoryTemplate->getFilename();

        if ($entity->getHasRepository()) {
            return new File($repositoryPath, $repositoryName, $repositoryTemplate->render());
        } else {
            return new NoFile($repositoryPath, $repositoryName, sprintf('The entity \'%s\' is not marked to have a repository.', $entity->getFullyQualifiedName()));
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     *
     * @return FileInterface
     */
    private function getFormFile($entity, $path)
    {
        $formTemplate     = $this->getFormTemplate()->setEntity($entity);
        $formBaseTemplate = $this->getFormBaseTemplate()->setEntity($entity);

        $formPath     = $path . $formTemplate->getPath();
        $formBasePath = $path . $formBaseTemplate->getPath();

        $formName     = $formTemplate->getFilename();
        $formBaseName = $formBaseTemplate->getFilename();

        $fileCollection = new FileCollection();

        if ($entity->getHasForm()) {
            // Form
            $fileCollection->add(new File($formPath, $formName, $formTemplate->render()));

            // Form Base
            $fileCollection->add(new File($formBasePath, $formBaseName, $formBaseTemplate->render()));
        } else {
            $fileCollection->add(new NoFile($formPath, $formName, sprintf('The entity \'%s\' is not marked to have a form.', $entity->getFullyQualifiedName())));
            $fileCollection->add(new NoFile($formBasePath, $formBaseName, sprintf('The entity \'%s\' is not marked to have a form.', $entity->getFullyQualifiedName())));
        }

        return $fileCollection;
    }

    /**
     * @param Entity $entity
     * @param string $path
     *
     * @return FileInterface
     */
    private function getControllerFile($entity, $path)
    {
        $controllerTemplate = $this->getControllerTemplate()->setEntity($entity);

        $controllerPath = $path . $controllerTemplate->getPath();
        $controllerName = $controllerTemplate->getFilename();

        if ($entity->getHasController()) {
            return new File($controllerPath, $controllerName, $controllerTemplate->render());
        } else {
            return new NoFile($controllerPath, $controllerName, sprintf('The entity \'%s\' is not marked to have a controller.', $entity->getFullyQualifiedName()));
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     *
     * @return FileInterface
     */
    private function getFixturesFile($entity, $path)
    {
        $fixturesTemplate = $this->getFixturesTemplate()->setEntity($entity);

        $fixturesPath = $path . $fixturesTemplate->getPath();
        $fixturesName = $fixturesTemplate->getFilename();

        if ($entity->getHasFixtures()) {
            return new File($fixturesPath, $fixturesName, $fixturesTemplate->render());
        } else {
            return new NoFile($fixturesPath, $fixturesName, sprintf('The entity \'%s\'is not marked to have fixtures.', $entity->getFullyQualifiedName()));
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     *
     * @return FileInterface
     */
    private function getRoutesFile($entity, $path)
    {
        $routesTemplate = $this->getRoutesTemplate()->setEntity($entity);

        $routesPath = $path . $routesTemplate->getPath();
        $routesName = $routesTemplate->getFilename();

        if ($entity->getHasRoutes()) {
            return new File($routesPath, $routesName, $routesTemplate->render());
        } else {
            return new NoFile($routesPath, $routesName, sprintf('The entity \'%s\' is not marked to have CRUD.', $entity->getFullyQualifiedName()));
        }
    }

    /**
     * @param string $module
     * @param string $path
     *
     * @return File|null
     */
    private function getRoutesRoutingFile($module, $path)
    {
        $routesRoutingTemplate = $this->getRoutesRoutingTemplate();

        $routesRoutingPath = $path . $routesRoutingTemplate->getPath();
        $routesRoutingName = $routesRoutingTemplate->getFilename();

        $routesArray = [];

        /** @var Entity $entity */
        foreach ($this->moduleEntities[$module] as $entity) {
            if ($entity->getHasRoutes()) {
                $routesRoutingTemplate->setEntity($entity);

                $routesArray[] = $routesRoutingTemplate->render();
            }
        }

        if (count($routesArray) > 0) {
            $routes =   '# <system-additions part="routes">' . PHP_EOL .
                        implode(PHP_EOL,$routesArray) .
                        '# </system-additions>' . PHP_EOL;

            $file = new File($routesRoutingPath, $routesRoutingName, $routes);
            $file->setAddToFile(true);

            return $file;
        }

        return null;
    }

    /**
     * @param Entity $entity
     * @param string $path
     *
     * @return FileInterface
     */
    private function getTwigCreateFile($entity, $path)
    {
        $twigCreateTemplate = $this->getCrudCreateTwigTemplate()->setEntity($entity);

        $twigCreatePath = $path . $twigCreateTemplate->getPath();
        $twigCreateName = $twigCreateTemplate->getFilename();

        if ($entity->getCrudCreate()) {
            return new File($twigCreatePath, $twigCreateName, $twigCreateTemplate->render());
        } else {
            $fileCollection = new FileCollection();

            $fileCollection->add(new NoFile($twigCreatePath, $twigCreateName, sprintf('The entity \'%s\' is not marked to have CRUD(C).', $entity->getFullyQualifiedName())));

            return $fileCollection;
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     *
     * @return FileInterface
     */
    private function getTwigReadFile($entity, $path)
    {
        $twigReadTemplate = $this->getCrudReadTwigTemplate()->setEntity($entity);

        $twigReadPath = $path . $twigReadTemplate->getPath();
        $twigReadName = $twigReadTemplate->getFilename();

        if ($entity->getCrudRead()) {
            return new File($twigReadPath, $twigReadName, $twigReadTemplate->render());
        } else {
            $fileCollection = new FileCollection();

            $fileCollection->add(new NoFile($twigReadPath, $twigReadName, sprintf('The entity \'%s\' is not marked to have CRUD(R).', $entity->getFullyQualifiedName())));

            return $fileCollection;
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     *
     * @return FileInterface
     */
    private function getTwigUpdateFile($entity, $path)
    {
        $twigUpdateTemplate = $this->getCrudUpdateTwigTemplate()->setEntity($entity);

        $twigUpdatePath = $path . $twigUpdateTemplate->getPath();
        $twigUpdateName = $twigUpdateTemplate->getFilename();

        if ($entity->getCrudUpdate()) {
            return new File($twigUpdatePath, $twigUpdateName, $twigUpdateTemplate->render());
        } else {
            $fileCollection = new FileCollection();

            $fileCollection->add(new NoFile($twigUpdatePath, $twigUpdateName, sprintf('The entity \'%s\' is not marked to have CRUD(U).', $entity->getFullyQualifiedName())));

            return $fileCollection;
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     *
     * @return FileInterface
     */
    private function getInterfaceFile($entity, $path)
    {
        $interfaceTemplate = $this->getInterfaceTemplate()->setEntity($entity);

        $interfacePath = $path . $interfaceTemplate->getPath();
        $interfaceName = $interfaceTemplate->getFilename();

        return new File($interfacePath, $interfaceName, $interfaceTemplate->render());
    }

    /**
     * @param Entity $entity
     * @param string $path
     *
     * @return FileInterface
     */
    private function getTraitFile($entity, $path)
    {
        $traitTemplate = $this->getTraitTemplate()->setEntity($entity);

        $traitPath     = $path . $traitTemplate->getPath();
        $traitName     = $traitTemplate->getFilename();

        return new File($traitPath, $traitName, $traitTemplate->render());
    }

    public function supportsReverseAttributes()
    {
        return 'doctrine2' === $this->getOrm();
    }

    /**
     * Get the plural name from a singular
     *
     * @param string $string
     *
     * @return string
     */
    public static function singlelise($string)
    {
        $rules = [
            'ies' => 'y',
            'ves' => 'f',
            's'   => '',
        ];

        foreach ($rules as $ending => $replacement) {
            if ($ending === substr($string, -strlen($ending))) {
                return substr($string, 0, -strlen($ending)) . $replacement;
            }
        }

        return $string . 'Single';
    }

    /**
     * Get the plural name from a singular
     * Source: http://en.wikipedia.org/wiki/English_plurals
     *
     * @param string $string
     *
     * @return string
     */
    public static function pluralise($string)
    {
        $rules = [
            'tus' => 'tuses', // status to statuses

            'ss'  => 'sses', // kiss to kissess
            'sh'  => 'shes', // dish to dishes
            'ch'  => 'ches', // witch to witches
            'oy'  => 'oys',  // boy to boys
            'ay'  => 'ays',  // day to days
            'ey'  => 'eys',  // monkey to monkeys

            'o'   => 'oes', // hero to heroes
            'y'   => 'ies', // cherry to cherries
            'f'   => 'ves', // leaf to leaves
        ];

        foreach ($rules as $ending => $replacement) {
            if ($ending === substr($string, -strlen($ending))) {
                return substr($string, 0, -strlen($ending)) . $replacement;
            }
        }

        return $string . 's';
    }
    // </user-additions>
    // </editor-fold>
}
