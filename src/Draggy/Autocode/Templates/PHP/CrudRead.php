<?php
// Draggy\Autocode\Templates\PHP\CrudRead.php

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

use Draggy\Autocode\Templates\PHP\Base\CrudReadBase;
// <user-additions part="use">
use Draggy\Autocode\Templates\RenderizableTemplateInterface;
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\CrudRead
 */
class CrudRead extends CrudReadBase implements RenderizableTemplateInterface
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
        return 'crud-read';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'list' . $this->getEntity()->getName();
    }

    public function getExtendBundlePath()
    {
        return 'MockBundle:Default:navigationPage.html.twig';
    }

    public function getTitleLinePart()
    {
        return '{{ parent() }} | View ' . $this->getEntity()->getPluralLowerHumanName();
    }

    public function getPageTitleLinePart()
    {
        return 'View ' . $this->getEntity()->getPluralLowerHumanName();
    }

    public function getContentLines()
    {
        $lines = [];

        $lines[] = '<table class="table table-hover table-bordered">';
        $lines[] =     '<thead>';
        $lines[] =         '<tr>';

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if (
                null === $attr->getForeign() ||
                'OneToOne' === $attr->getForeign() ||
                ('ManyToOne' === $attr->getForeign() && $attr->getOwnerSide())
            ) {
                $lines[] = '<th>' . $attr->getUpperName() . '</th>';
            }
        }

        $lines[] =             '<th>Actions</th>';
        $lines[] =         '</tr>';
        $lines[] =     '</thead>';

        $lines[] =     '<tbody>';
        $lines[] =         '{% for ' . $this->getEntity()->getLowerName() . ' in ' . $this->getEntity()->getPluralLowerName() . ' %}';
        $lines[] =             '<tr>';

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if (
                null === $attr->getForeign() ||
                'OneToOne' === $attr->getForeign() ||
                ('ManyToOne' === $attr->getForeign() && $attr->getOwnerSide())
            ) {
                if ('boolean' === $attr->getType()) {
                    $lines[] = '<td>{{ ' . $this->getEntity()->getLowerName() . '.' . $attr->getGetterName() . '() ? \'Y\' : \'\' }}</td>';
                } elseif ('date' === $attr->getType()) {
                    $lines[] = '<td>{{ ' . $this->getEntity()->getLowerName() . '.' . $attr->getGetterName() . '() | date(\'d-M-Y\') }}</td>';
                } elseif ('time' === $attr->getType()) {
                    $lines[] = '<td>{{ ' . $this->getEntity()->getLowerName() . '.' . $attr->getGetterName() . '() | date(\'H:i:s\') }}</td>';
                } elseif ('datetime' === $attr->getType()) {
                    $lines[] = '<td>{{ ' . $this->getEntity()->getLowerName() . '.' . $attr->getGetterName() . '() | date(\'d-M-Y H:i:s\') }}</td>';
                } else {
                    $lines[] = '<td>{{ ' . $this->getEntity()->getLowerName() . '.' . $attr->getGetterName() . '() }}</td>';
                }
            }
        }

        $lines[] =             '<td>';

        $id = $this->getEntity()->getPrimaryAttribute();

        if ($this->getEntity()->getCrudUpdate()) {
            if (null === $id->getForeign()) {
                $lines[] = $actionsArray[] = '<a href="{{ path(\'' . $this->getEntity()->getEditRoute() . '\', {\'' . $id->getName() . '\': ' . $this->getEntity()->getLowerName() . '.' . $id->getGetterName() . '()}) }}">Edit</a>';
            } else {
                // Is also foreign
                $lines[] = $actionsArray[] = '<a href="{{ path(\'' . $this->getEntity()->getEditRoute() . '\', {\'' . $id->getForeignEntity()->getPrimaryAttribute()->getName() . '\': ' . $this->getEntity()->getLowerName() . '.' . $id->getGetterName() . '().' . $id->getForeignEntity()->getPrimaryAttribute()->getGetterName() . '()}) }}">Edit</a>';
            }
        }

        if ($this->getEntity()->getCrudDelete()) {
            if (null === $id->getForeign()) {
                $lines[] = $actionsArray[] = '<a href="{{ path(\'' . $this->getEntity()->getDeleteRoute() . '\', {\'' . $id->getName() . '\': ' . $this->getEntity()->getLowerName() . '.' . $id->getGetterName() . '()}) }}">Delete</a>';
            } else {
                // Is also foreign
                $lines[] = $actionsArray[] = '<a href="{{ path(\'' . $this->getEntity()->getDeleteRoute() . '\', {\'' . $id->getForeignEntity()->getPrimaryAttribute()->getName() . '\': ' . $this->getEntity()->getLowerName() . '.' . $id->getGetterName() . '().' . $id->getForeignEntity()->getPrimaryAttribute()->getGetterName() . '()}) }}">Delete</a>';
            }
        }

        $lines[] =             '</td>';
        $lines[] =             '</tr>';
        $lines[] =         '{% endfor %}';
        $lines[] =     '</tbody>';
        $lines[] = '</table>';

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
