function save() {
    $.ajax({
        type:'POST',
        url:'save.php',
        data: { xml: getXML() },
        success:function () {
            statusMsg('Saved');
        }
    });
}

function getXML() {
    var ret = '';

    ret += '<\?xml version="1.0" encoding="UTF-8" ?>\n';

    ret += '<classes>\n';
    for (var i in Class.prototype.classes)
        ret += '\t' + Class.prototype.classes[i].toXML() + '\n';
    ret += '</classes>\n';

    return ret;
}

$(document).ready(function () {
    <?php
        $xml = simplexml_load_file('saved.txt');

        $classes = (array) $xml->xpath('/classes/class');

        foreach ($classes as $class) {
            $classAttributes = (array) $class;
            $classAttributes = $classAttributes['@attributes'];

            echo 'addClass(\'' . $classAttributes['name'] . '\');' . "\n";
            echo 'Class.prototype.getClassByName(\'' . $classAttributes['name'] . '\').moveTo(\'' . $classAttributes['left'] . '\',\'' . $classAttributes['top'] . '\');' . "\n";
        }

    ?>
});