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
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\CrudRead
 */
class CrudRead extends CrudReadBase
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
        return 'list' . $this->getEntity()->getName();
    }

    public function getExtendBundlePath()
    {
        return 'MockBundle:Default:navigationPage.html.twig';
    }

    public function getTitleLinePart()
    {
        return '{{ parent() }} | List ' . $this->getEntity()->getName();
    }

    public function getPageTitleLinePart()
    {
        return 'List ' . $this->getEntity()->getName();
    }

    public function getContentLines()
    {
        $lines = [];

        $lines[] = '<table class="table table-hover table-bordered">';
        $lines[] =     '<thead>';
        $lines[] =         '<tr>';

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if (null === $attr->getForeign()) {
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
            if (null === $attr->getForeign()) {
                if ('boolean' === $attr->getType()) {
                    $lines[] = '<td>{{ ' . $this->getEntity()->getLowerName() . '.' . $attr->getGetterName() . '() ? \'Y\' : \'\' }}</td>';
                } else {
                    $lines[] = '<td>{{ ' . $this->getEntity()->getLowerName() . '.' . $attr->getGetterName() . '() }}</td>';
                }
            }
        }

        $lines[] =             '<td>';

        if ($this->getEntity()->getCrudUpdate()) {
            $lines[] = 'Edit';
            //$actionsArray[] = 'T::a(\'Edit\',[\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '_edit\',[\'id\'=>\'{{ ' . $entity->getLowerName() . '.getId() }}\']])';
        }

        if ($this->getEntity()->getCrudDelete()) {
            $lines[] = 'Delete';
            //$actionsArray[] = 'T::a(\'Delete\',[\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '_delete\',[\'id\'=>\'{{ ' . $entity->getLowerName() . '.getId() }}\']])';
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
