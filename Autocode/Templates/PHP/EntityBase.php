<?php
// Autocode\Templates\PHP\EntityBase.php

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

use Autocode\Templates\PHP\Base\EntityBaseBase;
// <user-additions part="use">
// </user-additions>

/**
 * Autocode\Templates\PHP\Entity\EntityBase
 */
class EntityBase extends EntityBaseBase
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

        $file .= '// ' . $entity->getNamespace() . '\\';
        if ($entity->getProject()->getFramework() === 'Symfony2') {
            $file .= 'Entity\\';
        }
        $file .= $entity->getName() . '.php' . "\n";

        $file .= $this->getBlurb();

        $file .= 'namespace ' . $entity->getNamespace();
        if ($entity->getProject()->getFramework() === 'Symfony2') {
            $file .= '\\Entity';
        }
        $file .= ';' . "\n";

        $file .= "\n";

        if ($entity->getProject()->getORM() === 'Doctrine2') {
            $file .= 'use Doctrine\ORM\Mapping as ORM;' . "\n";
        }

        if ($entity->getProject()->getFramework() === 'Symfony2') {
            $file .= 'use Symfony\Component\Validator\Constraints as Assert;' . "\n";
        }

        $file .= 'use ' . $entity->getNamespace() . '\\';
        if ($entity->getProject()->getFramework() === 'Symfony2') {
            $file .= 'Entity\\';
        }
        $file .= 'Base\\' . $entity->getNameBase() . ';' . "\n";

        if ($entity->getProject()->getORM() === 'Doctrine2') {
            $useArrayCollection = false;
            foreach ($entity->getAttributes() as $attr) {
                if (!is_null($attr->getForeign()) && $attr->getType() == 'array') {
                    $useArrayCollection = true;
                    break;
                }
            }

            if ($useArrayCollection)
                $file .= 'use Doctrine\\Common\\Collections\\ArrayCollection;' . "\n";
        }

        $file .= '// <user-additions' . ' part="use">' . "\n";
        $file .= '// </user-additions' . '>' . "\n";
        $file .= "\n";

        $file .= '/**' . "\n";
        $file .= ' * ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . "\n";

        if ($entity->getProject()->getORM() === 'Doctrine2') {
            $file .= ' *' . "\n";

            if (count($entity->getChildrenEntities()) == 0 /*|| count($this->getAttributes()) != $this->getMaxNumberAttributesChildren()*/ ) {
                if (!$entity->getHasRepository()) {
                    $file .= ' * @ORM\\Entity' . "\n";
                } else {
                    $file .= ' * @ORM\\Entity(repositoryClass="' . $entity->getFullyQualifiedName() . 'Repository")' . "\n";
                }
            } else {
                $file .= ' * @ORM\MappedSuperclass' . "\n";
            }
        }

        $file .= ' */' . "\n";

        if (count($entity->getChildrenEntities()) == 0 /*|| count($this->getAttributes()) != $this->getMaxNumberAttributesChildren()*/ ) {
            $file .= 'class ' . $entity->getName() . ' extends ' . $entity->getNameBase() . "\n";
        } else {
            $file .= 'abstract class ' . $entity->getName() . ' extends ' . $entity->getNameBase() . "\n";
        }
        $file .= '    // <user-additions' . ' part="implements">' . "\n";
        $file .= '    // </user-additions' . '>' . "\n";

        $file .= '{' . "\n";
        $file .= '    // <editor-fold desc="Attributes">' . "\n";
        $file .= '    // <user-additions' . ' part="attributes">' . "\n";
        $file .= '    // </user-additions' . '>' . "\n";
        $file .= '    // </editor-fold>' . "\n";
        $file .= "\n";

        if ($entity->getHasConstructor()) {
            $file .= '    // <editor-fold desc="Constructor">' . "\n";
            $file .= '    // <user-additions' . ' part="constructorDeclaration">' . "\n";
            $file .= '    public function __construct()' . "\n";
            $file .= '    // </user-additions' . '>' . "\n";
            $file .= '    {' . "\n";

            $file .= $this->getConstructorDefaultValuesPart();

            $file .= '        // <user-additions' . ' part="constructor">' . "\n";
            $file .= '        // </user-additions' . '>' . "\n";
            $file .= '    }' . "\n";
            $file .= '    // </editor-fold>' . "\n";
            $file .= "\n";
        }

        $file .= '    // <editor-fold desc="Setters and Getters">' . "\n";
        $file .= '    // <user-additions' . ' part="settersAndGetters">' . "\n";
        $file .= '    // </user-additions' . '>' . "\n";
        $file .= '    // </editor-fold>' . "\n";
        $file .= "\n";
        $file .= '    // <editor-fold desc="Other methods">' . "\n";
        $file .= '    // <user-additions' . ' part="otherMethods">' . "\n";
        $file .= '    // </user-additions' . '>' . "\n";
        $file .= '    // </editor-fold>' . "\n";
        $file .= '}';

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}