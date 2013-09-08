<?php

namespace Draggy\Utils\Indenter;

/**
 * Interface IndenterInterface
 *
 * This interface provides the minimum functionality expected from a class that will indent code
 *
 * @package Draggy\Utils\Indenter
 */
interface IndenterInterface
{
    /**
     * @param string $indentationCharacter The character used for indentation
     * @param int    $indentationCount     How many times the character should be used
     * @param string $eol                  Character used for the end of line
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($indentationCharacter, $indentationCount, $eol);

    /**
     * Execute all the steps require to indent the loaded lines
     */
    public function indent();

    /**
     * Load lines from a string array, indent it and return it
     *
     * @param string[] $lines
     *
     * @return string[]
     */
    public function indentFromLines($lines);

    /**
     * Load a source code file, indent it and return it
     *
     * @param string $sourceFile
     *
     * @return string
     */
    public function indentFromSourceFile($sourceFile);

    /**
     * Returns the current indentation value
     *
     * @return string
     */
    public function getIndentation();
}
