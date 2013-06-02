<?php
// Draggy\Autocode\Templates\PHP\EntityBase1.php

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

namespace Draggy\Autocode\Templates\PHP;

use Draggy\Autocode\Templates\PHP\Base\EntityBase1Base;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\EntityBase1
 */
class EntityBase1 extends EntityBase1Base
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    public function getFilenameLine()
    {
        $line = '// ' . $this->getEntity()->getNamespace() . '\\';
        if ($this->getEntity()->getProject()->getFramework() === 'Symfony2') {
            $line .= 'Entity\\';
        }
        $line .= $this->getEntity()->getName() . '.php';

        return $line;
    }

    public function getNamespaceLine()
    {
        $line = 'namespace ' . $this->getEntity()->getNamespace();

        if ($this->getEntity()->getProject()->getFramework() === 'Symfony2') {
            $line.= '\\Entity';
        }

        $line .= ';';

        return $line;
    }

    public function getUseLines()
    {
        $lines = [];

        if ($this->getEntity()->getProject()->getORM() === 'Doctrine2') {
            $lines[] = 'use Doctrine\ORM\Mapping as ORM;';
        }

        if ($this->getEntity()->getProject()->getFramework() === 'Symfony2') {
            $lines[] = 'use Symfony\Component\Validator\Constraints as Assert;';
        }

        $line = 'use ' . $this->getEntity()->getNamespace() . '\\';
        if ($this->getEntity()->getProject()->getFramework() === 'Symfony2') {
            $line .= 'Entity\\';
        }
        $line.= 'Base\\' . $this->getEntity()->getNameBase() . ';';

        $lines[] = $line;

        if ($this->getEntity()->getProject()->getORM() === 'Doctrine2') {
            $useArrayCollection = false;

            foreach ($this->getEntity()->getAttributes() as $attr) {
                if (null !== $attr->getForeign() && 'array' === $attr->getType()) {
                    $useArrayCollection = true;
                    break;
                }
            }

            if ($useArrayCollection) {
                $lines[] = 'use Doctrine\\Common\\Collections\\ArrayCollection;';
            }
        }

        $lines[] = '// <user-additions' . ' part="use">';
        $lines[] = '// </user-additions' . '>';

        return $lines;
    }

    public function getEntityDocumentationLines()
    {
        $lines = [];

        $lines[] = $this->getEntity()->getNamespace() . '\\Entity\\' . $this->getEntity()->getName();

        if ($this->getEntity()->getProject()->getORM() === 'Doctrine2') {
            $lines[] = '';

            if (count($this->getEntity()->getChildrenEntities()) == 0 /*|| count($this->getAttributes()) != $this->getMaxNumberAttributesChildren()*/ ) {
                if (!$this->getEntity()->getHasRepository()) {
                    $lines[] = '@ORM\\Entity';
                } else {
                    $lines[] = '@ORM\\Entity(repositoryClass="' . $this->getEntity()->getFullyQualifiedName() . 'Repository")';
                }
            } else {
                $lines[] = '@ORM\MappedSuperclass';
            }
        }

        return $lines;
    }

    public function getEntityDeclarationLine()
    {
        return 'class' === $this->getEntity()->getType()
            ? 'class ' . $this->getEntity()->getName() . ' extends ' . $this->getEntity()->getNameBase()
            : 'abstract class ' . $this->getEntity()->getName() . ' extends ' . $this->getEntity()->getNameBase();
    }

    public function getImplementLines()
    {
        $lines = [];

        $lines[] = '// <user-additions' . ' part="implements">';
        $lines[] = '// </user-additions' . '>';

        return $lines;
    }

    public function getAttributeLines()
    {
        $lines = [];

        $lines[] = '// <editor-fold desc="Attributes">';
        $lines[] = '// <user-additions' . ' part="attributes">';
        $lines[] = '// </user-additions' . '>';
        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getConstructorLines()
    {
        $lines = [];

        if ($this->getEntity()->getHasConstructor()) {
            $lines[] = '';

            $lines[] = '// <editor-fold desc="Constructor">';
            $lines[] = '// <user-additions' . ' part="constructorDeclaration">';
            $lines[] = 'public function __construct()';
            $lines[] = '// </user-additions' . '>';
            $lines[] = '{';

            foreach ($this->getEntity()->getAttributes() as $attr) {
                $attributeDefaultValueConstructor = $attr->getDefaultValueConstructorInit();

                if ('' !== $attributeDefaultValueConstructor) {
                    $lines[] = '$this->' . $attr->getLowerName() . ' = ' . $attributeDefaultValueConstructor . ';';
                }
            }

            $lines[] =     '// <user-additions' . ' part="constructor">';
            $lines[] =     '// </user-additions' . '>';
            $lines[] = '}';
            $lines[] = '// </editor-fold>';
        }

        return $lines;
    }

    public function getSetterGetterLines()
    {
        $lines = [];

        $lines[] = '';

        $lines[] = '// <editor-fold desc="Setters and Getters">';
        $lines[] = '// <user-additions' . ' part="settersAndGetters">';
        $lines[] = '// </user-additions' . '>';
        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getOtherMethodLines()
    {
        $lines = [];

        $lines[] = '';

        $lines[] = '// <editor-fold desc="Other methods">';
        $lines[] = '// <user-additions' . ' part="otherMethods">';
        $lines[] = '// </user-additions' . '>';
        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getEntityLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getEntityDocumentationLines()));

        $lines[] = $this->getEntityDeclarationLine();

        $lines = array_merge($lines, $this->getImplementLines());

        $lines[] = '{';

        $lines = array_merge($lines, $this->indentLines($this->getAttributeLines()));
        $lines = array_merge($lines, $this->indentLines($this->getConstructorLines()));
        $lines = array_merge($lines, $this->indentLines($this->getSetterGetterLines()));
        $lines = array_merge($lines, $this->indentLines($this->getOtherMethodLines()));

        $lines[] = '}';

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
