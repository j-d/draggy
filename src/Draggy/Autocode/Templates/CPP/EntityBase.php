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

namespace Draggy\Autocode\Templates\CPP;

// <user-additions part="use">
use Draggy\Autocode\Templates\RenderizableTemplateInterface;
use Draggy\Autocode\Templates\CPPEntityTemplate;
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\EntityBase1
 */
class EntityBase extends CPPEntityTemplate implements RenderizableTemplateInterface
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

    public function getImportLines()
    {
        $lines = [];

        return array_unique($lines, SORT_STRING);
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

        $lines = array_merge($lines, $this->getConstructorLines());
        $lines = array_merge($lines, $this->getSetterGetterLines());
        $lines = array_merge($lines, $this->getOtherMethodLines());

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
