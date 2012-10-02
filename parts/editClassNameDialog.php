<div id="edit-item-dialog" title="Edit item">
    Name:
    <input type="text" name="name" class="text ui-widget-content ui-corner-all" />
    <br/>

	<div id="edit-item-tabs">
        <ul>
            <li><a href="#edit-item-tabs-attributes">Attributes</a></li>
            <li><a href="#edit-item-tabs-links">Links</a></li>
        </ul>

		<div id="edit-item-tabs-attributes">
            <input id="add-attribute" type="button" value="Add attribute">
			<div>
	            <table border="1" id="edit-attributes">
	                <thead>
	                <tr>
	                    <th></th>
	                    <th>Name</th>
	                    <th>Type</th>
	                    <th>Size</th>
	                    <th>Null</th>
	                    <th>PK</th>
	                    <th>FK</th>
	                    <th>AI</th>
	                    <th>UQ</th>
	                    <th>Default</th>
	                    <th>Description</th>
	                    <th>Act.</th>
	                </tr>
	                </thead>
	                <tbody>
	                </tbody>
	            </table>
            </div>
		</div>
		<div id="edit-item-tabs-links">
			blah
		</div>
	</div>
</div>

<script>
    $(function() {
        $('#edit-item-tabs').tabs();

        $('#edit-item-dialog').dialog({
            autoOpen: false,
            //height: 300,
            width: 750,
            modal: true,
            buttons: {
                'Change': function() {
                    EditItemDialog.prototype.commitChanges();

                    $( this ).dialog("close");
                },
                'Cancel': function() {
                    $( this ).dialog("close");
                }
            }
        });

        $('#add-attribute').click(function () {
            EditItemDialog.prototype.addAttribute();
        });
    });
</script>