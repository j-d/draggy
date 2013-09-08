<?php

namespace Draggy\Utils\Indenter;

abstract class AbstractLineIndenter implements LineIndenterInterface
{
    /**
     * @var array
     */
    protected $lineTypes;

    protected $rules = [];

    /**
     * @var IndenterMachineInterface
     */
    protected $indenterMachine;

    protected function addIndentationRule(IndentationRule $rule)
    {
        $this->rules[$rule->getPass()][] = $rule->getRule();
    }

    protected function getPasses()
    {
        return array_keys($this->rules);
    }

    protected function getRules($pass)
    {
        return $this->rules[$pass];
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

        throw new \RuntimeException('Cannot find the end of the ' . $name . ' block starting in line ' . $lineNumber . ' (' . $this->indenterMachine->getLine($lineNumber) . ')');
    }

    protected function identifyLines()
    {
        throw new \LogicException('Optional abstract method not implemented');
    }

    public function indent()
    {
        $this->identifyLines();

        $endLine = count($this->indenterMachine->getLines()) - 1;

        if ($endLine < 0) {
            return;
        }

        foreach ($this->rules as $rulePass) {
            for ($i = 0; $i <= $endLine; $i++) {
                foreach ($rulePass as $rule) {
                    $rule($i, $endLine);
                }
            }
        }
    }
}