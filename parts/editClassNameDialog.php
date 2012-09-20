<div id="edit-item-dialog" title="Edit item">
    Name:
    <input type="text" name="name" class="text ui-widget-content ui-corner-all" />
    <input type="hidden" name="currentname" class="text ui-widget-content ui-corner-all" />
    <br/>
    <br/>

	<div id="edit-item-tabs">
        <ul>
            <li><a href="#edit-item-tabs-attributes">Attributes</a></li>
            <li><a href="#edit-item-tabs-links">Links</a></li>
        </ul>


		<div id="edit-item-tabs-attributes">
            <input id="add-attribute" type="button" value="Add attribute"><br/>
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
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
		</div>
		<div id="edit-item-tabs-links">
			blah
		</div>
	</div>
</div>

<script>
    function getAttributeRow (rowId, name, type, size, nul, primary, foreign, autoincrement, unique, def, description) {
        var row =   '<tr>' +
                        '<td>' + rowId + '</td>' +
                        '<td align="center">' +
                            '<input id="name' + rowId + '" type="text" size="12" value="' + (name == undefined ? '' : name) + '">' +
                        '</td>' +
                        '<td align="center">' +
                            '<select id="type' + rowId + '">' +
                                '<option value=""' + (type == undefined ? ' selected="selected"' : '') + '></option>';
                                for (var i = 0; i < Config.prototype.types.length; i++)
                                    row += '<option value="' + Config.prototype.types[i] + '"' + (type == Config.prototype.types[i] ? ' selected="selected"' : '') + '>' + Config.prototype.types[i] + '</option>';

        row +=              '</select>' +
                        '</td>' +
                        '<td align="center">' +
                            '<input id="size' + rowId + '" type="text" size="2" value="' + ( size == undefined ? '' : size ) + '">' +
                        '</td>' +
                        '<td align="center">' +
                            '<input id="null' + rowId + '" type="checkbox"'+ ( nul != undefined && nul ? ' checked="checked"' : '' ) + '">' +
                        '</td>' +
                        '<td align="center">' +
                            '<input id="primary' + rowId + '" type="checkbox"'+ ( primary != undefined && primary ? ' checked="checked"' : '' ) + '">' +
                        '</td>' +
                        '<td align="center">' +
                            '<input id="foreign' + rowId + '" type="checkbox" disabled="disabled"'+ ( foreign != undefined && foreign ? ' checked="checked"' : '' ) + '">' +
                        '</td>' +
                        '<td align="center">' +
                            '<input id="autoincrement' + rowId + '" type="checkbox"'+ ( autoincrement != undefined && autoincrement ? ' checked="checked"' : '' ) + '">' +
                        '</td>' +
                        '<td align="center">' +
                            '<input id="unique' + rowId + '" type="checkbox"'+ ( unique != undefined && unique ? ' checked="checked"' : '' ) + '">' +
                        '</td>' +
                        '<td align="center">' +
                            '<input id="default' + rowId + '" type="text" size="7" value="' + ( def == undefined ? '' : def ) + '">' +
                        '</td>' +
                        '<td align="center">' +
                            '<input id="description' + rowId + '" type="text" size="15" value="' + ( description == undefined ? '' : description ) + '">' +
                        '</td>' +
            '</tr>';

        return row;
    }

    $(function() {
        $('#edit-item-tabs').tabs();

        $('#edit-item-dialog').dialog({
            autoOpen: false,
            //height: 300,
            width: 750,
            modal: true,
            buttons: {
                'Change': function() {
                    var currentName = $('#edit-item-dialog input[name=currentname]').attr('value');
                    var newName = $('#edit-item-dialog input[name=name]').attr('value');
                    var i = Item.prototype.getItemByName(currentName);

                    if (currentName != newName) {
                        i.setName(newName);
                        $(i.hashId + ' .name').html(i.getName());
                    }

                    var a;

                    for (var j = 0; j < i.getNumberAttributes(); j++) {
                        a  = i.getAttribute(j);

                        a.setName( $('#name' + j).val() );
                        a.setType( $('#type' + j).val() );
                        a.setSize( $('#size' + j).val() );
                        a.setNull( $('#null' + j).is(':checked'));
                        a.setPrimary( $('#primary' + j).is(':checked'));
                        a.setForeign( $('#foreign' + j).is(':checked'));
                        a.setAutoincrement( $('#autoincrement' + j).is(':checked'));
                        a.setUnique( $('#unique' + j).is(':checked'));
                        a.setDefault( $('#default' + j).val() );
                        a.setDescription( $('#description' + j).val() );
                    }

                    $(i.hashId + ' .attributes').html(i.attributesToHtml());

	                i.reDrawLinks();

                    $( this ).dialog("close");
                },
                Cancel: function() {
                    $( this ).dialog("close");
                }
            }
        });

        $('#add-attribute').click(function () {
            $(getAttributeRow(
                Item.prototype.getItemByName($('#edit-item-dialog input[name=currentname]').attr('value')).getNumberAttributes()
            )).appendTo('#edit-item-dialog #edit-attributes tbody');

            Item.prototype.getItemByName($('#edit-item-dialog input[name=currentname]').attr('value')).addAttribute();
        });
    });
</script>