function LinkClassDialog () {
}

LinkClassDialog.prototype.connectable = null;

LinkClassDialog.prototype.innit = function () {
    $('#link-item-dialog select[name=type]').change(function () {
        if ($('#link-item-dialog select[name=type]').val() != 'Inheritance') {
            $('#link-item-dialog .attribute-selector').show();
            //LinkClassDialog.prototype.populateOptions('#link-item-dialog select[name=sourceAttribute]',$('#link-item-dialog input[name=class]').val(),true);
            //LinkClassDialog.prototype.populateOptions('#link-item-dialog select[name=destinationAttribute]',$('#link-item-dialog select[name=destinationItem]').val());
        }
        else
            $('#link-item-dialog .attribute-selector').hide();
    });

    // Change when changing target
    $('#link-item-dialog select[name=destinationItem]').change(function () {
        LinkClassDialog.prototype.populateOptions('#link-item-dialog select[name=destinationAttribute]',$('#link-item-dialog select[name=destinationItem]').val());
    });
};

LinkClassDialog.prototype.openDialog = function (connectableId) {
    var c = LinkClassDialog.prototype.connectable = Connectable.prototype.connectables[connectableId];
    var i;

    // Remove previous dropdowns
    $('#link-item-dialog select[name=destinationItem] option').remove();
    $('#link-item-dialog select[name=type] option').remove();

    // Add other items
    for (i in Connectable.prototype.connectables)
        if (Connectable.prototype.connectables[i].getId() != connectableId)
            $('<option value="' + Connectable.prototype.connectables[i].getName() + '">' + Connectable.prototype.connectables[i].getName() + '</option>').appendTo($('#link-item-dialog select[name=destinationItem]'));

    // Add types
    for (i = 0; i < Config.prototype.relationships.length; i++)
        if ( Config.prototype.relationships[i].internalName != 'Inheritance' || c.getInheritedFrom() == null )
            $('<option value="' + Config.prototype.relationships[i].internalName + '">' + Config.prototype.relationships[i].nameSelf + '</option>').appendTo($('#link-item-dialog select[name=type]'));

    //$('#link-class-name-dialog input[name=name]').attr('value',$(this.hashId + ' .name').html());
    $('#link-item-dialog input[name=class]').attr('value',c.getName());

    // Populate options for the first time
    LinkClassDialog.prototype.populateOptions('#link-item-dialog select[name=sourceAttribute]',$('#link-item-dialog input[name=class]').val(),true);
    LinkClassDialog.prototype.populateOptions('#link-item-dialog select[name=destinationAttribute]',$('#link-item-dialog select[name=destinationItem]').val());

    $('#link-item-dialog').dialog('open');
};

LinkClassDialog.prototype.createLink = function () {
    var source = Connectable.prototype.getConnectableFromName($('#link-item-dialog input[name=class]').val());
    var destination = Connectable.prototype.getConnectableFromName($('#link-item-dialog select[name=destinationItem]').val());
    var type = $('#link-item-dialog select[name=type]').val();

    if (type != 'Inheritance') {
        var sourceAttribute = Attribute.prototype.attributes[$('#link-item-dialog select[name=sourceAttribute]').val()];

        var destinationAttribute = $('#link-item-dialog select[name=destinationAttribute]').val();

        if (destinationAttribute == '**new**') {
            destinationAttribute = new Attribute('');
            destinationAttribute.copyFrom(sourceAttribute);
            destinationAttribute.setName(source.getName() + '_' + sourceAttribute.getName());
            destinationAttribute.setPrimary(false);
            destinationAttribute.setAutoincrement(false);
            destinationAttribute.setForeign(true);
            destination.addAttribute(destinationAttribute);
        }
        else {
            destinationAttribute = Attribute.prototype.attributes[destinationAttribute];
            var name = destinationAttribute.getName();
            destinationAttribute.copyFrom(sourceAttribute);
            destinationAttribute.setName(name);
            destinationAttribute.setPrimary(false);
            destinationAttribute.setAutoincrement(false);
            destinationAttribute.setForeign(true);
        }

        Draggy.prototype.addLink(
            source.getName(),
            destination.getName(),
            type,
            sourceAttribute.getName(),
            destinationAttribute.getName()
        );

        destination.reDraw();
    }
    else {
        Draggy.prototype.addLink(
            source.getName(),
            destination.getName(),
            type
        );
    }

    Link.prototype.reDrawLinks();
};

LinkClassDialog.prototype.populateOptions = function (select,itemName,key) {
    if (key == undefined)
        key = false;

    var s = $(select);
    var item = Connectable.prototype.getConnectableFromName(itemName);
    var attribute;

    s.children().remove();

    if (!key)
        s.append('<option value="**new**">** New attribute **</option>');

    for (var i = 0; i < item.getNumberAttributes(); i++) {
        attribute = item.getAttribute(i);

        if (key) {
            if (attribute.getPrimary())
                s.append('<option value="' + attribute.getId() + '">' + attribute.getName() + '</option>');
        }
        else {
            if (!attribute.getForeign())
                s.append('<option value="' + attribute.getId() + '">' + attribute.getName() + '</option>');
        }
    }
};

