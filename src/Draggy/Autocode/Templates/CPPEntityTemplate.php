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

use Draggy\Autocode\Entity;
use Draggy\Autocode\Templates\Base\PHPEntityTemplateBase;
// <user-additions part="use">
use Draggy\Utils\Justifier\CPP\CPPJustifier;
// </user-additions>

/**
 * Draggy\Autocode\Templates\Entity\PHPEntityTemplate
 */
abstract class CPPEntityTemplate extends EntityTemplate
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
    public function getFilenameLine()
    {
        return '// ' . str_replace('\\', '/', $this->getFullPathAndFilename());
    }

    public function getDescriptionCodeLines()
    {
        $lines = [];

        if ( '' !== trim($this->getEntity()->getDescription()) ) {
            $lines[] = '/*';
            $lines[] = ' * ' . trim($this->getEntity()->getDescription());
            $lines[] = ' */';
            $lines[] = '';
        }

        return $lines;
    }

    public function getNamespaceLines()
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
        $phpJustifier = new CPPJustifier($this->getIndentation(), 1);

        $lines = $phpJustifier->justifyFromLines($lines);

        return $this->commentLines($lines);
    }

    public function surroundDocumentationBlock(array $lines)
    {
        $phpJustifier = new CPPJustifier($this->getIndentation(), 1);

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

        $lines[] = $this->getFilenameLine();

        $lines = array_merge($lines, $this->getDescriptionCodeLines());

        $lines = array_merge($lines, $this->getBlurbLines());

        $lines = array_merge($lines, $this->getNamespaceLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getFileLines());

        $CPPJustifier = new CPPJustifier($this->getIndentation(), 1);

        $lines = $CPPJustifier->justifyFromLines($lines);

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

    /**
     * @return string
     */
    abstract public function getName();

    public function getFilename()
    {
        return $this->getName() . '.cpp';
    }

    /**
     * {@inheritDoc}
     */
    public function getFullPathAndFilename()
    {
        return $this->getEntity()->getProject()->getAutocodeConfiguration('target-path') . '\\' . $this->getFilename();
    }
    // </user-additions>
    // </editor-fold>
}
