<?php

namespace Draggy\Autocode\Templates;

interface TwigEntityTemplateInterface extends EntityTemplateInterface
{
    public function getFilenameLine();

    public function getExtendLine();

    public function getBlockTitleLine();

    public function getBlockPageTitleLine();

    public function getNavigationLines();

    public function getBlockNavigationLines();

    public function getContentLines();

    public function getBlockContentLines();

    public function getFileLines();
}
