<?php

namespace Draggy\Utils\Indenter;

interface LineIndenterInterface
{
    public function __construct(IndenterMachineInterface $indenterMachine);

    public function indent();
}