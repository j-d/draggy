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
class TwigEntityTemplate extends EntityTemplate implements TwigEntityTemplateInterface
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
    /**
     * @return ConcreteTwigEntityTemplateInterface
     */
    public function getTemplate()
    {
        return parent::getTemplate();
    }
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    /**
     * {@inheritDoc}
     */
    public function getFilename()
    {
        return $this->getTemplate()->getName() . '.html.twig';
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        return 'Resources/views/' . $this->getTemplate()->getEntity()->getName() . '/';
    }

    public function getFilenameLine()
    {
        return '{# ' . $this->getTemplate()->getPathAndFilename() . ' #}';
    }

    public function getExtendLine()
    {
        return '{% extends \'' . $this->getTemplate()->getExtendBundlePath() . '\' %}';
    }

    public function getBlockTitleLine()
    {
        return '{% block title %}' . $this->getTemplate()->getTitleLinePart() . '{% endblock %}';
    }

    public function getBlockPageTitleLine()
    {
        return '{% block pageTitle %}' . $this->getTemplate()->getPageTitleLinePart() . '{% endblock %}';
    }

    public function getNavigationLines()
    {
        $lines = [];

        $lines[] = '<ul class="nav nav-list">';
        $lines[] =     '<li class="nav-header">' . $this->getTemplate()->getEntity()->getPluralName() . '</li>';

        if ($this->getTemplate()->getEntity()->getCrudCreate()) {
            $lines[] = '<li><a href="{{ path(\'' . $this->getTemplate()->getEntity()->getAddRoute() . '\') }}">Add ' . $this->getTemplate()->getEntity()->getLowerName() . '</a></li>';
        }

        if ($this->getTemplate()->getEntity()->getCrudRead()) {
            $lines[] = '<li><a href="{{ path(\'' . $this->getTemplate()->getEntity()->getListRoute() . '\') }}">View ' . $this->getTemplate()->getEntity()->getPluralLowerName() . '</a></li>';
        }

        $otherEntityLines = [];

        foreach ($this->getTemplate()->getEntity()->getProject()->getEntities() as $entity) {
            if ($entity !== $this->getTemplate()->getEntity()) {
                if ($entity->getCrudRead()) {
                    $otherEntityLines[] = '<li><a href="{{ path(\'' . $entity->getListRoute() . '\') }}">' . $entity->getPluralName() . '</a></li>';
                }
            }
        }

        if (count($otherEntityLines) > 0) {
            $lines[] = '<li class="divider"></li>';
            $lines[] = '<li class="nav-header">Other</li>';

            $lines = array_merge($lines, $otherEntityLines);
        }

        $lines[] = '</ul>';

        return $lines;
    }

    public function getBlockNavigationLines()
    {
        $lines = [];

        $lines[] = '{% block navigation %}';

        $lines = array_merge($lines, $this->getTemplate()->getNavigationLines());

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

        $lines = array_merge($lines, $this->getTemplate()->getContentLines());

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

        $lines[] = $this->getTemplate()->getFilenameLine();
        $lines[] = '';

        $lines = array_merge($lines, $this->getTemplate()->getFileLines());

        $twigJustifier = new TwigJustifier($this->getTemplate()->getIndentation(), 1);

        $lines = $twigJustifier->justifyFromLines($lines);

        return $this->getTemplate()->convertLinesToCode($lines);
    }

    public function getUserAdditions($part)
    {
        return '{# <user-additions' . ' part="' . $part . '"> #}';
    }

    public function getEndUserAdditions()
    {
        return '{# </user-additions' . '> #}';
    }

    public function getDescriptionCodeLines()
    {
        return [];
    }
    // </user-additions>
    // </editor-fold>
}
