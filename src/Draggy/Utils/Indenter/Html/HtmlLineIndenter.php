<?php

namespace Draggy\Utils\Indenter\Html;

use Draggy\Utils\Indenter\AbstractLineIndenter;
use Draggy\Utils\Indenter\IndentationRule;
use Draggy\Utils\Indenter\IndenterMachineInterface;

class HtmlLineIndenter extends AbstractLineIndenter
{
    public function __construct(IndenterMachineInterface $indenterMachine)
    {
        $this->indenterMachine = $indenterMachine;

        $this->addIndentationRules();
    }

    protected function identifyLines()
    {
        foreach ($this->indenterMachine->getLines() as $lineNumber => $line) {
            $this->lineTypes['startTable'][$lineNumber] = $this->isStartTableBlock($lineNumber);
            $this->lineTypes['endTable'][$lineNumber]   = $this->isEndTableBlock($lineNumber);

            $this->lineTypes['startThead'][$lineNumber] = $this->isStartTheadBlock($lineNumber);
            $this->lineTypes['endThead'][$lineNumber]   = $this->isEndTheadBlock($lineNumber);

            $this->lineTypes['startTbody'][$lineNumber] = $this->isStartTbodyBlock($lineNumber);
            $this->lineTypes['endTbody'][$lineNumber]   = $this->isEndTbodyBlock($lineNumber);

            $this->lineTypes['startTr'][$lineNumber] = $this->isStartTrBlock($lineNumber);
            $this->lineTypes['endTr'][$lineNumber]   = $this->isEndTrBlock($lineNumber);

            $this->lineTypes['startTd'][$lineNumber] = $this->isStartTdBlock($lineNumber);
            $this->lineTypes['endTd'][$lineNumber]   = $this->isEndTdBlock($lineNumber);

            $this->lineTypes['startUl'][$lineNumber] = $this->isStartUlBlock($lineNumber);
            $this->lineTypes['endUl'][$lineNumber]   = $this->isEndUlBlock($lineNumber);

            $this->lineTypes['startSection'][$lineNumber] = $this->isStartSectionBlock($lineNumber);
            $this->lineTypes['endSection'][$lineNumber]   = $this->isEndSectionBlock($lineNumber);

            $this->lineTypes['startDiv'][$lineNumber] = $this->isStartDivBlock($lineNumber);
            $this->lineTypes['endDiv'][$lineNumber]   = $this->isEndDivBlock($lineNumber);

            $this->lineTypes['startForm'][$lineNumber] = $this->isStartFormBlock($lineNumber);
            $this->lineTypes['endForm'][$lineNumber]   = $this->isEndFormBlock($lineNumber);

            $this->lineTypes['startP'][$lineNumber] = $this->isStartPBlock($lineNumber);
            $this->lineTypes['endP'][$lineNumber]   = $this->isEndPBlock($lineNumber);
        }
    }

    protected function isStartTableBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('<table' === substr($line, 0, 6)) {
            return true;
        }

        return false;
    }

    protected function isEndTableBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('</table>' === substr($line, -8)) {
            return true;
        }

        return false;
    }

    protected function isStartTheadBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('<thead' === substr($line, 0, 6)) {
            return true;
        }

        return false;
    }

    protected function isEndTheadBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('</thead>' === substr($line, -8)) {
            return true;
        }

        return false;
    }

    protected function isStartTbodyBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('<tbody' === substr($line, 0, 6)) {
            return true;
        }

        return false;
    }

    protected function isEndTbodyBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('</tbody>' === substr($line, -8)) {
            return true;
        }

        return false;
    }

    protected function isStartTrBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('<tr' === substr($line, 0, 3)) {
            return true;
        }

        return false;
    }

    protected function isEndTrBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('</tr>' === substr($line, -5)) {
            return true;
        }

        return false;
    }

    protected function isStartTdBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('<td' === substr($line, 0, 3) && false === strstr($line, '</td>')) {
            return true;
        }

        return false;
    }

    protected function isEndTdBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('</td>' === substr($line, -5)) {
            return true;
        }

        return false;
    }

    protected function isStartUlBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('<ul' === substr($line, 0, 3)) {
            return true;
        }

        return false;
    }

    protected function isEndUlBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('</ul>' === substr($line, -5)) {
            return true;
        }

        return false;
    }

    protected function isStartSectionBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('<section ' === substr($line, 0, 9)) {
            return true;
        }

        return false;
    }

    protected function isEndSectionBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('</section>' === substr($line, -10)) {
            return true;
        }

        return false;
    }

    protected function isStartDivBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('<div ' === substr($line, 0, 5)) {
            return true;
        }

        return false;
    }

    protected function isEndDivBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('</div>' === substr($line, -6)) {
            return true;
        }

        return false;
    }

    protected function isStartFormBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('<form ' === substr($line, 0, 5)) {
            return true;
        }

        if (false !== strstr($line, '$form->getOpeningTag()')) {
            return true;
        }

        return false;
    }

    protected function isEndFormBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('</form>' === substr($line, -7)) {
            return true;
        }

        if (false !== strstr($line, '$form->getClosingTag()')) {
            return true;
        }

        return false;
    }

    protected function isStartPBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if (('<p>' === substr($line, 0, 3) || '<p ' === substr($line, 0, 3)) && false === strstr($line, '</p>')) {
            return true;
        }

        return false;
    }

    protected function isEndPBlock($lineNumber)
    {
        $line = $this->indenterMachine->getLine($lineNumber);

        if ('</p>' === substr($line, -4)) {
            return true;
        }

        return false;
    }

    protected function addIndentationRules()
    {
        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startTable'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Table', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startThead'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Thead', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startTbody'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Tbody', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startTr'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Tr', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startTd'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Td', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startUl'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Ul', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startSection'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Section', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startDiv'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Div', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startForm'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Form', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addIndentationRule(new IndentationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startP'][$lineNumber]) {
                $this->indenterMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('P', $lineNumber, $endLine) - 1);
            }
        }));
    }
}
