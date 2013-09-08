<?php

namespace Draggy\Utils\Indenter\CPP;

use Draggy\Utils\Indenter\AbstractIndenter;

class CPPIndenter extends AbstractIndenter
{
    /**
     * @var CPPLineIndenter
     */
    protected $cppLineIndenter;

    /**
     * {@inheritdoc}
     */
    public function __construct($indentationCharacter = ' ', $indentationCount = 4, $eol = PHP_EOL)
    {
        parent::__construct($indentationCharacter, $indentationCount, $eol);

        $this->cppLineIndenter = new CPPLineIndenter($this);
    }

    /**
     * {@inheritdoc}
     */
    public function indent()
    {
        $this->prepareToIndent();

        $this->cppLineIndenter->indent();
    }
}
