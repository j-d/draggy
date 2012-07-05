<div id="edit-class-name-dialog" title="Edit class name">
    Name:
    <input type="text" name="name" class="text ui-widget-content ui-corner-all" />
    <input type="hidden" name="class" class="text ui-widget-content ui-corner-all" />
</div>

<script>
    $(function() {
        $("#edit-class-name-dialog").dialog({
            autoOpen: false,
            //height: 300,
            //width: 350,
            modal: true,
            buttons: {
                'Change': function() {
                    var className = $('#edit-class-name-dialog input[name=class]').attr('value');
                    var newName = $('#edit-class-name-dialog input[name=name]').attr('value');

                    if (className != newName) {
                        for (var i in Class.prototype.classes)
                            if (Class.prototype.classes[i].getName() == className) {
                                Class.prototype.classes[i].setName(newName)
                                newName = Class.prototype.classes[i].getName();
                                break;
                            }

                        $('#class_' + className + ' .name').html(newName);
                        $('#class_' + className).attr('id','class_' + newName);
                    }

                    $( this ).dialog("close");
                },
                Cancel: function() {
                    $( this ).dialog("close");
                }
            }
        });
    });
</script>