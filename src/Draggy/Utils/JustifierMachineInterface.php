<?php

namespace Draggy\Utils;

interface JustifierMachineInterface
{
    public function indentLines($startLine, $endLine);

    public function getLines();

    public function getLine($number);

    public function setOutputLine($lineNumber, $line);

    public function getOutputLine($number);
}