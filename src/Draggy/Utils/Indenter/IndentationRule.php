<?php

namespace Draggy\Utils\Indenter;

/**
 * Class IndentationRule
 *
 * Small class that contains the rule (a callable function) and the pass number in which it should be executed
 *
 * @package Draggy\Utils\Indenter
 */
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

    /**
     * @param int       $pass
     * @param \Callable $rule
     */
    public function __construct($pass, $rule)
    {
        $this->pass = $pass;
        $this->rule = $rule;
    }

    /**
     * @return int
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @return Callable
     */
    public function getRule()
    {
        return $this->rule;
    }
}
