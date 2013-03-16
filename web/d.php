<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
        <title>Draggy</title>
        <meta charset="utf-8">
        <link type="text/css" href="../css/ui-lightness/jquery-ui-1.9.0.custom.css" rel="stylesheet"/>
        <link type="text/css" href="../js/contextMenu/jquery.contextMenu.css" rel="stylesheet"/>
        <link type="text/css" href="../css/style.css" rel="stylesheet"/>
        <script type="text/javascript" src="../js/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="../js/jquery-ui-1.9.0.custom.min.js"></script>
        <script type="text/javascript" src="../js/contextMenu/jquery.contextMenu.js"></script>
        <script type="text/javascript" src="../js/Config.js"></script>
        <script type="text/javascript" src="../js/func.js"></script>
        <script type="text/javascript" src="../js/Item.js"></script>
        <script type="text/javascript" src="../js/ScreenItem.js"></script>
        <script type="text/javascript" src="../js/Connectable.js"></script>
	    <script type="text/javascript" src="../js/ClassLike.js"></script>
        <script type="text/javascript" src="../js/Class.js"></script>
        <script type="text/javascript" src="../js/Abstract.js"></script>
        <script type="text/javascript" src="../js/Interface.js"></script>
        <script type="text/javascript" src="../js/Trait.js"></script>
        <script type="text/javascript" src="../js/Link.js"></script>
        <script type="text/javascript" src="../js/Attribute.js"></script>
        <script type="text/javascript" src="../js/InheritedAttribute.js"></script>
        <script type="text/javascript" src="../js/Container.js"></script>
        <script type="text/javascript" src="../js/System.js"></script>
        <script type="text/javascript" src="../js/EditItemDialog.js"></script>
        <script type="text/javascript" src="../js/EditModuleDialog.js"></script>
        <script type="text/javascript" src="../js/LinkClassDialog.js"></script>
        <script type="text/javascript" src="../js/ProjectPropertiesDialog.js"></script>
        <script type="text/javascript" src="../js/Draggy.js"></script>
        <script type="text/javascript" src="../js/ContextMenu.js"></script>
        <script type="text/javascript" src="../js/jsPlumb/jquery.jsPlumb-1.3.16-all-min.js"></script>
        <script type="text/javascript" src="../js/Exceptions/AmbiguousNameException.js"></script>
        <script type="text/javascript" src="../js/Exceptions/NameNotFoundException.js"></script>
    </head>
    <body>
        <?php
            if (empty($_GET['f']))
                die('Project filename not specified. Use ?f=project_name');
        ?>
        <script>
            <?php
                $file = 'saves/' . $_GET['f'] . '.xml';

                require 'js/load.php';
            ?>

            ContextMenu.prototype.enableMenus();
        </script>

        <div id="menu">
            <span onClick="Draggy.prototype.save('<?php echo $file; ?>');">Save</span>
            |
            <span onClick="ProjectPropertiesDialog.prototype.openDialog();">Project properties</span>
            <span id="contextMenus" style="display: none;">| <span onClick="ContextMenu.prototype.enableMenus();">Show context menus</span></span>
        </div>
        <div id="draggy-area">
            <div id="contextual-menu-overlay"></div>
        </div>

        <script>
            // Enable items to drop onto the background
            $('#draggy-area').droppable({
                greedy: true,
                hoverClass: 'droppable-hover',
                accept: '.connectable',
                drop: function( event, ui ) {
                    //$(hashId).css("background-color",'#F00');
                    Item.prototype.items[ui.draggable.attr('id')].setModule('');
                }
            });
        </script>
        <?php
            require 'parts/editItemDialog.html';
            require 'parts/editModuleDialog.html';
            require 'parts/linkClassDialog.html';
            require 'parts/projectPropertiesDialog.html';
        ?>
    </body>
</html>