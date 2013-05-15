<?php
// Draggy\Autocode\Templates\PHP\CrudCreateTwig.php

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

use Draggy\Autocode\Templates\PHP\Base\CrudCreateTwigBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\CrudCreateTwig
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

        $file .= '<?php' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '// <user-additions' . ' part="template">' . PHP_EOL;
        $file .= 'use Common\Twig as T;' . PHP_EOL;
        $file .= 'use Common\Html\Form;' . PHP_EOL;
        $file .= 'use Common\Html\FormItem;' . PHP_EOL;
        $file .= 'use Common\Html\FormItemArray;' . PHP_EOL;
        $file .= 'use Common\Html\Submit;' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '$type = $GLOBALS[\'twigPhpParameters\'];' . PHP_EOL;
        $file .= '/** @var $type FormItemArray|FormItem[] */' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '$type' . PHP_EOL;
        $file .= '    ->setRenderStyle(\'bootstrap\')' . PHP_EOL;
        $file .= '    ->setRenderModeParameter(\'form\');' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '$formAttributes = [' . PHP_EOL;
        $file .= '    \'css\' => \'form-horizontal\'' . PHP_EOL;
        $file .= '];' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '$form = new Form($formAttributes);' . PHP_EOL;
        $file .= '$form   ->setName(\'form\');' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '?>' . PHP_EOL;
        $file .= '    {% extends \'CommonBundle:Default:base.html.twig\' %}' . PHP_EOL;
        $file .= '    {% block body_div_class %}container-fluid{% endblock %}' . PHP_EOL;
        $file .= '    {% block title %}Add ' . $entity->getName() . '{% endblock %}' . PHP_EOL;
        $file .= '    {% block content %}' . PHP_EOL;
        $file .= '<?= $form->getOpeningTag() ?>' . PHP_EOL;
        $file .= '<?= $form->getTwigErrors() ?>' . PHP_EOL;
        $file .= '    <section id="' . strtolower($entity->getName()) . '">' . PHP_EOL;
        $file .= '        <div class="row-fluid">' . PHP_EOL;
        $file .= '            <div class="span12">' . PHP_EOL;

        foreach ($entity->getFormAttributes() as $attr) {
            $file .= '                <?= $type[\'' . $attr->getName() . '\'] ?>' . PHP_EOL;
        }

        $file .= '            </div>' . PHP_EOL;
        $file .= '       </div>' . PHP_EOL;
        $file .= '       <?= new Submit(\'submit\',\'Submit\',[\'validate\'=>\'\'], [\'css\'=>\'btn\']) ?>' . PHP_EOL;
        $file .= '       {{ form_rest(form) }}' . PHP_EOL;
        $file .= '    </section>' . PHP_EOL;
        $file .= '<?= $form->getClosingTag() ?>' . PHP_EOL;
        $file .= '    {% endblock %}' . PHP_EOL;
        $file .= '<?php' . PHP_EOL;
        $file .= 'echo    T::blockJS($form->getJS());' . PHP_EOL;
        $file .= '// </user-additions>' . PHP_EOL;

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}