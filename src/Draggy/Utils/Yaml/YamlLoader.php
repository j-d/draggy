<?php

namespace Draggy\Utils\Yaml;

use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlLoader
 *
 * This class will process the configuration file, and it will merge all the different settings depending on the options
 * chosen. The output will be a configuration array that will be used on the project.
 *
 * @package Draggy\Utils\Yaml
 */
class YamlLoader
{
    /**
     * Overwrite / complete the target array with the values found on the source array
     *
     * @param array $target
     * @param array $source
     *
     * @return array
     */
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

    /**
     * Complete the different configuration sections on the target array with those ones found on the source array
     *
     * @param array $target
     * @param array $source
     *
     * @return array
     */
    public static function mergeConfigurations($target, $source)
    {
        foreach (['attributes', 'entities', 'relationships', 'autocode', 'languages', 'frameworks', 'orms'] as $configurationPart) {
            if (isset($source[$configurationPart])) {
                $target[$configurationPart] = self::mergeArrays($target[$configurationPart], $source[$configurationPart]);
            }
        }

        return $target;
    }

    /**
     * Load the model configuration, merge it onto the default one and return the result array
     *
     * @return array
     */
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
