<?php

namespace Draggy\Autocode;

class FileCollection implements FileInterface
{
    /**
     * @var AbstractFile[]
     */
    var $files = [];

    var $overwrite = false;

    public function __construct()
    {

    }

    public function setOverwrite($overwrite)
    {
        $this->overwrite = $overwrite;

        foreach ($this->getFiles() as $file) {
            $file->setOverwrite($overwrite);
        }

        return $this;
    }

    public function getOverwrite()
    {
        return $this->overwrite;
    }

    public function getLog()
    {
        $log = [];

        foreach ($this->getFiles() as $file) {
            $fileLog = $file->getLog();

            if ($fileLog !== '') {
                $log[] = $fileLog;
            }
        }

        return implode(PHP_EOL, $log);
    }

    public function add($file)
    {
        if (null !== $file && !$file instanceof FileInterface) {
            throw new \InvalidArgumentException('The file added has to implement FileInterface or be null.');
        }

        if (null === $file) {
            return;
        } elseif ($file instanceof FileCollection) {
            $files = $file->getFiles();

            foreach ($files as $f) {
                $this->add($f);
            }
        } else {
            $this->files[] = $file;
        }
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function save()
    {
        foreach ($this->getFiles() as $file) {
            $file->save();
        }
    }

    /**
     * @return array
     */
    public function getDiff()
    {
        /** @var AbstractFile[] $orderedFiles */
        $orderedFiles = [];

        foreach ($this->getFiles() as $file) {
            $orderedFiles[$file->getFullName()] = $file;
        }

        ksort($orderedFiles);

        $ret = [];

        foreach ($orderedFiles as $fullName => $file) {
            if ($file->isNew()) {
                $ret[$fullName] = [
                    'what' => 'NEW',
                    'path' => $file->getPath(),
                    'name' => $file->getName(),
                    'diff' => null,
                ];
            } elseif ($file->isBeingRemoved()) {
                $ret[$fullName] = [
                    'what' => 'BEING_REMOVED',
                    'path' => $file->getPath(),
                    'name' => $file->getName(),
                    'diff' => null,
                ];
            } elseif (!$file->isChanged()) {
                // SAME (No diff)

                //$ret[$fullName] = [
                //    'what' => 'SAME',
                //    'path' => $file->getPath(),
                //    'name' => $file->getName(),
                //    'diff' => null,
                //];
            } else {
                $diff = $file->getDiff();

                if (count($diff) > 0) {         // Ignore insignificant differences
                    $ret[$fullName] = [
                        'what' => 'DIFF',
                        'path' => $file->getPath(),
                        'name' => $file->getName(),
                        'diff' => $diff,
                    ];
                }
            }
        }

        return $ret;
    }
}