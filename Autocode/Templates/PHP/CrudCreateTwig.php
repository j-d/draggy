<?php
// Autocode\Templates\PHP\CrudCreateTwig.php

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

namespace Autocode\Templates\PHP;

use Autocode\Templates\PHP\Base\CrudCreateTwigBase;
// <user-additions part="use">
// </user-additions>

/**
 * Autocode\Templates\PHP\Entity\CrudCreateTwig
 */
class CrudCreateTwig extends CrudCreateTwigBase
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

        $file .= '<?php' . "\n";
        $file .= "\n";
        $file .= '// <user-additions' . ' part="template">' . "\n";
        $file .= 'use Common\Twig as T;' . "\n";
        $file .= 'use Common\Html\FormItem;' . "\n";
        $file .= 'use Common\Html\Table;' . "\n";
        $file .= 'use Common\Html\Cell;' . "\n";
        $file .= 'use Common\Html\Submit;' . "\n";
        $file .= "\n";
        $file .= '/** @var $type FormItem[] */' . "\n";
        $file .= '$type = $GLOBALS[\'twigPhpParameters\'];' . "\n";
        $file .= "\n";
        $file .= 'echo    T::extends_(\'CommonBundle:Default:base.html.twig\');' . "\n";
        $file .= "\n";
        $file .= 'echo    T::block_(\'title\'), \'Add ' . $entity->getName() . '\', T::_BLOCK;' . "\n";
        $file .= "\n";
        $file .= '$form = new Table();' . "\n";
        $file .= "\n";
        $file .= '$form' . "\n";
        $file .= '    ->setRenderModeParameter(\'form\')' . "\n";
        $file .= '    ->addCss(\'noBorder\');' . "\n";
        $file .= "\n";
        $file .= '$form' . "\n";
        $file .= '    ->addRows(' . "\n";

        foreach ($entity->getFormAttributes() as $attr) {
            $file .= '        [' . "\n";
            $file .= '            $type[\'' . $attr->getName() . '\']->toTwigLabel(),' . "\n";
            $file .= '            $type[\'' . $attr->getName() . '\']' . "\n";
            $file .= '        ],' . "\n";
        }

        $file .= '        new Cell(new Submit(\'#submit\',\'Add\',[\'validate\'=>\'\']),[\'colspan\'=>2],\'center\')' . "\n";
        $file .= '    );' . "\n";
        $file .= "\n";
        $file .= 'echo    T::block(\'body\'),' . "\n";
        $file .= '            T::PARENT,' . "\n";
        $file .= '            T::form(\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '_add\',\'form\'),' . "\n";
        $file .= '                T::formErrors(\'form\'),' . "\n";
        $file .= '                    $form->toHtml(),' . "\n";
        $file .= '                T::formRest(\'form\'),' . "\n";
        $file .= '            T::_FORM,' . "\n";
        $file .= '        T::_BLOCK;' . "\n";
        $file .= "\n";
        $file .= 'echo    T::blockJS($form->getJS());' . "\n";
        $file .= '// </user-additions' . '>' . "\n";

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}