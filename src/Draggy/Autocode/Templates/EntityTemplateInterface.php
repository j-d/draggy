<?php

namespace Draggy\Autocode\Templates;

use Draggy\Autocode\Entity;

interface EntityTemplateInterface extends TemplateInterface
{
    /**
     * @return Entity
     */
    public function getEntity();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getFilename();

    /**
     * @return string
     */
    public function getPathAndFilename();

    /**
     * @return string
     */
    public function getFullPathAndFilename();

    /**
     * @param string $part Name of the part
     *
     * @return string
     */
    public function getUserAdditions($part);

    /**
     * @return string
     */
    public function getEndUserAdditions();

    public function getDescriptionCodeLines();

    public function getDescriptionCode();
}
