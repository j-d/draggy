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
use Draggy\Utils\Justifier\PHP\PHPJustifier;
// </user-additions>

/**
 * Draggy\Autocode\Templates\Entity\PHPEntityTemplate
 */
abstract class PHPEntityTemplate extends PHPEntityTemplateBase implements PHPEntityTemplateInterface
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
     * {@inheritdoc}
     *
     * @return PHPEntity
     */
    public function getEntity()
    {
        return parent::getEntity();
    }
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    /**
     * @param PHPEntity $entity
     *
     * @return string
     */
    public static function getEntityUseLine(PHPEntity $entity)
    {
        $line = 'use ' . $entity->getFullyQualifiedName() . ';';

        return $line;
    }

    public function getFilenameLine()
    {
        return '// ' . $this->getFullPathAndFilename();
    }

    public function getNamespaceLine()
    {
        return null;
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

    public function getFilename()
    {
        return $this->getName() . '.php';
    }

    /**
     * @return string
     */
    public function getFullNamespace()
    {
        return substr($this->getEntity()->getNamespace() . '\\' . str_replace('/', '\\', $this->getPath()), 0, -1);
    }

    /**
     * {@inheritDoc}
     */
    public function getFullPathAndFilename()
    {
        return $this->getFullNamespace() . '\\' . $this->getFilename();
    }

    /**
     * @return string
     */
    public function getFullyQualifiedName()
    {
        return $this->getFullNamespace() . '\\' . $this->getName();
    }
    // </user-additions>
    // </editor-fold>
}
