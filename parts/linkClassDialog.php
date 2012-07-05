<div id="link-class-name-dialog" title="Link class">
    Destination:
    <select name="destClass" class="text ui-widget-content ui-corner-all"></select><br/>
    Type:
    <select name="type" class="text ui-widget-content ui-corner-all">
        <option value='OneToOne'>One to one</option>
        <option value='ManyToOne'>Many to one</option>
        <option value='ManyToMany'>Many to many</option>
    </select>
    <input type="text" name="class" class="text ui-widget-content ui-corner-all" />
</div>

<script>
    $(function() {
        $("#link-class-name-dialog").dialog({
            autoOpen: false,
            //height: 300,
            //width: 350,
            modal: true,
            buttons: {
                'Link': function() {
                    addLink(
                        $('#link-class-name-dialog input[name=class]').val(),
                        $('#link-class-name-dialog select[name=destClass]').val(),
                        $('#link-class-name-dialog select[name=type]').val()
                    );

                    $( this ).dialog("close");
                },
                Cancel: function() {
                    $( this ).dialog("close");
                }
            }
        });

    });
</script>