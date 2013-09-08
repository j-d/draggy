<?php

namespace Draggy\Utils\Indenter;

abstract class AbstractIndenter implements IndenterInterface, IndenterMachineInterface
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
     * {@inheritdoc}
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

    /**
     * {@inheritdoc}
     */
    public function getLine($lineNumber)
    {
        return isset($this->lines[$lineNumber])
            ? $this->lines[$lineNumber]
            : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * {@inheritdoc}
     */
    public function getOutputLine($lineNumber)
    {
        return isset($this->outputLines[$lineNumber])
            ? $this->outputLines[$lineNumber]
            : null;
    }

    /**
     * {@inheritdoc}
     */
    public function setOutputLine($lineNumber, $line)
    {
        $this->outputLines[$lineNumber] = $line;
    }

    /**
     * {@inheritdoc}
     */
    public function indentLines($startLine, $endLine)
    {
        for ($i = $startLine; $i <= $endLine; $i++) {
            if ('' !== $this->lines[$i]) { // Don't indent blank lines
                $this->outputLines[$i] = $this->indentation . $this->outputLines[$i];
            }
        }
    }

    /**
     * Get all the source code lines from a source code file
     *
     * @param string $sourceFile
     */
    protected function initialiseFromSourceFile($sourceFile)
    {
        $this->lines = explode($this->eol, $sourceFile);
    }

    /**
     * Initialise from an array of lines
     *
     * @param string[] $lines
     */
    protected function initialiseFromLines($lines)
    {
        $this->lines = $lines;
    }

    /**
     * Add a new indentation rule to the indenter that will be processed in order
     *
     * @param int $pass
     * @param $rule
     */
    protected function addIndentationRule($pass, $rule)
    {
        $this->passes[$pass][] = $rule;
    }

    /**
     * {@inheritdoc}
     */
    public function indentFromLines($lines)
    {
        $this->initialiseFromLines($lines);

        $this->indent();

        return $this->outputLines;
    }

    /**
     * {@inheritdoc}
     */
    public function indentFromSourceFile($sourceFile)
    {
        $this->initialiseFromSourceFile($sourceFile);

        $this->indent();

        return implode($this->eol, $this->outputLines);
    }

    /**
     * {@inheritdoc}
     */
    public function getIndentation()
    {
        return $this->indentation;
    }

    /**
     * Pre-process all the lines so they are ready to be indented
     */
    protected function prepareToIndent()
    {
        foreach ($this->lines as $lineNumber => $line) {
            $this->lines[$lineNumber] = trim($line);
        }

        $this->outputLines = $this->lines;
    }
}