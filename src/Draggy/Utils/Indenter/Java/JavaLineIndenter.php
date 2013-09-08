<?php

namespace Draggy\Utils\Indenter\Java;

use Draggy\Utils\Indenter\AbstractLineIndenter;
use Draggy\Utils\Indenter\IndentationRule;
use Draggy\Utils\Indenter\IndenterMachineInterface;

class JavaLineIndenter extends AbstractLineIndenter
{
    public function __construct(IndenterMachineInterface $indenterMachine)
    {
        $this->indenterMachine = $indenterMachine;

        $this->addIndentationRules();
    }

    protected function identifyLines()
    {
        foreach ($this->indenterMachine->getLines() as $lineNumber => $line) {
            $this->lineTypes['commentBlock'][$lineNumber] = $this->isStartCommentBlock($lineNumber);

            $this->lineTypes['startBraces'][$lineNumber] = $this->isStartBracesBlock($lineNumber);
            $this->lineTypes['endBraces'][$lineNumber]   = $this->isEndBracesBlock($lineNumber);

            $this->lineTypes['startBrackets'][$lineNumber] = $this->isStartBracketsBlock($lineNumber);
            $this->lineTypes['endBrackets'][$lineNumber]   = $this->isEndBracketsBlock($lineNumber);

            $this->lineTypes['startSquaredBrackets'][$lineNumber] = $this->isStartSquaredBracketsBlock($lineNumber);
            $this->lineTypes['endSquaredBrackets'][$lineNumber]   = $this->isEndSquaredBracketsBlock($lineNumber);

            $this->lineTypes['startCase'][$lineNumber] = $this->isStartCaseBlock($lineNumber);
            $this->lineTypes['endCase'][$lineNumber]   = $this->isEndCaseBlock($lineNumber);

            $this->lineTypes['startEcho'][$lineNumber] = $this->isStartEchoBlock($lineNumber);
            $this->lineTypes['endEcho'][$lineNumber]   = $this->isEndEchoBlock($lineNumber);

            $this->lineTypes['arrow'][$lineNumber]       = $this->isArrowsRow($lineNumber);
            $this->lineTypes['doubleArrow'][$lineNumber] = $this->isDoubleArrowLine($lineNumber);
            $this->lineTypes['assignment'][$lineNumber]  = $this->isAssignmentLine($lineNumber);
            $this->lineTypes['atParam'][$lineNumber]     = $this->isAtParamLine($lineNumber);
            $this->lineTypes['special'][$lineNumber]     = $this->isSpecialIndentationBlock($lineNumber);
        }
    }

    protected function isStartCommentBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('/*' === substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function findEndCommentBlock($lineNumber, $endLine)
    {
        for ($i = $lineNumber; $i <= $endLine; $i++) {
            if ('*/' === substr($this->indenterMachine->getLine($i), -2)) {
                return $i;
            }
        }

        throw new \RuntimeException('Cannot find the end of the comment block starting in line ' . $lineNumber);
    }

    protected function indentCommentBlock($startLine, $endLine)
    {
        // Restore deleted space
        for ($i = $startLine; $i <= $endLine; $i++) {
            if ('*' === substr($this->indenterMachine->getLine($i), 0, 1)) {
                $this->indenterMachine->setOutputLine($i, ' ' . $this->indenterMachine->getLine($i));
            }
        }
    }

    protected function isStartBracesBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('{' === substr($line, -1) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function isEndBracesBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if (('}' === substr($line, 0, 1) || '}' === substr($line, -1)) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function isStartBracketsBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('(' === substr($line, -1) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function isEndBracketsBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

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
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('[' === substr($line, -1) && '*' !== substr($line, 0, 1) && '//' !== substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function isEndSquaredBracketsBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

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

    protected function isStartEchoBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('<?=' === substr($line, 0, 3) && false === strstr($line, '?>')) {
            return true;
        }

        return false;
    }

    protected function isEndEchoBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('?>' === substr($line, -2) && false === strstr($line, '<?=')) {
            return true;
        }

        return false;
    }

    protected function isStartCaseBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('case ' === substr($line, 0, 5) || 'default:' === $line) {
            return true;
        }

        return false;
    }

    protected function isEndCaseBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

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
        $line = $this->indenterMachine->getLine($lineNumber);

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
        $line = $this->indenterMachine->getLine($lineNumber);

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

        $indenterMachine = $this->indenterMachine;

        for ($i = $startLine; $i <= $endLine; $i++) {
            $line = $indenterMachine->getOutputLine($i);

            $positionAssignment   = strpos($line, ' => ');
            $beforeAssignment[$i] = substr($line, 0, $positionAssignment);
            $afterAssignment[$i]  = substr($line, $positionAssignment);

            $maxPositionAssignment = max($positionAssignment, $maxPositionAssignment);
        }

        for ($i = $startLine; $i <= $endLine; $i++) {
            $indenterMachine->setOutputLine($i, $beforeAssignment[$i] . str_repeat(' ', $maxPositionAssignment - strlen($beforeAssignment[$i])) . $afterAssignment[$i]);
        }
    }

    protected function isAssignmentLine($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

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

        $indenterMachine = $this->indenterMachine;

        for ($i = $startLine; $i <= $endLine; $i++) {
            $line = $indenterMachine->getOutputLine($i);

            $positionAssignment   = strpos($line, ' = ');
            $beforeAssignment[$i] = substr($line, 0, $positionAssignment);
            $afterAssignment[$i]  = substr($line, $positionAssignment);

            $maxPositionAssignment = max($positionAssignment, $maxPositionAssignment);
        }

        for ($i = $startLine; $i <= $endLine; $i++) {
            $indenterMachine->setOutputLine($i, $beforeAssignment[$i] . str_repeat(' ', $maxPositionAssignment - strlen($beforeAssignment[$i])) . $afterAssignment[$i]);
        }
    }

    protected function isAtParamLine($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

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

        $indenterMachine = $this->indenterMachine;

        for ($i = $startLine; $i <= $endLine; $i++) {
            $line = $indenterMachine->getOutputLine($i);

            $positionDescription   = strpos($line, ' ', 7);
            $beforeDescription[$i] = substr($line, 0, $positionDescription);
            $afterDescription[$i]  = ' ' . ltrim(substr($line, $positionDescription));

            $maxPositionDescription = max($positionDescription, $maxPositionDescription);
        }

        for ($i = $startLine; $i <= $endLine; $i++) {
            $indenterMachine->setOutputLine($i, $beforeDescription[$i] . str_repeat(' ', $maxPositionDescription - strlen($beforeDescription[$i])) . $afterDescription[$i]);
        }
    }

    protected function isSpecialIndentationBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('implements' === substr($line, 0, 10)) {
            return true;
        }

        if ('// <user-additions part="implements">' === $line) {
            return true;
        }

        if ('// </user-additions>' === $line && $lineNumber > 0 && '// <user-additions part="implements">' === $this->indenterMachine->getLine($lineNumber - 1)) {
            return true;
        }

        if ('? ' === substr($line, 0, 2)) {
            return true;
        }

        if (': ' === substr($line, 0, 2)) {
            return true;
        }

        return false;
    }

    protected function addIndentationRules()
    {
        $this->addIndentationRule(new IndentationRule(1, function ($lineNumber, $endLine) {
            if ($this->isStartCommentBlock($lineNumber)) {
                $this->indentCommentBlock($lineNumber, $this->findEndCommentBlock($lineNumber, $endLine));
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startBraces'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Braces', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startBrackets'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Brackets', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startSquaredBrackets'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('SquaredBrackets', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startEcho'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Echo', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startCase'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndCaseBlock($lineNumber, $endLine));
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber) {
            if ($this->lineTypes['special'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber, $lineNumber);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($lineNumber > 0) {
                if ($this->lineTypes['arrow'][$lineNumber] && !$this->lineTypes['arrow'][$lineNumber - 1]) {
                    $endArrowsBlock = $this->findEndArrowsBlock($lineNumber, $endLine);

                    if ($this->lineTypes['startBrackets'][$lineNumber]) {
                        $endArrowsBlock = $this->findEndStandardBlock('Brackets', $lineNumber, $endLine);
                    }

                    $this->indenterMachine->indentLines($lineNumber, $endArrowsBlock);
                }
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($lineNumber > 0) {
                if ($this->lineTypes['doubleArrow'][$lineNumber] && !$this->lineTypes['doubleArrow'][$lineNumber - 1]) {
                    $this->alignDoubleArrowLines($lineNumber, $this->findEndDoubleArrowBlock($lineNumber, $endLine));
                }
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($lineNumber > 0) {
                if ($this->lineTypes['assignment'][$lineNumber] && !$this->lineTypes['assignment'][$lineNumber - 1]) {
                    $this->alignAssignmentsLines($lineNumber, $this->findEndAssignmentsBlock($lineNumber, $endLine));
                }
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($lineNumber > 0) {
                if ($this->lineTypes['atParam'][$lineNumber] && !$this->lineTypes['atParam'][$lineNumber - 1]) {
                    $this->alignAtParamLines($lineNumber, $this->findEndAtParamBlock($lineNumber, $endLine));
                }
            }
        }));
    }
}