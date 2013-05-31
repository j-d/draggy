<?php
// Draggy\Autocode\Templates\PHP\CrudUpdate.php

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

use Draggy\Autocode\Templates\PHP\Base\CrudUpdateBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\CrudUpdate
 */
class CrudUpdate extends CrudUpdateBase
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
    public function render()
    {
        $entity = $this->getEntity();

        $file = '';

        $file .= '<?php' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '// <user-additions' . ' part="template">' . PHP_EOL;
        $file .= 'use Common\Twig as T;' . PHP_EOL;
        $file .= 'use Common\Html\FormItem;' . PHP_EOL;
        $file .= 'use Common\Html\Table;' . PHP_EOL;
        $file .= 'use Common\Html\Cell;' . PHP_EOL;
        $file .= 'use Common\Html\Submit;' . PHP_EOL;
        $file .= 'use Common\Html\FormItemArray;' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '/** @var $type FormItemArray|FormItem[] */' . PHP_EOL;
        $file .= '$type = $GLOBALS[\'twigPhpParameters\'];' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '$type->setRenderEngineParameter(\'form\');' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= 'echo    \'{% extends \\\'CommonBundle:Default:base.html.twig\\\' %}\' . PHP_EOL;' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= 'echo    \'{% block title %}\', \'Edit ' . $entity->getName() . '\', \' {% endblock %}\' . PHP_EOL;' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '$form = new Table();' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '$form' . PHP_EOL;
        $file .= '    ->setRenderEngineParameter(\'form\')' . PHP_EOL;
        $file .= '    ->addCss(\'noBorder\');' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '$form' . PHP_EOL;
        $file .= '    ->addRows(' . PHP_EOL;

        foreach ($entity->getFormAttributes() as $attr) {
            $file .= '        [' . PHP_EOL;
            $file .= '            $type[\'' . $attr->getName() . '\']->toTwigLabel(),' . PHP_EOL;
            $file .= '            $type[\'' . $attr->getName() . '\']' . PHP_EOL;
            $file .= '        ],' . PHP_EOL;
        }

        $file .= '        new Cell(new Submit(\'#submit\',\'Save\',[\'validate\'=>\'\']),[\'colspan\'=>2],\'center\')' . PHP_EOL;
        $file .= '    );' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= 'echo    \'{% block body %}\', PHP_EOL,' . PHP_EOL;
        $file .= '            \'{{ parent() }}\', PHP_EOL,' . PHP_EOL;
        $file .= '            T::form([\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '_edit\',[\'id\'=>\'{{ id }}\']],\'form\'),' . PHP_EOL;
        $file .= '                T::formErrors(\'form\'),' . PHP_EOL;
        $file .= '                    $form->toHtml(),' . PHP_EOL;
        $file .= '                T::formRest(\'form\'),' . PHP_EOL;
        $file .= '            T::_FORM,' . PHP_EOL;
        $file .= '        \'{% endblock %}\' . PHP_EOL;' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= 'echo    T::blockJS($form->getJS());' . PHP_EOL;
        $file .= '// </user-additions' . '>' . PHP_EOL;

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}