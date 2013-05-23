<?php
// Draggy\Autocode\Entity.php

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

use Draggy\Autocode\Base\EntityBase;
// <user-additions part="use">
use Draggy\Autocode\Exceptions\DuplicateAttributeException;
// </user-additions>

/**
 * Draggy\Autocode\Entity\Entity
 */
abstract class Entity extends EntityBase
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Constructor">
    // <user-additions part="constructorDeclaration">
    public function __construct(Project $project, $namespace, $module, $name)
    // </user-additions>
    {
        // <user-additions part="constructor">
        if (!$project->isValidEntityName($name)) {
            throw new \RuntimeException( 'The entity \'' . $name . '\' name cannot be used because is a reserved word.' );
        }

        $this->setNamespace($namespace);
        $this->setModule($module);
        $this->setName($name);
        $this->setProject($project);
        // </user-additions>
    }
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
    /**
     * Get lowerName
     *
     * @return string
     */
    public function getLowerName()
    {
        return strtolower($this->name[0]) . substr($this->name,1);
    }

    public function getModuleNoBundle()
    {
        return substr($this->module,0,substr($this->module,-6) == 'Bundle' ? -6 : null);
    }

    public function getPluralName()
    {
        if (substr($this->getName(),-1) == 'y')
            return substr($this->getName(),0,-1) . 'ies';
        elseif (substr($this->getName(),-1) == 'f')
            return substr($this->getName(),0,-1) . 'ves';
        else
            return $this->getName() . 's';
    }

    public function getPluralLowerName()
    {
        $plural = $this->getPluralName();

        return strtolower($plural[0]) . substr($plural,1);
    }

    public function getNameBase()
    {
        $projectEntities = $this->getProject()->getEntities();

        if (!$this->getProject()->getBase()) {
            return $this->name;
        } elseif (isset($projectEntities[$this->name . 'Base'])) {
            return $this->name . 'CodeBase';
//        }
//        elseif(strtolower(substr($this->name,-4)) === 'base') {
//            return $this->name . 'CodeBase';
        } else {
            return $this->name . 'Base';
        }
    }

    public function getFullyQualifiedName()
    {
        $ret = $this->getNamespace() . '\\';

        if ($this->getProject()->getFramework() === 'Symfony2') {
            $ret .= 'Entity\\';
        }

        $ret .= $this->getName();

        return $ret;
    }

    public function getFullyQualifiedBaseName()
    {
        $ret = $this->getNamespace() . '\\';

        if ($this->getProject()->getFramework() === 'Symfony2') {
            $ret .= 'Entity\\';
        }

        $ret .= 'Base\\';

        $ret .= $this->getName() . 'Base';

        return $ret;
    }

    public function getRelativePathName()
    {
        $projectNamespace = $this->getProject()->getNamespace();

        $relativePath = $this->getNamespace() . '\\' . $this->getName();

        if (substr($relativePath,0,strlen($projectNamespace)) === $projectNamespace) {
            $relativePath = substr($relativePath, strlen($projectNamespace));
        }

        if (substr($relativePath, 0, 1) == '\\') {
            $relativePath = substr($relativePath, 1);
        }

        return $relativePath;
    }

    /**
     * @inheritDoc
     */
    public function addAttribute(Attribute $attribute, $allowRepeatedValues = true)
    {
        if (isset( $this->attributes[$attribute->getName()] )) {
            throw new DuplicateAttributeException( 'Tried to add an attribute by the name of \'' . $attribute->getName() . '\' to the entity \'' . $this->getName() . '\' but there was already an attribute by that name.' );
        }

        $this->attributeNames[] = $attribute->getName();
        $this->attributes[$attribute->getName()] = $attribute;

        if ($attribute->getPrimary()) {
            $attribute                                      = &$this->getAttributeByName($attribute->getName()); // Get it by reference so they point to the same one
            $this->primaryAttributes[$attribute->getName()] = $attribute;
        }

        return $this;
    }

    public function addAttributeReference(Attribute &$attribute)
    {
        if (isset( $this->attributes[$attribute->getName()] )) {
            unset($this->attributes[$attribute->getName()]);    // It was temporary
            if(($key = array_search($attribute->getName(), $this->attributeNames)) !== false) {
                unset($this->attributeNames[$key]);
                $this->attributeNames = array_values($this->attributeNames);
            }
        }

        $this->attributes[$attribute->getName()] = $attribute;

        if ($attribute->getPrimary()) {
            $attribute                                      = &$this->getAttributeByName($attribute->getName()); // Get it by reference so they point to the same one
            $this->primaryAttributes[$attribute->getName()] = $attribute;
        }

        return $this;
    }

    /**
     * @param $index
     *
     * @return Attribute
     */
    public function getAttribute($index)
    {
        return $this->attributes[$this->attributeNames[$index]];
    }

    /**
     * @return Attribute[]
     */
    public function getFormAttributes()
    {
        $ret = [];

        foreach ($this->attributes as $attr) {
            if ( null === $this->parentEntity || !in_array($attr->getName(), array_keys($this->parentEntity->getAttributes())) ) {
                if (!$attr->getAutoIncrement()) {
                    if (null === $attr->getForeignEntity()) {
                        $ret[] = $attr;
                    } elseif ($attr->getFormClassType() === 'Entity' && $attr->getForeign() === 'OneToOne' && $attr->getOwnerSide()) {
                        $ret[] = $attr;
                    } elseif ($attr->getFormClassType() === 'Entity' && $attr->getForeign() === 'ManyToOne' && $attr->getOwnerSide() && $attr->getForeignKey()->getFormClassType() !== 'Entity') {
                        $ret[] = $attr;
                    } elseif ($attr->getFormClassType() === 'Entity' && $attr->getForeign() === 'ManyToMany' && $attr->getOwnerSide() && $attr->getForeignKey()->getFormClassType() !== 'Entity') {
                        $ret[] = $attr;
                    } elseif ($attr->getFormClassType() === 'Collection' && !$attr->getOwnerSide() && $attr->getForeign() === 'ManyToOne' && $attr->getForeignEntity()->getHasForm()) {
                        $ret[] = $attr;
                    }
                }
            }
        }

        return $ret;
    }

    /**
     * @param $name
     *
     * @return Attribute
     *
     * @throws \RuntimeException
     */
    public function &getAttributeByName($name)
    {
        if (!isset( $this->attributes[$name] )) {
            throw new \RuntimeException( 'An attribute by the name of \'' . $name . '\' could not be located on the \'' . $this->getName() . '\' entity.' );
        }

        return $this->attributes[$name];
    }

    /**
     * @return Attribute
     *
     * @throws \RuntimeException
     */
    public function &getPrimaryAttribute()
    {
        if (count($this->primaryAttributes) != 1) {
            throw new \RuntimeException( 'There is not one primary attribute on the \'' . $this->getName() . '\' entity. (There are ' . count($this->getPrimaryAttributes()) . ')' );
        }

        return $this->primaryAttributes[array_keys($this->primaryAttributes)[0]];
    }

    public function getMaxNumberAttributesChildren()
    {
        $max = -1;

        foreach ($this->childrenEntities as $child) {
            if (count($child->getAttributes()) > $max) {
                $max = count($child->getAttributes());
            }
        }

        return $max;
    }

    public function getCrudCreate()
    {
        return false !== strpos($this->crud, 'C');
    }

    public function getCrudRead()
    {
        return false !== strpos($this->crud, 'R');
    }

    public function getCrudUpdate()
    {
        return false !== strpos($this->crud, 'U');
    }

    public function getCrudDelete()
    {
        return false !== strpos($this->crud, 'D');
    }
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    public function hasSetters()
    {
        foreach ($this->getAttributes() as $attr)
            if ($attr->getSetter())
                return true;

        return false;
    }
    // </user-additions>
    // </editor-fold>
}