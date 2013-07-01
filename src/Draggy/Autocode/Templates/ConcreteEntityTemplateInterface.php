<?php

namespace Draggy\Autocode\Templates;

use Draggy\Autocode\Entity;

interface ConcreteEntityTemplateInterface extends EntityTemplateInterface, PHPEntityTemplateInterface
{
    /**
     * @return string
     */
    public function getName();
}
