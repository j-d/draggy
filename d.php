<!DOCTYPE html>

<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
        <title>Draggy</title>
        <meta charset="utf-8">
        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet"/>
        <link type="text/css" href="css/style.css" rel="stylesheet"/>
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" src="js/Class.js"></script>
        <script type="text/javascript" src="js/Link.js"></script>

        <script>

            function statusMsg(msg) {
                $('#status').html(msg);

                setTimeout('$(\'#status\').html(\'<br>\');', 500);
            }

            var usedNames = [];

            function getValidName(name) {
                if (usedNames[name] == undefined) {
                    usedNames[name] = true;
                    return name;
                }

                var number = 1;

                while (usedNames[name + number] != undefined)
                    number++;

                usedNames[name + number] = true;

                return name + number;
            }

            <?php
                require 'js/saveLoad.php';
            ?>

            $(document).ready(function () {
                //addLink('Class6', 'Class3', 'OneToOne');
                addLink('Class1', 'Elefante', 'OneToOne');
                addLink('Class1', 'Elefante', 'OneToOne');
                //addLink('Class', 'Elefante', 'OneToOne');
                addLink('Class6', 'Elefante', 'OneToOne');

  /*              addLink('Elefante', 'Class1', 'OneToOne');
                addLink('Elefante', 'Class', 'OneToOne');
                addLink('Elefante', 'Class6', 'OneToOne');
*/

                //addLink('Class2', 'Class6', 'OneToOne');

                Link.prototype.reDrawLinks();
            });

	        function debug(str) {
		        $('#debug').html($('#debug').html() + '<br>' + str);
	        }

        </script>
    </head>
    <body>

    <div id='status' style=""></div>

    <div id='footer'>
        <span onClick="addClass();">Add class</span>
        |
        <span onClick="save();">Save</span>
    </div>

    <div id="debug" style="border: 1px solid red; width: 500px; position: absolute; right: 0; height:100%;"></div>

    <?php
        require 'parts/editClassNameDialog.php';
        require 'parts/linkClassDialog.php';
    ?>
    </body>
</html>