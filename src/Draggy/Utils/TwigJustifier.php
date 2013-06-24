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

    public function initJustificationRules()
    {
        $this->addJustificationRule(2, function ($lineNumber, $endLine) {
            if ($this->lineTypes['startBlock'][$lineNumber]) {
                $this->indentLines($lineNumber + 1, $this->findEndStandardBlock('Block', $lineNumber, $endLine) - 1);
            }
        });
    }
}
