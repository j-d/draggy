<?php
// Draggy\Autocode\Templates\PHP\CrudCreate.php

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

use Draggy\Autocode\Templates\PHP\Base\CrudCreateBase;
// <user-additions part="use">
use Draggy\Autocode\Templates\RenderizableTemplateInterface;
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\CrudCreate
 */
class CrudCreate extends CrudCreateBase implements RenderizableTemplateInterface
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
    public function getName()
    {
        return 'add' . $this->getEntity()->getName();
    }

    public function getExtendBundlePath()
    {
        return 'MockBundle:Default:navigationPage.html.twig';
    }

    public function getTitleLinePart()
    {
        return '{{ parent() }} | Add ' . $this->getEntity()->getName();
    }

    public function getPageTitleLinePart()
    {
        return 'Add ' . $this->getEntity()->getName();
    }

    public function getContentLines()
    {
        $lines = [];

        $lines[] = '{{ parent() }}';
        $lines[] = '{{ form(form) }}';

        return $lines;
    }

    public function getFileLines()
    {
        $lines = [];

        //$lines[] = $this->getUserAdditions('template');
        $lines[] = $this->getExtendLine();
        $lines[] = '';
        $lines[] = $this->getBlockTitleLine();
        $lines[] = '';
        $lines[] = $this->getBlockPageTitleLine();
        $lines[] = '';

        $lines = array_merge($lines, $this->getBlockNavigationLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getBlockContentLines());

        //$lines[] = $this->getEndUserAdditions();

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
