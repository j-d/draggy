<?php

namespace Draggy\Utils\Justifier\Java;

use Draggy\Utils\Justifier\AbstractJustifier;
use Draggy\Utils\Justifier\JustifierMachineInterface;

class JavaJustifier extends AbstractJustifier implements JustifierMachineInterface
{
    /**
     * @var JavaLineJustifier
     */
    protected $javaLineJustifier;

    /**
     * {@inheritdoc}
     */
    public function __construct($indentationCharacter = ' ', $indentationCount = 4, $eol = PHP_EOL)
    {
        parent::__construct($indentationCharacter, $indentationCount, $eol);

        $this->javaLineJustifier = new JavaLineJustifier($this);
    }

    public function justify()
    {
        $this->prepareToJustify();

        $this->javaLineJustifier->justify();
    }
}
