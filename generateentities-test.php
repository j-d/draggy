<?php

require 'include/psr0.php';

use Autocode\Project;

function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require $fileName;
}

$modelFile = '/var/www/draggy/saves/test.xml';
$namespace = 'Test';
$targetFolder = '/var/www/test/src/';

$project = new Project($namespace);

//try {
$project
    ->setBase(true)
    ->loadFile($modelFile)
    ->setOverwrite(true)
    ->setValidation(false)
//->setDeleteUnmapped(true)
    ->saveTo($targetFolder);
//}
//catch (\Exception $e) {
//    die($e->getMessage());
//}

echo nl2br($project->getLog());