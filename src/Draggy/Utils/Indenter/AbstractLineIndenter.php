<?php

namespace Draggy\Utils\Indenter;

/**
 * Class AbstractLineIndenter
 *
 * This class provides basic functionality for the indentation of a source code file.
 * There will be one or more passes, and at each pass a set of rules will be processed
 *
 * @package Draggy\Utils\Indenter
 */
abstract class AbstractLineIndenter implements LineIndenterInterface
{
    /**
     * @var array
     */
    protected $lineTypes;

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var IndenterMachineInterface
     */
    protected $indenterMachine;

    /**
     * @param IndentationRule $rule
     */
    protected function addIndentationRule(IndentationRule $rule)
    {
        $this->rules[$rule->getPass()][] = $rule->getRule();
    }

    /**
     * Returns the passes that it will need to cover
     *
     * @return int array
     */
    protected function getPasses()
    {
        return array_keys($this->rules);
    }

    /**
     * Get the rules for a particular pass
     *
     * @param $pass
     *
     * @return mixed
     */
    protected function getRules($pass)
    {
        return $this->rules[$pass];
    }

    /**
     * Generic algorithm to find the end of a block
     *
     * @param string $name            Name of the block
     * @param int    $lineNumber      Starting line
     * @param int    $maxLine         Max line
     * @param int    $targetStepsInto Targets steps into the source code, used as a stop criteria
     *
     * @return int
     *
     * @throws \RuntimeException
     */
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

    /**
     * As a way to save time, it will pre-identify all the lines on the source code in one pass so it doesn't need
     * to do it at a later, as the number of times that a line needs to be identified for different purposescould be
     * quite substantial.
     *
     * @throws \LogicException
     */
    protected function identifyLines()
    {
        throw new \LogicException('Optional abstract method not implemented');
    }

    /**
     * {@inheritdoc}
     */
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