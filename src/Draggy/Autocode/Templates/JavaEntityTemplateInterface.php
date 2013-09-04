<?php

namespace Draggy\Autocode\Templates;

use Draggy\Autocode\PHPEntity;

interface JavaEntityTemplateInterface
{
    /**
     * @return string
     */
    public function getFullNamespace();

    /**
     * @return string
     */
    public function getFullyQualifiedName();

    /**
     * @param PHPEntity $entity
     *
     * @return string
     */
    public static function getEntityUseLine(PHPEntity $entity);

    /**
     * @return string
     */
    public function getNamespaceLine();

    /**
     * @return string[]
     */
    public function getUseLinesUserAdditionsPart();

    /**
     * @return string[]
     */
    public function getUseLines();

    /**
     * @param string[] $lines
     *
     * @return string[]
     */
    public function commentLines($lines);

    /**
     * @param string[] $lines
     *
     * @return string[]
     */
    public function commentAndJustifyLines($lines);

    /**
     * @param string[] $lines
     *
     * @return string[]
     */
    public function surroundDocumentationBlock(array $lines);
}
