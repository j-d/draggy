<?php

namespace Draggy\Utils\Indenter\PHP;

use Draggy\Utils\Indenter\AbstractIndenter;
use Draggy\Utils\Indenter\Html\HtmlLineIndenter;
use Draggy\Utils\Indenter\IndenterMachineInterface;

class PHPIndenter extends AbstractIndenter implements IndenterMachineInterface
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
        $this->phpLineIndenter = new PHPLineIndenter($this);
    }

    public function indent()
    {
        $this->prepareToIndent();

        $this->htmlLineIndenter->indent();
        $this->phpLineIndenter->indent();
    }
}
