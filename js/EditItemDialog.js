function EditItemDialog () {
}

EditItemDialog.prototype.connectable = null;
EditItemDialog.prototype.attributesToDelete = [];

EditItemDialog.prototype.openDialog = function (connectableId) {
    EditItemDialog.prototype.attributesToDelete = [];

    var c = EditItemDialog.prototype.connectable = Connectable.prototype.connectables[connectableId];

    $('#edit-item-dialog input[name=name]').attr('value', c.getName());

    $('#edit-item-dialog #edit-attributes tbody tr').remove();

    for (var i = 0; i < c.getNumberAttributes(); i++)
        $(EditItemDialog.prototype.addAttributeRow(i,c.attributes[i])).appendTo('#edit-item-dialog #edit-attributes tbody');

    $("#edit-attributes tbody").sortable({
        //placeholder: "ui-state-highlight"
    });

    $('#edit-item-dialog').dialog('open');
};

EditItemDialog.prototype.deleteAttribute = function (attributeId, rowId) {
    EditItemDialog.prototype.attributesToDelete.push(attributeId);

    $('#delete' + rowId).parents('tr').remove()
};

EditItemDialog.prototype.performDeletionAttributes = function () {
    for (var i in EditItemDialog.prototype.attributesToDelete) {
        var attributeId = EditItemDialog.prototype.attributesToDelete[i];

        EditItemDialog.prototype.connectable.deleteAttribute(attributeId);
    }
};

EditItemDialog.prototype.addAttributeRow = function (rowId, attributeId) {
    var attribute;

    if (attributeId == undefined)
        attribute = new Attribute('unnamed');
    else
        attribute = Attribute.prototype.attributes[attributeId];

    var row =   '<tr>' +
        '<td name="' + attribute.getId() + '">' + rowId + '</td>' +
        '<td align="center">' +
        '<input id="name' + rowId + '" type="text" size="12" value="' +  attribute.getName() + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        '<select id="type' + rowId + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + '>' +
        '<option value=""' + (attribute.getType() == null ? ' selected="selected"' : '') + '></option>';

    for (var i = 0; i < Config.prototype.types.length; i++)
        row += '<option value="' + Config.prototype.types[i] + '"' + (attribute.getType() == Config.prototype.types[i] ? ' selected="selected"' : '') + '>' + Config.prototype.types[i] + '</option>';

    row +=              '</select>' +
        '</td>' +
        '<td align="center">' +
           '<input id="size' + rowId + '" type="text" size="2" value="' + ( attribute.getSize() == null ? '' : attribute.getSize() ) + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        '<input id="null' + rowId + '" type="checkbox"'+ ( attribute.getNull() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        '<input id="primary' + rowId + '" type="checkbox"'+ ( attribute.getPrimary() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        '<input id="foreign' + rowId + '" type="checkbox" disabled="disabled"'+ ( attribute.getForeign() ? ' checked="checked"' : '' ) + '">' +
        '</td>' +
        '<td align="center">' +
        '<input id="autoincrement' + rowId + '" type="checkbox"'+ ( attribute.getAutoincrement() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        '<input id="unique' + rowId + '" type="checkbox"'+ ( attribute.getUnique() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        '<input id="default' + rowId + '" type="text" size="7" value="' + ( attribute.getDefault() == null ? '' : attribute.getDefault() ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        '<input id="description' + rowId + '" type="text" size="15" value="' + ( attribute.getDescription() == null ? '' : attribute.getDescription() ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        (attribute.getInherited() || attribute.getNumberLinks() != 0 ? '' : '<input id="delete' + rowId + '" type="button" value="D" onClick="EditItemDialog.prototype.deleteAttribute(\'' + attribute.getId() + '\',' + rowId + ');">') +
        '</td>' +
        '</tr>';

    return row;
};

EditItemDialog.prototype.commitChanges = function () {
    var newName = $('#edit-item-dialog input[name=name]').attr('value');

    var c = EditItemDialog.prototype.connectable;

    EditItemDialog.prototype.performDeletionAttributes();

    // Change name
    if (c.getName() != newName)
        c.setName(newName);

    var a;

    for (var j = 0; j < c.getNumberAttributes(); j++) {
        a  = c.getAttribute(j);

        if (!a.getInherited()) {
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
    }

    // Resave the attributes in order in case they were reordered

    c.attributes = [];

    var rows = $("#edit-attributes tbody tr td:first-child");

    for (var i = 0; i < rows.length; i++)
        c.attributes.push($(rows[i]).attr('name'));

    // Redraw
    c.reDraw();
    c.reDrawLinks();
};

EditItemDialog.prototype.addAttribute = function () {
    $(EditItemDialog.prototype.addAttributeRow(
        EditItemDialog.prototype.connectable.getNumberAttributes()
    )).appendTo('#edit-item-dialog #edit-attributes tbody');

    var a = new Attribute();

    EditItemDialog.prototype.connectable.addAttribute(a);
};