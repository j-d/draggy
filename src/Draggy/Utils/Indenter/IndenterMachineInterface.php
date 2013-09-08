<?php

namespace Draggy\Utils\Indenter;

interface IndenterMachineInterface
{
    public function indentLines($startLine, $endLine);

    public function getLines();

    public function getLine($number);

    public function setOutputLine($lineNumber, $line);

    public function getOutputLine($number);
}