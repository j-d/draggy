<?php

namespace Draggy\Utils\Indenter;

interface LineIndenterInterface
{
    /**
     * @param IndenterMachineInterface $indenterMachine
     */
    public function __construct(IndenterMachineInterface $indenterMachine);

    /**
     * Main method that will process the lines according to the definition and will save the results on the output array
     */
    public function indent();
}