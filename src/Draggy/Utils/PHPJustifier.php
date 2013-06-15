<?php

namespace Draggy\Utils;

class PHPJustifier extends AbstractJustifier
{
    /**
     * @var array
     */
    protected $lineTypes;

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

        foreach ($this->lines as $lineNumber => $line) {
            $this->lines[$lineNumber] = $line = trim($line);

            // Empty lines or PHP Open tag don't need to be justified
            if ('' === $line || '<?php' === $line) {
                $this->processedLines[$lineNumber] = true;
            }
        }

        $this->outputLines = $this->lines;

        $this->identifyLines();
    }

    protected function identifyLines()
    {
        foreach ($this->lines as $lineNumber => $line) {
            $this->lineTypes['commentBlock'][$lineNumber] = $this->isStartCommentBlock($lineNumber);

            $this->lineTypes['startBraces'][$lineNumber] = $this->isStartBracesBlock($lineNumber);
            $this->lineTypes['endBraces'][$lineNumber]   = $this->isEndBracesBlock($lineNumber);

            $this->lineTypes['startBrackets'][$lineNumber] = $this->isStartBracketsBlock($lineNumber);
            $this->lineTypes['endBrackets'][$lineNumber]   = $this->isEndBracketsBlock($lineNumber);

            $this->lineTypes['startSquaredBrackets'][$lineNumber] = $this->isStartSquaredBracketsBlock($lineNumber);
            $this->lineTypes['endSquaredBrackets'][$lineNumber]   = $this->isEndSquaredBracketsBlock($lineNumber);

            $this->lineTypes['startCase'][$lineNumber] = $this->isStartCaseBlock($lineNumber);
            $this->lineTypes['endCase'][$lineNumber]   = $this->isEndCaseBlock($lineNumber);

            $this->lineTypes['arrow'][$lineNumber]       = $this->isArrowsRow($lineNumber);
            $this->lineTypes['doubleArrow'][$lineNumber] = $this->isDoubleArrowLine($lineNumber);
            $this->lineTypes['assignment'][$lineNumber]  = $this->isAssignmentLine($lineNumber);
            $this->lineTypes['atParam'][$lineNumber]     = $this->isAtParamLine($lineNumber);
            $this->lineTypes['special'][$lineNumber]     = $this->isSpecialIndentationBlock($lineNumber);
        }
    }

    protected function isStartCommentBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('/*' === substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function findEndCommentBlock($lineNumber, $endLine)
    {
        for ($i = $lineNumber; $i <= $endLine; $i++) {
            if ('*/' === substr($this->lines[$i], -2)) {
                return $i;
            }
        }

        throw new \RuntimeException('Cannot find the end of the comment block starting in line ' . $lineNumber);
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

    protected function isStartBracesBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('{' === substr($line, -1) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function isEndBracesBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if (('}' === substr($line, 0, 1) || '}' === substr($line, -1)) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function findEndBracesBlock($lineNumber, $maxLine, $targetStepsInto = 0)
    {
        $stepsInto = 0;

        for ($i = $lineNumber; $i <= $maxLine; $i++) {
            if ($this->lineTypes['endBraces'][$i] && $i > $lineNumber) {
                $stepsInto--;

                if ($stepsInto === $targetStepsInto) {
                    return $i;
                }
            }

            if ($this->lineTypes['startBraces'][$i]) {
                $stepsInto++;
            }
        }

        throw new \RuntimeException('Cannot find the end of the braces block starting in line ' . $lineNumber);
    }

    protected function isStartBracketsBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('(' === substr($line, -1) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function isEndBracketsBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if (')' === substr($line, 0, 1) && '*' !== substr($line, 0, 1)) {
            return true;
        }

        if (');' === $line) {
            return true;
        }

        if (');' === substr($line, 0, 2) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function findEndBracketsBlock($lineNumber, $maxLine, $targetStepsInto = 0)
    {
        $stepsInto = 0;

        for ($i = $lineNumber; $i <= $maxLine; $i++) {
            if ($this->lineTypes['endBrackets'][$i] && $i > $lineNumber) {
                $stepsInto--;

                if ($stepsInto === $targetStepsInto) {
                    return $i;
                }
            }

            if ($this->lineTypes['startBrackets'][$i]) {
                $stepsInto++;
            }
        }

        throw new \RuntimeException('Cannot find the end of the brackets block starting in line ' . $lineNumber);
    }

    protected function isStartSquaredBracketsBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('[' === substr($line, -1) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function isEndSquaredBracketsBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if (']' === substr($line, 0, 1) && '*' !== substr($line, 0, 1)) {
            return true;
        }

        if ('];' === $line) {
            return true;
        }

        if ('];' === substr($line, 0, 2) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function findEndSquaredBracketsBlock($lineNumber, $maxLine, $targetStepsInto = 0)
    {
        $stepsInto = 0;

        for ($i = $lineNumber; $i <= $maxLine; $i++) {
            if ($this->lineTypes['endSquaredBrackets'][$i] && $i > $lineNumber) {
                $stepsInto--;

                if ($stepsInto === $targetStepsInto) {
                    return $i;
                }
            }

            if ($this->lineTypes['startSquaredBrackets'][$i]) {
                $stepsInto++;
            }
        }

        throw new \RuntimeException('Cannot find the end of the squared brackets block starting in line ' . $lineNumber);
    }

    protected function isStartCaseBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('case ' === substr($line, 0, 5) || 'default:' === $line) {
            return true;
        }

        return false;
    }

    protected function isEndCaseBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('break;' === $line) {
            return true;
        }

        return false;
    }

    protected function findEndCaseBlock($lineNumber, $maxLine)
    {
        $maxLine = $this->findEndBracesBlock($lineNumber, $maxLine, -1) - 1;

        for ($i = $lineNumber; $i <= $maxLine; $i++) {
            if ($this->lineTypes['endCase'][$i]) {
                return $i;
            }

            // Have found a new one, so the previous one ended on the line above
            if ($this->lineTypes['startCase'][$i] && $i > $lineNumber) {
                return $i - 1;
            }
        }

        return $maxLine;
    }

    protected function isArrowsRow($lineNumber)
    {
        if ('->' === substr($this->lines[$lineNumber], 0, 2)) {
            return true;
        }

        return false;
    }

    protected function findEndArrowsBlock($lineNumber, $maxLine)
    {
        for ($i = $lineNumber + 1; $i <= $maxLine; $i++) {
            if (!$this->lineTypes['arrow'][$i]) {
                return $i - 1;
            }
        }

        throw new \RuntimeException('Cannot find the end of the arrows block starting in line ' . $lineNumber);
    }

    protected function isDoubleArrowLine($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if (1 === substr_count($line, ' => ')) {
            return true;
        }

        return false;
    }

    protected function findEndDoubleArrowBlock($lineNumber, $maxLine)
    {
        for ($i = $lineNumber + 1; $i <= $maxLine; $i++) {
            if (!$this->lineTypes['doubleArrow'][$i]) {
                return $i - 1;
            }
        }

        return $lineNumber;
    }

    protected function alignDoubleArrowLines($startLine, $endLine)
    {
        if ($endLine - $startLine < 1) {
            return;
        }

        $maxPositionAssignment = 0;

        $beforeAssignment    = [];
        $afterAssignment     = [];

        for ($i = $startLine; $i <= $endLine; $i++) {
            $line = $this->outputLines[$i];

            $positionAssignment   = strpos($line, ' => ');
            $beforeAssignment[$i] = substr($line, 0, $positionAssignment);
            $afterAssignment[$i]  = substr($line, $positionAssignment);

            $maxPositionAssignment = max($positionAssignment, $maxPositionAssignment);
        }

        for ($i = $startLine; $i <= $endLine; $i++) {
            $this->outputLines[$i] = $beforeAssignment[$i] . str_repeat(' ', $maxPositionAssignment - strlen($beforeAssignment[$i])) . $afterAssignment[$i];
        }
    }

    protected function isAssignmentLine($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('$' === substr($line, 0, 1) && ';' === substr($line, -1) && 1 === substr_count($line, ' = ')) {
            return true;
        }

        return false;
    }

    protected function findEndAssignmentsBlock($lineNumber, $maxLine)
    {
        for ($i = $lineNumber + 1; $i <= $maxLine; $i++) {
            if (!$this->lineTypes['assignment'][$i]) {
                return $i - 1;
            }
        }

        return $lineNumber;
    }

    protected function alignAssignmentsLines($startLine, $endLine)
    {
        if ($endLine - $startLine < 1) {
            return;
        }

        $maxPositionAssignment = 0;

        $beforeAssignment    = [];
        $afterAssignment     = [];

        for ($i = $startLine; $i <= $endLine; $i++) {
            $line = $this->outputLines[$i];

            $positionAssignment   = strpos($line, ' = ');
            $beforeAssignment[$i] = substr($line, 0, $positionAssignment);
            $afterAssignment[$i]  = substr($line, $positionAssignment);

            $maxPositionAssignment = max($positionAssignment, $maxPositionAssignment);
        }

        for ($i = $startLine; $i <= $endLine; $i++) {
            $this->outputLines[$i] = $beforeAssignment[$i] . str_repeat(' ', $maxPositionAssignment - strlen($beforeAssignment[$i])) . $afterAssignment[$i];
        }
    }

    protected function isAtParamLine($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('@param' === substr($line, 0, 6)) {
            return true;
        }

        return false;
    }

    protected function findEndAtParamBlock($lineNumber, $maxLine)
    {
        for ($i = $lineNumber + 1; $i <= $maxLine; $i++) {
            if (!$this->lineTypes['atParam'][$i]) {
                return $i - 1;
            }
        }

        return $lineNumber;
    }

    protected function alignAtParamLines($startLine, $endLine)
    {
        if ($endLine - $startLine < 1) {
            return;
        }

        $maxPositionDescription = 0;

        $beforeDescription    = [];
        $afterDescription     = [];

        for ($i = $startLine; $i <= $endLine; $i++) {
            $line = $this->outputLines[$i];

            $positionDescription   = strpos($line, ' ', 7);
            $beforeDescription[$i] = substr($line, 0, $positionDescription);
            $afterDescription[$i]  = ' ' . ltrim(substr($line, $positionDescription));

            $maxPositionDescription = max($positionDescription, $maxPositionDescription);
        }

        for ($i = $startLine; $i <= $endLine; $i++) {
            $this->outputLines[$i] = $beforeDescription[$i] . str_repeat(' ', $maxPositionDescription - strlen($beforeDescription[$i])) . $afterDescription[$i];
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

    public function blockIndent($startLine, $endLine)
    {
        if ($endLine < $startLine) {
            return;
        }

        for ($i = $startLine; $i <= $endLine; $i++) {
            if ($this->isStartCommentBlock($i)) {
                $this->indentCommentBlock($i, $this->findEndCommentBlock($i, $endLine));
            }
        }

        for ($i = $startLine; $i <= $endLine; $i++) {
            if ($this->lineTypes['startBraces'][$i]) {
                $this->indentLines($i + 1, $this->findEndBracesBlock($i, $endLine) - 1);
            }

            if ($this->lineTypes['startBrackets'][$i]) {
                $this->indentLines($i + 1, $this->findEndBracketsBlock($i, $endLine) - 1);
            }

            if ($this->lineTypes['startSquaredBrackets'][$i]) {
                $this->indentLines($i + 1, $this->findEndSquaredBracketsBlock($i, $endLine) - 1);
            }

            if ($this->lineTypes['startCase'][$i]) {
                $this->indentLines($i + 1, $this->findEndCaseBlock($i, $endLine));
            }

            if ($this->lineTypes['special'][$i]) {
                $this->indentLines($i, $i);
            }

            if ($i > $startLine) {
                if ($this->lineTypes['arrow'][$i] && !$this->lineTypes['arrow'][$i - 1]) {
                    $this->indentLines($i, $this->findEndArrowsBlock($i, $endLine));
                }

                if ($this->lineTypes['doubleArrow'][$i] && !$this->lineTypes['doubleArrow'][$i - 1]) {
                    $this->alignDoubleArrowLines($i, $this->findEndDoubleArrowBlock($i, $endLine));
                }

                if ($this->lineTypes['assignment'][$i] && !$this->lineTypes['assignment'][$i - 1]) {
                    $this->alignAssignmentsLines($i, $this->findEndAssignmentsBlock($i, $endLine));
                }

                if ($this->lineTypes['atParam'][$i] && !$this->lineTypes['atParam'][$i - 1]) {
                    $this->alignAtParamLines($i, $this->findEndAtParamBlock($i, $endLine));
                }
            }
        }
    }

    public function justify()
    {
        $this->blockIndent(0, count($this->lines) - 1);
    }
}