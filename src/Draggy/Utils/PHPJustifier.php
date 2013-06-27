<?php

namespace Draggy\Utils;

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
