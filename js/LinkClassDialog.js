function LinkClassDialog () {
}

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
    // Remove previous select items
    $('#link-item-dialog select[name=destinationItem] option').remove();

    // Add other items
    for (var i in Connectable.prototype.connectables)
        $('<option value="' + Connectable.prototype.connectables[i].getName() + '">' + Connectable.prototype.connectables[i].getName() + '</option>').appendTo($('#link-item-dialog select[name=destinationItem]'));

    //$('#link-class-name-dialog input[name=name]').attr('value',$(this.hashId + ' .name').html());
    $('#link-item-dialog input[name=class]').attr('value',Connectable.prototype.connectables[connectableId].getName());

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
            destinationAttribute.setForeign(true);
            destination.addAttribute(destinationAttribute);
        }
        else {
            destinationAttribute = Attribute.prototype.attributes[destinationAttribute];
            var name = destinationAttribute.getName();
            destinationAttribute.copyFrom(sourceAttribute);
            destinationAttribute.setName(name);
            destinationAttribute.setPrimary(false);
            destinationAttribute.setForeign(true);
        }

        destination.reDraw();

        addLink(
            source.getName(),
            destination.getName(),
            type,
            sourceAttribute.getName(),
            destinationAttribute.getName()
        );
    }
    else {
        addLink(
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
            s.append('<option value="' + attribute.getId() + '">' + attribute.getName() + '</option>');
        }
    }
};

