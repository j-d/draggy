<div id="link-item-dialog" title="Link class">
    Destination:
    <select name="destinationItem" class="text ui-widget-content ui-corner-all"></select><br/>
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
        $("#link-item-dialog").dialog({
            autoOpen: false,
            //height: 300,
            //width: 350,
            modal: true,
            buttons: {
                'Link': function() {
                    addLink(
                        $('#link-item-dialog input[name=class]').val(),
                        $('#link-item-dialog select[name=destinationItem]').val(),
                        $('#link-item-dialog select[name=type]').val()
                    );

                    Link.prototype.reDrawLinks();

                    $( this ).dialog("close");
                },
                Cancel: function() {
                    $( this ).dialog("close");
                }
            }
        });

    });
</script>