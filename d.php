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
        <script type="text/javascript" src="js/Config.js"></script>
        <script type="text/javascript" src="js/func.js"></script>
        <script type="text/javascript" src="js/Item.js"></script>
        <script type="text/javascript" src="js/Class.js"></script>
        <script type="text/javascript" src="js/Link.js"></script>
        <script type="text/javascript" src="js/Attribute.js"></script>

        <script>
            <?php
                require 'js/load.php';
            ?>

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