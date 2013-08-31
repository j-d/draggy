<?php

namespace Draggy\Utils\Justifier;

interface LineJustifierInterface
{
    public function __construct(JustifierMachineInterface $justifierMachine);

    public function justify();
}