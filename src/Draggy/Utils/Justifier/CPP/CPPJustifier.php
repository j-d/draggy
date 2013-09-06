<?php

namespace Draggy\Utils\Justifier\CPP;

use Draggy\Utils\Justifier\AbstractJustifier;
use Draggy\Utils\Justifier\JustifierMachineInterface;

class CPPJustifier extends AbstractJustifier implements JustifierMachineInterface
{
    /**
     * @var CPPLineJustifier
     */
    protected $cppLineJustifier;

    /**
     * {@inheritdoc}
     */
    public function __construct($indentationCharacter = ' ', $indentationCount = 4, $eol = PHP_EOL)
    {
        parent::__construct($indentationCharacter, $indentationCount, $eol);

        $this->cppLineJustifier = new CPPLineJustifier($this);
    }

    public function justify()
    {
        $this->prepareToJustify();

        $this->cppLineJustifier->justify();
    }
}
