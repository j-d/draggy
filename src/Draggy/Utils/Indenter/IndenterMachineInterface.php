<?php

namespace Draggy\Utils\Indenter;

/**
 * Interface IndenterMachineInterface
 *
 * This interface provides the minimum functionality required to indent lines using the LineIndenter method.
 *
 * @package Draggy\Utils\Indenter
 */
interface IndenterMachineInterface
{
    /**
     * Indent all the lines between the indicated lines by one unit (if they are not empty)
     *
     * @param int $startLine
     * @param int $endLine
     */
    public function indentLines($startLine, $endLine);

    /**
     * Get all the lines
     *
     * @return string[]
     */
    public function getLines();

    /**
     * Return a particular line
     *
     * @param int $lineNumber
     *
     * @return null|string
     */
    public function getLine($lineNumber);

    /**
     * Set the processed line
     *
     * @param int    $lineNumber
     * @param string $line
     */
    public function setOutputLine($lineNumber, $line);

    /**
     * Get a processed line
     *
     * @param int $lineNumber
     *
     * @return null|string
     */
    public function getOutputLine($lineNumber);
}