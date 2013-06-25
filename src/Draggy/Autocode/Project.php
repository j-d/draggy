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
use Draggy\Autocode\Templates\PHP as PHPTemplates;
use Draggy\Autocode\Templates\JS as JSTemplates;
use Draggy\Autocode\Exceptions\DuplicateAttributeException;
use Draggy\Log;

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

        return parent::setNamespace($namespace);
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

        if ($module != '') {
            if (!in_array($module, $this->modules)) {
                $this->modules[] = $module;
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
        $reservedWords = [];

        if ($this->getLanguage() === 'PHP') {
            // PHP 5.4 reserved words as per http://php.net/manual/en/reserved.keywords.php
            $reservedWords = array_merge($reservedWords, ['__HALT_COMPILER', 'ABSTRACT', 'AND', 'ARRAY', 'AS', 'BREAK', 'CALLABLE', 'CASE', 'CATCH', 'CLASS', 'CLONE', 'CONST', 'CONTINUE', 'DECLARE', 'DEFAULT', 'DIE', 'DO', 'ECHO', 'ELSE', 'ELSEIF', 'EMPTY', 'ENDDECLARE', 'ENDFOR', 'ENDFOREACH', 'ENDIF', 'ENDSWITCH', 'ENDWHILE', 'EVAL()', 'EXIT', 'EXTENDS', 'FINAL', 'FOR', 'FOREACH', 'FUNCTION', 'GLOBAL', 'GOTO', 'IF', 'IMPLEMENTS', 'INCLUDE', 'INCLUDE_ONCE', 'INSTANCEOF', 'INSTEADOF', 'INTERFACE', 'ISSET', 'LIST', 'NAMESPACE', 'NEW', 'OR', 'PRINT', 'PRIVATE', 'PROTECTED', 'PUBLIC', 'REQUIRE', 'REQUIRE_ONCE', 'RETURN', 'STATIC', 'SWITCH', 'THROW', 'TRAIT', 'TRY', 'UNSET', 'USE', 'VAR', 'WHILE', 'XOR']);
        }

        return !in_array(strtoupper($term), $reservedWords);
    }

    public function isValidAttributeName($term)
    {
        if ($this->getORM() === '') {
            return true;
        }

        $reservedWords = [];

        // MySQL 5.5 reserved words as per http://dev.mysql.com/doc/refman/5.5/en/reserved-words.html
        $reservedWords = array_merge($reservedWords, ['ACCESSIBLE', 'ADD', 'ALL', 'ALTER', 'ANALYZE', 'AND', 'AS', 'ASC', 'ASENSITIVE', 'BEFORE', 'BETWEEN', 'BIGINT', 'BINARY', 'BLOB', 'BOTH', 'BY', 'CALL', 'CASCADE', 'CASE', 'CHANGE', 'CHAR', 'CHARACTER', 'CHECK', 'COLLATE', 'COLUMN', 'CONDITION', 'CONSTRAINT', 'CONTINUE', 'CONVERT', 'CREATE', 'CROSS', 'CURRENT_DATE', 'CURRENT_TIME', 'CURRENT_TIMESTAMP', 'CURRENT_USER', 'CURSOR', 'DATABASE', 'DATABASES', 'DAY_HOUR', 'DAY_MICROSECOND', 'DAY_MINUTE', 'DAY_SECOND', 'DEC', 'DECIMAL', 'DECLARE', 'DEFAULT', 'DELAYED', 'DELETE', 'DESC', 'DESCRIBE', 'DETERMINISTIC', 'DISTINCT', 'DISTINCTROW', 'DIV', 'DOUBLE', 'DROP', 'DUAL', 'EACH', 'ELSE', 'ELSEIF', 'ENCLOSED', 'ESCAPED', 'EXISTS', 'EXIT', 'EXPLAIN', 'FETCH', 'FLOAT', 'FLOAT4', 'FLOAT8', 'FOR', 'FORCE', 'FOREIGN', 'FROM', 'FULLTEXT', 'GENERAL', 'GRANT', 'GROUP', 'HAVING', 'HIGH_PRIORITY', 'HOUR_MICROSECOND', 'HOUR_MINUTE', 'HOUR_SECOND', 'IF', 'IGNORE', 'IGNORE_SERVER_IDS', 'IN', 'INDEX', 'INFILE', 'INNER', 'INOUT', 'INSENSITIVE', 'INSERT', 'INT', 'INT1', 'INT2', 'INT3', 'INT4', 'INT8', 'INTEGER', 'INTERVAL', 'INTO', 'IS', 'ITERATE', 'JOIN', 'KEY', 'KEYS', 'KILL', 'LEADING', 'LEAVE', 'LEFT', 'LIKE', 'LIMIT', 'LINEAR', 'LINES', 'LOAD', 'LOCALTIME', 'LOCALTIMESTAMP', 'LOCK', 'LONG', 'LONGBLOB', 'LONGTEXT', 'LOOP', 'LOW_PRIORITY', 'MASTER_HEARTBEAT_PERIOD', 'MASTER_SSL_VERIFY_SERVER_CERT', 'MATCH', 'MAXVALUE', 'MEDIUMBLOB', 'MEDIUMINT', 'MEDIUMTEXT', 'MIDDLEINT', 'MINUTE_MICROSECOND', 'MINUTE_SECOND', 'MOD', 'MODIFIES', 'NATURAL', 'NO_WRITE_TO_BINLOG', 'NOT', 'NULL', 'NUMERIC', 'ON', 'OPTIMIZE', 'OPTION', 'OPTIONALLY', 'OR', 'ORDER', 'OUT', 'OUTER', 'OUTFILE', 'PRECISION', 'PRIMARY', 'PROCEDURE', 'PURGE', 'RANGE', 'READ', 'READ_WRITE', 'READS', 'REAL', /*'REFERENCES',*/ 'REGEXP', 'RELEASE', 'RENAME', 'REPEAT', 'REPLACE', 'REQUIRE', 'RESIGNAL', 'RESTRICT', 'RETURN', 'REVOKE', 'RIGHT', 'RLIKE', 'SCHEMA', 'SCHEMAS', 'SECOND_MICROSECOND', 'SELECT', 'SENSITIVE', 'SEPARATOR', 'SET', 'SHOW', 'SIGNAL', 'SLOW', 'SMALLINT', 'SPATIAL', 'SPECIFIC', 'SQL', 'SQL_BIG_RESULT', 'SQL_CALC_FOUND_ROWS', 'SQL_SMALL_RESULT', 'SQLEXCEPTION', 'SQLSTATE', 'SQLWARNING', 'SSL', 'STARTING', 'STRAIGHT_JOIN', 'TABLE', 'TERMINATED', 'THEN', 'TINYBLOB', 'TINYINT', 'TINYTEXT', 'TO', 'TRAILING', 'TRIGGER', 'UNDO', 'UNION', 'UNIQUE', 'UNLOCK', 'UNSIGNED', 'UPDATE', 'USAGE', 'USE', 'USING', 'UTC_DATE', 'UTC_TIME', 'UTC_TIMESTAMP', 'VALUES', 'VARBINARY', 'VARCHAR', 'VARCHARACTER', 'VARYING', 'WHEN', 'WHERE', 'WHILE', 'WITH', 'WRITE', 'XOR', 'YEAR_MONTH', 'ZEROFILL', 'FALSE', 'TRUE']);

        return !in_array(strtoupper($term), $reservedWords);
    }

    private function xmlEntityToEntity(\SimpleXMLElement $class, $moduleName = '')
    {
        $classAttributes = (array)$class->attributes();
        $classAttributes = $classAttributes['@attributes'];
        $entityName      = $classAttributes['name'];

        $entityClass = $this->getEntityClass();

        /** @var Entity $entity */
        if ($moduleName !== '') {
            $entity = new $entityClass( $this, $this->namespace . '\\' . $moduleName, $moduleName, $entityName );
        } else {
            $entity = new $entityClass( $this, $this->namespace, '', $entityName );
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

    public function loadDesign(\SimpleXMLElement $xmlDesign)
    {
        // Load project properties
        $projectProperties = (array) $xmlDesign->xpath('project')[0];

        $this->setLanguage((string) $projectProperties['language']);
        $this->setDescription((string) $projectProperties['description']);
        $this->setOrm((string) $projectProperties['orm']);
        $this->setFramework((string) $projectProperties['framework']);

        if ($this->getLanguage() === 'PHP') {
            $this->setAttributeClass('Draggy\\Autocode\\PHPAttribute');
            $this->setEntityClass('Draggy\\Autocode\\PHPEntity');
        } elseif ($this->getLanguage() === 'JS') {
            $this->setAttributeClass('Draggy\\Autocode\\JSAttribute');
            $this->setEntityClass('Draggy\\Autocode\\Entity');
        }

        $attributeClass = $this->getAttributeClass();

        // Load autocode settings
        $autocodeProperties = (array) $xmlDesign->xpath('autocode')[0];

        if (!empty($autocodeProperties['base'])) {
            $this->setBase($autocodeProperties['base'] === 'true');
        }

        if (!empty($autocodeProperties['overwrite'])) {
            $this->setOverwrite($autocodeProperties['overwrite'] === 'true');
        }

        if (!empty($autocodeProperties['delete-unmapped'])) {
            $this->setDeleteUnmapped($autocodeProperties['delete-unmapped'] === 'true');
        }

        if (!empty($autocodeProperties['validation'])) {
            $this->setValidation($autocodeProperties['validation'] === 'true');
        }

        if (!empty($autocodeProperties['namespace'])) {
            $this->setNamespace($autocodeProperties['namespace']);
        }

        $autocodeTemplateProperties = (array) $xmlDesign->xpath('autocode/templates')[0];

        if (!empty($autocodeTemplateProperties['entity'])) {
            if (!class_exists($autocodeTemplateProperties['entity'])) {
                throw new \RuntimeException(sprintf('The specified class file \'%s\' cannot be loaded', $autocodeProperties['entity']));
            }

            $this->setEntityTemplate(new $autocodeTemplateProperties['entity']);
        }

        if (!empty($autocodeTemplateProperties['entity-base'])) {
            if (!class_exists($autocodeTemplateProperties['entity-base'])) {
                throw new \RuntimeException(sprintf('The specified class file \'%s\' cannot be loaded', $autocodeProperties['entity-base']));
            }

            $this->setEntityBaseTemplate(new $autocodeTemplateProperties['entity-base']);
        }

        if (!empty($autocodeTemplateProperties['repository'])) {
            if (!class_exists($autocodeTemplateProperties['repository'])) {
                throw new \RuntimeException(sprintf('The specified class file \'%s\' cannot be loaded', $autocodeProperties['repository']));
            }

            $this->setRepositoryTemplate(new $autocodeTemplateProperties['repository']);
        }

        if (!empty($autocodeTemplateProperties['form'])) {
            if (!class_exists($autocodeTemplateProperties['form'])) {
                throw new \RuntimeException(sprintf('The specified class file \'%s\' cannot be loaded', $autocodeProperties['form']));
            }

            $this->setFormTemplate(new $autocodeTemplateProperties['form']);
        }

        if (!empty($autocodeTemplateProperties['form-base'])) {
            if (!class_exists($autocodeTemplateProperties['form-base'])) {
                throw new \RuntimeException(sprintf('The specified class file \'%s\' cannot be loaded', $autocodeProperties['form-base']));
            }

            $this->setFormBaseTemplate(new $autocodeTemplateProperties['form-base']);
        }

        if (!empty($autocodeTemplateProperties['controller'])) {
            if (!class_exists($autocodeTemplateProperties['controller'])) {
                throw new \RuntimeException(sprintf('The specified class file \'%s\' cannot be loaded', $autocodeProperties['controller']));
            }

            $this->setControllerTemplate(new $autocodeTemplateProperties['controller']);
        }

        if (!empty($autocodeTemplateProperties['fixtures'])) {
            if (!class_exists($autocodeTemplateProperties['fixtures'])) {
                throw new \RuntimeException(sprintf('The specified class file \'%s\' cannot be loaded', $autocodeProperties['fixtures']));
            }

            $this->setFixturesTemplate(new $autocodeTemplateProperties['fixtures']);
        }

        if (!empty($autocodeTemplateProperties['routes'])) {
            if (!class_exists($autocodeTemplateProperties['routes'])) {
                throw new \RuntimeException(sprintf('The specified class file \'%s\' cannot be loaded', $autocodeProperties['routes']));
            }

            $this->setRoutesTemplate(new $autocodeTemplateProperties['routes']);
        }

        if (!empty($autocodeTemplateProperties['routes-routing'])) {
            if (!class_exists($autocodeTemplateProperties['routes-routing'])) {
                throw new \RuntimeException(sprintf('The specified class file \'%s\' cannot be loaded', $autocodeProperties['routes-routing']));
            }

            $this->setRoutesRoutingTemplate(new $autocodeTemplateProperties['routes-routing']);
        }

        if (!empty($autocodeTemplateProperties['crud-create-twig'])) {
            if (!class_exists($autocodeTemplateProperties['crud-create-twig'])) {
                throw new \RuntimeException(sprintf('The specified class file \'%s\' cannot be loaded', $autocodeTemplateProperties['crud-create-twig']));
            }

            $this->setCrudCreateTwigTemplate(new $autocodeTemplateProperties['crud-create-twig']);
        }

        if (!empty($autocodeTemplateProperties['crud-read-twig'])) {
            if (!class_exists($autocodeTemplateProperties['crud-read-twig'])) {
                throw new \RuntimeException(sprintf('The specified class file \'%s\' cannot be loaded', $autocodeTemplateProperties['crud-read-twig']));
            }

            $this->setCrudReadTwigTemplate(new $autocodeTemplateProperties['crud-read-twig']);
        }

        if (!empty($autocodeTemplateProperties['crud-update-twig'])) {
            if (!class_exists($autocodeTemplateProperties['crud-update-twig'])) {
                throw new \RuntimeException(sprintf('The specified class file \'%s\' cannot be loaded', $autocodeTemplateProperties['crud-update-twig']));
            }

            $this->setCrudUpdateTwigTemplate(new $autocodeTemplateProperties['crud-update-twig']);
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
        $childClasses = $xmlDesign->xpath('*[self::module or self::loose]/*[@inheritingFrom and (self::class or self::abstract)]');

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
        $foreignKeys = $xmlDesign->xpath('relationships/relation[@type=\'OneToOne\' or @type=\'OneToMany\']');

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

                // $manyToManyEntity->setRenderizable(false);
            }
        }

        // Add OneToOne and OneToMany inverse attributes
        $foreignKeys = $xmlDesign->xpath('relationships/relation[@type=\'OneToOne\' or @type=\'OneToMany\']');

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

            if ($targetEntity->getRenderizable()) {
                if ($type === 'OneToOne') {
                    /** @var Attribute $inverseAttribute */
                    $inverseAttribute = new $attributeClass($sourceEntity, $targetEntity->getLowerName(), 'object');
                    $inverseAttribute
                        ->setInverse(true)
                        ->setSubtype($targetEntity->getRelativePathName())
                        ->setForeign('OneToOne')
                        ->setForeignEntity($targetEntity)
                        ->setForeignKey($targetAttribute)
                        ->setNull($targetAttribute->getNull()); // TODO: CHECK

                    try {
                        $sourceEntity->addAttribute($inverseAttribute);
                    } catch (DuplicateAttributeException $e) {
                        //$existingAttribute = $sourceEntity->getAttributeByName($inverseAttribute->getName());

                        $this->log->prepend('*** The OneToOne inverse attribute \'' . $inverseAttribute->getLowerName() . '\' could not be added to the Entity \'' . $sourceEntity->getName() . '\' because there is an attribute with that name already there.');
                    }
                } else { // ManyToOne
                    /** @var Attribute $inverseAttribute */
                    $inverseAttribute = new $attributeClass($sourceEntity, $targetEntity->getPluralLowerName(), 'array');
                    $inverseAttribute
                        ->setInverse(true)
                        ->setSubtype($targetEntity->getRelativePathName())
                        ->setForeign('ManyToOne')
                        ->setForeignEntity($targetEntity)
                        ->setForeignKey($targetAttribute)
                        ->setNull($targetAttribute->getNull()) // TODO: CHECK
                        ->setReverseAttribute($targetAttribute);

                    $targetAttribute->setReverseAttribute($inverseAttribute);

                    try {
                        $sourceEntity->addAttribute($inverseAttribute);
                    } catch (DuplicateAttributeException $e) {
                        //$existingAttribute = $sourceEntity->getAttributeByName($inverseAttribute->getName());

                        $this->log->prepend('*** The ManyToOne inverse attribute \'' . $inverseAttribute->getLowerName() . '\' could not be added to the Entity \'' . $sourceEntity->getName() . '\' because there is an attribute with that name already there.');
                    }
                }

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

    private function completeMissingTemplates()
    {
        if (is_null($this->getEntityTemplate())) {
            $this->setEntityTemplate(new PHPTemplates\Entity1());
        }

        if (is_null($this->getEntityBaseTemplate())) {
            $this->setEntityBaseTemplate(new PHPTemplates\EntityBase1());
        }

        if (is_null($this->getRepositoryTemplate())) {
            $this->setRepositoryTemplate(new PHPTemplates\Symfony2\Repository());
        }

        if (is_null($this->getFormTemplate())) {
            $this->setFormTemplate(new PHPTemplates\Form());
        }

        if (is_null($this->getFormBaseTemplate())) {
            $this->setFormBaseTemplate(new PHPTemplates\FormBase1());
        }

        if (is_null($this->getControllerTemplate())) {
            $this->setControllerTemplate(new PHPTemplates\Symfony2\Controller());
        }

        if (is_null($this->getFixturesTemplate())) {
            $this->setFixturesTemplate(new PHPTemplates\Symfony2\Fixtures());
        }

        if (is_null($this->getRoutesTemplate())) {
            $this->setRoutesTemplate(new PHPTemplates\Symfony2\Routes());
        }

        if (is_null($this->getRoutesRoutingTemplate())) {
            $this->setRoutesRoutingTemplate(new PHPTemplates\Symfony2\RoutesRouting());
        }

        if (is_null($this->getCrudCreateTwigTemplate())) {
            $this->setCrudCreateTwigTemplate(new PHPTemplates\CrudCreate());
        }

        if (is_null($this->getCrudReadTwigTemplate())) {
            $this->setCrudReadTwigTemplate(new PHPTemplates\CrudRead());
        }

        if (is_null($this->getCrudUpdateTwigTemplate())) {
            $this->setCrudUpdateTwigTemplate(new PHPTemplates\CrudUpdate());
        }
    }

    public function getChanges($path)
    {
        $fileCollection = $this->getModelFiles($path);
        $fileCollection->setOverwrite($this->getOverwrite());

        $diffArray = $fileCollection->getDiff();

        return $diffArray;
    }


    public function saveTo($path)
    {
        if (!is_dir($path)) {
            //user_error('Was expecting to find the path ' . $path, E_USER_WARNING);
            mkdir($path);
        }

        $fileCollection = $this->getModelFiles($path);
        $fileCollection->setOverwrite($this->getOverwrite());

        $fileCollection->save();

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

        $this->completeMissingTemplates();

        $fileCollection->add($this->findExistingExtraFiles($path));

        $namespacePath = str_replace('\\', '/', $path . $this->getNamespace() . '/');

        foreach ($this->getEntities() as $entity) {
            if ($entity->getRenderizable()) {
                if ($entity->getNamespace() === '') {
                    $targetPath = $namespacePath;
                } else {
                    $targetPath = $path . str_replace('\\', '/', $entity->getNamespace()) . '/';
                }

                if ($this->getLanguage() === 'PHP') {
                    $fileCollection->add($this->getPHPEntityFile($entity, $targetPath));
                    $fileCollection->add($this->getRepositoryFile($entity, $targetPath));
                    $fileCollection->add($this->getFormFile($entity, $targetPath));
                    $fileCollection->add($this->getControllerFile($entity, $targetPath));
                    $fileCollection->add($this->getFixturesFile($entity, $targetPath));
                    $fileCollection->add($this->getRoutesFile($entity, $targetPath));
                    $fileCollection->add($this->getTwigCreateFile($entity, $targetPath));
                    $fileCollection->add($this->getTwigReadFile($entity, $targetPath));
                    $fileCollection->add($this->getTwigUpdateFile($entity, $targetPath));
                } elseif ($this->getLanguage() === 'JS') {
                    $fileCollection->add($this->getJSEntityFile($entity, $targetPath));
                }

            }
        }

        if ($this->getLanguage() === 'PHP') {
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

        if ($this->base) {
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
        return 'Doctrine2' === $this->getOrm();
    }
    // </user-additions>
    // </editor-fold>
}
