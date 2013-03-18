<?php

namespace Draggy;

class Log
{
    /**
     * @var string[]
     */
    private $log = [];

    /**
     * @var string[]
     */
    private $extendedLog = [];

    /**
     * Append a message to the log
     *
     * @param $message
     */
    public function append($message)
    {
        $this->log[] = $message;
        $this->extendedLog[] = $message;
    }

    /**
     * Append a message to the extended log
     *
     * @param $message
     */
    public function appendExtended($message)
    {
        $this->extendedLog[] = $message;
    }

    /**
     * Prepend a message to the log
     *
     * @param $message
     */
    public function prepend($message)
    {
        $this->log = [$message] + $this->log;
        $this->extendedLog = [$message] + $this->extendedLog;
    }

    /**
     * Prepend a message to the extended log
     *
     * @param $message
     */
    public function prependExtended($message)
    {
        $this->extendedLog = [$message] + $this->extendedLog;
    }

    /**
     * Retrieve the simple log
     *
     * @return string
     */
    public function getLog()
    {
        return implode($this->log, PHP_EOL);
    }

    /**
     * Retrieve the extended log
     *
     * @return string
     */
    public function getExtendedLog()
    {
        return implode($this->extendedLog, PHP_EOL);
    }
}