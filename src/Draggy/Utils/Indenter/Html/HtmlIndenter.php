<?php

namespace Draggy\Utils\Indenter\Html;

use Draggy\Utils\Indenter\AbstractIndenter;
use Draggy\Utils\Indenter\IndenterMachineInterface;

class HtmlIndenter extends AbstractIndenter implements IndenterMachineInterface
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

    public function indent()
    {
        $this->prepareToIndent();

        $this->htmlLineIndenter->indent();
    }
}
