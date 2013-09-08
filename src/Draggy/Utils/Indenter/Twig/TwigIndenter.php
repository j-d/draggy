<?php

namespace Draggy\Utils\Indenter\Twig;

use Draggy\Utils\Indenter\AbstractIndenter;
use Draggy\Utils\Indenter\Html\HtmlLineIndenter;

class TwigIndenter extends AbstractIndenter
{
    /**
     * @var HtmlLineIndenter
     */
    protected $htmlLineIndenter;

    /**
     * @var TwigLineIndenter
     */
    protected $twigLineIndenter;

    /**
     * {@inheritdoc}
     */
    public function __construct($indentationCharacter = ' ', $indentationCount = 4, $eol = PHP_EOL)
    {
        parent::__construct($indentationCharacter, $indentationCount, $eol);

        $this->htmlLineIndenter = new HtmlLineIndenter($this);
        $this->twigLineIndenter = new TwigLineIndenter($this);
    }

    /**
     * {@inheritdoc}
     */
    public function indent()
    {
        $this->prepareToIndent();

        $this->htmlLineIndenter->indent();
        $this->twigLineIndenter->indent();
    }
}
