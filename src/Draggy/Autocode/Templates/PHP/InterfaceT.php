<?php
// Autocode\Templates\PHP\Form.php

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

use Draggy\Autocode\Templates\PHP\Base\InterfaceTBase;
// <user-additions part="use">
// </user-additions>

/**
 * Autocode\Templates\PHP\Entity\Form
 */
class InterfaceT extends InterfaceTBase
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
        $file .= '// ' . $entity->getNamespace() . '\\Interfaces\\' . $entity->getName() . 'Interface.php' . "\n";
        $file .= $this->getBlurb();

        $file .= 'namespace ' . $entity->getNamespace() . '\\Interfaces;' . "\n";
        $file .= "\n";
        $file .= 'use Symfony\\Component\\Form\\FormBuilderInterface;' . "\n";
        $file .= 'use ' . $entity->getNamespace() . '\\Interfaces\\' . $entity->getName() . 'InterfaceTBase;' . "\n";

        $file .= '// <user-additions' . ' part="use">' . "\n";
        $file .= '// </user-additions' . '>' . "\n";
        $file .= "\n";
        $file .= 'interface ' . $entity->getName() . 'Interface {' . "\n";
        $file .= '    // <user-additions' . ' part="methods">' . "\n";
        $file .= '    // </user-additions' . '>' . "\n";
        $file .= '}' . "\n";

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}