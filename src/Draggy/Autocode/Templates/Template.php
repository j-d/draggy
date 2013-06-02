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

    // <editor-fold desc="Constructor">
    // <user-additions part="constructorDeclaration">
    public function __construct()
    // </user-additions>
    {
        // <user-additions part="constructor">
        $this->eol = PHP_EOL;
        // </user-additions>
    }
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

    /**
     * Returns all the indentation that should be put before the current line
     *
     * @param int $times
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function getIndentationPrefix($times = 1)
    {
        if (!is_integer($times)) {
            throw new \InvalidArgumentException('The times parameter has to be an integer');
        }

        $indentation = '';

        for ($i = 0; $i < $times; $i++) {
            $indentation .= $this->getIndentation();
        }

        return $indentation;
    }

    public function increaseIndentation()
    {
        $this->indentationCount++;
    }

    public function decreaseIndentation()
    {
        if ($this->indentationCount > 0) {
            $this->indentationCount--;
        }
    }

    public function indent($line, $times=1)
    {
        if ('' !== $line) {
            return $this->getIndentationPrefix($times) . $line;
        } else {
            return '';
        }
    }

    public function indentLines($lines, $times=1)
    {
        foreach ($lines as $key => $line) {
            $lines[$key] = $this->indent($line, $times);
        }

        return $lines;
    }

    /**
     * Converts an array of lines into code, including the current indentation
     *
     * @param array $lines
     *
     * @return string
     */
    public function convertLinesToCode(array $lines) {
        if (0 === count($lines)) {
            return '';
        }

        if (0 !== strlen($this->getIndentationPrefix())) {
            foreach ($lines as $lineNumber => $line) {
                if (null === $line) {
                    unset($lines[$lineNumber]);
                } elseif ('' === trim($line)) {
                    $lines[$lineNumber] = '';
                }
            }
        }

        return implode($this->getEol(), $lines) . $this->getEol();
    }

    /**
     * Get the default Blurb
     *
     * @return string
     */
    public function getBlurbLines()
    {
        $lines = [];

        $lines[] = '';
        $lines[] = '/************************************************************************************************';
        $lines[] = ' **  THIS IS AN AUTOMATICALLY GENERATED BASE FILE AND SHOULD NOT BE MANUALLY EDITED            **';
        $lines[] = ' **  All user content should be placed within <user-additions' . ' part="(name)"></user-additions' . '>  **';
        $lines[] = ' ************************************************************************************************/';
        $lines[] = '';
        $lines[] = '/*';
        $lines[] = ' * This file was automatically generated with \'Autocode\'';
        $lines[] = ' * by Jose Diaz-Angulo <jose@diazangulo.com>';
        $lines[] = ' * ';
        $lines[] = ' * For the full copyright and license information, please view the LICENSE';
        $lines[] = ' * file that was distributed with the package\'s source code.';
        $lines[] = ' */';
        $lines[] = '';

        return $lines;
    }

    public function getBlurb()
    {
        return $this->convertLinesToCode($this->getBlurbLines());
    }

    public function getHashBlurbLines()
    {
        $lines = [];

        $lines[] = '# THIS IS AN AUTOMATICALLY GENERATED BASE FILE AND SHOULD NOT BE MANUALLY EDITED';
        $lines[] = '# All user content should be placed within <user-additions' . ' part="(name)"></user-additions' . '>';
        $lines[] = '';
        $lines[] = '# This file was automatically generated with \'Autocode\'';
        $lines[] = '# by Jose Diaz-Angulo <jose@diazangulo.com>';
        $lines[] = '#';
        $lines[] = '# For the full copyright and license information, please view the LICENSE';
        $lines[] = '# file that was distributed with the package\'s source code.';
        $lines[] = '';

        return $lines;
    }

    public function getHashBlurb()
    {
        return $this->convertLinesToCode($this->getHashBlurbLines());
    }
    // </user-additions>
    // </editor-fold>
}
