<?php

namespace Draggy\Utils\Justifier\PHP;

use Draggy\Utils\Justifier\AbstractJustifier;
use Draggy\Utils\Justifier\Html\HtmlLineJustifier;
use Draggy\Utils\Justifier\JustifierMachineInterface;

class PHPJustifier extends AbstractJustifier implements JustifierMachineInterface
{
    /**
     * @var HtmlLineJustifier
     */
    protected $htmlLineJustifier;

    /**
     * @var PHPLineJustifier
     */
    protected $phpLineJustifier;

    /**
     * {@inheritdoc}
     */
    public function __construct($indentationCharacter = ' ', $indentationCount = 4, $eol = PHP_EOL)
    {
        parent::__construct($indentationCharacter, $indentationCount, $eol);

        $this->htmlLineJustifier = new HtmlLineJustifier($this);
        $this->phpLineJustifier = new PHPLineJustifier($this);
    }

    public function justify()
    {
        $this->prepareToJustify();

        $this->htmlLineJustifier->justify();
        $this->phpLineJustifier->justify();
    }
}
