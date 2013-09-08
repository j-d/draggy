<?php

namespace Draggy\Utils\Indenter;

interface IndenterInterface
{
    public function __construct($indentationCharacter, $indentationCount, $eol);

    public function indent();

    public function indentFromLines($lines);

    public function indentFromSourceFile($sourceFile);

    public function getIndentation();
}
