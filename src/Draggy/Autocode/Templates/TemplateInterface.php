<?php

namespace Draggy\Autocode\Templates;

interface TemplateInterface
{
    public function setIndentation($indentation);

    public function getIndentation();

    public function setIndentationCount($indentationCount);

    public function getIndentationCount();

    public function setEol($eol);

    public function getEol();

    public function __toString();

    public function setTemplate(TemplateInterface $template);

    public function getTemplate();

    public function getIndentationPrefix($times = 1);

    public function convertLinesToCode(array $lines);

    public function getBlurbLines();

    public function getBlurb();

    public function getHashBlurbLines();

    public function getHashBlurb();
}
