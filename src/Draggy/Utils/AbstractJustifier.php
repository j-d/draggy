<?php

namespace Draggy\Utils;


abstract class AbstractJustifier
{
    /**
     * @var string Character used to indent, typically a space or a tab
     */
    protected $indentationCharacter;

    /**
     * @var int Number of characters of the $indentationCharacter that will on each indentation
     */
    protected $indentationCount;

    /**
     * @var string The actual indentation (indentation character x indentation count)
     */
    protected $indentation;

    /**
     * @var string End of line character when exploding and imploding the file
     */
    protected $eol;

    /**
     * @var string[] Working lines
     */
    protected $lines;

    /**
     * @var string[] Lines to be returned
     */
    protected $outputLines;

    /**
     * @var bool[] Indicator of which lines don't need to be processed
     */
    protected $processedLines;

    /**
     * @param string $indentationCharacter
     * @param int    $indentationCount
     * @param string $eol
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($indentationCharacter = ' ', $indentationCount = 4, $eol = "\n")
    {
        if (!is_string($indentationCharacter)) {
            throw new \InvalidArgumentException('The indentation character has to be a string.');
        }

        if (!is_integer($indentationCount) || $indentationCount <= 0) {
            throw new \InvalidArgumentException('The indentation count has to be a positive integer.');
        }

        if (!is_string($eol)) {
            throw new \InvalidArgumentException('The end of line character has to be a string.');
        }

        $this->indentationCharacter = $indentationCharacter;
        $this->indentationCount     = $indentationCount;
        $this->indentation          = str_pad($indentationCharacter, $indentationCount);
        $this->eol                  = $eol;
    }

    protected abstract function initialise();

    protected function initialiseFromSourceFile($sourceFile)
    {
        $this->lines = explode($this->eol, $sourceFile);

        $this->initialise();
    }

    protected function initialiseFromLines($lines)
    {
        $this->lines = $lines;

        $this->initialise();
    }

    protected abstract function justify();

    public function justifyFromLines($lines)
    {
        $this->initialiseFromLines($lines);

        $this->justify();

        return $this->outputLines;
    }

    public function justifyFromSourceFile($sourceFile)
    {
        $this->initialiseFromSourceFile($sourceFile);

        $this->justify();

        return implode($this->eol, $this->outputLines);
    }

    public function getIndentation()
    {
        return $this->indentation;
    }
}