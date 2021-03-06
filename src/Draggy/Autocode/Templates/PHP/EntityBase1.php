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
use Draggy\Autocode\Templates\RenderizableTemplateInterface;
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\EntityBase1
 */
class EntityBase1 extends EntityBase1Base implements RenderizableTemplateInterface
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
    /**
     * {@inheritdoc}
     */
    public function getTemplateName()
    {
        return 'entity-base';
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getEntity()->getName();
    }

    public function getNamespaceLine()
    {
        return 'namespace ' . $this->getEntity()->getNamespace() .';';
    }

    public function getUseLines()
    {
        $lines = [];

        $lines[] = 'use ' . $this->getEntity()->getNamespace() . '\\Base\\' . $this->getEntity()->getNameBase() . ';';

        $lines = array_merge($lines, $this->getUseLinesUserAdditionsPart());

        return $lines;
    }

    public function getEntityDocumentationLines()
    {
        $lines = [];

        $lines[] = $this->getEntity()->getNamespace() . '\\Entity\\' . $this->getEntity()->getName();

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

        $lines[] = $this->getUserAdditions('implements');
        $lines[] = $this->getEndUserAdditions();

        return $lines;
    }

    public function getAttributeLines()
    {
        $lines = [];

        $lines[] = '// <editor-fold desc="Attributes">';
        $lines[] = $this->getUserAdditions('attributes');
        $lines[] = $this->getEndUserAdditions();
        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getConstructorLines()
    {
        $lines = [];

        if ($this->getEntity()->getHasConstructor()) {
            $lines[] = '';

            $lines[] = '// <editor-fold desc="Constructor">';
            $lines[] = $this->getUserAdditions('constructorDeclaration');
            $lines[] = 'public function __construct()';
            $lines[] = $this->getEndUserAdditions();
            $lines[] = '{';

            foreach ($this->getEntity()->getAttributes() as $attr) {
                $attributeDefaultValueConstructor = $attr->getDefaultValueConstructorInit();

                if ('' !== $attributeDefaultValueConstructor) {
                    $lines[] = '$this->' . $attr->getLowerName() . ' = ' . $attributeDefaultValueConstructor . ';';
                }
            }

            $lines[] =     $this->getUserAdditions('constructor');
            $lines[] =     $this->getEndUserAdditions();
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
        $lines[] = $this->getUserAdditions('settersAndGetters');
        $lines[] = $this->getEndUserAdditions();
        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getOtherMethodLines()
    {
        $lines = [];

        $lines[] = '';

        $lines[] = '// <editor-fold desc="Other methods">';
        $lines[] = $this->getUserAdditions('otherMethods');
        $lines[] = $this->getEndUserAdditions();
        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getFileLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getEntityDocumentationLines()));

        $lines[] = $this->getEntityDeclarationLine();

        $lines = array_merge($lines, $this->getImplementLines());

        $lines[] = '{';

        $lines = array_merge($lines, $this->getAttributeLines());
        $lines = array_merge($lines, $this->getConstructorLines());
        $lines = array_merge($lines, $this->getSetterGetterLines());
        $lines = array_merge($lines, $this->getOtherMethodLines());

        $lines[] = '}';

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
