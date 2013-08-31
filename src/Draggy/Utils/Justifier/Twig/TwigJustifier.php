<?php

namespace Draggy\Utils\Justifier\Twig;

use Draggy\Utils\Justifier\AbstractJustifier;
use Draggy\Utils\Justifier\Html\HtmlLineJustifier;
use Draggy\Utils\Justifier\JustifierMachineInterface;

class TwigJustifier extends AbstractJustifier implements JustifierMachineInterface
{
    /**
     * @var HtmlLineJustifier
     */
    protected $htmlLineJustifier;

    /**
     * @var TwigLineJustifier
     */
    protected $twigLineJustifier;

    /**
     * {@inheritdoc}
     */
    public function __construct($indentationCharacter = ' ', $indentationCount = 4, $eol = PHP_EOL)
    {
        parent::__construct($indentationCharacter, $indentationCount, $eol);

        $this->htmlLineJustifier = new HtmlLineJustifier($this);
        $this->twigLineJustifier = new TwigLineJustifier($this);
    }

    public function justify()
    {
        $this->prepareToJustify();

        $this->htmlLineJustifier->justify();
        $this->twigLineJustifier->justify();
    }
}
