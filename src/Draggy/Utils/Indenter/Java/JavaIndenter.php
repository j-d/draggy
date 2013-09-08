<?php

namespace Draggy\Utils\Indenter\Java;

use Draggy\Utils\Indenter\AbstractIndenter;
use Draggy\Utils\Indenter\IndenterMachineInterface;

class JavaIndenter extends AbstractIndenter implements IndenterMachineInterface
{
    /**
     * @var JavaLineIndenter
     */
    protected $javaLineIndenter;

    /**
     * {@inheritdoc}
     */
    public function __construct($indentationCharacter = ' ', $indentationCount = 4, $eol = PHP_EOL)
    {
        parent::__construct($indentationCharacter, $indentationCount, $eol);

        $this->javaLineIndenter = new JavaLineIndenter($this);
    }

    public function indent()
    {
        $this->prepareToIndent();

        $this->javaLineIndenter->indent();
    }
}
