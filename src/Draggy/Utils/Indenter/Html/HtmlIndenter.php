<?php

namespace Draggy\Utils\Indenter\Html;

use Draggy\Utils\Indenter\AbstractIndenter;

class HtmlIndenter extends AbstractIndenter
{
    /**
     * @var HtmlLineIndenter
     */
    protected $htmlLineIndenter;

    /**
     * {@inheritdoc}
     */
    public function __construct($indentationCharacter = ' ', $indentationCount = 4, $eol = PHP_EOL)
    {
        parent::__construct($indentationCharacter, $indentationCount, $eol);

        $this->htmlLineIndenter = new HtmlLineIndenter($this);
    }

    /**
     * {@inheritdoc}
     */
    public function indent()
    {
        $this->prepareToIndent();

        $this->htmlLineIndenter->indent();
    }
}
