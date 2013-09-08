<?php

namespace Draggy\Utils\Indenter;

class IndentationRule
{
    /**
     * @var integer
     */
    protected $pass;

    /**
     * @var \Callable
     */
    protected $rule;

    public function __construct($pass, $rule)
    {
        $this->pass = $pass;
        $this->rule = $rule;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function getRule()
    {
        return $this->rule;
    }
}