<?php

namespace Draggy\Autocode;

interface DifferentiableFileInterface
{
    public function isNew();
    public function isBeingRemoved();
    public function isChanged();

    public function getDiff();
}