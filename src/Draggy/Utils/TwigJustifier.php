<?php

namespace Draggy\Utils;

class TwigJustifier extends AbstractJustifier
{
    /**
     * {@inheritdoc}
     */
    public function __construct($indentationCharacter = ' ', $indentationCount = 4, $eol = PHP_EOL)
    {
        parent::__construct($indentationCharacter, $indentationCount, $eol);
    }

    protected function initialise()
    {
        $this->processedLines = array_fill(0, count($this->lines), false);

        foreach ($this->lines as $lineNumber => $line) {
            $this->lines[$lineNumber] = $line = trim($line);

            // Empty lines or PHP Open tag don't need to be justified
            if ('' === $line) {
                $this->processedLines[$lineNumber] = true;
            }
        }

        $this->outputLines = $this->lines;

        $this->identifyLines();
        $this->initJustificationRules();
    }

    protected function identifyLines()
    {
        foreach ($this->lines as $lineNumber => $line) {
            $this->lineTypes['startBlock'][$lineNumber] = $this->isStartBlockBlock($lineNumber);
            $this->lineTypes['endBlock'][$lineNumber]   = $this->isEndBlockBlock($lineNumber);

            $this->lineTypes['startFor'][$lineNumber] = $this->isStartForBlock($lineNumber);
            $this->lineTypes['endFor'][$lineNumber]   = $this->isEndForBlock($lineNumber);

            $this->lineTypes['startTable'][$lineNumber] = $this->isStartTableBlock($lineNumber);
            $this->lineTypes['endTable'][$lineNumber]   = $this->isEndTableBlock($lineNumber);

            $this->lineTypes['startThead'][$lineNumber] = $this->isStartTheadBlock($lineNumber);
            $this->lineTypes['endThead'][$lineNumber]   = $this->isEndTheadBlock($lineNumber);

            $this->lineTypes['startTbody'][$lineNumber] = $this->isStartTbodyBlock($lineNumber);
            $this->lineTypes['endTbody'][$lineNumber]   = $this->isEndTbodyBlock($lineNumber);

            $this->lineTypes['startTr'][$lineNumber] = $this->isStartTrBlock($lineNumber);
            $this->lineTypes['endTr'][$lineNumber]   = $this->isEndTrBlock($lineNumber);

            $this->lineTypes['startUl'][$lineNumber] = $this->isStartUlBlock($lineNumber);
            $this->lineTypes['endUl'][$lineNumber]   = $this->isEndUlBlock($lineNumber);
        }
    }

    protected function isStartBlockBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('{% block ' === substr($line, 0, 9) && false === strstr($line, '{% endblock %}')) {
            return true;
        }

        return false;
    }

    protected function isEndBlockBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('{% endblock %}' === substr($line, -14)) {
            return true;
        }

        return false;
    }

    protected function isStartForBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('{% for ' === substr($line, 0, 7) && false === strstr($line, '{% endfor %}')) {
            return true;
        }

        return false;
    }

    protected function isEndForBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('{% endfor %}' === substr($line, -12)) {
            return true;
        }

        return false;
    }

    protected function isStartTableBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('<table' === substr($line, 0, 6)) {
            return true;
        }

        return false;
    }

    protected function isEndTableBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('</table>' === substr($line, -8)) {
            return true;
        }

        return false;
    }

    protected function isStartTheadBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('<thead' === substr($line, 0, 6)) {
            return true;
        }

        return false;
    }

    protected function isEndTheadBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('</thead>' === substr($line, -8)) {
            return true;
        }

        return false;
    }

    protected function isStartTbodyBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('<tbody' === substr($line, 0, 6)) {
            return true;
        }

        return false;
    }

    protected function isEndTbodyBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('</tbody>' === substr($line, -8)) {
            return true;
        }

        return false;
    }

    protected function isStartTrBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('<tr' === substr($line, 0, 3)) {
            return true;
        }

        return false;
    }

    protected function isEndTrBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('</tr>' === substr($line, -5)) {
            return true;
        }

        return false;
    }

    protected function isStartUlBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('<ul' === substr($line, 0, 3)) {
            return true;
        }

        return false;
    }

    protected function isEndUlBlock($lineNumber)
    {
        $line = $this->lines[$lineNumber];

        if ('</ul>' === substr($line, -5)) {
            return true;
        }

        return false;
    }

    public function initJustificationRules()
    {
        $this->addJustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startBlock'][$lineNumber]) {
                $this->indentLines($lineNumber + 1, $this->findEndStandardBlock('Block', $lineNumber, $endLine) - 1);
            }
        });

        $this->addJustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startFor'][$lineNumber]) {
                $this->indentLines($lineNumber + 1, $this->findEndStandardBlock('For', $lineNumber, $endLine) - 1);
            }
        });

        $this->addJustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startTable'][$lineNumber]) {
                $this->indentLines($lineNumber + 1, $this->findEndStandardBlock('Table', $lineNumber, $endLine) - 1);
            }
        });

        $this->addJustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startThead'][$lineNumber]) {
                $this->indentLines($lineNumber + 1, $this->findEndStandardBlock('Thead', $lineNumber, $endLine) - 1);
            }
        });

        $this->addJustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startTbody'][$lineNumber]) {
                $this->indentLines($lineNumber + 1, $this->findEndStandardBlock('Tbody', $lineNumber, $endLine) - 1);
            }
        });

        $this->addJustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startTr'][$lineNumber]) {
                $this->indentLines($lineNumber + 1, $this->findEndStandardBlock('Tr', $lineNumber, $endLine) - 1);
            }
        });

        $this->addJustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startUl'][$lineNumber]) {
                $this->indentLines($lineNumber + 1, $this->findEndStandardBlock('Ul', $lineNumber, $endLine) - 1);
            }
        });
    }
}
