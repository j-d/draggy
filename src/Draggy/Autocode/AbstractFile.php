<?php

namespace Draggy\Autocode;

abstract class AbstractFile implements FileInterface, DifferentiableFileInterface
{
    protected $path = null;

    protected $name = null;

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFullName()
    {
        return $this->getPath() . $this->getName();
    }

    abstract public function isNew();
    abstract public function isBeingRemoved();
}