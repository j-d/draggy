<?php

namespace Draggy\Autocode\Templates;

interface RenderizableTemplateInterface
{
    /**
     * Renders a template and returns its contents
     *
     * @return string
     */
    public function render();
}
