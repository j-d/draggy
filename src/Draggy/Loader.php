<?php

namespace Draggy;

use Draggy\Exceptions\FileNotFoundException;
use Draggy\Exceptions\InvalidFileException;
use Symfony\Component\HttpFoundation\Response;

class Loader
{
    /**
     * @var \SimpleXMLElement
     */
    protected $xml;

    /**
     * @var string[]
     */
    protected $modules = [];

    /**
     * @var string[]
     */
    protected $insideClasses = [];

    /**
     * @var string[]
     */
    protected $outsideClasses = [];

    /**
     * @var string[]
     */
    protected $insideAbstracts = [];

    /**
     * @var string[]
     */
    protected $outsideAbstracts = [];

    /**
     * @var string[]
     */
    protected $insideInterfaces = [];

    /**
     * @var string[]
     */
    protected $outsideInterfaces = [];

    /**
     * Indicates if it is a new project or not
     *
     * @var bool
     */
    protected $newFile = false;

    public function __construct($file)
    {
        if (!file_exists($file)) {
            $this->newFile = true;
        } else {
            $this->xml = simplexml_load_file($file);

            if (false === $this->xml) {
                throw new InvalidFileException( 'The file \'' . $file . '\' is not a valid XML file' );
            }
        }
    }

    /**
     * @param string $where
     * @param array  $xmlSection
     * @param array  $requirements
     *
     * @throws Exceptions\InvalidFileException
     */
    private function checkMandatoryAttributes($where, array $xmlSection, array $requirements)
    {
        foreach ($requirements as $requirement) {
            if (!isset( $xmlSection[$requirement] )) {
                throw new InvalidFileException( 'Could not find the attribute \'' . $requirement . '\' on the ' . $where . ' section of the saved file.' );
            }
        }
    }

    /**
     * Get the project properties from the saved file
     *
     * @return string
     */
    private function getProjectProperties()
    {
        $projectOptions = (array)$this->xml->xpath('/draggy/project');
        $projectOptions = $projectOptions[0];

        $this->checkMandatoryAttributes('Project', $projectOptions, ['language', 'description', 'orm', 'framework']);

        $r = '';

        $r .= 'Draggy.prototype.setLanguage(\'' . $projectOptions['language'] . '\');' . PHP_EOL;
        $r .= 'Draggy.prototype.setDescription(\'' . $projectOptions['description'] . '\');' . PHP_EOL;
        $r .= 'Draggy.prototype.setORM(\'' . $projectOptions['orm'] . '\');' . PHP_EOL;
        $r .= 'Draggy.prototype.setFramework(\'' . $projectOptions['framework'] . '\');' . PHP_EOL;

        return $r;
    }

    /**
     * Get the project modules
     *
     * @return string
     */
    private function getModules()
    {
        $modules = (array)$this->xml->xpath('/draggy/module');

        $r = '';

        foreach ($modules as $module) {
            $moduleAttributes = (array)$module;
            $moduleAttributes = $moduleAttributes['@attributes'];

            $this->checkMandatoryAttributes('Modules', $moduleAttributes, ['name', 'left', 'top', 'width', 'height']);

            $moduleName = $moduleAttributes['name'];

            $r .= 'var o = new Container(\'' . str_replace('\\', '\\\\', $moduleName) . '\');' . PHP_EOL;
            $r .= 'o.moveTo(\'' . ( $moduleAttributes['left'] - 1 ) . 'px\',\'' . ( $moduleAttributes['top'] - 1 ) . 'px\',\'' . $moduleAttributes['width'] . 'px\',\'' . $moduleAttributes['height'] . 'px\')' . PHP_EOL;

            $this->modules[]                = $moduleName;
            $this->insideClasses[$module]   = [];
            $this->insideAbstracts[$module] = [];
        }

        return $r;
    }

    /**
     * @param array  $classLikeAttributes
     * @param string $varName
     *
     * @return string
     */
    private function getClassLikeProperties($classLikeAttributes, $varName)
    {
        $r = '';

        if (isset( $classLikeAttributes['description'] )) {
            $r .= $varName . '.setDescription("' . $classLikeAttributes['description'] . '");' . PHP_EOL;
        }

        if (isset( $classLikeAttributes['constructor'] )) {
            $r .= $varName . '.setConstructor(' . $classLikeAttributes['constructor'] . ');' . PHP_EOL;
        }

        if (isset( $classLikeAttributes['repository'] )) {
            $r .= $varName . '.setRepository(' . $classLikeAttributes['repository'] . ');' . PHP_EOL;
        }

        if (isset( $classLikeAttributes['form'] )) {
            $r .= $varName . '.setForm(' . $classLikeAttributes['form'] . ');' . PHP_EOL;
        }

        if (isset( $classLikeAttributes['controller'] )) {
            $r .= $varName . '.setController(' . $classLikeAttributes['controller'] . ');' . PHP_EOL;
        }

        if (isset( $classLikeAttributes['fixtures'] )) {
            $r .= $varName . '.setFixtures(' . $classLikeAttributes['fixtures'] . ');' . PHP_EOL;
        }

        if (isset( $classLikeAttributes['crud'] )) {
            $r .= $varName . '.setCrud(\'' . $classLikeAttributes['crud'] . '\');' . PHP_EOL;
        }

        return $r;
    }

    /**
     * Get the project classes
     *
     * @return string
     */
    private function getClasses()
    {
        $r = '';

        // Inside classes
        foreach ($this->modules as $module) {
            $classes = (array)$this->xml->xpath('/draggy/module[@name=\'' . $module . '\']/class');

            foreach ($classes as $class) {
                $classAttributes = (array)$class;
                $classAttributes = $classAttributes['@attributes'];

                $this->checkMandatoryAttributes('Class in module ' . $module, $classAttributes, ['name']);

                $className = $classAttributes['name'];

                $this->insideClasses[$module][] = $className;

                $this->checkMandatoryAttributes(
                    'Class ' . $className . ' in module ' . $module,
                    $classAttributes,
                    ['left', 'top']
                );

                $r .= 'var c = new Class(\'' . $classAttributes['name'] . '\',\'' . str_replace(
                    '\\',
                    '\\\\',
                    $module
                ) . '\');' . PHP_EOL;
                $r .= 'c.moveTo(\'' . ( $classAttributes['left'] /*- 1*/ ) . 'px\',\'' . ( $classAttributes['top'] /*- 1*/ ) . 'px\');' . PHP_EOL;

                $r .= $this->getClassLikeProperties($classAttributes, 'c');

                $r .= 'c.setModule(Container.prototype.getContainerByName(\'' . str_replace(
                    '\\',
                    '\\\\',
                    $module
                ) . '\').getId());' . PHP_EOL;
            }
        }

        // Outside classes
        $classes = (array)$this->xml->xpath('/draggy/loose/class');

        foreach ($classes as $class) {
            $classAttributes = (array)$class;
            $classAttributes = $classAttributes['@attributes'];

            $this->checkMandatoryAttributes('Loose class', $classAttributes, ['name']);

            $className = $classAttributes['name'];

            $this->outsideClasses[] = $className;

            $this->checkMandatoryAttributes('Loose class ' . $className, $classAttributes, ['left', 'top']);

            $r .= 'var c = new Class(\'' . $className . '\');' . PHP_EOL;
            $r .= 'c.moveTo(\'' . ( $classAttributes['left'] ) . 'px\',\'' . ( $classAttributes['top'] ) . 'px\');' . PHP_EOL;

            $r .= $this->getClassLikeProperties($classAttributes, 'c');
        }

        return $r;
    }

    /**
     * Get the project classes
     *
     * @return string
     */
    private function getAbstracts()
    {
        $r = '';

        // Inside abstracts
        foreach ($this->modules as $module) {
            $abstracts = (array)$this->xml->xpath('/draggy/module[@name=\'' . $module . '\']/abstract');

            foreach ($abstracts as $abstract) {
                $abstractAttributes = (array)$abstract;
                $abstractAttributes = $abstractAttributes['@attributes'];

                $this->checkMandatoryAttributes('Abstract in module ' . $module, $abstractAttributes, ['name']);

                $abstractName = $abstractAttributes['name'];

                $this->insideAbstracts[$module][] = $abstractName;

                $this->checkMandatoryAttributes(
                    'Abstract ' . $abstractName . ' in module ' . $module,
                    $abstractAttributes,
                    ['left', 'top']
                );

                $r .= 'var s = new Abstract(\'' . $abstractName . '\',\'' . str_replace(
                    '\\',
                    '\\\\',
                    $module
                ) . '\');' . PHP_EOL;
                $r .= 's.moveTo(\'' . ( $abstractAttributes['left'] /*- 1*/ ) . 'px\',\'' . ( $abstractAttributes['top'] /*- 1*/ ) . 'px\');' . PHP_EOL;

                $r .= $this->getClassLikeProperties($abstractAttributes, 's');

                $r .= 's.setModule(Container.prototype.getContainerByName(\'' . str_replace(
                    '\\',
                    '\\\\',
                    $module
                ) . '\').getId());' . PHP_EOL;
            }
        }

        // Outside abstracts
        $abstracts = (array)$this->xml->xpath('/draggy/loose/abstract');

        foreach ($abstracts as $abstract) {
            $abstractAttributes = (array)$abstract;
            $abstractAttributes = $abstractAttributes['@attributes'];

            $this->checkMandatoryAttributes('Loose abstract', $abstractAttributes, ['name']);

            $abstractName = $abstractAttributes['name'];

            $this->outsideAbstracts[] = $abstractName;

            $this->checkMandatoryAttributes('Loose abstract ' . $abstractName, $abstractAttributes, ['left', 'top']);

            $r .= 'var s = new Abstract(\'' . $abstractName . '\');' . PHP_EOL;
            $r .= 's.moveTo(\'' . ( $abstractAttributes['left'] ) . 'px\',\'' . ( $abstractAttributes['top'] ) . 'px\');' . PHP_EOL;

            $r .= $this->getClassLikeProperties($abstractAttributes, 's');
        }

        return $r;
    }

    /**
     * @param array  $interfaceAttributes
     * @param string $varName
     *
     * @return string
     */
    private function getInterfaceProperties($interfaceAttributes, $varName)
    {
        $r = '';

        if (isset( $interfaceAttributes['description'] )) {
            $r .= $varName . '.setDescription("' . $interfaceAttributes['description'] . '");' . PHP_EOL;
        }

        return $r;
    }

    /**
     * Get the project interfaces
     *
     * @return string
     */
    private function getInterfaces()
    {
        $r = '';

        // Inside interfaces
        foreach ($this->modules as $module) {
            $interfaces = (array)$this->xml->xpath('/draggy/module[@name=\'' . $module . '\']/interface');

            foreach ($interfaces as $interface) {
                $interfaceAttributes = (array)$interface;
                $interfaceAttributes = $interfaceAttributes['@attributes'];

                $this->checkMandatoryAttributes('Interface in module ' . $module, $interfaceAttributes, ['name']);

                $className = $interfaceAttributes['name'];

                $this->checkMandatoryAttributes(
                    'Interface ' . $className . ' in module ' . $module,
                    $interfaceAttributes,
                    ['left', 'top']
                );

                $r .= 'var i = new Interface(\'' . $interfaceAttributes['name'] . '\',\'' . str_replace(
                    '\\',
                    '\\\\',
                    $module
                ) . '\');' . PHP_EOL;
                $r .= 'i.moveTo(\'' . ( $interfaceAttributes['left'] /*- 1*/ ) . 'px\',\'' . ( $interfaceAttributes['top'] /*- 1*/ ) . 'px\');' . PHP_EOL;

                $r .= $this->getInterfaceProperties($interfaceAttributes, 'i');

                $r .= 'i.setModule(Container.prototype.getContainerByName(\'' . str_replace(
                    '\\',
                    '\\\\',
                    $module
                ) . '\').getId());' . PHP_EOL;
            }
        }

        // Outside interfaces
        $interfaces = (array)$this->xml->xpath('/draggy/loose/interface');

        foreach ($interfaces as $interface) {
            $interfaceAttributes = (array)$interface;
            $interfaceAttributes = $interfaceAttributes['@attributes'];

            $this->checkMandatoryAttributes('Loose interface', $interfaceAttributes, ['name']);

            $className = $interfaceAttributes['name'];

            $this->checkMandatoryAttributes('Loose interface ' . $className, $interfaceAttributes, ['left', 'top']);

            $r .= 'var i = new Interface(\'' . $className . '\');' . PHP_EOL;
            $r .= 'i.moveTo(\'' . ( $interfaceAttributes['left'] ) . 'px\',\'' . ( $interfaceAttributes['top'] ) . 'px\');' . PHP_EOL;

            $r .= $this->getInterfaceProperties($interfaceAttributes, 'i');
        }

        return $r;
    }

    /**
     * @param string $classLike
     * @param array  $classLikeAttributeAttributes
     * @param string $varName
     *
     * @return string
     */
    private function getClassLikeAttributeProperties($classLike, $classLikeAttributeAttributes, $varName)
    {
        $r = '';

        foreach ($classLikeAttributeAttributes as $attribute) {
            $attributeProperties = (array)$attribute;
            $attributeProperties = $attributeProperties['@attributes'];

            $this->checkMandatoryAttributes('Attributes ' . $classLike, $attributeProperties, ['id', 'name']);

            if (isset( $attributeProperties['inherited'] )) {
                $r .= 'var a = new InheritedAttribute(\'' . $attributeProperties['id'] . '\');' . PHP_EOL;

                $r .= $varName . '.addInheritedAttribute(a);' . PHP_EOL;
            } else {
                $r .= 'var a = new Attribute(\'' . $attributeProperties['name'] . '\',\'' . $attributeProperties['id'] . '\');' . PHP_EOL;
                if (isset( $attributeProperties['type'] )) {
                    $r .= 'a.setType(\'' . $attributeProperties['type'] . '\');' . PHP_EOL;
                }
                if (isset( $attributeProperties['subtype'] )) {
                    $r .= 'a.setSubtype(\'' . str_replace(
                        '\\',
                        '\\\\',
                        $attributeProperties['subtype']
                    ) . '\');' . PHP_EOL;
                }
                if (isset( $attributeProperties['size'] )) {
                    $r .= 'a.setSize(\'' . $attributeProperties['size'] . '\');' . PHP_EOL;
                }
                if (isset( $attributeProperties['null'] )) {
                    $r .= 'a.setNull(' . $attributeProperties['null'] . ');' . PHP_EOL;
                }
                if (isset( $attributeProperties['primary'] )) {
                    $r .= 'a.setPrimary(' . $attributeProperties['primary'] . ');' . PHP_EOL;
                }
                if (isset( $attributeProperties['foreign'] )) {
                    $r .= 'a.setForeign(' . $attributeProperties['foreign'] . ');' . PHP_EOL;
                }
                if (isset( $attributeProperties['autoincrement'] )) {
                    $r .= 'a.setAutoincrement(' . $attributeProperties['autoincrement'] . ');' . PHP_EOL;
                }
                if (isset( $attributeProperties['unique'] )) {
                    $r .= 'a.setUnique(' . $attributeProperties['unique'] . ');' . PHP_EOL;
                }
                if (isset( $attributeProperties['default'] )) {
                    $r .= 'a.setDefault(\'' . str_replace(
                        '\'',
                        '\\\'',
                        $attributeProperties['default']
                    ) . '\');' . PHP_EOL;
                }
                if (isset( $attributeProperties['description'] )) {
                    $r .= 'a.setDescription(\'' . $attributeProperties['description'] . '\');' . PHP_EOL;
                }
                if (isset( $attributeProperties['getter'] )) {
                    $r .= 'a.setGetter(' . $attributeProperties['getter'] . ');' . PHP_EOL;
                }
                if (isset( $attributeProperties['setter'] )) {
                    $r .= 'a.setSetter(' . $attributeProperties['setter'] . ');' . PHP_EOL;
                }
                if (isset( $attributeProperties['minSize'] )) {
                    $r .= 'a.setMinSize(\'' . $attributeProperties['minSize'] . '\');' . PHP_EOL;
                }
                if (isset( $attributeProperties['email'] )) {
                    $r .= 'a.setEmail(' . $attributeProperties['email'] . ');' . PHP_EOL;
                }
                if (isset( $attributeProperties['min'] )) {
                    $r .= 'a.setMin(\'' . $attributeProperties['min'] . '\');' . PHP_EOL;
                }
                if (isset( $attributeProperties['max'] )) {
                    $r .= 'a.setMax(\'' . $attributeProperties['max'] . '\');' . PHP_EOL;
                }
                if (isset( $attributeProperties['static'] )) {
                    $r .= 'a.setStatic(\'' . $attributeProperties['static'] . '\');' . PHP_EOL;
                }

                $r .= $varName . '.addAttribute(a);' . PHP_EOL;
            }
        }

        return $r;
    }

    /**
     * Get the project attributes
     *
     * @return string
     */
    private function getAttributes()
    {
        $r = '';

        // Inside classes
        foreach ($this->insideClasses as $insideClassModule => $insideClass) {
            $attributes = $this->xml->xpath(
                '/draggy/module[@name=\'' . $insideClassModule . '\']/class[@name=\'' . $insideClass . '\']/attribute'
            );

            $r .= 'c = Connectable.prototype.getConnectableFromName(\'' . str_replace(
                '\\',
                '\\\\',
                $insideClassModule . '\\'
            ) . $insideClass . '\');' . PHP_EOL;

            $this->getClassLikeAttributeProperties($insideClass, $attributes, 'c');

            if (isset( $classAttributes['toString'] )) {
                $r .= 'c.setToString(c.getAttributeFromName("' . $classAttributes['toString'] . '"))' . PHP_EOL;
            }
        }

        // Inside abstracts
        foreach ($this->insideAbstracts as $insideAbstractModule => $insideAbstract) {
            $attributes = $this->xml->xpath(
                '/draggy/module[@name=\'' . $$insideAbstractModule . '\']/abstract[@name=\'' . $insideAbstract . '\']/attribute'
            );

            $r .= 's = Connectable.prototype.getConnectableFromName(\'' . str_replace(
                '\\',
                '\\\\',
                $insideAbstractModule . '\\'
            ) . $insideAbstract . '\');' . PHP_EOL;

            $this->getClassLikeAttributeProperties($insideAbstract, $attributes, 's');

            if (isset( $abstractAttributes['toString'] )) {
                $r .= 's.setToString(s.getAttributeFromName("' . $abstractAttributes['toString'] . '"))' . PHP_EOL;
            }
        }

        // Outside classes
        foreach ($this->outsideClasses as $outsideClass) {
            $attributes = $this->xml->xpath('/draggy/loose/class[@name=\'' . $outsideClass . '\']/attribute');

            $r .= 'c = Connectable.prototype.getConnectableFromName(\'' . $outsideClass . '\');' . PHP_EOL;

            $this->getClassLikeAttributeProperties($outsideClass, $attributes, 'c');

            if (isset( $classAttributes['toString'] )) {
                $r .= 'c.setToString(c.getAttributeFromName("' . $classAttributes['toString'] . '"))' . PHP_EOL;
            }
        }

        // Outside abstracts
        foreach ($this->outsideAbstracts as $outsideAbstract) {
            $attributes = $this->xml->xpath('/draggy/loose/abstract[@name=\'' . $outsideAbstract . '\']/attribute');

            $r .= 's = Connectable.prototype.getConnectableFromName(\'' . $outsideAbstract . '\');' . PHP_EOL;

            $this->getClassLikeAttributeProperties($outsideAbstract, $attributes, 'c');

            if (isset( $abstractAttributes['toString'] )) {
                $r .= 's.setToString(s.getAttributeFromName("' . $abstractAttributes['toString'] . '"))' . PHP_EOL;
            }
        }

        return $r;
    }

    /**
     * Get the project attributes
     *
     * @return string
     */
    private function getRelationships()
    {
        $r = '';

        $relationships = (array)$this->xml->xpath('/draggy/relationships/relation');

        foreach ($relationships as $relation) {
            $relationAttributes = (array)$relation;
            $relationAttributes = $relationAttributes['@attributes'];

            $this->checkMandatoryAttributes('Relationship', $relationAttributes, ['from', 'to', 'type']);

            $r .= 'var l = new Link(\'' . str_replace(
                '\\',
                '\\\\',
                $relationAttributes['from']
            ) . '\',\'' . str_replace(
                '\\',
                '\\\\',
                $relationAttributes['to']
            ) . '\',\'' . $relationAttributes['type'] . '\',' . ( isset( $relationAttributes['fromAttribute'] ) ? '\'' . $relationAttributes['fromAttribute'] . '\'' : 'undefined' ) . ', ' . ( isset( $relationAttributes['toAttribute'] ) ? '\'' . $relationAttributes['toAttribute'] . '\'' : 'undefined' ) . ')' . PHP_EOL;

            if (isset( $relationAttributes['broken'] )) {
                $r .= 'l.setBroken(' . $relationAttributes['broken'] . ');' . PHP_EOL;
            }
        }

        return $r;
    }

    public function getLoaderJS()
    {
        if ($this->newFile) {
            return '';
        }

        $r = '';

        $r .= $this->getProjectProperties();

        // FIRST STEP: Load all modules and entities
        $r .= $this->getModules();
        $r .= $this->getClasses();
        $r .= $this->getAbstracts();
        $r .= $this->getInterfaces();

        // SECOND STEP: Add the attributes
        $r .= $this->getAttributes();

        // THIRD STEP: Relationships
        $r .= $this->getRelationships();

        // Finalise
        $r .= 'for (var i in Connectable.prototype.connectables) Connectable.prototype.connectables[i].reDraw();' . PHP_EOL;
        $r .= 'Link.prototype.reDrawLinks();' . PHP_EOL;
        $r .= 'System.prototype.runtime = true;' . PHP_EOL;

        return $r;
    }
}