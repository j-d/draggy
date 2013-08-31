<?php

namespace Draggy\Utils\Justifier;

interface JustifierInterface
{
    public function __construct($indentationCharacter, $indentationCount, $eol);

    public function justify();

    public function justifyFromLines($lines);

    public function justifyFromSourceFile($sourceFile);

    public function getIndentation();
}
