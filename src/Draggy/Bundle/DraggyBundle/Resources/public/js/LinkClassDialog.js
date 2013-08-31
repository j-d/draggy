function LinkClassDialog () {
}

LinkClassDialog.prototype.connectable = null;

LinkClassDialog.prototype.innit = function () {
    $('#link-item-type').change(function () {
        var relationshipTypes = Draggy.prototype.getRelationshipTypes();

        var thisRelationship = relationshipTypes[$('#link-item-type').val()];

        var attributeSelectors = $('#link-item-dialog').find('.attribute-selector');

        if (!thisRelationship['connect-entity']) {
            attributeSelectors.show();
            //LinkClassDialog.prototype.populateOptions('#link-item-dialog select[name=sourceAttribute]',$('#link-item-dialog input[name=class]').val(),true);
            //LinkClassDialog.prototype.populateOptions('#link-item-dialog select[name=destinationAttribute]',$('#link-item-dialog select[name=destinationItem]').val());

            if (Draggy.prototype.options.linkClasses) {
                $('#link-item-source').parents('.attribute-selector').hide();
            }
        } else {
            attributeSelectors.hide();
        }
    });

    // Change when changing target
    $('#link-item-destination-class').change(function () {
        LinkClassDialog.prototype.populateOptions(
            '#link-item-dialog select[name=destinationAttribute]',
            $('#link-item-destination-class').val()
        );
    });
};

LinkClassDialog.prototype.openDialog = function (connectableId) {
    var
        c = LinkClassDialog.prototype.connectable = Connectable.prototype.connectables[connectableId],
        i,
        $destinationAttribute = $('#link-item-destination'),
        $destinationClass = $('#link-item-destination-class'),
        $sourceClass = $('#link-item-source-class'),
        $type = $('#link-item-type'),
        $dialog = $('#link-item-dialog');

    // Show attribute selectors
    $dialog.find('.attribute-selector').show();

    // Remove previous dropdowns
    $destinationClass.find('option').remove();
    $destinationAttribute.find('option').remove();
    $type.find('option').remove();

    // Add other connectables
    for (i = 0; i < Connectable.prototype.connectableList.length; i++) {
        //if (Connectable.prototype.connectableList[i].getId() != connectableId) {
            $('<option value="' + Connectable.prototype.connectableList[i].getFullyQualifiedName() + '">' + Connectable.prototype.connectableList[i].getFullyQualifiedName() + '</option>').appendTo($destinationClass);
        //}
    }

    // Add types
    var relationshipTypes = Draggy.prototype.getRelationshipTypes();

    for (i in relationshipTypes) {
        if ( relationshipTypes[i].name !== 'Inheritance' || c.getInheritedFrom() == null ) {
            $('<option value="' + i + '">' + relationshipTypes[i]['direct-name'] + '</option>').appendTo($type);
        }
    }

    $sourceClass.attr('value', c.getFullyQualifiedName());

    // Populate options for the first time
    LinkClassDialog.prototype.populateOptions('#link-item-source',$sourceClass.val(),true);
    LinkClassDialog.prototype.populateOptions('#link-item-destination',$destinationClass.val());

    if (Draggy.prototype.options.linkClasses) {
        $('#link-item-source').parents('.attribute-selector').hide();
    }

    $dialog.dialog('open');
};

LinkClassDialog.prototype.createLink = function () {
    var $sourceSelector = $('#link-item-source');
    var $destinationSelector = $('#link-item-destination');
    var source = Connectable.prototype.getConnectableFromName($('#link-item-source-class').val());
    var destination = Connectable.prototype.getConnectableFromName($('#link-item-destination-class').val());
    var type = $('#link-item-type').val();

    if (type !== 'Inheritance') {
        var sourceAttribute;
        var destinationAttribute = $destinationSelector.val();

        if (destinationAttribute == '**new**') {
            destinationAttribute = new Attribute('');
            if (!Draggy.prototype.options.linkClasses) {
                sourceAttribute = Attribute.prototype.attributes[$sourceSelector.val()];
                destinationAttribute.copyFrom(sourceAttribute);
                destinationAttribute.setName(source.getName() + '_' + sourceAttribute.getName());
            } else {
                destinationAttribute.setName(source.getName() + '_autoName');
            }

            destinationAttribute.setPrimary(false);
            destinationAttribute.setAutoincrement(false);
            destinationAttribute.setForeign(true);
            destination.addAttribute(destinationAttribute);
        }
        else {
            destinationAttribute = Attribute.prototype.attributes[destinationAttribute];
            if (!Draggy.prototype.options.linkClasses) {
                sourceAttribute = Attribute.prototype.attributes[$sourceSelector.val()];
                var name = destinationAttribute.getName();
                destinationAttribute.copyFrom(sourceAttribute);
                destinationAttribute.setName(name);
            }

            destinationAttribute.setPrimary(false);
            destinationAttribute.setAutoincrement(false);
            destinationAttribute.setForeign(true);
        }

        if (Draggy.prototype.options.linkClasses) {
            Draggy.prototype.addLink(
                source.getFullyQualifiedName(),
                destination.getFullyQualifiedName(),
                type,
                undefined,
                destinationAttribute.getName()
            );
        } else {
            Draggy.prototype.addLink(
                source.getFullyQualifiedName(),
                destination.getFullyQualifiedName(),
                type,
                sourceAttribute.getName(),
                destinationAttribute.getName()
            );
        }

        destination.reDraw();
    }
    else { // Type == inheritance
        if (source.canInheritFrom(destination)) {
            Draggy.prototype.addLink(
                source.getFullyQualifiedName(),
                destination.getFullyQualifiedName(),
                type
            );
        } else {
            alert('The entity ' + source.getName() + ' cannot inherit from the entity ' + destination.getName() + ' because there is at least one attribute with the same name on it or any of its descendants.');
        }
    }

    Link.prototype.reDrawLinks();
};

LinkClassDialog.prototype.populateOptions = function (select,itemName,key) {
    if (key == undefined)
        key = false;

    var s = $(select);
    var item = Connectable.prototype.getConnectableFromName(itemName);
    var attribute;

    s.find('option').remove();

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

