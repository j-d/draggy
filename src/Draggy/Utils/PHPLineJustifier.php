<?php

namespace Draggy\Utils;

class PHPLineJustifier extends AbstractLineJustifier
{
    public function __construct(JustifierMachineInterface $justifierMachine)
    {
        $this->justifierMachine = $justifierMachine;

        $this->addJustificationRules();
    }

    protected function identifyLines()
    {
        foreach ($this->justifierMachine->getLines() as $lineNumber => $line) {
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
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('/*' === substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function findEndCommentBlock($lineNumber, $endLine)
    {
        for ($i = $lineNumber; $i <= $endLine; $i++) {
            if ('*/' === substr($this->justifierMachine->getLine($i), -2)) {
                return $i;
            }
        }

        throw new \RuntimeException('Cannot find the end of the comment block starting in line ' . $lineNumber);
    }

    protected function indentCommentBlock($startLine, $endLine)
    {
        // Restore deleted space
        for ($i = $startLine; $i <= $endLine; $i++) {
            if ('*' === substr($this->justifierMachine->getLine($i), 0, 1)) {
                $this->justifierMachine->setOutputLine($i, ' ' . $this->justifierMachine->getLine($i));
            }
        }
    }

    protected function isStartBracesBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('{' === substr($line, -1) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function isEndBracesBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if (('}' === substr($line, 0, 1) || '}' === substr($line, -1)) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function isStartBracketsBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('(' === substr($line, -1) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function isEndBracketsBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

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

    protected function isStartSquaredBracketsBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('[' === substr($line, -1) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function isEndSquaredBracketsBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

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

    protected function isStartCaseBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('case ' === substr($line, 0, 5) || 'default:' === $line) {
            return true;
        }

        return false;
    }

    protected function isEndCaseBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('break;' === $line) {
            return true;
        }

        return false;
    }

    protected function findEndCaseBlock($lineNumber, $maxLine)
    {
        $maxLine = $this->findEndStandardBlock('Braces', $lineNumber, $maxLine, -1) - 1;

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
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('->' === substr($line, 0, 2)) {
            return true;
        }

        if ('//->' === substr($line, 0, 4)) {
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
        $line = $this->justifierMachine->getLine($lineNumber);

        if (
            1 === substr_count($line, ' => ') &&
            !$this->isStartBracesBlock($lineNumber) &&
            !$this->isStartSquaredBracketsBlock($lineNumber) &&
            !$this->isStartBracketsBlock($lineNumber)
        ) {
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

        $justifierMachine = $this->justifierMachine;

        for ($i = $startLine; $i <= $endLine; $i++) {
            $line = $justifierMachine->getOutputLine($i);

            $positionAssignment   = strpos($line, ' => ');
            $beforeAssignment[$i] = substr($line, 0, $positionAssignment);
            $afterAssignment[$i]  = substr($line, $positionAssignment);

            $maxPositionAssignment = max($positionAssignment, $maxPositionAssignment);
        }

        for ($i = $startLine; $i <= $endLine; $i++) {
            $justifierMachine->setOutputLine($i, $beforeAssignment[$i] . str_repeat(' ', $maxPositionAssignment - strlen($beforeAssignment[$i])) . $afterAssignment[$i]);
        }
    }

    protected function isAssignmentLine($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if (
            ('$' === substr($line, 0, 1) || '//$' === substr($line, 0, 3) || '// $' === substr($line, 0, 4)) &&
            ';' === substr($line, -1) &&
            1 === substr_count($line, ' = ')
        ) {
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

        $justifierMachine = $this->justifierMachine;

        for ($i = $startLine; $i <= $endLine; $i++) {
            $line = $justifierMachine->getOutputLine($i);

            $positionAssignment   = strpos($line, ' = ');
            $beforeAssignment[$i] = substr($line, 0, $positionAssignment);
            $afterAssignment[$i]  = substr($line, $positionAssignment);

            $maxPositionAssignment = max($positionAssignment, $maxPositionAssignment);
        }

        for ($i = $startLine; $i <= $endLine; $i++) {
            $justifierMachine->setOutputLine($i, $beforeAssignment[$i] . str_repeat(' ', $maxPositionAssignment - strlen($beforeAssignment[$i])) . $afterAssignment[$i]);
        }
    }

    protected function isAtParamLine($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

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

        $justifierMachine = $this->justifierMachine;

        for ($i = $startLine; $i <= $endLine; $i++) {
            $line = $justifierMachine->getOutputLine($i);

            $positionDescription   = strpos($line, ' ', 7);
            $beforeDescription[$i] = substr($line, 0, $positionDescription);
            $afterDescription[$i]  = ' ' . ltrim(substr($line, $positionDescription));

            $maxPositionDescription = max($positionDescription, $maxPositionDescription);
        }

        for ($i = $startLine; $i <= $endLine; $i++) {
            $justifierMachine->setOutputLine($i, $beforeDescription[$i] . str_repeat(' ', $maxPositionDescription - strlen($beforeDescription[$i])) . $afterDescription[$i]);
        }
    }

    protected function isSpecialIndentationBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('implements' === substr($line, 0, 10)) {
            return true;
        }

        if ('// <user-additions part="implements">' === $line) {
            return true;
        }

        if ('// </user-additions>' === $line && $lineNumber > 0 && '// <user-additions part="implements">' === $this->justifierMachine->getLine($lineNumber - 1)) {
            return true;
        }

        return false;
    }

    protected function addJustificationRules()
    {
        $this->addJustificationRule(new JustificationRule(1, function ($lineNumber, $endLine) {
            if ($this->isStartCommentBlock($lineNumber)) {
                $this->indentCommentBlock($lineNumber, $this->findEndCommentBlock($lineNumber, $endLine));
            }
        }));

        $this->addJustificationRule(new JustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startBraces'][$lineNumber]) {
                $this->justifierMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Braces', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addJustificationRule(new JustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startBrackets'][$lineNumber]) {
                $this->justifierMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Brackets', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addJustificationRule(new JustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startSquaredBrackets'][$lineNumber]) {
                $this->justifierMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('SquaredBrackets', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addJustificationRule(new JustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startCase'][$lineNumber]) {
                $this->justifierMachine->indentLines($lineNumber + 1, $this->findEndCaseBlock($lineNumber, $endLine));
            }
        }));

        $this->addJustificationRule(new JustificationRule(2, function ($lineNumber) {
            if ($this->lineTypes['special'][$lineNumber]) {
                $this->justifierMachine->indentLines($lineNumber, $lineNumber);
            }
        }));

        $this->addJustificationRule(new JustificationRule(2, function ($lineNumber, $endLine) {
            if ($lineNumber > 0) {
                if ($this->lineTypes['arrow'][$lineNumber] && !$this->lineTypes['arrow'][$lineNumber - 1]) {
                    $endArrowsBlock = $this->findEndArrowsBlock($lineNumber, $endLine);

                    if ($this->lineTypes['startBrackets'][$lineNumber]) {
                        $endArrowsBlock = $this->findEndStandardBlock('Brackets', $lineNumber, $endLine);
                    }

                    $this->justifierMachine->indentLines($lineNumber, $endArrowsBlock);
                }
            }
        }));

        $this->addJustificationRule(new JustificationRule(2, function ($lineNumber, $endLine) {
            if ($lineNumber > 0) {
                if ($this->lineTypes['doubleArrow'][$lineNumber] && !$this->lineTypes['doubleArrow'][$lineNumber - 1]) {
                    $this->alignDoubleArrowLines($lineNumber, $this->findEndDoubleArrowBlock($lineNumber, $endLine));
                }
            }
        }));

        $this->addJustificationRule(new JustificationRule(2, function ($lineNumber, $endLine) {
            if ($lineNumber > 0) {
                if ($this->lineTypes['assignment'][$lineNumber] && !$this->lineTypes['assignment'][$lineNumber - 1]) {
                    $this->alignAssignmentsLines($lineNumber, $this->findEndAssignmentsBlock($lineNumber, $endLine));
                }
            }
        }));

        $this->addJustificationRule(new JustificationRule(2, function ($lineNumber, $endLine) {
            if ($lineNumber > 0) {
                if ($this->lineTypes['atParam'][$lineNumber] && !$this->lineTypes['atParam'][$lineNumber - 1]) {
                    $this->alignAtParamLines($lineNumber, $this->findEndAtParamBlock($lineNumber, $endLine));
                }
            }
        }));
    }
}