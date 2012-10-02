$(document).ready(function () {
    <?php
		function assignAttributesToClassLike($attributes,$classLikeVarName) {
			foreach ($attributes as $attribute) {
				$attributeProperties = (array) $attribute;
				$attributeProperties = $attributeProperties['@attributes'];

				if (isset($attributeProperties['inherited'])) {
					echo 'var a = new InheritedAttribute(\'' . $attributeProperties['id'] . '\');' . "\n";

					echo $classLikeVarName . '.addInheritedAttribute(a);' . "\n";
				}
				else {
					echo 'var a = new Attribute(\'' . $attributeProperties['name'] . '\',\'' . $attributeProperties['id'] . '\');' . "\n";
					echo 'a.setType(\'' . $attributeProperties['type'] . '\');' . "\n";
					if (isset($attributeProperties['size']))
						echo 'a.setSize(\'' . $attributeProperties['size'] . '\');' . "\n";
					if (isset($attributeProperties['null']))
						echo 'a.setNull(' . $attributeProperties['null'] . ');' . "\n";
					if (isset($attributeProperties['primary']))
						echo 'a.setPrimary(' . $attributeProperties['primary'] . ');' . "\n";
					if (isset($attributeProperties['foreign']))
						echo 'a.setForeign(' . $attributeProperties['foreign'] . ');' . "\n";
					if (isset($attributeProperties['autoincrement']))
						echo 'a.setAutoincrement(' . $attributeProperties['autoincrement'] . ');' . "\n";
					if (isset($attributeProperties['unique']))
						echo 'a.setUnique(' . $attributeProperties['unique'] . ');' . "\n";
					if (isset($attributeProperties['default']))
						echo 'a.setDefault(\'' . $attributeProperties['default'] . '\');' . "\n";
					if (isset($attributeProperties['description']))
						echo 'a.setDescription(\'' . $attributeProperties['description'] . '\');' . "\n";

					echo $classLikeVarName . '.addAttribute(a);' . "\n";
				}
			}
		}

        $xml = simplexml_load_file('saved.xml');

		$modules = (array) $xml->xpath('/draggy/module');

		foreach ($modules as $module) {
			$moduleAttributes = (array) $module;
			$moduleAttributes = $moduleAttributes['@attributes'];

			echo 'addContainer(\'' . $moduleAttributes['name'] . '\',\'' . ($moduleAttributes['left'] - 1) . 'px\',\'' . ($moduleAttributes['top'] - 1) . 'px\',\'' . $moduleAttributes['width'] . 'px\',\'' . $moduleAttributes['height'] . 'px\')' . "\n";

			// Inside classes

			$classes = (array) $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/class');

			foreach ($classes as $class) {
				$classAttributes = (array) $class;
				$classAttributes = $classAttributes['@attributes'];

				echo 'var c = new Class(\'' . $classAttributes['name'] . '\',\'' . $moduleAttributes['name'] . '\');' . "\n";
				echo 'c.moveTo(\'' . ($classAttributes['left'] - 1) . 'px\',\'' . ($classAttributes['top'] - 1) . 'px\');' . "\n";

				$attributes = $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/class[@name=\'' . $classAttributes['name'] . '\']/attribute');

				assignAttributesToClassLike($attributes,'c');

				echo 'c.setModule(Container.prototype.getContainerByName(\'' . $moduleAttributes['name'] .'\').getId());' . "\n";
			}

			// Inside abstracts
			$abstracts = (array) $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/abstract');

			foreach ($abstracts as $abstract) {
				$abstractAttributes = (array) $abstract;
				$abstractAttributes = $abstractAttributes['@attributes'];

				echo 'var s = new Abstract(\'' . $abstractAttributes['name'] . '\',\'' . $moduleAttributes['name'] . '\');' . "\n";
				echo 's.moveTo(\'' . ($abstractAttributes['left'] - 1) . 'px\',\'' . ($abstractAttributes['top'] - 1) . 'px\');' . "\n";

				$attributes = $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/abstract[@name=\'' . $abstractAttributes['name'] . '\']/attribute');

				assignAttributesToClassLike($attributes,'s');

				echo 's.setModule(Container.prototype.getContainerByName(\'' . $moduleAttributes['name'] .'\').getId());' . "\n";
			}
		}

		// Outside classes

        $classes = (array) $xml->xpath('/draggy/classes/class');

        foreach ($classes as $class) {
            $classAttributes = (array) $class;
            $classAttributes = $classAttributes['@attributes'];

            echo 'var c = new Class(\'' . $classAttributes['name'] . '\');' . "\n";
            echo 'c.moveTo(\'' . ($classAttributes['left'] - 1) . 'px\',\'' . ($classAttributes['top'] - 1) . 'px\');' . "\n";

	        $attributes = $xml->xpath('/draggy/classes/class[@name=\'' . $classAttributes['name'] . '\']/attribute');

	        assignAttributesToClassLike($attributes,'c');
        }

		// Outside abstracts

		$abstracts = (array) $xml->xpath('/draggy/abstracts/abstract');

		foreach ($abstracts as $abstract) {
			$abstractAttributes = (array) $abstract;
			$abstractAttributes = $abstractAttributes['@attributes'];

			echo 'var s = new Abstract(\'' . $abstractAttributes['name'] . '\');' . "\n";
			echo 's.moveTo(\'' . ($abstractAttributes['left'] - 1) . 'px\',\'' . ($abstractAttributes['top'] - 1) . 'px\');' . "\n";

			$attributes = $xml->xpath('/draggy/abstracts/abstract[@name=\'' . $abstractAttributes['name'] . '\']/attribute');

			assignAttributesToClassLike($attributes,'s');
		}

		// Relationships

        $relationships = (array) $xml->xpath('/draggy/relationships/relation');

        foreach ($relationships as $relation) {
            $relationAttributes = (array) $relation;
            $relationAttributes = $relationAttributes['@attributes'];

	        if (isset($relationAttributes['fromAttribute']))
                echo 'addLink(\'' . $relationAttributes['from'] . '\',\'' . $relationAttributes['to'] . '\',\'' . $relationAttributes['type'] . '\',\'' . $relationAttributes['fromAttribute'] . '\',\'' . $relationAttributes['toAttribute'] . '\')' . "\n";
	        else
                echo 'addLink(\'' . $relationAttributes['from'] . '\',\'' . $relationAttributes['to'] . '\',\'' . $relationAttributes['type'] . '\')' . "\n";
        }

		echo 'for (var i in Connectable.prototype.connectables) Connectable.prototype.connectables[i].reDraw();' . "\n";

        echo 'Link.prototype.reDrawLinks();' . "\n";

		echo 'System.prototype.runtime = true;' . "\n";
    ?>
});