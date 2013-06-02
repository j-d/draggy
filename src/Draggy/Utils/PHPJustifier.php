<?php

namespace Draggy\Utils;

class PHPJustifier extends AbstractJustifier
{
    /**
     * {@inheritdoc}
     */
    public function __construct($indentationCharacter = ' ', $indentationCount = 4, $eol = PHP_EOL)
    {
        parent::__construct($indentationCharacter, $indentationCount, $eol);
    }

    protected function indentLines($startLine, $endLine)
    {
        for ($i = $startLine; $i <= $endLine; $i++) {
            if (!$this->processedLines[$i]) {
                $this->outputLines[$i] = $this->indentation . $this->outputLines[$i];
            }
        }
    }

    protected function initialise()
    {
        $this->processedLines = array_fill(0, count($this->lines), false);

        foreach ($this->lines as $number => $line) {
            $this->lines[$number] = $line = trim($line);

            // Empty lines or PHP Open tag don't need to be justified
            if ('' === $line || '<?php' === $line) {
                $this->processedLines[$number] = true;
            }
        }

        $this->outputLines = $this->lines;
    }

    protected function findEndCommentBlock($lineNumber)
    {
        for ($i = $lineNumber; $i < count($this->lines); $i++) {
            if ('*/' === substr($this->lines[$i], -2)) {
                return $i;
            }
        }

        throw new \RuntimeException('Found a comment block without end');
    }

    protected function indentCommentBlock($startLine, $endLine)
    {
        // Restore deleted space
        for ($i = $startLine; $i <= $endLine; $i++) {
            if ('*' === substr($this->lines[$i], 0, 1)) {
                $this->outputLines[$i] = ' ' . $this->lines[$i];

            }
        }
    }

    protected function isSpecialIndentationBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('implements' === substr($line, 0, 10)) {
            return true;
        }

        if ('// <user-additions part="implements">' === $line) {
            return true;
        }

        if ('// </user-additions>' === $line && $lineNumber > 0 && '// <user-additions part="implements">' === $this->lines[$lineNumber - 1]) {
            return true;
        }

        return false;
    }

    protected function isStartBracesBlock($line)
    {
        if ('{' === substr($line, -1)) {
            return true;
        }

        return false;
    }

    protected function isEndBracesBlock($line)
    {
        if ('}' === substr($line, 0, 1)) {
            return true;
        }

        return false;
    }

    protected function findEndBracesBlock($lineNumber, $maxLine, $targetStepsInto = 0)
    {
        $stepsInto = 0;

        for ($i = $lineNumber; $i <= $maxLine; $i++) {
            $line = $this->lines[$i];

            if ($this->isEndBracesBlock($line) && $i > $lineNumber) {
                $stepsInto--;

                if ($stepsInto === $targetStepsInto) {
                    return $i;
                }
            }

            if ($this->isStartBracesBlock($line)) {
                $stepsInto++;
            }
        }

        throw new \RuntimeException('Cannot find the end of the braces block starting in line ' . $lineNumber);
    }

    protected function isStartBracketsBlock($line)
    {
        if ('(' === substr($line, -1) && '*' !== substr($line, 0, 1)) {
            return true;
        }

        return false;
    }

    protected function isEndBracketsBlock($line)
    {
        if (')' === substr($line, 0, 1) && '*' !== substr($line, 0, 1)) {
            return true;
        }

        return false;
    }

    protected function findEndBracketsBlock($lineNumber, $maxLine, $targetStepsInto = 0)
    {
        $stepsInto = 0;

        for ($i = $lineNumber; $i <= $maxLine; $i++) {
            $line = $this->lines[$i];

            if ($this->isEndBracketsBlock($line) && $i > $lineNumber) {
                $stepsInto--;

                if ($stepsInto === $targetStepsInto) {
                    return $i;
                }
            }

            if ($this->isStartBracketsBlock($line)) {
                $stepsInto++;
            }
        }

        throw new \RuntimeException('Cannot find the end of the brackets block starting in line ' . $lineNumber);
    }

    protected function isStartCaseBlock($line)
    {
        if ('case ' === substr($line, 0, 5) || 'default:' === $line) {
            return true;
        }

        return false;
    }

    protected function isEndCaseBlock($line)
    {
        if ('break;' === $line) {
            return true;
        }

        return false;
    }

    protected function findEndCaseBlock($lineNumber, $maxLine)
    {
        $maxLine = $this->findEndBracesBlock($lineNumber, $maxLine, -1) - 1;

        for ($i = $lineNumber; $i <= $maxLine; $i++) {
            $line = $this->lines[$i];

            if ($this->isEndCaseBlock($line)) {
                return $i;
            }

            // Have found a new one, so the previous one ended on the line above
            if ($this->isStartCaseBlock($line) && $i > $lineNumber) {
                return $i - 1;
            }
        }

        return $maxLine;
    }

    public function blockIndent($startLine, $endLine)
    {
        if ($endLine < $startLine) {
            return;
        }

        for ($i = $startLine; $i <= $endLine; $i++) {
            $line = $this->lines[$i];

            if ($this->isStartBracesBlock($line)) {
                $this->indentLines($i + 1, $this->findEndBracesBlock($i, $endLine) - 1);
            }

            if ($this->isStartBracketsBlock($line)) {
                $this->indentLines($i + 1, $this->findEndBracketsBlock($i, $endLine) - 1);
            }

            if ($this->isSpecialIndentationBlock($i)) {
                $this->indentLines($i, $i);
            }

            if ($this->isStartCaseBlock($line)) {
                $this->indentLines($i + 1, $this->findEndCaseBlock($i, $endLine));
            }
        }
    }

    public function justify()
    {
        foreach ($this->lines as $number => $line) {
            if ('/*' === substr($line, 0, 2)) {
                $endLine = $this->findEndCommentBlock($number);
                $this->indentCommentBlock($number, $endLine);
            }
        }

        $this->blockIndent(0, count($this->lines) - 1);
    }
}