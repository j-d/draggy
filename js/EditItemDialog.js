function EditItemDialog() {
}

EditItemDialog.prototype.connectable = null;
EditItemDialog.prototype.attributesToDelete = [];
EditItemDialog.prototype.linksToDelete = [];

EditItemDialog.prototype.openDialog = function (connectableId) {
    var i, sizeBoxAction = [];

    EditItemDialog.prototype.attributesToDelete = [];
    EditItemDialog.prototype.linksToDelete = [];

    var c = EditItemDialog.prototype.connectable = Connectable.prototype.connectables[connectableId];

    $('#edit-item-dialog input[name=name]').attr('value', c.getName());
    $('#edit-item-dialog input[name=description]').attr('value', c.getDescription());

    $('#edit-attributes tbody tr').remove();

    for (i = 0; i < c.getNumberAttributes(); i++) {
        $(EditItemDialog.prototype.getAttributeRow(i, c.attributes[i])).appendTo('#edit-attributes tbody');
    }

    $('#edit-links tbody tr').remove();

    for (i = 0; i < c.getNumberLinks(); i++) {
        $(EditItemDialog.prototype.getLinkRow(i, connectableId, c.links[i])).appendTo('#edit-links tbody');
    }

    $("#edit-attributes tbody").sortable({
        //placeholder: "ui-state-highlight"
    });

    // Abstracts don't have the repository or form property
    $('#edit-item-repository').parents('label').show();
    $('#edit-item-form').parents('label').show();
    $('#edit-item-controller').parents('label').show();
    $('#edit-item-fixtures').parents('label').show();
    if (EditItemDialog.prototype.connectable instanceof Abstract) {
        $('#edit-item-repository').parents('label').hide();
        $('#edit-item-form').parents('label').hide();
        $('#edit-item-controller').parents('label').hide();
        $('#edit-item-fixtures').parents('label').hide();
        $('#edit-item-crud').parents('label').hide();
    }

    this.loadProgrammingTab();

    $('#edit-item-dialog').dialog('open');
};

EditItemDialog.prototype.deleteAttribute = function (attributeId, rowId) {
    EditItemDialog.prototype.attributesToDelete.push(attributeId);

    $('#delete' + rowId).parents('tr').remove();
};

EditItemDialog.prototype.deleteLink = function (linkId, rowId) {
    EditItemDialog.prototype.linksToDelete.push(linkId);

    $('#deleteLink' + rowId).parents('tr').remove();

    // Remove attribute rows for those attributes that were inherited
    var link = Link.prototype.links[linkId];

    if (link.getType() == 'Inheritance' && link.from == this.connectable.getId()) {
        var parentAttributes = Connectable.prototype.connectables[link.to].attributes;

        for (var k = 0; k < parentAttributes.length; k++)
            for (var j in this.connectable.attributes) {
                var attribute = Attribute.prototype.attributes[this.connectable.attributes[j]];

                if (attribute instanceof InheritedAttribute && attribute.getParentId() == parentAttributes[k]) {
                    $("#edit-attributes td[name=" + attribute.getId() + "]").parents('tr').remove();
                    break;
                }


            }
    }
};

EditItemDialog.prototype.performDeletionLinks = function () {
    var linkId;

    for (var i = 0; i < EditItemDialog.prototype.linksToDelete.length; i++) {
        linkId = EditItemDialog.prototype.linksToDelete[i];

        Draggy.prototype.removeLink(linkId);
    }
};

EditItemDialog.prototype.performDeletionAttributes = function () {
    var attributeId;

    for (var i = 0; i < EditItemDialog.prototype.attributesToDelete.length; i++) {
        attributeId = EditItemDialog.prototype.attributesToDelete[i];

        EditItemDialog.prototype.connectable.deleteAttribute(attributeId);
    }
};

EditItemDialog.prototype.getLinkRow = function (rowId, connectableId, linkId) {
    var link = Link.prototype.links[linkId];
    var type = link.getType();
    var target;
    var targetAttribute;
    var sourceAttribute;
    var inheritance = false;

    if (link.from === connectableId) {
        target = link.getTo();
        targetAttribute = link.getToAttribute();
        sourceAttribute = link.getFromAttribute();

        if (type === 'Inheritance') {
            type = 'Inherits from';
            inheritance = true;
        }
    }
    else {
        if (type === 'OneToMany') {
            type = 'ManyToOne';
        }
        else if (type === 'Inheritance') {
            type = 'Inherited by';
            inheritance = true;
        }

        target = link.getFrom();
        targetAttribute = link.getFromAttribute();
        sourceAttribute = link.getToAttribute();
    }

    target = Connectable.prototype.connectables[target].getName();

    if (inheritance) {
        targetAttribute = '';
        sourceAttribute = '';
    }
    else {
        targetAttribute = Attribute.prototype.attributes[targetAttribute].getName();
        sourceAttribute = Attribute.prototype.attributes[sourceAttribute].getName();
    }

    return  '<tr>' +
                '<td name="' + link.getId() + '">' + rowId + '</td>' +
                '<td>' + linkId + '</td>' +
                '<td>' + sourceAttribute + '</td>' +
                '<td>' + type + '</td>' +
                '<td>' + target + (targetAttribute == '' ? '' : '.' + targetAttribute) + '</td>' +
                '<td align="center">' +
                    '<input id="broken' + rowId + '" type="checkbox"'+ ( link.getBroken() ? ' checked="checked"' : '' ) + '">' +
                '</td>' +
                '<td><input id="deleteLink' + rowId + '" type="button" value="D" onClick="EditItemDialog.prototype.deleteLink(\'' + linkId + '\',' + rowId + ');"></td>' +
            '</tr>';
};

EditItemDialog.prototype.hideSizeBox = function (event) {
    var i = event.data;
    var sizeBox = $('#size' + i);

    if ($('#type' + i).val() === 'string') {
        sizeBox.show();
    }
    else {
        sizeBox.hide();
        sizeBox.val('');
    }
};

EditItemDialog.prototype.hideDefaultBox = function (event) {
    var i = event.data;
    var defaultBox = $('#default' + i);

    if (!$('#autoincrement' + i).is(':checked')) {
        defaultBox.show();
    }
    else {
        defaultBox.hide();
        defaultBox.val('');
    }
};

EditItemDialog.prototype.hideNullBox = function (event) {
    var i = event.data;
    var nullBox = $('#null' + i);

    if (!$('#primary' + i).is(':checked') && !$('#unique' + i).is(':checked') ) {
        nullBox.show();
    }
    else {
        nullBox.hide();
        nullBox.removeAttr('checked');
    }
};

EditItemDialog.prototype.getAttributeRow = function (rowId, attributeId) {
    var attribute;

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
           '<input id="size' + rowId + '" type="text" size="2" value="' + ( attribute.getSize() == null ? '' : attribute.getSize() ) + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + (attribute.getType() !== 'string' ? ' style="display:none;"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        '<input id="null' + rowId + '" type="checkbox"'+ ( attribute.getNull() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + (attribute.getPrimary() || attribute.getUnique() ? ' style="display:none;"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        '<input id="primary' + rowId + '" type="checkbox"'+ ( attribute.getPrimary() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() || ( attribute.getPrimary() && attribute.getNumberLinks() != 0 ) ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        //'<td align="center">' +
        //'<input id="foreign' + rowId + '" type="checkbox" disabled="disabled"'+ ( attribute.getForeign() ? ' checked="checked"' : '' ) + '">' +
        //'</td>' +
        '<td align="center">' +
        '<input id="autoincrement' + rowId + '" type="checkbox"'+ ( attribute.getAutoincrement() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        '<input id="unique' + rowId + '" type="checkbox"'+ ( attribute.getUnique() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        '<input id="default' + rowId + '" type="text" size="7" value="' + ( attribute.getDefault() == null ? '' : attribute.getDefault() ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + (attribute.getAutoincrement() ? ' style="display:none;"' : '' ) + '>' +
        '</td>' +
        '<td align="center">' +
        '<input id="description' + rowId + '" type="text" size="15" value="' + ( attribute.getDescription() == null ? '' : attribute.getDescription() ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        (attribute.getInherited() || attribute.getNumberLinks() != 0 ? '' : '<input id="delete' + rowId + '" type="button" value="D" onClick="EditItemDialog.prototype.deleteAttribute(\'' + attribute.getId() + '\',' + rowId + ');">') +
        '</td>' +
        '</tr>';

    $('#edit-attributes').on('change','#type' + rowId,rowId,EditItemDialog.prototype.hideSizeBox).on('keyup','#type' + rowId,rowId,EditItemDialog.prototype.hideSizeBox);
    $('#edit-attributes').on('click','#autoincrement' + rowId,rowId,EditItemDialog.prototype.hideDefaultBox);
    $('#edit-attributes').on('click','#primary' + rowId,rowId,EditItemDialog.prototype.hideNullBox);
    $('#edit-attributes').on('click','#unique' + rowId,rowId,EditItemDialog.prototype.hideNullBox);

    return row;
};

EditItemDialog.prototype.getProgrammingAttributeRow = function (rowId, attributeId) {
    var attribute;

    attribute = Attribute.prototype.attributes[attributeId];

    return   '<tr>' +
        '<td>' +
            attribute.getName() +
        '</td>' +
        '<td align="center">' +
        ( attribute.getAutoincrement() ? '' : '<input id="setter' + rowId + '" type="checkbox"'+ ( attribute.getSetter() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' ) +
        '</td>' +
        '<td align="center">' +
        '<input id="getter' + rowId + '" type="checkbox"'+ ( attribute.getGetter() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td align="center">' +
        ( attribute.getType() === 'string' ? '<input id="minsize' + rowId + '" type="text" size="2" value="' + ( attribute.getMinSize() == null ? '' : attribute.getMinSize() ) + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + '>' : '' ) +
        '</td>' +

        '<td align="center">' +
        ( attribute.getType() === 'string' ? '<input id="email' + rowId + '" type="checkbox"'+ ( attribute.getEmail() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' : '' ) +
        '</td>' +

        '<td align="center">' +
        ( !attribute.getAutoincrement() && ( attribute.getType() === 'integer' || attribute.getType() == 'smallint' ) ? '<input id="min' + rowId + '" type="text" size="2" value="' + ( attribute.getMin() == null ? '' : attribute.getMin() ) + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + '>' : '' ) +
        '</td>' +

        '<td align="center">' +
        ( !attribute.getAutoincrement() && ( attribute.getType() === 'integer' || attribute.getType() == 'smallint' ) ? '<input id="max' + rowId + '" type="text" size="2" value="' + ( attribute.getMax() == null ? '' : attribute.getMax() ) + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + '>' : '' ) +
        '</td>' +

        '</tr>';
};

EditItemDialog.prototype.commitChanges = function () {
    var newName = $('#edit-item-dialog input[name=name]').val();

    var c = EditItemDialog.prototype.connectable;

    EditItemDialog.prototype.performDeletionLinks();
    EditItemDialog.prototype.performDeletionAttributes();

    // Change name
    if (c.getName() !== newName) {
        c.setName(newName);
    }

    if ($('#edit-item-tostring').val() != '')
        c.setToString($('#edit-item-tostring').val());

    if (EditItemDialog.prototype.connectable instanceof Class) {
        c.setRepository( $('#edit-item-repository').is(':checked') );
        c.setForm( $('#edit-item-form').is(':checked') );
        c.setController( $('#edit-item-controller').is(':checked') );
        c.setFixtures( $('#edit-item-fixtures').is(':checked') );
        c.setCrud( $('#edit-item-crud').val());
    }

    if ($('#edit-item-dialog input[name=description]').val() != '')
        c.setDescription($('#edit-item-dialog input[name=description]').val());


    var a, l, j;

    for (j = 0; j < c.getNumberAttributes(); j++) {
        a  = c.getAttribute(j);

        if (!a.getInherited()) {
            a.setName( $('#name' + j).val() );
            a.setType( $('#type' + j).val() );
            a.setSize( $('#size' + j).val() );
            a.setNull( $('#null' + j).is(':checked') );
            a.setPrimary( $('#primary' + j).is(':checked') );
            a.setAutoincrement( $('#autoincrement' + j).is(':checked') );
            a.setUnique( $('#unique' + j).is(':checked') );
            a.setDefault( $('#default' + j).val() );
            a.setDescription( $('#description' + j).val() );

            var setter =  $('#setter' + j);
            if (setter.length > 0)
                a.setSetter( setter.is(':checked') );

            var getter = $('#getter' + j);
            if (getter.length > 0)
                a.setGetter( getter.is(':checked'));

            var minSize = $('#minsize' + j)
            if (minSize.length > 0)
                a.setMinSize(minSize.val());

            var email = $('#email' + j)
            if (email.length > 0)
                a.setEmail(email.is(':checked'));

            var min = $('#min' + j)
            if (min.length > 0)
                a.setMin(min.val());

            var max = $('#max' + j)
            if (max.length > 0)
                a.setMax(max.val());
        }
    }

    for (j = 0; j < c.getNumberLinks(); j++) {
        l  = c.getLink(j);

        l.setBroken( $('#broken' + j).is(':checked'));

        l.forceRender = true;
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
    var a = new Attribute('unnamed');

    $(EditItemDialog.prototype.getAttributeRow(
        EditItemDialog.prototype.connectable.getNumberAttributes(),
        a.getId()
    )).appendTo('#edit-item-dialog #edit-attributes tbody');

    EditItemDialog.prototype.connectable.addAttribute(a);
};

EditItemDialog.prototype.loadProgrammingTab = function () {
    $('#edit-item-tostring option').remove();

    var a, i;
    var c = EditItemDialog.prototype.connectable;
    var repository, form, controller, fixtures, crud;

    // Repository

    if (c instanceof Class) {
        repository = $('#edit-item-repository');
        form = $('#edit-item-form');
        controller = $('#edit-item-controller');
        fixtures = $('#edit-item-fixtures');
        crud = $('#edit-item-crud');

        if (c.getRepository())
            repository.attr('checked','checked');
        else
            repository.removeAttr('checked');
        repository.button('refresh');

        if (c.getForm())
            form.attr('checked','checked');
        else
            form.removeAttr('checked');
        form.button('refresh');

        if (c.getController())
            controller.attr('checked','checked');
        else
            controller.removeAttr('checked');
        controller.button('refresh');

        if (c.getFixtures())
            fixtures.attr('checked','checked');
        else
            fixtures.removeAttr('checked');
        fixtures.button('refresh');

        if (c.getCrud() !== null)
            crud.val(c.getCrud());
        else
            crud.val('');
    }

    // ToString

    var currentToString = c.getToString();

    $('<option value=""' + (currentToString == null ? ' selected="selected"' : '') + '>--None--</option>').appendTo('#edit-item-tostring');

    for (i = 0; i < c.getNumberAttributes(); i++) {
        a = c.getAttribute(i);

        $('<option value="' + a.getId() + '"' + (currentToString == a.getId() ? ' selected="selected"' : '') + '>' + a.getName() + '</option>').appendTo('#edit-item-tostring');
    }

    // Attributes

    $('#edit-programming-attributes tbody tr').remove();

    for (i = 0; i < c.getNumberAttributes(); i++)
        $(EditItemDialog.prototype.getProgrammingAttributeRow(i,c.attributes[i])).appendTo('#edit-programming-attributes tbody');

};