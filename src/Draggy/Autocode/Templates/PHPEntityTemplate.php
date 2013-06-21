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
use Draggy\Utils\PHPJustifier;
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

        if ('Symfony2' === $entity->getProject()->getFramework()) {
            $line .= '\\Entity';
        }

        $line .= '\\' . $entity->getName() . ';';

        return $line;
    }

    public function getFilenameLine()
    {
        return null;
    }

    public function getNamespaceLine()
    {
        return null;
    }

    public function getUseLinesUserAdditionsPart()
    {
        $lines = [];

        $lines[] = $this->getUserAdditions('use');
        $lines[] = $this->getEndUserAdditions();

        return $lines;
    }

    public function getUseLines()
    {
        return [];
    }

    public function getFileLines()
    {
        return [];
    }

    public function commentLines($lines)
    {
        foreach ($lines as $number => $line) {
            $lines[$number] = '//' . $line;
        }

        return $lines;
    }

    public function commentAndJustifyLines($lines)
    {
        $phpJustifier = new PHPJustifier($this->getIndentation(), 1);

        $lines = $phpJustifier->justifyFromLines($lines);

        return $this->commentLines($lines);
    }

    public function surroundDocumentationBlock(array $lines)
    {
        $phpJustifier = new PHPJustifier($this->getIndentation(), 1);

        $lines = $phpJustifier->justifyFromLines($lines);

        foreach ($lines as $key => $line) {
            $lines[$key] = '' !== $line
                ? ' * ' . $line
                : ' *' . $line;
        }

        $lines = array_merge(['/**'], $lines, [' */']);

        return $lines;
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
        $lines[] = '';

        $lines = array_merge($lines, $this->getFileLines());

        $phpJustifier = new PHPJustifier($this->getIndentation(), 1);

        $lines = $phpJustifier->justifyFromLines($lines);

        return $this->convertLinesToCode($lines);
    }

    public function getUserAdditions($part)
    {
        return '// <user-additions' . ' part="' . $part . '">';
    }

    public function getEndUserAdditions()
    {
        return '// </user-additions' . '>';
    }
    // </user-additions>
    // </editor-fold>
}
