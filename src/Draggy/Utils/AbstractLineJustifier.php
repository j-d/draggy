<?php

namespace Draggy\Utils;

abstract class AbstractLineJustifier implements LineJustifierInterface
{
    /**
     * @var array
     */
    protected $lineTypes;

    protected $rules = [];

    /**
     * @var JustifierMachineInterface
     */
    protected $justifierMachine;

    protected function addJustificationRule(JustificationRule $rule)
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

        throw new \RuntimeException('Cannot find the end of the ' . $name . ' block starting in line ' . $lineNumber . ' (' . $this->justifierMachine->getLine($lineNumber) . ')');
    }

    protected function identifyLines()
    {
        throw new \LogicException('Optional abstract method not implemented');
    }

    public function justify()
    {
        $this->identifyLines();

        $endLine = count($this->justifierMachine->getLines()) - 1;

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