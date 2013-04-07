function EditItemDialog() {
}

EditItemDialog.prototype.connectable = null;
EditItemDialog.prototype.attributesToDelete = [];
EditItemDialog.prototype.linksToDelete = [];

EditItemDialog.prototype.openDialog = function (connectableId) {
    var i;
    var dialogAttributes = $('#edit-attributes');

    EditItemDialog.prototype.attributesToDelete = [];
    EditItemDialog.prototype.linksToDelete = [];

    var c = EditItemDialog.prototype.connectable = Connectable.prototype.connectables[connectableId];

    $('#edit-item-name').attr('value', c.getName());
    $('#edit-item-description').attr('value', c.getDescription());

    dialogAttributes.find('tbody tr').remove();

    for (i = 0; i < c.getNumberAttributes(); i++) {
        $(EditItemDialog.prototype.getAttributeRow(i, c.attributes[i])).appendTo('#edit-attributes tbody');

        $('#delete' + i).click({attributeId: c.attributes[i], rowId: i}, function (event) {
            EditItemDialog.prototype.deleteAttribute(event.data.attributeId, event.data.rowId);
        });
    }

    $('#edit-links').find('tbody tr').remove();

    for (i = 0; i < c.getNumberLinks(); i++) {
        $(EditItemDialog.prototype.getLinkRow(i, connectableId, c.links[i])).appendTo('#edit-links tbody');

        $('#deleteLink' + i).click({linkId: c.links[i], rowId: i}, function (event) {
            EditItemDialog.prototype.deleteLink(event.data.linkId, event.data.rowId);
        });
    }

    dialogAttributes.find('tbody').sortable({
        //placeholder: "ui-state-highlight"
    });
    
    var repository = $('#edit-item-repository').parents('label');
    var form = $('#edit-item-form').parents('label');
    var controller = $('#edit-item-controller').parents('label');
    var fixtures = $('#edit-item-fixtures').parents('label');
    var crud = $('#edit-item-crud').parents('label');

    // Abstracts don't have the repository or form property
    repository.show();
    form.show();
    controller.show();
    fixtures.show();
    crud.show();
    if (EditItemDialog.prototype.connectable instanceof Abstract) {
        repository.hide();
        form.hide();
        controller.hide();
        fixtures.hide();
        crud.hide();
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

    var j, k;

    // If I am destroying an inheritance link, remove the inherited attributes from the Attributes tab
    if (link.getType() === 'Inheritance' && link.from === this.connectable.getId()) {
        var parentAttributes = Connectable.prototype.connectables[link.to].attributes;

        for (k = 0; k < parentAttributes.length; k++)
            for (j = 0; j < this.connectable.attributes.length; j++) {
                var attribute = Attribute.prototype.attributes[this.connectable.attributes[j]];

                if (attribute instanceof InheritedAttribute && attribute.getParentId() === parentAttributes[k]) {
                    $("#edit-attributes").find("td[data-name=" + attribute.getId() + "]").parents('tr').remove();
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
        if (!Draggy.prototype.options.linkClasses) {
            targetAttribute = Attribute.prototype.attributes[targetAttribute].getName();
        } else {
            targetAttribute = '';
        }

        if (Draggy.prototype.options.linkClasses) {
            sourceAttribute = '';
        } else {
            sourceAttribute = Attribute.prototype.attributes[sourceAttribute].getName();
        }
    }

    return  '<tr>' +
                '<td data-name="' + link.getId() + '">' + rowId + '</td>' +
                '<td>' + linkId + '</td>' +
                '<td>' + sourceAttribute + '</td>' +
                '<td>' + type + '</td>' +
                '<td>' + target + (targetAttribute == '' ? '' : '.' + targetAttribute) + '</td>' +
                '<td class="center">' +
                    '<input id="broken' + rowId + '" type="checkbox"'+ ( link.getBroken() ? ' checked="checked"' : '' ) + '">' +
                '</td>' +
                '<td><input id="deleteLink' + rowId + '" type="button" value="D"></td>' +
            '</tr>';
};

EditItemDialog.prototype.hideSizeBox = function (event) {
    var i = event.data;
    var $sizeBox = $('#size' + i);

    if ($('#type' + i).val() === 'string') {
        $sizeBox.show();
    } else {
        $sizeBox.val('').hide();
    }
};

EditItemDialog.prototype.hideSubtypeBox = function (event) {
    var i = event.data;
    var $subtypeBox = $('#subtype' + i);
    var $typeBox = $('#type' + i);

    if ($typeBox.val() === 'array' || $typeBox.val() === 'object') {
        $subtypeBox.show();
    } else {
        $subtypeBox.val('').hide();
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
    var attribute, i;

    attribute = Attribute.prototype.attributes[attributeId];

    var row =   '<tr>' +
        '<td data-name="' + attribute.getId() + '">' + rowId + '</td>' +
        '<td class="center">' +
        '<input id="name' + rowId + '" type="text" size="12" value="' +  attribute.getName() + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td>' +
        '<select id="type' + rowId + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + '>' +
        '<option value=""' + (attribute.getType() == null ? ' selected="selected"' : '') + '></option>';

    for (i = 0; i < Config.prototype.types.length; i++)
        row += '<option value="' + Config.prototype.types[i] + '"' + (attribute.getType() == Config.prototype.types[i] ? ' selected="selected"' : '') + '>' + Config.prototype.types[i] + '</option>';

    row += '</select>' +
        '<select id="subtype' + rowId + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + (attribute.getType() !== 'object' && attribute.getType() !== 'array' ? ' style="display:none;"' : '') + '>' +
        '<option value=""' + (attribute.getType() == null ? ' selected="selected"' : '') + '></option>';

    for (i = 0; i < Config.prototype.types.length; i++)
        row += '<option value="' + Config.prototype.types[i] + '"' + (attribute.getSubtype() == Config.prototype.types[i] ? ' selected="selected"' : '') + '>' + Config.prototype.types[i] + '</option>';

    for (i = 0; i < Connectable.prototype.connectableList.length; i++)
        row += '<option value="' + Connectable.prototype.connectableList[i].getFullyQualifiedName() + '"' + (attribute.getSubtype() == Connectable.prototype.connectableList[i].getFullyQualifiedName() ? ' selected="selected"' : '') + '>' + Connectable.prototype.connectableList[i].getFullyQualifiedName() + '</option>';

    row +=              '</select>' +
        //'</td>' +
        //'<td class="center">' +
           '<input id="size' + rowId + '" type="text" size="2" value="' + ( attribute.getSize() == null ? '' : attribute.getSize() ) + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + (attribute.getType() !== 'string' ? ' style="display:none;"' : '') + '>' +
        '</td>' +
        '<td class="center">' +
        '<input id="null' + rowId + '" type="checkbox"'+ ( attribute.getNull() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + (attribute.getPrimary() || attribute.getUnique() ? ' style="display:none;"' : '') + '>' +
        '</td>' +
        '<td class="center">' +
        '<input id="primary' + rowId + '" type="checkbox"'+ ( attribute.getPrimary() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() || ( attribute.getPrimary() && attribute.getNumberLinks() != 0 ) ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        //'<td class="center">' +
        //'<input id="foreign' + rowId + '" type="checkbox" disabled="disabled"'+ ( attribute.getForeign() ? ' checked="checked"' : '' ) + '">' +
        //'</td>' +
        '<td class="center">' +
        '<input id="autoincrement' + rowId + '" type="checkbox"'+ ( attribute.getAutoincrement() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td class="center">' +
        '<input id="unique' + rowId + '" type="checkbox"'+ ( attribute.getUnique() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td class="center">' +
        '<input id="default' + rowId + '" type="text" size="7" value="' + ( attribute.getDefault() == null ? '' : attribute.getDefault() ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + (attribute.getAutoincrement() ? ' style="display:none;"' : '' ) + '>' +
        '</td>' +
        '<td class="center">' +
        '<input id="description' + rowId + '" type="text" size="15" value="' + ( attribute.getDescription() == null ? '' : attribute.getDescription() ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td class="center">' +
        (attribute.getInherited() || attribute.getNumberLinks() != 0 ? '' : '<input id="delete' + rowId + '" type="button" value="D">') +
        '</td>' +
    '</tr>';

    var editAttributes = $('#edit-attributes');

    editAttributes.on('change','#type' + rowId,rowId,EditItemDialog.prototype.hideSizeBox).on('keyup','#type' + rowId,rowId,EditItemDialog.prototype.hideSizeBox);
    editAttributes.on('change','#type' + rowId,rowId,EditItemDialog.prototype.hideSubtypeBox).on('keyup','#type' + rowId,rowId,EditItemDialog.prototype.hideSubtypeBox);
    editAttributes.on('click','#autoincrement' + rowId,rowId,EditItemDialog.prototype.hideDefaultBox);
    editAttributes.on('click','#primary' + rowId,rowId,EditItemDialog.prototype.hideNullBox);
    editAttributes.on('click','#unique' + rowId,rowId,EditItemDialog.prototype.hideNullBox);

    return row;
};

EditItemDialog.prototype.getProgrammingAttributeRow = function (rowId, attributeId) {
    var attribute;

    attribute = Attribute.prototype.attributes[attributeId];

    return   '<tr>' +
        '<td>' +
            attribute.getName() +
        '</td>' +
        '<td class="center">' +
        ( attribute.getAutoincrement() ? '' : '<input id="setter' + rowId + '" type="checkbox"'+ ( attribute.getSetter() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' ) +
        '</td>' +
        '<td class="center">' +
        '<input id="getter' + rowId + '" type="checkbox"'+ ( attribute.getGetter() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' +
        '</td>' +
        '<td class="center">' +
        ( attribute.getType() === 'string' ? '<input id="minSize' + rowId + '" type="text" size="2" value="' + ( attribute.getMinSize() == null ? '' : attribute.getMinSize() ) + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + '>' : '' ) +
        '</td>' +

        '<td class="center">' +
        ( attribute.getType() === 'string' ? '<input id="email' + rowId + '" type="checkbox"'+ ( attribute.getEmail() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' : '' ) +
        '</td>' +

        '<td class="center">' +
        ( !attribute.getAutoincrement() && ( attribute.getType() === 'integer' || attribute.getType() == 'smallint' ) ? '<input id="min' + rowId + '" type="text" size="2" value="' + ( attribute.getMin() == null ? '' : attribute.getMin() ) + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + '>' : '' ) +
        '</td>' +

        '<td class="center">' +
        ( !attribute.getAutoincrement() && ( attribute.getType() === 'integer' || attribute.getType() == 'smallint' ) ? '<input id="max' + rowId + '" type="text" size="2" value="' + ( attribute.getMax() == null ? '' : attribute.getMax() ) + '"' + (attribute.getInherited() || attribute.getForeign() ? ' disabled="disabled"' : '') + '>' : '' ) +
        '</td>' +
        '<td class="center">' +
        ( attribute.getAutoincrement() ? '' : '<input id="static' + rowId + '" type="checkbox"'+ ( attribute.getStatic() ? ' checked="checked"' : '' ) + '"' + (attribute.getInherited() ? ' disabled="disabled"' : '') + '>' ) +
        '</td>' +

        '</tr>';
};

EditItemDialog.prototype.commitChanges = function () {
    var newName = $('#edit-item-name').val();

    var c = EditItemDialog.prototype.connectable;

    // Change name
    if (c.getName() !== newName) {
        c.setName(newName);
    }

    var toString = $('#edit-item-tostring');
    var description = $('#edit-item-description');

    if (toString.val() != '') {
        c.setToString(toString.val());
    }

    c.setConstructor( $('#edit-item-constructor').is(':checked') );

    if (EditItemDialog.prototype.connectable instanceof Class) {
        c.setRepository( $('#edit-item-repository').is(':checked') );
        c.setForm( $('#edit-item-form').is(':checked') );
        c.setController( $('#edit-item-controller').is(':checked') );
        c.setFixtures( $('#edit-item-fixtures').is(':checked') );
        c.setCrud( $('#edit-item-crud').val());
        c.setRoutes( $('#edit-item-routes').is(":checked"));
    }

    if (description.val() != '') {
        c.setDescription(description.val());
    }

    var a, l, j;

    for (j = 0; j < c.getNumberAttributes(); j++) {
        a  = c.getAttribute(j);

        if (!a.getInherited()) {
            a.setName( $('#name' + j).val() );
            a.setType( $('#type' + j).val() );
            a.setSubtype( $('#subtype' + j).val() );
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

            var minSize = $('#minSize' + j);
            if (minSize.length > 0)
                a.setMinSize(minSize.val());

            var email = $('#email' + j);
            if (email.length > 0)
                a.setEmail(email.is(':checked'));

            var min = $('#min' + j);
            if (min.length > 0)
                a.setMin(min.val());

            var max = $('#max' + j);
            if (max.length > 0)
                a.setMax(max.val());

            var stat = $('#static' + j);
            if (stat.length > 0)
                a.setStatic( stat.is(':checked'));
        }
    }

    for (j = 0; j < c.getNumberLinks(); j++) {
        l  = c.getLink(j);

        l.setBroken( $('#broken' + j).is(':checked'));

        l.forceRender = true;
    }

    // Perform changes after potential changes have been saved
    EditItemDialog.prototype.performDeletionLinks();
    EditItemDialog.prototype.performDeletionAttributes();


    // Re-save the attributes in order in case they were reordered
    c.attributes = [];

    var rows = $("#edit-attributes").find("tbody tr td:first-child");
    var attributeId;

    for (var i = 0; i < rows.length; i++) {
        attributeId = $(rows[i]).attr('data-name');

        if (Attribute.prototype.attributes[attributeId] !== undefined) {
            c.attributes.push(attributeId);
        }
    }

    // Redraw
    c.reDraw();
    c.reDrawLinks();
};

EditItemDialog.prototype.addAttribute = function () {
    var a = new Attribute('unnamed');
    var rowId = EditItemDialog.prototype.connectable.getNumberAttributes();

    EditItemDialog.prototype.connectable.addAttribute(a);

    $(EditItemDialog.prototype.getAttributeRow(
        rowId,
        a.getId()
    )).appendTo('#edit-item-dialog #edit-attributes tbody');

    $('#delete' + rowId).click({attributeId: a.getId(), rowId: rowId}, function (event) {
        EditItemDialog.prototype.deleteAttribute(event.data.attributeId, event.data.rowId);
    });
};

EditItemDialog.prototype.loadProgrammingTab = function () {
    $("#edit-item-tostring").find("option").remove();

    var a, i;
    var c = EditItemDialog.prototype.connectable;
    var $constructor, $repository, $form, $controller, $fixtures, $crud, $routes;

    // Repository

    if (c instanceof Class) {
        $constructor = $('#edit-item-constructor');
        $repository = $('#edit-item-repository');
        $form = $('#edit-item-form');
        $controller = $('#edit-item-controller');
        $fixtures = $('#edit-item-fixtures');
        $crud = $('#edit-item-crud');
        $routes = $("#edit-item-routes");

        if (c.getConstructor()) {
            $constructor.attr('checked','checked');
        } else {
            $constructor.removeAttr('checked');
        }
        $constructor.button('refresh');

        if (c.getRepository()) {
            $repository.attr('checked','checked');
        } else {
            $repository.removeAttr('checked');
        }
        $repository.button('refresh');

        if (c.getForm()) {
            $form.attr('checked','checked');
        } else {
            $form.removeAttr('checked');
        }
        $form.button('refresh');

        if (c.getController()) {
            $controller.attr('checked','checked');
        } else {
            $controller.removeAttr('checked');
        }
        $controller.button('refresh');

        if (c.getFixtures()) {
            $fixtures.attr('checked','checked');
        } else {
            $fixtures.removeAttr('checked');
        }
        $fixtures.button('refresh');

        if (c.getCrud() !== null) {
            $crud.val(c.getCrud());
        } else {
            $crud.val('');
        }

        // Routes
        if (c.getConstructor()) {
            $constructor.attr('checked','checked');
        } else {
            $constructor.removeAttr('checked');
        }
        if ($("#edit-item-crud").val() != '') {
            $routes.parents("label").first().show();
        } else {
            $routes.parents("label").first().hide();
        }

        if (c.getRoutes()) {
            $routes.attr("checked", "checked");
        } else {
            $routes.removeAttr("checked");
        }
    }

    // ToString

    var currentToString = c.getToString();

    $('<option value=""' + (currentToString == null ? ' selected="selected"' : '') + '>--None--</option>').appendTo('#edit-item-tostring');

    for (i = 0; i < c.getNumberAttributes(); i++) {
        a = c.getAttribute(i);

        $('<option value="' + a.getId() + '"' + (currentToString == a.getId() ? ' selected="selected"' : '') + '>' + a.getName() + '</option>').appendTo('#edit-item-tostring');
    }

    // Attributes

    $("#edit-programming-attributes").find("tbody tr").remove();

    for (i = 0; i < c.getNumberAttributes(); i++) {
        $(EditItemDialog.prototype.getProgrammingAttributeRow(i,c.attributes[i])).appendTo('#edit-programming-attributes tbody');
    }
};