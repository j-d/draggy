$(document).ready(function () {
    <?php
        $xml = simplexml_load_file('saved.xml');

		$modules = (array) $xml->xpath('/draggy/module');

		foreach ($modules as $module) {
			$moduleAttributes = (array) $module;
			$moduleAttributes = $moduleAttributes['@attributes'];

			echo 'addContainer(\'' . $moduleAttributes['name'] . '\',\'' . $moduleAttributes['left'] . '\',\'' . $moduleAttributes['top'] . '\',\'' . $moduleAttributes['width'] . '\',\'' . $moduleAttributes['height'] . '\')' . "\n";

			// Inside classes

			$classes = (array) $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/class');

			foreach ($classes as $class) {
				$classAttributes = (array) $class;
				$classAttributes = $classAttributes['@attributes'];

				echo 'addClass(\'' . $classAttributes['name'] . '\',\'' . $moduleAttributes['name'] . '\');' . "\n";
				echo 'Class.prototype.getItemByName(\'' . $classAttributes['name'] . '\').moveTo(\'' . $classAttributes['left'] . '\',\'' . $classAttributes['top'] . '\');' . "\n";

				$attributes = $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/class[@name=\'' . $classAttributes['name'] . '\']/attribute');

				foreach ($attributes as $attribute) {
					$attributeProperties = (array) $attribute;
					$attributeProperties = $attributeProperties['@attributes'];

					echo 'Class.prototype.getItemByName(\'' . $classAttributes['name'] . '\').addAttribute(\'' . $attributeProperties['name'] . '\',\'' . $attributeProperties['type'] . '\',\'' . (isset($attributeProperties['size']) ? $attributeProperties['size'] : '') . '\',' . (isset($attributeProperties['null']) ? $attributeProperties['null'] : 'false') . ',' . (isset($attributeProperties['primary']) ? $attributeProperties['primary'] : 'false' ) . ',' . (isset($attributeProperties['foreign']) ? $attributeProperties['foreign'] : 'false') . ',' . (isset($attributeProperties['autoincrement']) ? $attributeProperties['autoincrement'] : 'false') . ',' . (isset($attributeProperties['unique']) ? $attributeProperties['unique'] : 'false') . ',\'' . (isset($attributeProperties['default']) ? $attributeProperties['default'] : '') . '\',\'' . (isset($attributeProperties['description']) ? $attributeProperties['description'] : '') . '\');' . "\n";
				}

				echo 'Class.prototype.getItemByName(\'' . $classAttributes['name'] . '\').setModule(Container.prototype.getContainerByName(\'' . $moduleAttributes['name'] .'\').getId());' . "\n";
			}
			
			// Inside abstracts
			$abstracts = (array) $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/abstract');

			foreach ($abstracts as $abstract) {
				$abstractAttributes = (array) $abstract;
				$abstractAttributes = $abstractAttributes['@attributes'];

				echo 'addAbstract(\'' . $abstractAttributes['name'] . '\',\'' . $moduleAttributes['name'] . '\');' . "\n";
				echo 'Abstract.prototype.getItemByName(\'' . $abstractAttributes['name'] . '\').moveTo(\'' . $abstractAttributes['left'] . '\',\'' . $abstractAttributes['top'] . '\');' . "\n";

				$attributes = $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/abstract[@name=\'' . $abstractAttributes['name'] . '\']/attribute');

				foreach ($attributes as $attribute) {
					$attributeProperties = (array) $attribute;
					$attributeProperties = $attributeProperties['@attributes'];

					echo 'Abstract.prototype.getItemByName(\'' . $abstractAttributes['name'] . '\').addAttribute(\'' . $attributeProperties['name'] . '\',\'' . $attributeProperties['type'] . '\',\'' . (isset($attributeProperties['size']) ? $attributeProperties['size'] : '') . '\',' . (isset($attributeProperties['null']) ? $attributeProperties['null'] : 'false') . ',' . (isset($attributeProperties['primary']) ? $attributeProperties['primary'] : 'false' ) . ',' . (isset($attributeProperties['foreign']) ? $attributeProperties['foreign'] : 'false') . ',' . (isset($attributeProperties['autoincrement']) ? $attributeProperties['autoincrement'] : 'false') . ',' . (isset($attributeProperties['unique']) ? $attributeProperties['unique'] : 'false') . ',\'' . (isset($attributeProperties['default']) ? $attributeProperties['default'] : '') . '\',\'' . (isset($attributeProperties['description']) ? $attributeProperties['description'] : '') . '\');' . "\n";
				}

				echo 'Abstract.prototype.getItemByName(\'' . $abstractAttributes['name'] . '\').setModule(Container.prototype.getContainerByName(\'' . $moduleAttributes['name'] .'\').getId());' . "\n";
			}
		}

		// Outside classes

        $classes = (array) $xml->xpath('/draggy/classes/class');

        foreach ($classes as $class) {
            $classAttributes = (array) $class;
            $classAttributes = $classAttributes['@attributes'];

            echo 'addClass(\'' . $classAttributes['name'] . '\');' . "\n";
            echo 'Class.prototype.getItemByName(\'' . $classAttributes['name'] . '\').moveTo(\'' . $classAttributes['left'] . '\',\'' . $classAttributes['top'] . '\');' . "\n";

	        $attributes = $xml->xpath('/draggy/classes/class[@name=\'' . $classAttributes['name'] . '\']/attribute');

	        foreach ($attributes as $attribute) {
		        $attributeProperties = (array) $attribute;
		        $attributeProperties = $attributeProperties['@attributes'];

		        echo 'Class.prototype.getItemByName(\'' . $classAttributes['name'] . '\').addAttribute(\'' . $attributeProperties['name'] . '\',\'' . $attributeProperties['type'] . '\',\'' . (isset($attributeProperties['size']) ? $attributeProperties['size'] : '') . '\',' . (isset($attributeProperties['null']) ? $attributeProperties['null'] : 'false') . ',' . (isset($attributeProperties['primary']) ? $attributeProperties['primary'] : 'false' ) . ',' . (isset($attributeProperties['foreign']) ? $attributeProperties['foreign'] : 'false') . ',' . (isset($attributeProperties['autoincrement']) ? $attributeProperties['autoincrement'] : 'false') . ',' . (isset($attributeProperties['unique']) ? $attributeProperties['unique'] : 'false') . ',\'' . (isset($attributeProperties['default']) ? $attributeProperties['default'] : '') . '\',\'' . (isset($attributeProperties['description']) ? $attributeProperties['description'] : '') . '\');' . "\n";
	        }
        }

		// Outside abstracts

		$abstracts = (array) $xml->xpath('/draggy/abstracts/abstract');

		foreach ($abstracts as $abstract) {
			$abstractAttributes = (array) $abstract;
			$abstractAttributes = $abstractAttributes['@attributes'];

			echo 'addAbstract(\'' . $abstractAttributes['name'] . '\');' . "\n";
			echo 'Abstract.prototype.getItemByName(\'' . $abstractAttributes['name'] . '\').moveTo(\'' . $abstractAttributes['left'] . '\',\'' . $abstractAttributes['top'] . '\');' . "\n";

			$attributes = $xml->xpath('/draggy/abstracts/abstract[@name=\'' . $abstractAttributes['name'] . '\']/attribute');

			foreach ($attributes as $attribute) {
				$attributeProperties = (array) $attribute;
				$attributeProperties = $attributeProperties['@attributes'];

				echo 'Abstract.prototype.getItemByName(\'' . $abstractAttributes['name'] . '\').addAttribute(\'' . $attributeProperties['name'] . '\',\'' . $attributeProperties['type'] . '\',\'' . (isset($attributeProperties['size']) ? $attributeProperties['size'] : '') . '\',' . (isset($attributeProperties['null']) ? $attributeProperties['null'] : 'false') . ',' . (isset($attributeProperties['primary']) ? $attributeProperties['primary'] : 'false' ) . ',' . (isset($attributeProperties['foreign']) ? $attributeProperties['foreign'] : 'false') . ',' . (isset($attributeProperties['autoincrement']) ? $attributeProperties['autoincrement'] : 'false') . ',' . (isset($attributeProperties['unique']) ? $attributeProperties['unique'] : 'false') . ',\'' . (isset($attributeProperties['default']) ? $attributeProperties['default'] : '') . '\',\'' . (isset($attributeProperties['description']) ? $attributeProperties['description'] : '') . '\');' . "\n";
			}
		}

		// Relationships

        $relationships = (array) $xml->xpath('/draggy/relationships/relation');

        foreach ($relationships as $relation) {
            $relationAttributes = (array) $relation;
            $relationAttributes = $relationAttributes['@attributes'];

	        if (isset($relationAttributes['fromType']))
                echo 'addLink(\'' . $relationAttributes['from'] . '\',\'' . $relationAttributes['to'] . '\',\'' . $relationAttributes['type'] . '\',\'' . $relationAttributes['fromType'] . '\',\'' . $relationAttributes['toType'] . '\')' . "\n";
	        else
                echo 'addLink(\'' . $relationAttributes['from'] . '\',\'' . $relationAttributes['to'] . '\',\'' . $relationAttributes['type'] . '\')' . "\n";
        }

        echo 'Link.prototype.reDrawLinks();' . "\n";
    ?>
});