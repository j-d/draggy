<div id="edit-item-dialog" title="Edit item">
    Name:
	<input type="text" name="name" size="30" class="text ui-widget-content ui-corner-all" />
	Description:
	<input type="text" name="description" size="40" class="text ui-widget-content ui-corner-all" /><br/>

	<div id="edit-item-tabs">
        <ul>
            <li><a href="#edit-item-tabs-attributes">Attributes</a></li>
            <li><a href="#edit-item-tabs-links">Links</a></li>
            <li><a href="#edit-item-tabs-programming-attributes">Programming</a></li>
        </ul>

		<div id="edit-item-tabs-attributes">
            <input id="add-attribute" type="button" value="Add attribute">
			<div class="scroll">
	            <table border="0" id="edit-attributes">
	                <thead>
	                <tr>
	                    <th></th>
	                    <th>Name</th>
	                    <th>Type</th>
	                    <th>Size</th>
	                    <th>Null</th>
	                    <th>PK</th>
	                    <!--<th>FK</th>-->
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
            <div class="scroll">
                <table border="1" id="edit-links">
                    <thead>
	                    <tr>
	                        <th></th>
	                        <th>Id</th>
	                        <th>Attribute</th>
		                    <th>Type</th>
	                        <th>Object</th>
	                        <th>Broken?</th>
	                        <th>Act.</th>
	                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
		</div>
        <div id="edit-item-tabs-programming-attributes">
            <div id="edit-item-buttons">
                <input id="edit-item-repository" type="checkbox"><label for="edit-item-repository">Repository?</label>
                <input id="edit-item-form" type="checkbox"><label for="edit-item-form">Form?</label>
                <input id="edit-item-controller" type="checkbox"><label for="edit-item-controller">Controller?</label>
                <input id="edit-item-fixtures" type="checkbox"><label for="edit-item-fixtures">Fixtures?</label>
            </div>
            <label for="edit-item-crud">
                CRUD?
                <select id="edit-item-crud">
                    <option value=""></option>
                    <option value="CRUD">CRUD</option>
                    <option value="CRU">CRU</option>
                    <option value="CUD">CUD</option>
                    <option value="CRD">CRD</option>
                    <option value="CR">CR</option>
                    <option value="CU">CU</option>
                    <option value="CD">CD</option>
                    <option value="C">C</option>
                    <option value="RUD">RUD</option>
                    <option value="RU">RU</option>
                    <option value="RD">RD</option>
                    <option value="R">R</option>
                    <option value="UD">UD</option>
                    <option value="U">U</option>
                    <option value="D">D</option>
                </select>
            </label>
            <br>
	        <label for="edit-item-tostring">toString: <select id="edit-item-tostring"></select></label>
            <div class="scroll">
                <table border="0" id="edit-programming-attributes">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Setter</th>
                        <th>Getter</th>
                        <th>MinSize</th>
                        <th>Email</th>
                        <th>Min</th>
                        <th>Max</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
	</div>
</div>

<script>
    $(function() {
        $('#edit-item-buttons').buttonset();

        $('#edit-item-tabs').tabs({
            beforeActivate: function( event, ui ) {
	            if ($(ui.newTab).children('a').html() == 'Programming')
                    EditItemDialog.prototype.loadProgrammingTab();
            }
        });

        $('#edit-item-dialog').dialog({
            autoOpen: false,
            //height: 300,
            width: 850,
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