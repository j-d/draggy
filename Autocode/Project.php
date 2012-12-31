<?php
// Autocode\Project.php

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

namespace Autocode;

use Autocode\Base\ProjectBase;
// <user-additions part="use">
use Autocode\Templates\PHP as PHPTemplates;
use Autocode\Templates\JS as JSTemplates;
use Autocode\Exceptions\DuplicateAttributeException;
// </user-additions>

/**
 * Autocode\Entity\Project
 */
class Project extends ProjectBase
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Constructor">
    // <user-additions part="constructorDeclaration">
    public function __construct($namespace)
    // </user-additions>
    {
        // <user-additions part="constructor">
        if (substr($namespace, 0, -1) == '\\') {
            $namespace = substr($namespace, 0, -1);
        }

        $this->setNamespace($namespace);
        // </user-additions>
    }
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
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
        $reservedWords = array_merge($reservedWords, ['ACCESSIBLE', 'ADD', 'ALL', 'ALTER', 'ANALYZE', 'AND', 'AS', 'ASC', 'ASENSITIVE', 'BEFORE', 'BETWEEN', 'BIGINT', 'BINARY', 'BLOB', 'BOTH', 'BY', 'CALL', 'CASCADE', 'CASE', 'CHANGE', 'CHAR', 'CHARACTER', 'CHECK', 'COLLATE', 'COLUMN', 'CONDITION', 'CONSTRAINT', 'CONTINUE', 'CONVERT', 'CREATE', 'CROSS', 'CURRENT_DATE', 'CURRENT_TIME', 'CURRENT_TIMESTAMP', 'CURRENT_USER', 'CURSOR', 'DATABASE', 'DATABASES', 'DAY_HOUR', 'DAY_MICROSECOND', 'DAY_MINUTE', 'DAY_SECOND', 'DEC', 'DECIMAL', 'DECLARE', 'DEFAULT', 'DELAYED', 'DELETE', 'DESC', 'DESCRIBE', 'DETERMINISTIC', 'DISTINCT', 'DISTINCTROW', 'DIV', 'DOUBLE', 'DROP', 'DUAL', 'EACH', 'ELSE', 'ELSEIF', 'ENCLOSED', 'ESCAPED', 'EXISTS', 'EXIT', 'EXPLAIN', 'FETCH', 'FLOAT', 'FLOAT4', 'FLOAT8', 'FOR', 'FORCE', 'FOREIGN', 'FROM', 'FULLTEXT', 'GENERAL', 'GRANT', 'GROUP', 'HAVING', 'HIGH_PRIORITY', 'HOUR_MICROSECOND', 'HOUR_MINUTE', 'HOUR_SECOND', 'IF', 'IGNORE', 'IGNORE_SERVER_IDS', 'IN', 'INDEX', 'INFILE', 'INNER', 'INOUT', 'INSENSITIVE', 'INSERT', 'INT', 'INT1', 'INT2', 'INT3', 'INT4', 'INT8', 'INTEGER', 'INTERVAL', 'INTO', 'IS', 'ITERATE', 'JOIN', 'KEY', 'KEYS', 'KILL', 'LEADING', 'LEAVE', 'LEFT', 'LIKE', 'LIMIT', 'LINEAR', 'LINES', 'LOAD', 'LOCALTIME', 'LOCALTIMESTAMP', 'LOCK', 'LONG', 'LONGBLOB', 'LONGTEXT', 'LOOP', 'LOW_PRIORITY', 'MASTER_HEARTBEAT_PERIOD', 'MASTER_SSL_VERIFY_SERVER_CERT', 'MATCH', 'MAXVALUE', 'MEDIUMBLOB', 'MEDIUMINT', 'MEDIUMTEXT', 'MIDDLEINT', 'MINUTE_MICROSECOND', 'MINUTE_SECOND', 'MOD', 'MODIFIES', 'NATURAL', 'NO_WRITE_TO_BINLOG', 'NOT', 'NULL', 'NUMERIC', 'ON', 'OPTIMIZE', 'OPTION', 'OPTIONALLY', 'OR', 'ORDER', 'OUT', 'OUTER', 'OUTFILE', 'PRECISION', 'PRIMARY', 'PROCEDURE', 'PURGE', 'RANGE', 'READ', 'READ_WRITE', 'READS', 'REAL', 'REFERENCES', 'REGEXP', 'RELEASE', 'RENAME', 'REPEAT', 'REPLACE', 'REQUIRE', 'RESIGNAL', 'RESTRICT', 'RETURN', 'REVOKE', 'RIGHT', 'RLIKE', 'SCHEMA', 'SCHEMAS', 'SECOND_MICROSECOND', 'SELECT', 'SENSITIVE', 'SEPARATOR', 'SET', 'SHOW', 'SIGNAL', 'SLOW', 'SMALLINT', 'SPATIAL', 'SPECIFIC', 'SQL', 'SQL_BIG_RESULT', 'SQL_CALC_FOUND_ROWS', 'SQL_SMALL_RESULT', 'SQLEXCEPTION', 'SQLSTATE', 'SQLWARNING', 'SSL', 'STARTING', 'STRAIGHT_JOIN', 'TABLE', 'TERMINATED', 'THEN', 'TINYBLOB', 'TINYINT', 'TINYTEXT', 'TO', 'TRAILING', 'TRIGGER', 'UNDO', 'UNION', 'UNIQUE', 'UNLOCK', 'UNSIGNED', 'UPDATE', 'USAGE', 'USE', 'USING', 'UTC_DATE', 'UTC_TIME', 'UTC_TIMESTAMP', 'VALUES', 'VARBINARY', 'VARCHAR', 'VARCHARACTER', 'VARYING', 'WHEN', 'WHERE', 'WHILE', 'WITH', 'WRITE', 'XOR', 'YEAR_MONTH', 'ZEROFILL', 'FALSE', 'TRUE']);

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
            $this->log .= 'Found entity: ' . $moduleName . '\\' . $entityName . "\n";
        } else {
            $this->log .= 'Found entity: ' . $entityName . "\n";
        }

        if ( ($entity->getCrudCreate() || $entity->getCrudUpdate()) && !$entity->getHasForm() ) {
            throw new \Exception( 'On the entity ' . $entity->getName() . ' you have enabled CRUD (C or U) but it is not set to have a Form' );
        }

        if ( !is_null($entity->getCrud()) && !$entity->getHasController() ) {
            throw new \Exception( 'On the entity ' . $entity->getName() . ' you have enabled CRUD but it is not set to have a Controller' );
        }

        return $entity;
    }

    public function loadFile($file)
    {
        if (!is_file($file))
            throw new \Exception( 'Not valid model file provided (' . $file . ')' );

        $xmlDesign = simplexml_load_file($file);

        // Load project properties
        $projectProperties = (array) $xmlDesign->xpath('project')[0];

        $this->setLanguage((string) $projectProperties['language']);
        $this->setDescription((string) $projectProperties['description']);
        $this->setOrm((string) $projectProperties['orm']);
        $this->setFramework((string) $projectProperties['framework']);

        if ($this->getLanguage() === 'PHP') {
            $this->setAttributeClass('Autocode\\PHPAttribute');
            $this->setEntityClass('Autocode\\PHPEntity');
        } elseif ($this->getLanguage() === 'JS') {
            $this->setAttributeClass('Autocode\\JSAttribute');
            $this->setEntityClass('Autocode\\Entity');
        }

        $attributeClass = $this->getAttributeClass();

        // Process entities

        $modules = $xmlDesign->xpath('module');

        // Process in three steps. First create all the entities, second add all the attributes, and finally link the foreign entities.
        // This way it can reference foreign entities and attributes because they will exist.

        // First step: Add the entities (Classes or Abstracts)
        foreach ($modules as $module) {
            $moduleName = (string)$module->attributes()->name;

            $this->log .= 'Found module: ' . $moduleName . "\n";

            // Classes
            $classes = $module->xpath('*[self::class or self::abstract]');

            foreach ($classes as $class) {
                $class->addAttribute('fullyQualifiedName', $moduleName . '\\' . $class->attributes()->name);
                $entity = $this->xmlEntityToEntity($class, $moduleName);
                $this->addEntity($entity);
            }
        }

        // Add loose entities
        $loose = $xmlDesign->xpath('loose')[0];
        $classes = $loose->xpath('*[self::class or self::abstract]');

        foreach ($classes as $class) {
            $class->addAttribute('fullyQualifiedName',$class->attributes()->name); // Add fully qualified name
            $entity = $this->xmlEntityToEntity($class);
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
            $manyToManyEntityName = $manyToManyEntityName['@attributes']['name'];

            $manyToManyEntity = &$this->getEntityByFullyQualifiedName($manyToManyEntityName);

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
            if ($type == 'OneToOne') {
                $targetAttribute->setForeign('OneToOne');

                if ($targetEntity->getRenderizable()) {
                    /** @var Attribute $inverseAttribute */
                    $inverseAttribute = new $attributeClass($sourceEntity,$targetEntity->getLowerName(),'object');
                    $inverseAttribute
                        ->setInverse(true)
                        ->setSubtype($targetEntity->getName())
                        ->setForeign('OneToOne')
                        ->setForeignEntity($targetEntity)
                        ->setForeignKey($targetAttribute)
                        ->setNull($targetAttribute->getNull()); // TODO: CHECK

                    try {
                        $sourceEntity->addAttribute($inverseAttribute);
                    } catch (DuplicateAttributeException $e) {
                        $existingAttribute = $sourceEntity->getAttributeByName($inverseAttribute->getName());

                        $this->log = '*** The OneToOne inverse attribute \'' . $inverseAttribute->getLowerName() . '\' could not be added to the Entity \'' . $sourceEntity->getName() . '\' because there is an attribute with that name already there.' . "\n" . $this->log;
                    }
                }
            } else {
                $targetAttribute->setForeign('ManyToOne');
            }

            $targetAttribute->setOwnerSide(true);

            //$sourceAttribute->setForeignEntity($targetEntity);
            //$sourceAttribute->setForeignKey($targetAttribute);

            $targetAttribute->setForeignEntity($sourceEntity);
            $targetAttribute->setForeignKey($sourceAttribute);
        }

        foreach ($manyToManyRelationships as $manyToManyRelationship) {
            $manyToManyEntityName = (array)$manyToManyRelationship->attributes();
            $manyToManyEntityName = $manyToManyEntityName['@attributes']['name'];

            $manyToManyEntity = &$this->getEntityByFullyQualifiedName($manyToManyEntityName);

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

        return $this;
    }

    private function findExistingExtraFiles($path)
    {
        $path .= $this->namespace;

        if (is_dir($path)) {
            foreach (scandir($path) as $folder) {
                if (is_dir($path . '/' . $folder . '/Entity/') && !in_array($folder, ['.', '..']))
                    foreach (scandir($path . '/' . $folder . '/Entity/') as $file)
                        if (!is_dir($path . '/' . $folder . '/Entity/' . $file)) {
                            $file = str_replace('Repository.php','.php',$file); // Repositories are allowed

                            try {
                                $entity = $this->getEntityByFullyQualifiedName(substr($file, 0, -4));

                                if (!$entity->getRenderizable())
                                    $this->log = '*** Perhaps the file ' . $folder . '/Entity/' . $file . ' should not be there as there is not an it belongs to an implicit ManyToMany relationship.' . "\n" . $this->log;

                                if ($entity->getModule() != $folder)
                                    $this->log = '*** Perhaps the file ' . $folder . '/Entity/' . $file . ' should be in the project ' . $entity->getModule() . '.' . "\n" . $this->log;
                            } catch (\RuntimeException $e) {
                                if (!$this->deleteUnmapped)
                                    $this->log = '*** Perhaps the file ' . $folder . '/Entity/' . $file . ' should not be there as there is not an entity linked to it.' . "\n" . $this->log;
                                else {
                                    if (file_exists($path . '/' . $folder . '/Entity/' . $file)) {
                                        unlink($path . '/' . $folder . '/Entity/' . $file);
                                        $this->log = '*** The file ' . $path . '/' . $folder . '/Entity/' . $file . ' has been deleted as there is not an entity linked to it.' . "\n" . $this->log;
                                    }
                                    if ($this->base) {
                                        $baseFile = $path . '/' . $folder . '/Entity/Base/' . str_replace('.php','Base.php',$file);
                                        if (file_exists($baseFile)) {
                                            unlink($baseFile);
                                            $this->log = '*** The file ' . $baseFile . ' has been deleted as there is not an entity linked to it.' . "\n" . $this->log;
                                        }
                                    }
                                }
                            }
                        }
            }
        }
    }

    private function completeMissingTemplates()
    {
        if (is_null($this->getEntityTemplate())) {
            $this->setEntityTemplate(new PHPTemplates\Entity1());
        }

        if (is_null($this->getEntityBaseTemplate())) {
            $this->setEntityBaseTemplate(new PHPTemplates\EntityBase());
        }

        if (is_null($this->getRepositoryTemplate())) {
            $this->setRepositoryTemplate(new PHPTemplates\Repository());
        }

        if (is_null($this->getFormTemplate())) {
            $this->setFormTemplate(new PHPTemplates\Form());
        }

        if (is_null($this->getFormBaseTemplate())) {
            $this->setFormBaseTemplate(new PHPTemplates\FormBase());
        }

        if (is_null($this->getControllerTemplate())) {
            $this->setControllerTemplate(new PHPTemplates\Controller());
        }

        if (is_null($this->getFixturesTemplate())) {
            $this->setFixturesTemplate(new PHPTemplates\Fixtures());
        }

        if (is_null($this->getRoutesTemplate())) {
            $this->setRoutesTemplate(new PHPTemplates\Routes());
        }

        if (is_null($this->getRoutesRoutingTemplate())) {
            $this->setRoutesRoutingTemplate(new PHPTemplates\RoutesRouting());
        }

        if (is_null($this->getCrudCreateTwigTemplate())) {
            $this->setCrudCreateTwigTemplate(new PHPTemplates\CrudCreateTwig());
        }

        if (is_null($this->getCrudReadTwigTemplate())) {
            $this->setCrudReadTwigTemplate(new PHPTemplates\CrudReadTwig());
        }

        if (is_null($this->getCrudUpdateTwigTemplate())) {
            $this->setCrudUpdateTwigTemplate(new PHPTemplates\CrudUpdateTwig());
        }


    }

    public function saveTo($path)
    {
        $this->completeMissingTemplates();

        $this->findExistingExtraFiles($path);

        if (!is_dir($path)) {
            user_error('Was expecting to find the path ' . $path, E_USER_WARNING);
            mkdir($path);
        }

        $namespacePath = str_replace('\\', '/', $path . $this->namespace . '/');

        if (!is_dir($namespacePath)) {
            user_error('Was expecting to find the path ' . $namespacePath, E_USER_WARNING);
            mkdir($namespacePath);
        }

        foreach ($this->entities as $entity)
            if ($entity->getRenderizable()) {
                if ($entity->getNamespace() === '') {
                    $targetPath = $namespacePath;
                } else {
                    $targetPath = $path . str_replace('\\', '/', $entity->getNamespace()) . '/';
                }

                if (!is_dir($targetPath)) {
                    user_error('Was expecting to find the path ' . $targetPath . '. Have you created the package or bundle?', E_USER_WARNING);
                    mkdir($targetPath);
                }

                $entityPath = $targetPath;

                if ($this->getFramework() == 'Symfony2') {
                    $entityPath .= 'Entity/';
                }

                $basePath = $entityPath;

                if ($this->base) {
                    $basePath .= 'Base/';
                }

                if ($this->getLanguage() === 'PHP') {
                    $targetFile = $basePath . $entity->getNameBase() . '.php';
                    $this->saveFile($targetFile,'File',$this->getEntityTemplate()->setEntity($entity)->render());

                    if ($this->getBase()) {
                        $targetFile = $entityPath . $entity->getName() . '.php';
                        $this->saveFile($targetFile,'Base file',$this->getEntityBaseTemplate()->setEntity($entity)->render());
                    }

                    $this->saveRepository($entity, $targetPath);
                    $this->saveForm($entity, $targetPath);
                    $this->saveController($entity, $targetPath);
                    $this->saveFixtures($entity, $targetPath);
                    $this->saveRoutes($entity, $targetPath);
                    $this->saveTwigCreate($entity, $targetPath);
                    $this->saveTwigUpdate($entity, $targetPath);
                    $this->saveTwigRead($entity, $targetPath);

                } elseif ($this->getLanguage() === 'JS') {
                    $targetFile = $basePath . $entity->getNameBase() . '.js';
                    $this->saveFile($targetFile,'File',$this->getEntityTemplate()->setEntity($entity)->render());

                    if ($this->getBase()) {
                        $targetFile = $entityPath . $entity->getName() . '.js';
                        $this->saveFile($targetFile,'Base file',$this->getEntityBaseTemplate()->setEntity($entity)->render());
                    }
                }

            }

        foreach ($this->modules as $module) {
            if ($this->getLanguage() === 'PHP') {
                $targetPath = $path . str_replace('\\', '/', $this->moduleNamespaces[$module]) . '/';

                $this->saveRoutesRouting($module, $targetPath);
            }
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     */
    private function saveRepository(Entity $entity, $path)
    {
        $path .= 'Entity/';

        $targetFile = $path . $entity->getName() . 'Repository.php';

        if ($entity->getHasRepository()) {
            $this->saveFile($targetFile,'Repository',$this->getRepositoryTemplate()->setEntity($entity)->render());
        }
        elseif (file_exists($targetFile)) {
            $this->log = '*** Perhaps the file ' . $targetFile . ' should not be there as the entity is not marked to have a repository.' . "\n" . $this->log;
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     */
    private function saveForm($entity, $path)
    {
        $path .= 'Form/';
        $formBasePath = $path . 'Base/';

        $targetFile = $path . $entity->getName() . 'Type.php';
        $targetBaseFile = $formBasePath . $entity->getName() . 'TypeBase.php';

        if ($entity->getHasForm()) {
            // Form
            $this->saveFile($targetFile,'Form',$this->getFormTemplate()->setEntity($entity)->render());

            // Form Base
            $this->saveFile($targetBaseFile,'Form Base',$this->getFormBaseTemplate()->setEntity($entity)->render());

            // Form Dependencies
            /*foreach ($entity->getAttributes() as $attr) {
                if(!is_null($attr->getForeignEntity()) && $attr->getOwnerSide()) {
                    $componentName = $entity->getName() . '_' . $attr->getForeignEntity()->getName();

                    $targetComponentBaseFile = $formBasePath . $componentName . 'TypeBase.php';

                    $this->saveFile($targetComponentBaseFile,'Component Base Form', $attr->getForeignEntity()->toFormComponentBaseFile($entity));

                    $targetComponentFile = $path . $componentName . 'Type.php';

                    $this->saveFile($targetComponentFile,'Component Form', $attr->getForeignEntity()->toFormComponentFile($entity));
                }
            }*/
        }
        else {
            if (file_exists($targetFile)) {
                $this->log = '*** Perhaps the file ' . $targetFile . ' should not be there as the entity is not marked to have a form.' . "\n" . $this->log;
            }

            if (file_exists($targetBaseFile)) {
                $this->log = '*** Perhaps the file ' . $targetBaseFile . ' should not be there as the entity is not marked to have a form.' . "\n" . $this->log;
            }
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     */
    private function saveController($entity, $path)
    {
        $path .= 'Controller/';

        $targetFile = $path . $entity->getName() . 'Controller.php';

        if ($entity->getHasController()) {
            $this->saveFile($targetFile,$entity->getName() . 'Controller',$this->getControllerTemplate()->setEntity($entity)->render());
        }
        elseif (file_exists($targetFile)) {
            $this->log = '*** Perhaps the file ' . $targetFile . ' should not be there as the entity is not marked to have a controller.' . "\n" . $this->log;
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     */
    private function saveFixtures($entity, $path)
    {
        $path .= 'DataFixtures/ORM/';

        $targetFile = $path . $entity->getName() . 'Fixtures.php';

        if ($entity->getHasFixtures()) {
            $this->saveFile($targetFile,$entity->getName() . 'Fixtures',$this->getFixturesTemplate()->setEntity($entity)->render());
        }
        elseif (file_exists($targetFile)) {
            $this->log = '*** Perhaps the file ' . $targetFile . ' should not be there as the entity is not marked to have fixtures.' . "\n" . $this->log;
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     */
    private function saveRoutes($entity, $path)
    {
        $path .= 'Resources/config/';

        $targetFile = $path . 'auto_' . $entity->getLowerName() . '.yml';

        if (!is_null($entity->getCrud())) {
            $this->saveFile($targetFile,$entity->getName() . '-CRUD',$this->getRoutesTemplate()->setEntity($entity)->render());
        }
        elseif (file_exists($targetFile)) {
            $this->log = '*** Perhaps the file ' . $targetFile . ' should not be there as the entity is not marked to have CRUD.' . "\n" . $this->log;
        }
    }

    /**
     * @param string $module
     * @param string $path
     */
    private function saveRoutesRouting($module, $path)
    {
        $path .= 'Resources/config/';
        $targetFile = $path . 'routing.yml';

        $routesArray = [];

        /** @var Entity $entity */
        foreach ($this->moduleEntities[$module] as $entity) {
            if (!is_null($entity->getCrud())) {
                $routesArray[] = $this->getRoutesRoutingTemplate()->setEntity($entity)->render();
            }
        }

        if (count($routesArray) > 0) {
            $routes =   '# <system-additions part="routes">' . "\n" .
                implode("\n",$routesArray) .
                '# </system-additions>' . "\n";

            $this->addToFile($targetFile, $this->namespace, $routes);
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     */
    private function saveTwigCreate($entity, $path)
    {
        $path .= 'Resources/views/' . $entity->getName() . '/';

        $targetFile = $path . 'add' . $entity->getName() . '.html.twig.php';

        if ($entity->getCrudCreate()) {
            $this->saveFile($targetFile,$entity->getName() . '-CRUD(C)',$this->getCrudCreateTwigTemplate()->setEntity($entity)->render());
        }
        elseif (file_exists($targetFile)) {
            $this->log = '*** Perhaps the file ' . $targetFile . ' should not be there as the entity is not marked to have CRUD(C).' . "\n" . $this->log;
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     */
    private function saveTwigUpdate($entity, $path)
    {
        $path .= 'Resources/views/' . $entity->getName() . '/';

        $targetFile = $path . 'edit' . $entity->getName() . '.html.twig.php';

        if ($entity->getCrudCreate()) {
            $this->saveFile($targetFile,$entity->getName() . '-CRUD(U)',$this->getCrudUpdateTwigTemplate()->setEntity($entity)->render());
        }
        elseif (file_exists($targetFile)) {
            $this->log = '*** Perhaps the file ' . $targetFile . ' should not be there as the entity is not marked to have CRUD(U).' . "\n" . $this->log;
        }
    }

    /**
     * @param Entity $entity
     * @param string $path
     */
    private function saveTwigRead($entity, $path)
    {
        $path .= 'Resources/views/' . $entity->getName() . '/';

        $targetFile = $path . 'list' . $entity->getName() . '.html.twig.php';

        if ($entity->getCrudCreate()) {
            $this->saveFile($targetFile,$entity->getName() . '-CRUD(R)',$this->getCrudReadTwigTemplate()->setEntity($entity)->render());
        }
        elseif (file_exists($targetFile)) {
            $this->log = '*** Perhaps the file ' . $targetFile . ' should not be there as the entity is not marked to have CRUD(R).' . "\n" . $this->log;
        }
    }

    public function saveFile ($targetFile, $description, $contents)
    {
        $folder = pathinfo($targetFile,PATHINFO_DIRNAME);

        if(!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        if (!file_exists($targetFile)) {
            file_put_contents($targetFile, $contents);
            $this->log .= 'Saved ' . $description . ' to ' . $targetFile . "\n";
        }
        elseif ($this->overwrite) {
            $existingFile = file_get_contents($targetFile);
            $newFile = $this->keepUserAdditions($contents,$existingFile, $description);

            file_put_contents($targetFile, $newFile);

            $this->log .= $description . ' file existed and modified: ' . $targetFile . "\n";
        }
        else {
            $this->log = '*** You may need to manually change the ' . $description . ' file ' . $targetFile . ' as the template might have changed since you started using it.' . "\n" . $this->log;
        }
    }

    public function addToFile ($targetFile, $description, $contents, $addAtEndIfMissing=true)
    {
        $folder = pathinfo($targetFile,PATHINFO_DIRNAME);

        if(!is_dir($folder)) {
            mkdir($folder);
        }

        if (!file_exists($targetFile)) {
            file_put_contents($targetFile, $contents);
            $this->log .= 'Saved ' . $description . ' to ' . $targetFile . "\n";
        }
        else {
            $existingFile = file_get_contents($targetFile);
            $newFile = $this->addSystemAdditions($contents,$existingFile, $description, $addAtEndIfMissing);

            file_put_contents($targetFile, $newFile);

            $this->log .= $description . ' file existed and added modifications: ' . $targetFile . "\n";
        }
    }

    public function keepUserAdditions($masterFile, $userFile, $fileName)
    {
        preg_match_all('/(<user-additions' . ' part=")(.+)(">)/', $masterFile, $masterParts);
        $masterParts = $masterParts[2];

        preg_match_all('/(<user-additions' . ' part=")(.+)(">)/', $userFile, $userParts);
        $userParts = $userParts[2];

        foreach ($userParts as $part) {
            if (!in_array($part,$masterParts)) {
                throw new \RuntimeException('Found a user-additions part (' . $part . ') on ' . $fileName . ' but there is no section for it on the master file');
            }
        }

        foreach ($masterParts as $part) {
            if (preg_match('%<user-additions' . ' part="' . $part . '">.+?</user-additions' . '>%s', $userFile, $regs)) {
                $newPart = $regs[0];

                $masterFile = preg_replace('%<user-additions' . ' part="' . $part . '">.+?</user-additions' . '>%s',str_replace('\\','\\\\',$newPart),$masterFile,1);
            }
        }

        return $masterFile;
    }

    public function addSystemAdditions($masterFile, $userFile, $fileName, $addAtEndIfMissing=true)
    {
        preg_match_all('/(<system-additions part=")(.+)(">)/', $masterFile, $masterParts);
        $masterParts = $masterParts[2];

        preg_match_all('/(<system-additions part=")(.+)(">)/', $userFile, $userParts);
        $userParts = $userParts[2];

        foreach ($masterParts as $part) {
            if (!in_array($part,$userParts) && !$addAtEndIfMissing) {
                throw new \RuntimeException('Found a system-additions part (' . $part . ') on ' . $fileName . ' but there is no section for it on the user file and is not allowed to add at the end');
            }
        }

        foreach ($masterParts as $part) {
            if (!in_array($part,$userParts)) {
                $userFile .= "\n" . $masterFile;
            }
            elseif (preg_match('%<system-additions part="' . $part . '">.+?</system-additions>%s', $masterFile, $regs)) {
                $newPart = $regs[0];

                $userFile = preg_replace('%<system-additions part="' . $part . '">.+?</system-additions>%s',$newPart,$userFile,1);
            }
        }

        return $userFile;
    }
    // </user-additions>
    // </editor-fold>
}