<?php

namespace Draggy\Utils\Indenter\PHP;

use Draggy\Utils\Indenter\AbstractIndenter;
use Draggy\Utils\Indenter\Html\HtmlLineIndenter;

/**
 * Class PHPIndenter
 *
 * This class will indent a PHP file, by applying the HTML indentation first and then the PHP one.
 *
 * @package Draggy\Utils\Indenter\PHP
 */
class PHPIndenter extends AbstractIndenter
{
    /**
     * @var HtmlLineIndenter
     */
    protected $htmlLineIndenter;

    /**
     * @var PHPLineIndenter
     */
    protected $phpLineIndenter;

    /**
     * {@inheritdoc}
     */
    public function __construct($indentationCharacter = ' ', $indentationCount = 4, $eol = PHP_EOL)
    {
        parent::__construct($indentationCharacter, $indentationCount, $eol);

        $this->htmlLineIndenter = new HtmlLineIndenter($this);
        $this->phpLineIndenter  = new PHPLineIndenter($this);
    }

    /**
     * {@inheritdoc}
     */
    public function indent()
    {
        $this->prepareToIndent();

        $this->htmlLineIndenter->indent();
        $this->phpLineIndenter->indent();
    }
}
