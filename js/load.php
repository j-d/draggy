$(document).ready(function () {
    <?php
        $xml = simplexml_load_file('saved.xml');

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

		        echo 'Class.prototype.getItemByName(\'' . $classAttributes['name'] . '\').addAttribute(\'' . $attributeProperties['name'] . '\',\'' . $attributeProperties['type'] . '\',\'' . $attributeProperties['size'] . '\',' . $attributeProperties['null'] . ',' . $attributeProperties['primary'] . ',' . $attributeProperties['foreign'] . ',' . $attributeProperties['autoincrement'] . ',' . $attributeProperties['unique'] . ',\'' . $attributeProperties['default'] . '\',\'' . $attributeProperties['description'] . '\');' . "\n";
	        }
        }

        $relationships = (array) $xml->xpath('/draggy/relationships/relation');

        foreach ($relationships as $relation) {
            $relationAttributes = (array) $relation;
            $relationAttributes = $relationAttributes['@attributes'];

            echo 'addLink(\'' . $relationAttributes['from'] . '\',\'' . $relationAttributes['to'] . '\',\'' . $relationAttributes['type'] . '\',\'' . $relationAttributes['fromType'] . '\',\'' . $relationAttributes['toType'] . '\')' . "\n";
        }

        echo 'Link.prototype.reDrawLinks();' . "\n";
    ?>
});