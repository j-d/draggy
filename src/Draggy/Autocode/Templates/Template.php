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
abstract class Template extends TemplateBase implements TemplateInterface
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    /**
     * @var TemplateInterface
     */
    protected $template;
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Constructor">
    // <user-additions part="constructorDeclaration">
    public function __construct()
    // </user-additions>
    {
        // <user-additions part="constructor">
        $this->setTemplate($this);
        $this->eol = PHP_EOL;
        // </user-additions>
    }
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
    /**
     * @param TemplateInterface $template
     *
     * @return $this
     */
    public function setTemplate(TemplateInterface $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return TemplateInterface
     */
    public function getTemplate()
    {
        return $this->template;
    }
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">


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
            $indentation .= $this->getTemplate()->getIndentation();
        }

        return $indentation;
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

        if (0 !== strlen($this->getTemplate()->getIndentationPrefix())) {
            foreach ($lines as $lineNumber => $line) {
                if (null === $line) {
                    unset($lines[$lineNumber]);
                } elseif ('' === trim($line)) {
                    $lines[$lineNumber] = '';
                }
            }
        }

        return implode($this->getTemplate()->getEol(), $lines) . $this->getTemplate()->getEol();
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
        return $this->getTemplate()->convertLinesToCode($this->getTemplate()->getBlurbLines());
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
        return $this->getTemplate()->convertLinesToCode($this->getTemplate()->getHashBlurbLines());
    }

    abstract public function getTemplateName();
    // </user-additions>
    // </editor-fold>
}
