<?php

    namespace Draggy;

    class Loader
    {
        public function __construct($file)
        {
            if (!file_exists($file)) {
                
            }
        }
    }





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
                    if (isset($attributeProperties['type']))
                        echo 'a.setType(\'' . $attributeProperties['type'] . '\');' . "\n";
					if (isset($attributeProperties['subtype']))
						echo 'a.setSubtype(\'' . str_replace('\\','\\\\',$attributeProperties['subtype']) . '\');' . "\n";
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
						echo 'a.setDefault(\'' . str_replace('\'','\\\'',$attributeProperties['default']) . '\');' . "\n";
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
                    if (isset($attributeProperties['static']))
                        echo 'a.setStatic(\'' . $attributeProperties['static'] . '\');' . "\n";

                    echo $classLikeVarName . '.addAttribute(a);' . "\n";
				}
			}
		}

        if (file_exists($file)) {
            $xml = simplexml_load_file($file);

            $projectOptions = (array) $xml->xpath('/draggy/project');
            $projectOptions = (array) $projectOptions[0];

            echo 'Draggy.prototype.setLanguage(\'' . (string) $projectOptions['language'] . '\');' . "\n";
            echo 'Draggy.prototype.setDescription(\'' . (string) $projectOptions['description'] . '\');' . "\n";
            echo 'Draggy.prototype.setORM(\'' . (string) $projectOptions['orm'] . '\');' . "\n";
            echo 'Draggy.prototype.setFramework(\'' . (string) $projectOptions['framework'] . '\');' . "\n";

            // FIRST PASS: Load all modules and entities

            $modules = (array) $xml->xpath('/draggy/module');

            foreach ($modules as $module) {
                $moduleAttributes = (array) $module;
                $moduleAttributes = $moduleAttributes['@attributes'];

                echo 'var o = new Container(\'' . str_replace('\\','\\\\',$moduleAttributes['name']) . '\');' . "\n";
                echo 'o.moveTo(\'' . ($moduleAttributes['left'] - 1) . 'px\',\'' . ($moduleAttributes['top'] - 1) . 'px\',\'' . $moduleAttributes['width'] . 'px\',\'' . $moduleAttributes['height'] . 'px\')' . "\n";

                // Inside classes

                $classes = (array) $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/class');

                foreach ($classes as $class) {
                    $classAttributes = (array) $class;
                    $classAttributes = $classAttributes['@attributes'];

                    echo 'var c = new Class(\'' . $classAttributes['name'] . '\',\'' . str_replace('\\','\\\\',$moduleAttributes['name']) . '\');' . "\n";
                    echo 'c.moveTo(\'' . ($classAttributes['left'] /*- 1*/) . 'px\',\'' . ($classAttributes['top'] /*- 1*/) . 'px\');' . "\n";

                    if (isset($classAttributes['description']))
                        echo 'c.setDescription("' . $classAttributes['description'] . '");' . "\n";

                    if (isset($classAttributes['constructor']))
                        echo 'c.setConstructor(' . $classAttributes['constructor'] . ');' . "\n";

                    if (isset($classAttributes['repository']))
                        echo 'c.setRepository(' . $classAttributes['repository'] . ');' . "\n";

                    if (isset($classAttributes['form']))
                        echo 'c.setForm(' . $classAttributes['form'] . ');' . "\n";

                    if (isset($classAttributes['controller']))
                        echo 'c.setController(' . $classAttributes['controller'] . ');' . "\n";

                    if (isset($classAttributes['fixtures']))
                        echo 'c.setFixtures(' . $classAttributes['fixtures'] . ');' . "\n";

                    if (isset($classAttributes['crud']))
                        echo 'c.setCrud(\'' . $classAttributes['crud'] . '\');' . "\n";

                    echo 'c.setModule(Container.prototype.getContainerByName(\'' . str_replace('\\','\\\\',$moduleAttributes['name']) .'\').getId());' . "\n";
                }

                // Inside abstracts
                $abstracts = (array) $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/abstract');

                foreach ($abstracts as $abstract) {
                    $abstractAttributes = (array) $abstract;
                    $abstractAttributes = $abstractAttributes['@attributes'];

                    echo 'var s = new Abstract(\'' . $abstractAttributes['name'] . '\',\'' . $moduleAttributes['name'] . '\');' . "\n";
                    echo 's.moveTo(\'' . ($abstractAttributes['left'] /*- 1*/) . 'px\',\'' . ($abstractAttributes['top'] /*- 1*/) . 'px\');' . "\n";

                    if (isset($abstractAttributes['description']))
                        echo 's.setDescription("' . $abstractAttributes['description'] . '");' . "\n";

                    if (isset($abstractAttributes['constructor']))
                        echo 's.setConstructor(' . $abstractAttributes['constructor'] . ');' . "\n";

                    if (isset($abstractAttributes['repository']))
                        echo 's.setRepository(' . $abstractAttributes['repository'] . ');' . "\n";

                    if (isset($abstractAttributes['form']))
                        echo 's.setForm(' . $abstractAttributes['form'] . ');' . "\n";

                    if (isset($abstractAttributes['controller']))
                        echo 's.setController(' . $abstractAttributes['controller'] . ');' . "\n";

                    if (isset($abstractAttributes['fixtures']))
                        echo 's.setFixtures(' . $abstractAttributes['fixtures'] . ');' . "\n";

                    if (isset($abstractAttributes['crud']))
                        echo 's.setCrud(\'' . $abstractAttributes['crud'] . '\');' . "\n";

                    echo 's.setModule(Container.prototype.getContainerByName(\'' . $moduleAttributes['name'] .'\').getId());' . "\n";
                }

                // Inside interfaces

                $interfaces = (array) $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/interface');

                foreach ($interfaces as $interface) {
                    $interfaceAttributes = (array) $interface;
                    $interfaceAttributes = $interfaceAttributes['@attributes'];

                    echo 'var i = new Interface(\'' . $interfaceAttributes['name'] . '\',\'' . $moduleAttributes['name'] . '\');' . "\n";
                    echo 'i.moveTo(\'' . ($interfaceAttributes['left'] /*- 1*/) . 'px\',\'' . ($interfaceAttributes['top'] /*- 1*/) . 'px\');' . "\n";

                    if (isset($classAttributes['description']))
                        echo 'i.setDescription("' . $classAttributes['description'] . '");' . "\n";

                    echo 'i.setModule(Container.prototype.getContainerByName(\'' . $moduleAttributes['name'] .'\').getId());' . "\n";
                }
            }

            // Outside classes

            $classes = (array) $xml->xpath('/draggy/loose/class');

            foreach ($classes as $class) {
                $classAttributes = (array) $class;
                $classAttributes = $classAttributes['@attributes'];

                echo 'var c = new Class(\'' . $classAttributes['name'] . '\');' . "\n";
                echo 'c.moveTo(\'' . ($classAttributes['left']) . 'px\',\'' . ($classAttributes['top']) . 'px\');' . "\n";

                if (isset($classAttributes['description']))
                    echo 'c.setDescription("' . $classAttributes['description'] . '");' . "\n";

                if (isset($classAttributes['constructor']))
                    echo 'c.setConstructor(' . $classAttributes['constructor'] . ');' . "\n";

                if (isset($classAttributes['repository']))
                    echo 'c.setRepository(' . $classAttributes['repository'] . ');' . "\n";

                if (isset($classAttributes['form']))
                    echo 'c.setForm(' . $classAttributes['form'] . ');' . "\n";

                if (isset($classAttributes['controller']))
                    echo 'c.setController(' . $classAttributes['controller'] . ');' . "\n";

                if (isset($classAttributes['fixtures']))
                    echo 'c.setFixtures(' . $classAttributes['fixtures'] . ');' . "\n";

                if (isset($classAttributes['crud']))
                    echo 'c.setCrud(\'' . $classAttributes['crud'] . '\');' . "\n";
            }

            // Outside abstracts

            $abstracts = (array) $xml->xpath('/draggy/loose/abstract');

            foreach ($abstracts as $abstract) {
                $abstractAttributes = (array) $abstract;
                $abstractAttributes = $abstractAttributes['@attributes'];

                echo 'var s = new Abstract(\'' . $abstractAttributes['name'] . '\');' . "\n";
                echo 's.moveTo(\'' . ($abstractAttributes['left']) . 'px\',\'' . ($abstractAttributes['top']) . 'px\');' . "\n";

                if (isset($abstractAttributes['description']))
                    echo 's.setDescription("' . $abstractAttributes['description'] . '");' . "\n";

                if (isset($abstractAttributes['constructor']))
                    echo 's.setConstructor(' . $abstractAttributes['constructor'] . ');' . "\n";

                if (isset($abstractAttributes['repository']))
                    echo 's.setRepository(' . $abstractAttributes['repository'] . ');' . "\n";

                if (isset($abstractAttributes['form']))
                    echo 's.setForm(' . $abstractAttributes['form'] . ');' . "\n";

                if (isset($abstractAttributes['controller']))
                    echo 's.setController(' . $abstractAttributes['controller'] . ');' . "\n";

                if (isset($abstractAttributes['fixtures']))
                    echo 's.setFixtures(' . $abstractAttributes['fixtures'] . ');' . "\n";

                if (isset($abstractAttributes['crud']))
                    echo 's.setCrud(\'' . $abstractAttributes['crud'] . '\');' . "\n";
            }

            // Outside interfaces

            $interfaces = (array) $xml->xpath('/draggy/loose/interface');

            foreach ($interfaces as $interface) {
                $interfaceAttributes = (array) $interface;
                $interfaceAttributes = $interfaceAttributes['@attributes'];

                echo 'var i = new Interface(\'' . $interfaceAttributes['name'] . '\');' . "\n";
                echo 'i.moveTo(\'' . ($interfaceAttributes['left']) . 'px\',\'' . ($interfaceAttributes['top']) . 'px\');' . "\n";

                if (isset($classAttributes['description']))
                    echo 'c.setDescription("' . $classAttributes['description'] . '");' . "\n";
            }

            // SECOND PASS: Add the attributes

            $modules = (array) $xml->xpath('/draggy/module');

            foreach ($modules as $module) {
                $moduleAttributes = (array) $module;
                $moduleAttributes = $moduleAttributes['@attributes'];

                // Inside classes

                $classes = (array) $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/class');

                foreach ($classes as $class) {
                    $classAttributes = (array) $class;
                    $classAttributes = $classAttributes['@attributes'];

                    $attributes = $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/class[@name=\'' . $classAttributes['name'] . '\']/attribute');

                    echo 'c = Connectable.prototype.getConnectableFromName(\'' . str_replace('\\','\\\\',$moduleAttributes['name'] . '\\') . $classAttributes['name'] . '\');' . "\n";

                    assignAttributesToClassLike($attributes,'c');

                    if (isset($classAttributes['toString']))
                        echo 'c.setToString(c.getAttributeFromName("' . $classAttributes['toString'] . '"))' . "\n";
                }

                // Inside abstracts
                $abstracts = (array) $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/abstract');

                foreach ($abstracts as $abstract) {
                    $abstractAttributes = (array) $abstract;
                    $abstractAttributes = $abstractAttributes['@attributes'];

                    $attributes = $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/abstract[@name=\'' . $abstractAttributes['name'] . '\']/attribute');

                    echo 's = Connectable.prototype.getConnectableFromName(\'' . str_replace('\\','\\\\',$moduleAttributes['name'] . '\\') . $abstractAttributes['name'] . '\');' . "\n";

                    assignAttributesToClassLike($attributes,'s');

                    if (isset($abstractAttributes['toString']))
                        echo 's.setToString(s.getAttributeFromName("' . $abstractAttributes['toString'] . '"))' . "\n";
                }

                // Inside interfaces

                $interfaces = (array) $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/interface');

                foreach ($interfaces as $interface) {
                    $interfaceAttributes = (array) $interface;
                    $interfaceAttributes = $interfaceAttributes['@attributes'];

                    $attributes = $xml->xpath('/draggy/module[@name=\'' . $moduleAttributes['name'] . '\']/interface[@name=\'' . $interfaceAttributes['name'] . '\']/attribute');
                }
            }

            // Outside classes

            $classes = (array) $xml->xpath('/draggy/loose/class');

            foreach ($classes as $class) {
                $classAttributes = (array) $class;
                $classAttributes = $classAttributes['@attributes'];

                echo 'c = Connectable.prototype.getConnectableFromName(\'' . $classAttributes['name'] . '\');' . "\n";

                $attributes = $xml->xpath('/draggy/loose/class[@name=\'' . $classAttributes['name'] . '\']/attribute');

                assignAttributesToClassLike($attributes,'c');

                if (isset($classAttributes['toString']))
                    echo 'c.setToString(c.getAttributeFromName("' . $classAttributes['toString'] . '"))' . "\n";
            }

            // Outside abstracts

            $abstracts = (array) $xml->xpath('/draggy/loose/abstract');

            foreach ($abstracts as $abstract) {
                $abstractAttributes = (array) $abstract;
                $abstractAttributes = $abstractAttributes['@attributes'];

                $attributes = $xml->xpath('/draggy/loose/abstract[@name=\'' . $abstractAttributes['name'] . '\']/attribute');

                echo 's = Connectable.prototype.getConnectableFromName(\'' . $abstractAttributes['name'] . '\');' . "\n";

                assignAttributesToClassLike($attributes,'s');

                if (isset($abstractAttributes['toString']))
                    echo 's.setToString(s.getAttributeFromName("' . $abstractAttributes['toString'] . '"))' . "\n";
            }

            // Outside interfaces

            $interfaces = (array) $xml->xpath('/draggy/loose/interface');

            foreach ($interfaces as $interface) {
                $interfaceAttributes = (array) $interface;
                $interfaceAttributes = $interfaceAttributes['@attributes'];

                $attributes = $xml->xpath('/draggy/loose/interface[@name=\'' . $interfaceAttributes['name'] . '\']/attribute');
            }

            // THIRD STEP: Relationships

            $relationships = (array) $xml->xpath('/draggy/relationships/relation');

            foreach ($relationships as $relation) {
                $relationAttributes = (array) $relation;
                $relationAttributes = $relationAttributes['@attributes'];

                echo 'var l = new Link(\'' . str_replace('\\','\\\\',$relationAttributes['from']) . '\',\'' . str_replace('\\','\\\\',$relationAttributes['to']) . '\',\'' . $relationAttributes['type'] . '\',' . ( isset($relationAttributes['fromAttribute']) ? '\'' . $relationAttributes['fromAttribute'] . '\'' : 'undefined' ) . ', ' . ( isset($relationAttributes['toAttribute']) ? '\'' . $relationAttributes['toAttribute'] . '\'' : 'undefined' ) . ')' . "\n";


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