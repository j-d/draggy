<?php
// Draggy\Autocode\Templates\Template.php

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

use Draggy\Autocode\Templates\Base\TemplateBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\Entity\Template
 */
abstract class Template extends TemplateBase
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
     * Renders a template and returns its contents
     *
     * @return string
     */
    abstract public function render();

    public function getBlurb()
    {
        $file = '';

        $file .= "\n";
        $file .= '/************************************************************************************************' . "\n";
        $file .= ' **  THIS IS AN AUTOMATICALLY GENERATED BASE FILE AND SHOULD NOT BE MANUALLY EDITED            **' . "\n";
        $file .= ' **  All user content should be placed within <user-additions' . ' part="(name)"></user-additions' . '>  **' . "\n";
        $file .= ' ************************************************************************************************/' . "\n";
        $file .= "\n";
        $file .= '/*' . "\n";
        $file .= ' * This file was automatically generated with \'Autocode\'' . "\n";
        $file .= ' * by Jose Diaz-Angulo <jose@diazangulo.com>' . "\n";
        $file .= ' * ' . "\n";
        $file .= ' * For the full copyright and license information, please view the LICENSE' . "\n";
        $file .= ' * file that was distributed with the package\'s source code.' . "\n";
        $file .= ' */' . "\n";
        $file .= "\n";

        return $file;
    }

    public function getHashBlurb()
    {
        $file = '';

        $file .= '#  THIS IS AN AUTOMATICALLY GENERATED BASE FILE AND SHOULD NOT BE MANUALLY EDITED' . "\n";
        $file .= '#  All user content should be placed within <user-additions' . ' part="(name)"></user-additions' . '>' . "\n";
        $file .= "\n";
        $file .= '# This file was automatically generated with \'Autocode\'' . "\n";
        $file .= '# by Jose Diaz-Angulo <jose@diazangulo.com>' . "\n";
        $file .= '# ' . "\n";
        $file .= '# For the full copyright and license information, please view the LICENSE' . "\n";
        $file .= '# file that was distributed with the package\'s source code.' . "\n";
        $file .= "\n";

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}