<?php

namespace Draggy\Utils;

class TwigLineJustifier extends AbstractLineJustifier
{
    public function __construct(JustifierMachineInterface $justifierMachine)
    {
        $this->justifierMachine = $justifierMachine;

        $this->addJustificationRules();
    }

    protected function identifyLines()
    {
        foreach ($this->justifierMachine->getLines() as $lineNumber => $line) {
            $this->lineTypes['startBlock'][$lineNumber] = $this->isStartBlockBlock($lineNumber);
            $this->lineTypes['endBlock'][$lineNumber]   = $this->isEndBlockBlock($lineNumber);

            $this->lineTypes['startIf'][$lineNumber] = $this->isStartIfBlock($lineNumber);
            $this->lineTypes['endIf'][$lineNumber]   = $this->isEndIfBlock($lineNumber);

            $this->lineTypes['startFor'][$lineNumber] = $this->isStartForBlock($lineNumber);
            $this->lineTypes['endFor'][$lineNumber]   = $this->isEndForBlock($lineNumber);
        }
    }

    protected function isStartBlockBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('{% block ' === substr($line, 0, 9) && false === strstr($line, '{% endblock %}')) {
            return true;
        }

        return false;
    }

    protected function isEndBlockBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('{% endblock %}' === substr($line, -14)) {
            return true;
        }

        return false;
    }

    protected function isStartIfBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('{% if ' === substr($line, 0, 6) && false === strstr($line, '{% else %}') && false === strstr($line, '{% endif %}')) {
            return true;
        }

        if ('{% else %}' === substr($line, 0, 10)) {
            return true;
        }

        return false;
    }

    protected function isEndIfBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('{% endif %}' === substr($line, -11)) {
            return true;
        }

        if ('{% else %}' === substr($line, 0, 10)) {
            return true;
        }

        return false;
    }

    protected function isStartForBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('{% for ' === substr($line, 0, 7) && false === strstr($line, '{% endfor %}')) {
            return true;
        }

        return false;
    }

    protected function isEndForBlock($lineNumber)
    {
        $line = $this->justifierMachine->getLine($lineNumber);

        if ('{% endfor %}' === substr($line, -12)) {
            return true;
        }

        return false;
    }

    protected function addJustificationRules()
    {
        $this->addJustificationRule(new JustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startBlock'][$lineNumber]) {
                $this->justifierMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('Block', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addJustificationRule(new JustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startIf'][$lineNumber]) {
                $this->justifierMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('If', $lineNumber, $endLine) - 1);
            }
        }));

        $this->addJustificationRule(new JustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startFor'][$lineNumber]) {
                $this->justifierMachine->indentLines($lineNumber + 1, $this->findEndStandardBlock('For', $lineNumber, $endLine) - 1);
            }
        }));
    }
}
