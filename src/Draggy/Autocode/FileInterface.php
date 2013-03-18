<?php

namespace Draggy\Autocode;

interface FileInterface
{
    public function setOverwrite($overwrite);
    public function getOverwrite();

    public function getLog();

    public function save();
}