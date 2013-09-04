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

namespace Draggy\Autocode\Templates\Java;

// <user-additions part="use">
use Draggy\Autocode\Templates\RenderizableTemplateInterface;
use Draggy\Autocode\Templates\JavaEntityTemplate;
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\EntityBase1
 */
class EntityBase extends JavaEntityTemplate implements RenderizableTemplateInterface
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

    public function getPackageLine()
    {
        return 'package ' . $this->getFullPackage() . ';';
    }

    public function getImportLines()
    {
        $lines = [];

        if ($this->getEntity()->getProject()->getAutocodeProperty('base')) {
            $lines[] = 'import ' . $this->getFullPackage() . '.base.' . $this->getEntity()->getNameBase() . ';';
        }

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ('object' == $attr->getType()) {
                $lines[] = 'import ' . $this->getFullPackage($attr->getEntitySubtype()) . '.' . $attr->getEntitySubtype()->getName() . ';';
            }
        }

        return array_unique($lines, SORT_STRING);
    }

    public function getEntityDeclarationLine()
    {
        return 'public class' === $this->getEntity()->getType()
            ? 'public class ' . $this->getEntity()->getName() . ' extends ' . $this->getEntity()->getNameBase()
            : 'public abstract class ' . $this->getEntity()->getName() . ' extends ' . $this->getEntity()->getNameBase();
    }

    public function getAttributeLines()
    {
        $lines = [];

        $lines[] = '// Attributes';
        $lines[] = $this->getUserAdditions('attributes');
        $lines[] = $this->getEndUserAdditions();
        $lines[] = '// End of attributes';

        return $lines;
    }

    public function getConstructorLines()
    {
        $lines = [];

        if ($this->getEntity()->getHasConstructor()) {
            $lines[] = '';

            $lines[] = '// Constructor';
            $lines[] = 'public ' . $this->getEntity()->getName() . '()';
            $lines[] = '{';
            $lines[] =     $this->getUserAdditions('constructor');
            $lines[] =     $this->getEndUserAdditions();
            $lines[] = '}';
            $lines[] = '// End of constructor';
        }

        return $lines;
    }

    public function getSetterGetterLines()
    {
        $lines = [];

        $lines[] = '';

        $lines[] = '// Setters and Getters';
        $lines[] = $this->getUserAdditions('settersAndGetters');
        $lines[] = $this->getEndUserAdditions();
        $lines[] = '// End of setters and getters';

        return $lines;
    }

    public function getOtherMethodLines()
    {
        $lines = [];

        $lines[] = '';

        $lines[] = '// Other methods';
        $lines[] = $this->getUserAdditions('otherMethods');
        $lines[] = $this->getEndUserAdditions();
        $lines[] = '// End of other methods';

        return $lines;
    }

    public function getFileLines()
    {
        $lines = [];

        $lines[] = $this->getEntityDeclarationLine();

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
