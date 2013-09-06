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
class EntityBaseHeader extends CPPEntityTemplate implements RenderizableTemplateInterface
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
        return 'entity-base-header';
    }

    public function getFilename()
    {
        return $this->getEntity()->getName() . '.h';
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

    public function getEntityDeclarationLine()
    {
        return 'class ' . $this->getEntity()->getName() . ': public ' . $this->getEntity()->getNameBase();
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

    public function getFileLines()
    {
        $lines = [];

        $lines[] = $this->getEntityDeclarationLine();

        $lines[] = '{';

        $lines = array_merge($lines, $this->getAttributeLines());

        $lines[] = '};';

        $lines[] = '';

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
