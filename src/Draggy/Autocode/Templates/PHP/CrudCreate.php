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
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\CrudCreate
 */
class CrudCreate extends CrudCreateBase
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
        return 'Resources/views/' . $this->getEntity()->getName() . '/';
    }

    /**
     * {@inheritDoc}
     */
    public function getFilename()
    {
        return 'add' . $this->getEntity()->getName() . '.html.twig';
    }

    public function getExtendBundlePath()
    {
        return 'MockBundle:Default:navigationPage.html.twig';
    }

    public function getExtendLine()
    {
        return '{% extends \'' . $this->getExtendBundlePath() . '\' %}';
    }

    public function getTitleLine()
    {
        return '{{ parent() }} | Add ' . $this->getEntity()->getName();
    }

    public function getBlockTitleLine()
    {
        return '{% block title %}' . $this->getTitleLine() . '{% endblock %}';
    }

    public function getPageTitleLine()
    {
        return 'Add ' . $this->getEntity()->getName();
    }

    public function getBlockPageTitleLine()
    {
        return '{% block pageTitle %}' . $this->getPageTitleLine() . '{% endblock %}';
    }

    public function getNavigationLines()
    {
        $lines = [];

        return $lines;
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
        $lines = [];

        $lines[] = '{{ parent() }}';
        $lines[] = '{{ form(form) }}';

        return $lines;
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
        $lines = [];

        $lines[] = $this->getUserAdditions('template');
        $lines[] = $this->getExtendLine();
        $lines[] = '';
        $lines[] = $this->getBlockTitleLine();
        $lines[] = '';
        $lines[] = $this->getBlockPageTitleLine();
        $lines[] = '';

        $lines = array_merge($lines, $this->getBlockNavigationLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getBlockContentLines());

        $lines[] = $this->getEndUserAdditions();

        return $lines;
    }

//    public function render()
//    {
//        $lines = [];
//
//        $lines[] = '<?php';
//        $lines[] = '';
//        //$lines[] = $this->getUserAdditions('template');
//        $lines[] = 'use Common\Twig as T;';
//        $lines[] = 'use Common\Html\FormItem;';
//        $lines[] = 'use Common\Html\Table;';
//        $lines[] = 'use Common\Html\Cell;';
//        $lines[] = 'use Common\Html\Submit;';
//        $lines[] = '';
//        $lines[] = '/** @var $type FormItem[] */';
//        $lines[] = '$type = $GLOBALS[\'twigPhpParameters\'];';
//        $lines[] = '';
//        $lines[] = 'echo    \'{% extends \\\'CommonBundle:Default:base.html.twig\\\' %}\';';
//        $lines[] = '';
//        $lines[] = 'echo    \'{% block title %}\', \'Add ' . $this->getEntity()->getName() . '\', \' {% endblock %}\';';
//        $lines[] = '';
//        $lines[] = '$form = new Table();';
//        $lines[] = '';
//        $lines[] = '$form';
//        $lines[] = '    ->setRenderEngineParameter(\'form\')';
//        $lines[] = '    ->addCss(\'noBorder\');';
//        $lines[] = '';
//        $lines[] = '$form';
//        $lines[] = '    ->addRows(';
//
//        foreach ($this->getEntity()->getFormAttributes() as $attr) {
//            $lines[] = '        [';
//            $lines[] = '            $type[\'' . $attr->getName() . '\']->toTwigLabel(),';
//            $lines[] = '            $type[\'' . $attr->getName() . '\']';
//            $lines[] = '        ],';
//        }
//
//        $lines[] = '        new Cell(new Submit(\'#submit\',\'Add\',[\'validate\'=>\'\']),[\'colspan\'=>2],\'center\')';
//        $lines[] = '    );';
//        $lines[] = '';
//        $lines[] = 'echo    \'{% block body %}\', PHP_EOL,';
//        $lines[] = '            \'{{ parent() }}\', PHP_EOL,';
//        $lines[] = '            T::form(\'' . strtolower($this->getEntity()->getModuleNoBundle()) . '_' . strtolower($this->getEntity()->getName()) . '_add\',\'form\'),';
//        $lines[] = '                T::formErrors(\'form\'),';
//        $lines[] = '                    $form->toHtml(),';
//        $lines[] = '                T::formRest(\'form\'),';
//        $lines[] = '            T::_FORM,';
//        $lines[] = '        \'{% endblock %}\';';
//        $lines[] = '';
//        $lines[] = 'echo    T::blockJS($form->getJS());';
//        //$lines[] = $this->getEndUserAdditions();
//
//        return implode("\n", $lines);
//    }
    // </user-additions>
    // </editor-fold>
}
