<?php
// Draggy\Autocode\Templates\Base\Template.php

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

namespace Draggy\Autocode\Templates\Base;

use Draggy\Autocode\Templates\Template;

/**
 * Draggy\Autocode\Templates\Entity\Base\Template
 */
abstract class TemplateBase
{
    // <editor-fold desc="Attributes">
    /**
     * @var string $indentation
     */
    protected $indentation = '    ';

    /**
     * @var integer $indentationCount
     */
    protected $indentationCount = 0;

    /**
     * @var string $eol
     */
    protected $eol;

    // </editor-fold>

    // <editor-fold desc="Setters and getters">
    /**
     * Set indentation
     *
     * @param string $indentation
     *
     * @return Template
     *
     * @throws \InvalidArgumentException
     */
    public function setIndentation($indentation)
    {
        if (!is_string($indentation)) {
            throw new \InvalidArgumentException('The attribute indentation on the class Template has to be string (' . gettype($indentation) . ('object' === gettype($indentation) ? ' ' . get_class($indentation) : '') . ' given).');
        }

        $this->indentation = $indentation;

        return $this;
    }

    /**
     * Get indentation
     *
     * @return string
     */
    public function getIndentation()
    {
        return $this->indentation;
    }

    /**
     * Set indentationCount
     *
     * @param integer $indentationCount
     *
     * @return Template
     *
     * @throws \InvalidArgumentException
     */
    public function setIndentationCount($indentationCount)
    {
        if (!is_int($indentationCount)) {
            throw new \InvalidArgumentException('The attribute indentationCount on the class Template has to be integer (' . gettype($indentationCount) . ('object' === gettype($indentationCount) ? ' ' . get_class($indentationCount) : '') . ' given).');
        }

        $this->indentationCount = $indentationCount;

        return $this;
    }

    /**
     * Get indentationCount
     *
     * @return integer
     */
    public function getIndentationCount()
    {
        return $this->indentationCount;
    }

    /**
     * Set eol
     *
     * @param string $eol
     *
     * @return Template
     *
     * @throws \InvalidArgumentException
     */
    public function setEol($eol)
    {
        if (!is_string($eol)) {
            throw new \InvalidArgumentException('The attribute eol on the class Template has to be string (' . gettype($eol) . ('object' === gettype($eol) ? ' ' . get_class($eol) : '') . ' given).');
        }

        $this->eol = $eol;

        return $this;
    }

    /**
     * Get eol
     *
     * @return string
     */
    public function getEol()
    {
        return $this->eol;
    }
    // </editor-fold>

    // <editor-fold desc="Other methods">
    /**
     * Template to string (Default)
     *
     * @return string
     */
    public function __toString()
    {
        return 'Template';
    }
    // </editor-fold>
}
