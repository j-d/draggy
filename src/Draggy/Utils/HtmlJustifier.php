<?php

namespace Draggy\Utils;

class HtmlJustifier extends AbstractJustifier implements JustifierMachineInterface
{
    /**
     * @var HtmlLineJustifier
     */
    protected $htmlLineJustifier;

    /**
     * {@inheritdoc}
     */
    public function __construct($indentationCharacter = ' ', $indentationCount = 4, $eol = PHP_EOL)
    {
        parent::__construct($indentationCharacter, $indentationCount, $eol);

        $this->htmlLineJustifier = new HtmlLineJustifier($this);
    }

    public function justify()
    {
        $this->prepareToJustify();

        $this->htmlLineJustifier->justify();
    }
}
