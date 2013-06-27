<?php

namespace Draggy\Utils;

abstract class AbstractJustifier implements JustifierInterface
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
     * Validation passes
     *
     * @var array
     */
    protected $passes;

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

    public function getLine($lineNumber)
    {
        return isset($this->lines[$lineNumber])
            ? $this->lines[$lineNumber]
            : null;
    }

    public function getLines()
    {
        return $this->lines;
    }

    public function getOutputLine($lineNumber)
    {
        return isset($this->outputLines[$lineNumber])
            ? $this->outputLines[$lineNumber]
            : null;
    }

    public function setOutputLine($lineNumber, $line)
    {
        $this->outputLines[$lineNumber] = $line;
    }

    public function indentLines($startLine, $endLine)
    {
        for ($i = $startLine; $i <= $endLine; $i++) {
            if ('' !== $this->lines[$i]) { // Don't justify blank lines
                $this->outputLines[$i] = $this->indentation . $this->outputLines[$i];
            }
        }
    }

    protected function initialiseFromSourceFile($sourceFile)
    {
        $this->lines = explode($this->eol, $sourceFile);
    }

    protected function initialiseFromLines($lines)
    {
        $this->lines = $lines;
    }

    protected function addJustificationRule($pass, $rule)
    {
        $this->passes[$pass][] = $rule;
    }

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

    protected function prepareToJustify()
    {
        foreach ($this->lines as $lineNumber => $line) {
            $this->lines[$lineNumber] = trim($line);
        }

        $this->outputLines = $this->lines;
    }
}