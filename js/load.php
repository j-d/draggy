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
					if (isset($attributeProperties['getter']))
						echo 'a.setGetter(' . $attributeProperties['getter'] . ');' . "\n";
					if (isset($attributeProperties['setter']))
						echo 'a.setSetter(' . $attributeProperties['setter'] . ');' . "\n";
					if (isset($attributeProperties['minSize']))
						echo 'a.setMinSize(\'' . $attributeProperties['minSize'] . '\');' . "\n";
					if (isset($attributeProperties['email']))
						echo 'a.setEmail(' . $attributeProperties['email'] . ');' . "\n";
                    if (isset($attributeProperties['min']))
                        echo 'a.setMin(\'' . $attributeProperties['min'] . '\');' . "\n";
                    if (isset($attributeProperties['max']))
                        echo 'a.setMax(\'' . $attributeProperties['max'] . '\');' . "\n";

                    echo $classLikeVarName . '.addAttribute(a);' . "\n";
				}
			}
		}

        if (file_exists($file)) {
            $xml = simplexml_load_file($file);

            $modules = (array) $xml->xpath('/draggy/module');

            foreach ($modules as $module) {
                $moduleAttributes = (array) $module;
                $moduleAttributes = $moduleAttributes['@attributes'];

                echo 'var o = new Container(\'' . $moduleAttributes['name'] . '\');' . "\n";
                echo 'o.moveTo(\'' . ($moduleAttributes['left'] - 1) . 'px\',\'' . ($moduleAttributes['top'] - 1) . 'px\',\'' . $moduleAttributes['width'] . 'px\',\'' . $moduleAttributes['height'] . 'px\')' . "\n";

                // Inside classes

                $classes = (array) $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/class');

                foreach ($classes as $class) {
                    $classAttributes = (array) $class;
                    $classAttributes = $classAttributes['@attributes'];

                    echo 'var c = new Class(\'' . $classAttributes['name'] . '\',\'' . $moduleAttributes['name'] . '\');' . "\n";
                    echo 'c.moveTo(\'' . ($classAttributes['left'] - 1) . 'px\',\'' . ($classAttributes['top'] - 1) . 'px\');' . "\n";

                    $attributes = $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/class[@name=\'' . $classAttributes['name'] . '\']/attribute');

                    assignAttributesToClassLike($attributes,'c');

                    if (isset($classAttributes['toString']))
                        echo 'c.setToString(c.getAttributeFromName("' . $classAttributes['toString'] . '"))' . "\n";

                    if (isset($classAttributes['description']))
                        echo 'c.setDescription("' . $classAttributes['description'] . '");' . "\n";

                    if (isset($classAttributes['repository']))
                        echo 'c.setRepository(' . $classAttributes['repository'] . ')' . "\n";

                    if (isset($classAttributes['form']))
                        echo 'c.setForm(' . $classAttributes['form'] . ')' . "\n";

                    if (isset($classAttributes['controller']))
                        echo 'c.setController(' . $classAttributes['controller'] . ')' . "\n";

                    if (isset($classAttributes['fixtures']))
                        echo 'c.setFixtures(' . $classAttributes['fixtures'] . ')' . "\n";

                    if (isset($classAttributes['crud']))
                        echo 'c.setCrud(\'' . $classAttributes['crud'] . '\')' . "\n";

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

                    if (isset($abstractAttributes['toString']))
                        echo 's.setToString(s.getAttributeFromName("' . $abstractAttributes['toString'] . '"))' . "\n";

                    if (isset($abstractAttributes['description']))
                        echo 's.setDescription("' . $abstractAttributes['description'] . '");' . "\n";

                    if (isset($abstractAttributes['repository']))
                        echo 's.setRepository(' . $abstractAttributes['repository'] . ')' . "\n";

                    if (isset($abstractAttributes['form']))
                        echo 's.setForm(' . $abstractAttributes['form'] . ')' . "\n";

                    if (isset($abstractAttributes['controller']))
                        echo 's.setController(' . $abstractAttributes['controller'] . ')' . "\n";

                    if (isset($abstractAttributes['fixtures']))
                        echo 's.setFixtures(' . $abstractAttributes['fixtures'] . ')' . "\n";

                    if (isset($abstractAttributes['crud']))
                        echo 's.setCrud(\'' . $abstractAttributes['crud'] . '\')' . "\n";

                    echo 's.setModule(Container.prototype.getContainerByName(\'' . $moduleAttributes['name'] .'\').getId());' . "\n";
                }
            }

            // Outside classes

            $classes = (array) $xml->xpath('/draggy/loose/class');

            foreach ($classes as $class) {
                $classAttributes = (array) $class;
                $classAttributes = $classAttributes['@attributes'];

                echo 'var c = new Class(\'' . $classAttributes['name'] . '\');' . "\n";
                echo 'c.moveTo(\'' . ($classAttributes['left'] - 1) . 'px\',\'' . ($classAttributes['top'] - 1) . 'px\');' . "\n";

                $attributes = $xml->xpath('/draggy/loose/class[@name=\'' . $classAttributes['name'] . '\']/attribute');

                assignAttributesToClassLike($attributes,'c');

                if (isset($classAttributes['toString']))
                    echo 'c.setToString(c.getAttributeFromName("' . $classAttributes['toString'] . '"))' . "\n";

                if (isset($classAttributes['description']))
                    echo 'c.setDescription("' . $classAttributes['description'] . '");' . "\n";

                if (isset($classAttributes['repository']))
                    echo 'c.setRepository(' . $classAttributes['repository'] . ')' . "\n";

                if (isset($classAttributes['form']))
                    echo 'c.setForm(' . $classAttributes['form'] . ')' . "\n";

                if (isset($classAttributes['controller']))
                    echo 'c.setController(' . $classAttributes['controller'] . ')' . "\n";

                if (isset($classAttributes['fixtures']))
                    echo 'c.setFixtures(' . $classAttributes['fixtures'] . ')' . "\n";

                if (isset($classAttributes['crud']))
                    echo 'c.setCrud(\'' . $classAttributes['crud'] . '\')' . "\n";
            }

            // Outside abstracts

            $abstracts = (array) $xml->xpath('/draggy/loose/abstract');

            foreach ($abstracts as $abstract) {
                $abstractAttributes = (array) $abstract;
                $abstractAttributes = $abstractAttributes['@attributes'];

                echo 'var s = new Abstract(\'' . $abstractAttributes['name'] . '\');' . "\n";
                echo 's.moveTo(\'' . ($abstractAttributes['left'] - 1) . 'px\',\'' . ($abstractAttributes['top'] - 1) . 'px\');' . "\n";

                $attributes = $xml->xpath('/draggy/loose/abstract[@name=\'' . $abstractAttributes['name'] . '\']/attribute');

                assignAttributesToClassLike($attributes,'s');

                if (isset($abstractAttributes['toString']))
                    echo 's.setToString(s.getAttributeFromName("' . $abstractAttributes['toString'] . '"))' . "\n";

                if (isset($abstractAttributes['description']))
                    echo 's.setDescription("' . $abstractAttributes['description'] . '");' . "\n";

                if (isset($abstractAttributes['repository']))
                    echo 's.setRepository(' . $abstractAttributes['repository'] . ')' . "\n";

                if (isset($abstractAttributes['form']))
                    echo 's.setForm(' . $abstractAttributes['form'] . ')' . "\n";

                if (isset($abstractAttributes['controller']))
                    echo 's.setController(' . $abstractAttributes['controller'] . ')' . "\n";

                if (isset($abstractAttributes['fixtures']))
                    echo 's.setFixtures(' . $abstractAttributes['fixtures'] . ')' . "\n";

                if (isset($abstractAttributes['crud']))
                    echo 's.setCrud(\'' . $abstractAttributes['crud'] . '\')' . "\n";
            }

            // Relationships

            $relationships = (array) $xml->xpath('/draggy/relationships/relation');

            foreach ($relationships as $relation) {
                $relationAttributes = (array) $relation;
                $relationAttributes = $relationAttributes['@attributes'];

                if (isset($relationAttributes['fromAttribute']))
                    echo 'var l = new Link(\'' . $relationAttributes['from'] . '\',\'' . $relationAttributes['to'] . '\',\'' . $relationAttributes['type'] . '\',\'' . $relationAttributes['fromAttribute'] . '\',\'' . $relationAttributes['toAttribute'] . '\')' . "\n";
                else
                    echo 'var l = new Link(\'' . $relationAttributes['from'] . '\',\'' . $relationAttributes['to'] . '\',\'' . $relationAttributes['type'] . '\')' . "\n";

                if (isset($relationAttributes['broken'])) {
                    echo 'l.setBroken(' . $relationAttributes['broken'] . ');' . "\n";
                }
            }



            echo 'for (var i in Connectable.prototype.connectables) Connectable.prototype.connectables[i].reDraw();' . "\n";

            echo 'Link.prototype.reDrawLinks();' . "\n";
        }

		echo 'System.prototype.runtime = true;' . "\n";
    ?>
});