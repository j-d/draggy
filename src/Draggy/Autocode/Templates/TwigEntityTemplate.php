<?php
// Draggy\Autocode\Templates\PHPEntityTemplate.php

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

namespace Draggy\Autocode\Templates;

use Draggy\Autocode\Templates\Base\PHPEntityTemplateBase;
// <user-additions part="use">
use Draggy\Utils\TwigJustifier;
// </user-additions>

/**
 * Draggy\Autocode\Templates\Entity\PHPEntityTemplate
 */
abstract class TwigEntityTemplate extends EntityTemplate
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
    public function getFilename()
    {
        return $this->getName() . '.html.twig';
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        return 'Resources/views/' . $this->getEntity()->getName() . '/';
    }

    public function getFilenameLine()
    {
        return '{# ' . $this->getPathAndFilename() . ' #}';
    }

    public function getExtendBundlePath()
    {
        return null;
    }

    public function getExtendLine()
    {
        return '{% extends \'' . $this->getExtendBundlePath() . '\' %}';
    }

    public function getTitleLinePart()
    {
        return null;
    }

    public function getBlockTitleLine()
    {
        return '{% block title %}' . $this->getTitleLinePart() . '{% endblock %}';
    }

    public function getPageTitleLinePart()
    {
        return null;
    }

    public function getBlockPageTitleLine()
    {
        return '{% block pageTitle %}' . $this->getPageTitleLinePart() . '{% endblock %}';
    }

    public function getNavigationLines()
    {
        return [];
    }

    public function getBlockNavigationLines()
    {
        $lines = [];

        $lines[] = '{% block navigation %}';

        $lines = array_merge($lines, $this->getNavigationLines());

        $lines[] = '{% endblock %}';

        return $lines;
    }

    public function getContentLines()
    {
        return [];
    }

    public function getBlockContentLines()
    {
        $lines = [];

        $lines[] = '{% block contents %}';

        $lines = array_merge($lines, $this->getContentLines());

        $lines[] = '{% endblock %}';

        return $lines;
    }

    public function getFileLines()
    {
        return [];
    }

    public function render()
    {
        $lines = [];

        $lines[] = $this->getFilenameLine();
        $lines[] = '';

        $lines = array_merge($lines, $this->getFileLines());

        $twigJustifier = new TwigJustifier($this->getIndentation(), 1);

        $lines = $twigJustifier->justifyFromLines($lines);

        return $this->convertLinesToCode($lines);
    }

    public function getUserAdditions($part)
    {
        return '{# <user-additions' . ' part="' . $part . '"> #}';
    }

    public function getEndUserAdditions()
    {
        return '{# </user-additions' . '> #}';
    }
    // </user-additions>
    // </editor-fold>
}
