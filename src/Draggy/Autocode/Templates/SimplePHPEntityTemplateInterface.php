<?php

namespace Draggy\Autocode\Templates;

use Draggy\Autocode\PHPEntity;

interface SimplePHPEntityTemplateInterface extends EntityTemplateInterface
{
    /**
     * @return PHPEntity
     */
    public function getEntity();

    /**
     * @return string
     */
    public function getFilenameLine();

    /**
     * @return string[]
     */
    public function getFileLines();


}
