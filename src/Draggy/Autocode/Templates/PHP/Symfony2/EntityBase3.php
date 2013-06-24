<?php
// Draggy\Autocode\Templates\PHP\Symfony2\EntityBase3.php

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

namespace Draggy\Autocode\Templates\PHP\Symfony2;

use Draggy\Autocode\Templates\PHP\Symfony2\Base\EntityBase3Base;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Symfony2\Entity\EntityBase3
 */
class EntityBase3 extends EntityBase3Base
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
        return $this->getEntity()->getProject()->getBase()
            ? 'Entity/Base/'
            : 'Entity/';
    }

    public function getFilenameLine()
    {
        return '// ' . $this->getEntity()->getNamespace() . '\\Entity\\' . $this->getEntity()->getName() . '.php';
    }

    public function getNamespaceLine()
    {
        return 'namespace ' . $this->getEntity()->getNamespace() .'\\Entity;';
    }

    public function getUseLinesSymfony2Part()
    {
        $lines = [];

        $lines[] = 'use ' . $this->getEntity()->getNamespace() . '\\Entity\\Base\\' . $this->getEntity()->getNameBase() . ';';
        $lines[] = 'use Symfony\Component\Validator\Constraints as Assert;';

        return $lines;
    }

    public function getUseLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->getUseLinesSymfony2Part());
        $lines = array_merge($lines, $this->getUseLinesUserAdditionsPart());

        return $lines;
    }

    public function getEntityDocumentationLines()
    {
        $lines = parent::getEntityDocumentationLines();

        $lines[] = '';

        if (0 === count($this->getEntity()->getChildrenEntities())) {
            $lines[] = !$this->getEntity()->getHasRepository()
                ? '@ORM\\Entity'
                : '@ORM\\Entity(repositoryClass="' . $this->getEntity()->getFullyQualifiedName() . 'Repository")';
        } else {
            $lines[] = '@ORM\MappedSuperclass';
        }

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
