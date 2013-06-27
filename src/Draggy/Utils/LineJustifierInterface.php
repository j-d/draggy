<?php

namespace Draggy\Utils;

interface LineJustifierInterface
{
    public function __construct(JustifierMachineInterface $justifierMachine);

    public function justify();
}