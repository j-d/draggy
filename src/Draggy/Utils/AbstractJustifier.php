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
     * @var array
     */
    protected $lineTypes;

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

    protected function indentLines($startLine, $endLine)
    {
        for ($i = $startLine; $i <= $endLine; $i++) {
            if (!$this->processedLines[$i]) {
                $this->outputLines[$i] = $this->indentation . $this->outputLines[$i];
            }
        }
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

    protected abstract function identifyLines();

    protected function addJustificationRule($pass, $rule)
    {
        $this->passes[$pass][] = $rule;
    }

    protected function findEndStandardBlock($name, $lineNumber, $maxLine, $targetStepsInto = 0)
    {
        $stepsInto = 0;

        for ($i = $lineNumber; $i <= $maxLine; $i++) {
            if ($this->lineTypes['end' . $name][$i] && $i > $lineNumber) {
                $stepsInto--;

                if ($stepsInto === $targetStepsInto) {
                    return $i;
                }
            }

            if ($this->lineTypes['start' . $name][$i]) {
                $stepsInto++;
            }
        }

        throw new \RuntimeException('Cannot find the end of the ' . $name . ' block starting in line ' . $lineNumber);
    }

    abstract public function initJustificationRules();

    public function justify()
    {
        $endLine = count($this->lines) - 1;

        if ($endLine < 0) {
            return;
        }

        foreach ($this->passes as $pass) {
            for ($i = 0; $i <= $endLine; $i++) {
                foreach ($pass as $rule) {
                    $rule($i, $endLine);
                }
            }
        }
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
}