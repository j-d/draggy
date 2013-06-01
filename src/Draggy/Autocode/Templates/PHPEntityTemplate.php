<?php
// Draggy\Autocode\Templates\PHPEntityTemplate.php

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

use Draggy\Autocode\Templates\Base\PHPEntityTemplateBase;
// <user-additions part="use">
use Draggy\Autocode\Entity;
use Draggy\Autocode\PHPEntity;
// </user-additions>

/**
 * Draggy\Autocode\Templates\Entity\PHPEntityTemplate
 */
abstract class PHPEntityTemplate extends PHPEntityTemplateBase
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
    /**
     * Get entity
     *
     * @return PHPEntity
     */
    public function getEntity()
    {
        return $this->entity;
    }
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    /**
     * @param Entity $entity
     *
     * @return string
     */
    public static function getEntityUseLine(Entity $entity)
    {
        $line = 'use ' . $entity->getNamespace();

        if ($entity->getProject()->getFramework() === 'Symfony2') {
            $line .= '\\Entity';
        }

        $line .= '\\' . $entity->getName() . ';';

        return $line;
    }

    /**
     * TODO: Check deprecated
     *
     * @return string
     *
     * @deprecated
     */
    public function getConstructorDefaultValuesPart()
    {
        $file = '';

        foreach ($this->getEntity()->getAttributes() as $a) {
            $attributeDefaultValueConstructor = $a->getDefaultValueConstructorInit();

            if ($attributeDefaultValueConstructor !== '') {
                $file .= '        $this->' . $a->getLowerName() . ' = ' . $attributeDefaultValueConstructor . ';' . "\n";
            }
        }

        return $file;
    }

    public function getFilenameLine()
    {
        return null;
    }

    public function getNamespaceLine()
    {
        return null;
    }

    public function getUseLines()
    {
        return [];
    }

    public function getEntityDocumentationLines()
    {
        return [];
    }

    public function getEntityLines()
    {
        return [];
    }

    public function render()
    {
        $lines = [];

        $lines[] = '<?php';

        $lines[] = $this->getFilenameLine();

        $lines = array_merge($lines, $this->getDescriptionCodeLines());

        $lines = array_merge($lines, $this->getBlurbLines());

        $namespaceLine = $this->getNamespaceLine();

        if (null !== $namespaceLine) {
            $lines[] = $namespaceLine;
            $lines[] = '';
        }

        $lines = array_merge($lines, $this->getUseLines());

        $lines = array_merge($lines, $this->getEntityDocumentationLines());
        $lines = array_merge($lines, $this->getEntityLines());

        return $this->convertLinesToCode($lines);
    }
    // </user-additions>
    // </editor-fold>
}