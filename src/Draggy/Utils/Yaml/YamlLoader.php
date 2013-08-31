<?php

namespace Draggy\Utils\Yaml;

use Symfony\Component\Yaml\Yaml;

class YamlLoader
{
    protected static function mergeArrays($target, $source)
    {
        foreach ($source as $node => $values) {
            if (!array_key_exists($node, $target)) {
                $target[$node] = $values;
            } elseif (is_array($values)) {
                $target[$node] = self::mergeArrays($target[$node], $values);
            } else {
                $target[$node] = $values;
            }
        }

        return $target;
    }

    protected static function mergeConfigurations($target, $source)
    {
        foreach (['configuration', 'attributes', 'relationships', 'autocode', 'languages'] as $configurationPart) {
            if (isset($source[$configurationPart])) {
                $target[$configurationPart] = self::mergeArrays($target[$configurationPart], $source[$configurationPart]);
            }
        }

        return $target;
    }

    public static function loadConfiguration()
    {
        $defaultsFile = __DIR__ . '/../../../../app/config/defaults.yml';
        $draggyFile   = __DIR__ . '/../../../../app/config/draggy.yml';
        $userFile     = __DIR__ . '/../../../../app/config/user.yml';

        $defaultsArray = Yaml::parse($defaultsFile);

        $configurationArray = is_file($userFile)
            ? Yaml::parse($userFile)
            : Yaml::parse($draggyFile);

        $mergedArray = self::mergeConfigurations($defaultsArray, $configurationArray);

        return $mergedArray;
    }
}
