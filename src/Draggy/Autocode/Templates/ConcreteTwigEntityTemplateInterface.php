<?php

namespace Draggy\Autocode\Templates;

interface ConcreteTwigEntityTemplateInterface extends TwigEntityTemplateInterface
{
    public function getExtendBundlePath();

    public function getTitleLinePart();

    public function getPageTitleLinePart();
}
