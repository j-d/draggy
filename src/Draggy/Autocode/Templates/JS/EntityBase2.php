<?php
// Autocode\Templates\JS\EntityBase2.php

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

namespace Draggy\Autocode\Templates\JS;

use Draggy\Autocode\Templates\JS\Base\EntityBase2Base;
// <user-additions part="use">
use Draggy\Autocode\Entity;
// </user-additions>

/**
 * Autocode\Templates\JS\Entity\EntityBase2
 */
class EntityBase2 extends EntityBase2Base
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
    public static function needsInit(Entity $entity)
    {
        return count($entity->getChildrenEntities()) > 0;
    }

    public function render()
    {
        $entity = $this->getEntity();

        $file = '';

        $staticAttributes = [];
        foreach ($entity->getAttributes() as $attr) {
            if ($attr->getStatic() && $attr->getEntity()->getName() === $entity->getName()) {
                $staticAttributes[] = $attr->getAttribute();
            }
        }

        $file .= '// ' . $entity->getNamespace() . '\\';
        $file .= $entity->getName() . '.js' . "\n";

        $file .= $this->getBlurb();

        $file .= $entity->getName() . '.prototype = new ' . $entity->getName() . 'Base();' . "\n";
        $file .= $entity->getName() . '.prototype.constructor = ' . $entity->getName() . ';' . "\n";

        if (count($staticAttributes)) {
            $file .= "\n";
            $file .= '// Static' . "\n";
            $file .= implode("\n",$staticAttributes);
            $file .= "\n";
        }

        $file .= "\n";

        $file .= '/**' . "\n";
        $file .= ' * ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . "\n";
        $file .= ' */' . "\n";

        $file .= '// <user-additions' . ' part="classDeclaration">' . "\n";
        $file .= 'function ' . $entity->getName() . '()' . "\n";
        $file .= '// </user-additions' . '>' . "\n";

        $file .= '{' . "\n";
        $file .= '    // <editor-fold desc="Attributes">' . "\n";
        $file .= '    // <user-additions' . ' part="attributes">' . "\n";
        $file .= '    // </user-additions' . '>' . "\n";
        $file .= '    // </editor-fold>' . "\n";
        $file .= "\n";

        if (!$this->needsInit($this)) {
            $file .= '    // <editor-fold desc="Constructor">' . "\n";
            $file .= '    // <user-additions' . ' part="constructor">' . "\n";
            $file .= '    // </user-additions' . '>' . "\n";
            $file .= '    // </editor-fold>' . "\n";
        } else {
            $file .= '    // <user-additions' . ' part="init">' . "\n";
            $file .= '    this.init' . $entity->getName() . '();' . "\n";
            $file .= '    // </user-additions' . '>' . "\n";
        }

        $file .= '}' . "\n\n";

        if ($this->needsInit($this)) {
            $file .= '// <editor-fold desc="Constructor">' . "\n";
            $file .= '// <user-additions' . ' part="constructorDeclaration">' . "\n";
            $file .= $entity->getName() . '.prototype.init' . $entity->getName() . ' = function ()' . "\n";
            $file .= '// </user-additions' . '>' . "\n";
            $file .= '{' . "\n";

            if (!is_null($entity->getParentEntity()) && $this->needsInit($entity->getParentEntity())) {
                $file .= '    // <user-additions' . ' part="constructorInit">' . "\n";
                $file .= '    this.init' . $entity->getParentEntity()->getName() . '();' . "\n";
                $file .= '    // </user-additions' . '>' . "\n";
                $file .= "\n";
            }

            $file .= '    // <user-additions' . ' part="constructor">' . "\n";
            $file .= '    // </user-additions' . '>' . "\n";
            $file .= '};' . "\n";
            $file .= '// </editor-fold>' . "\n";
            $file .= "\n";
        }

        $file .= '// <editor-fold desc="Setters and Getters">' . "\n";
        $file .= '// <user-additions' . ' part="settersAndGetters">' . "\n";
        $file .= '// </user-additions' . '>' . "\n";
        $file .= '// </editor-fold>' . "\n";
        $file .= "\n";
        $file .= '// <editor-fold desc="Other methods">' . "\n";
        $file .= '// <user-additions' . ' part="otherMethods">' . "\n";
        $file .= '// </user-additions' . '>' . "\n";
        $file .= '// </editor-fold>';
        return $file;
    }
    // </user-additions>
    // </editor-fold>
}