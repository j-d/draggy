<?php

namespace Draggy\Autocode;

class NoFile extends AbstractFile
{
    protected $reason = null;

    public function __construct($path, $name, $reason)
    {
        $this->setPath($path);
        $this->setName($name);
        $this->reason = $reason;
    }

    public function setOverwrite($overwrite)
    {
        // Do nothing

        return $this;
    }

    public function getOverwrite()
    {
        return false;
    }

    public function getLog()
    {
        return '';
    }

    public function save()
    {
        if (file_exists($this->getFullName())) {
            unlink($this->getFullName());
        }
    }

    public function isNew()
    {
        return false; // Doesn't make sense to say yes as it shouldn't be there in the first place
    }

    public function isBeingRemoved()
    {
        return file_exists($this->getFullName());
    }

    public function isChanged()
    {
        return $this->isBeingRemoved();
    }

    public function getDiff()
    {
        return null;
    }
}