<?php

namespace Draggy\Autocode;

use Draggy\Log;

class File extends AbstractFile
{
    protected $contents = null;

    protected $oldContents = null;

    protected $addToFile = false;

    protected $overwrite = false;

    protected $log;

    public function __construct($path, $name, $contents)
    {
        $this->setPath($path);
        $this->setName($name);
        $this->contents = $contents;

        if (file_exists($this->getFullName()) && is_readable($this->getFullName())) {
            $this->oldContents = file_get_contents($this->getFullName());
        }

        $this->log = new Log();
    }

    public function setAddToFile($addToFile)
    {
        $this->addToFile = $addToFile;

        return $this;
    }

    public function getAddToFile()
    {
        return $this->addToFile;
    }

    public function setOverwrite($overwrite)
    {
        $this->overwrite = $overwrite;

        return $this;
    }

    public function getOverwrite()
    {
        return $this->overwrite;
    }

    public function getContents()
    {
        if (!$this->addToFile) {
            return $this->keepUserAdditions($this->contents, $this->oldContents, $this->path, $this->name);
        } else {
            return $this->addSystemAdditions($this->contents, $this->oldContents, $this->path, $this->name);
        }
    }

    public function getLog()
    {
        return $this->log->getLog();
    }

    public function save()
    {
        if (!$this->getAddToFile()) {
            $this->saveFile($this->path, $this->name, $this->contents);
        } else {
            $this->addToFile($this->path, $this->name, $this->contents, true);
        }
    }

    //TODO: REMOVE PATH AND NAME

    public function saveFile ($path, $name, $contents)
    {
        $targetFile = $path . $name;

        $folder = pathinfo($targetFile, PATHINFO_DIRNAME);

        if(!is_dir($folder)) {
            echo $folder . '<br>';
            mkdir($folder, 0777, true);
        }

        if (!file_exists($targetFile)) {
            file_put_contents($targetFile, $contents);
            $this->log->append(sprintf('Saved \'%s\' to \'%s\'', $name, $path));
        } elseif ($this->getOverwrite()) {
            $existingFile = file_get_contents($targetFile);
            $newFile      = $this->keepUserAdditions($contents, $existingFile, $path, $name);

            file_put_contents($targetFile, $newFile);

            $this->log->appendExtended(sprintf('\'%s\' file existed and modified in \'%s\'', $name, $path));
        } else {
            $this->log->prepend(sprintf('*** You may need to manually change the \'%s\' file in the \'%s\' folder as the template might have changed since you started using it.', $name, $path));
        }
    }

    public function addToFile ($path, $name, $contents, $addAtEndIfMissing=true)
    {
        $targetFile = $path . $name;

        $folder = pathinfo($targetFile,PATHINFO_DIRNAME);

        if(!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        if (!file_exists($targetFile)) {
            file_put_contents($targetFile, $contents);

            $this->log->append(sprintf('Saved \'%s\' to \'%s\'', $name, $path));
        } else {
            $existingFile = file_get_contents($targetFile);
            $newFile      = $this->addSystemAdditions($contents, $existingFile, $path, $name, $addAtEndIfMissing);

            file_put_contents($targetFile, $newFile);

            $this->log->appendExtended(sprintf('\'%s\' file existed and added modifications in \'%s\'', $name, $path));
        }
    }

    public function keepUserAdditions($masterFile, $userFile, $path, $name)
    {
        preg_match_all('/(<user-additions' . ' part=")(.+)(">)/', $masterFile, $masterParts);
        $masterParts = $masterParts[2];

        preg_match_all('/(<user-additions' . ' part=")(.+)(">)/', $userFile, $userParts);
        $userParts = $userParts[2];

//        foreach ($userParts as $part) {
//            if (!in_array($part, $masterParts)) {
//                throw new \RuntimeException(sprintf('Found a user-additions part (%s) on the file \'%s\' in the folder \'%s\' but there is no section for it on the master file', $part, $name, $path));
//            }
//        }

        foreach ($masterParts as $part) {
            if (preg_match('%<user-additions' . ' part="' . $part . '">.+?</user-additions' . '>%s', $userFile, $regs)) {
                $newPart = $regs[0];

                $masterFile = preg_replace(
                    '%<user-additions' . ' part="' . $part . '">.+?</user-additions' . '>%s',
                    str_replace('\\', '\\\\', $newPart),
                    $masterFile,
                    1
                );
            }
        }

        return $masterFile;
    }

    public function addSystemAdditions($masterFile, $userFile, $path, $name, $addAtEndIfMissing=true)
    {
        preg_match_all('/(<system-additions part=")(.+)(">)/', $masterFile, $masterParts);
        $masterParts = $masterParts[2];

        preg_match_all('/(<system-additions part=")(.+)(">)/', $userFile, $userParts);
        $userParts = $userParts[2];

        foreach ($masterParts as $part) {
            if (!in_array($part,$userParts) && !$addAtEndIfMissing) {
                throw new \RuntimeException(sprintf('Found a system-additions part (%s) on the file \'%s\' in the folder \'%s\' but there is no section for it on the user file and is not allowed to add at the end', $part, $name, $path));
            }
        }

        foreach ($masterParts as $part) {
            if (!in_array($part,$userParts)) {
                $userFile .= PHP_EOL . $masterFile;
            } elseif (preg_match('%<system-additions part="' . $part . '">.+?</system-additions>%s', $masterFile, $regs)) {
                $newPart = $regs[0];

                $userFile = preg_replace('%<system-additions part="' . $part . '">.+?</system-additions>%s',$newPart,$userFile,1);
            }
        }

        return $userFile;
    }

    public function isNew()
    {
        return !file_exists($this->getPath() . $this->getName());
    }

    public function isBeingRemoved()
    {
        return false;
    }

    public function isChanged()
    {
        return $this->contents !== $this->oldContents;
    }

    public function getDiff()
    {
        if ($this->isNew()) {
            return null;
        }

        $newFile = $this->getContents();
        $oldFile = $this->oldContents;

        $context = 3;

        $diff = $this->diff(explode(PHP_EOL, str_replace("\r", '', $oldFile)), explode(PHP_EOL, str_replace("\r", '', $newFile)));

        $keepLines = [];

        for ($i = 0; $i < count($diff); $i++) {
            $keepLines[$i] = is_array($diff[$i]) && (count($diff[$i]['d']) > 0 || count($diff[$i]['i']) > 0);
        }

        $contextLines = [];

        for ($i = 0; $i < count($diff); $i++) {
            if ($keepLines[$i]) {
                $contextLines[$i] = true;
                continue;
            }

            $contextLines[$i] = false;

            for ($j = 0; $j <= $context; $j++) {
                if ($i + $j < count($diff) &&  $keepLines[$i+$j]) {
                    $contextLines[$i] = true;
                    break;
                } elseif ($i - $j > 0 && $keepLines[$i-$j]) {
                    $contextLines[$i] = true;
                    break;
                }
            }
        }

        $contextDiff = [];

        for ($i = 0; $i < count($diff); $i++) {
            if ($contextLines[$i]) {
                $contextDiff[$i] = $diff[$i];
            }
        }

        return $contextDiff;
    }

    /*
        Paul's Simple Diff Algorithm v 0.1
        (C) Paul Butler 2007 <http://www.paulbutler.org/>
        May be used and distributed under the zlib/libpng license.

        This code is intended for learning purposes; it was written with short
        code taking priority over performance. It could be used in a practical
        application, but there are a few ways it could be optimized.

        Given two arrays, the function diff will return an array of the changes.
        I won't describe the format of the array, but it will be obvious
        if you use print_r() on the result of a diff on some test data.
    */

    private function diff($old, $new){
        $matrix = array();
        $maxlen = 0;

        foreach($old as $oindex => $ovalue){
            $nkeys = array_keys($new, $ovalue);
            foreach($nkeys as $nindex){
                $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                    $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
                if($matrix[$oindex][$nindex] > $maxlen){
                    $maxlen = $matrix[$oindex][$nindex];
                    $omax = $oindex + 1 - $maxlen;
                    $nmax = $nindex + 1 - $maxlen;
                }
            }
        }

        if($maxlen == 0) {
            return array(array('d'=>$old, 'i'=>$new));
        }

        return array_merge(
            $this->diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
            array_slice($new, $nmax, $maxlen),
            $this->diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen))
        );
    }
}