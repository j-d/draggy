Connectable.prototype = new ScreenItem();           // Inheritance
Connectable.prototype.constructor = Connectable;

Connectable.prototype.connectables = {};
Connectable.prototype.connectableList = [];

function Connectable() { }

Connectable.prototype.innitConnectable = function (desiredId, container) {
    this.innitScreenItem(desiredId);
    this.connectors = [[],[],[],[]];
    this.connectorsSide = {};
    this.attributes = [];
    this.module = '';
    this.links = [];
    this.dependantAttributes = [];
    this.type = null;

    Connectable.prototype.connectables[this.id] = this;
    Connectable.prototype.connectableList.push(this);

    if (container !== undefined) {
        var c = Container.prototype.getContainerByName(container);
        c.addObject(this.id);
        this.setModule(c.getId());
    }
};

Connectable.prototype.setName = function (desiredName) {
    var dependantAttribute;

    this.name = this.getValidName('Connectable', desiredName, this.getFolder());

    for (var i = 0; i < this.dependantAttributes.length; i++) {
        dependantAttribute = Attribute.prototype.attributes[this.dependantAttributes[i]];
        dependantAttribute.setSubtype(this.getFullyQualifiedName());
        Connectable.prototype.connectables[dependantAttribute.getOwner()].reDraw();
    }
};

Connectable.prototype.destroyConnectable = function () {
    for (var j = 0; j < 4; j++) {
        while (this.connectors[j].length > 0) {
            Link.prototype.links[this.connectors[j][0]].remove();
        }
    }

    delete Connectable.prototype.connectables[this.id];
    Connectable.prototype.connectableList.remove(this);

    this.destroyScreenItem();
};

Connectable.prototype.makeInteractive = function () {
    var id = this.getId(); // Later it will be out of context
    var hashId = this.getHashId();
    var connectable = $(this.hashId);

    // Make it draggable
    connectable.draggable({
        grid: [ 1,1 ],
        //handle: 'div.handle',
        drag: function () {
            Connectable.prototype.connectables[id].reDrawLinks();
        },
        stop: function () {
            var item = Item.prototype.items[id];

            item.reDrawLinks();

            if (item.getModule() !== '') {
                Container.prototype.containers[item.getModule()].adjustMinimumSizes();
            }
        }
    });

    // Hover controls
    connectable.hover(
        function () {
            $(hashId + ' > .controls').show();
        },
        function () {
            $(hashId + ' > .controls').hide();
        }
    );

    // Edit dialog
    connectable.dblclick(function (event) {
        EditItemDialog.prototype.openDialog(id);

        event.stopImmediatePropagation();
    });

    // Control clicks
    connectable.find('.controls .linkConnectable').click(function () {
        LinkClassDialog.prototype.openDialog(id);
    });

    connectable.find('.controls .removeConnectable').click(function () {
        Draggy.prototype.removeConnectable(id);
    });
};

Connectable.prototype.calculateMiddlePoints = function () {
    var connectable = $(this.hashId);

    this.x = connectable.offset().left;
    this.y = connectable.offset().top;

    this.width = parseInt(connectable.outerWidth());
    this.height = parseInt(connectable.outerHeight());

    this.middleX = Math.round(this.x + this.width / 2);
    this.middleY = Math.round(this.y + this.height / 2);

    this.leftMiddleX =   this.x;
    this.leftMiddleY =   Math.round(this.y + this.height / 2);

    this.rightMiddleX =  this.x + this.width;
    this.rightMiddleY =  this.leftMiddleY;

    this.topMiddleX =    Math.round(this.x + this.width / 2);
    this.topMiddleY =    this.y;

    this.bottomMiddleX = this.topMiddleX;
    this.bottomMiddleY = this.y + this.height;
};

Connectable.prototype.addConnector = function (side, linkId) {
    this.connectors[side].push(linkId);

    // If it exists is because is a self-connector, etc
    this.connectorsSide[linkId] = side;
    this.links.push(linkId);

    for (var i = 0; i < this.connectors[side].length - 1; i++) {
        Link.prototype.links[this.connectors[side][i]].reLocate(); // Needs to be redrawn since it position is now different
        Link.prototype.links[this.connectors[side][i]].draw(); // Needs to be redrawn since it position is now different
    }
};

Connectable.prototype.removeConnector = function (linkId) {
    var side = this.connectorsSide[linkId];
    var i;

    this.links.remove(linkId);

    if (side != undefined) {    // The link existed
        var tempConnectors = this.connectors[side];
        this.connectors[side] = [];

        // Add the rest to the side
        for (i = 0; i < tempConnectors.length; i++)
            if (tempConnectors[i] != linkId)
                this.connectors[side].push(tempConnectors[i]);

        // Tells them to relocate (once they are all added!!)
        for (i = 0; i < this.connectors[side].length; i++)
            Link.prototype.links[this.connectors[side][i]].reLocate(); // Needs to be redrawn since it position now maybe different
    }
};

Connectable.prototype.reDrawLinks = function () {
    Link.prototype.reDrawConnectableLinks(this);
};

Connectable.prototype.reDraw = function () {
    $(this.hashId).html(
        //'<div class="handle"></div>' +
        '<div class="name">' + this.getName() + '</div>' +
            '<div class="attributes">' + this.attributesToHtml() + '</div>' +
            '<div class="controls" style="display: none;">' +
            '<span style="float: left;" class="ui-icon ui-icon-closethick removeConnectable"></span>' +
            '<span style="float: left;" class="ui-icon ui-icon-link linkConnectable"></span>' +
        '</div>'
    );

    this.calculateMiddlePoints();

    this.makeInteractive();

    if (undefined !== this.children && this.children.length > 0) {
        for (var i = 0; i < this.children.length; i++) {
            Connectable.prototype.connectables[this.children[i]].reDraw();
        }
    }

    if (this instanceof Class && this.isPureManyToMany()) {
        $(this.getHashId()).addClass('manyToMany');
    } else {
        $(this.getHashId()).removeClass('manyToMany');
    }
};

Connectable.prototype.setModule = function (module) {
    if (this.module !== module) {
        var x, y;
        var hadModule = false;

        if (this.module !== '') {
            Container.prototype.containers[this.module].removeObject(this.id);
            hadModule = true;
        }

        this.module = module;

        if (this.module !== '') {
            var c = Container.prototype.containers[this.module];

            c.addObject(this.id);

            if (this.getDrawn()) {
                x = $(this.getHashId()).offset().left - $(c.getHashId()).offset().left;
                y = $(this.getHashId()).offset().top - $(c.getHashId()).offset().top;
                $(this.hashId).appendTo(c.hashId);
                this.moveTo(x,y);
                this.calculateMiddlePoints();
            }
        }
        else if (this.getDrawn()) {
            var $draggyArea = $('#draggy-area');

            if (hadModule) {
                x = $(this.getHashId()).offset().left - $draggyArea.offset().left;
                y = $(this.getHashId()).offset().top - $draggyArea.offset().top;
            }

            $(this.getHashId()).appendTo($draggyArea);

            if (hadModule) {
                this.moveTo(x,y);
                this.calculateMiddlePoints();
            }
        }

        // Set its name again in case there was another item on that module with the same name
        var currentName = this.getName();
        this.setName(currentName);
        if (currentName !== this.getName()) {
            this.reDraw();
        }
    }

    return this;
};

Connectable.prototype.getModule = function () {
    return this.module;
};

Connectable.prototype.getLinkX = function (name, side) {
    var total = this.connectors[side].length;
    var ret;

    for (var i = 0; i < total; i++) {
        if (this.connectors[side][i] == name) {
            if (this.id == Link.prototype.links[name].to ) {
                ret = this.getMultipleLinkX(side,Link.prototype.links[name].positionTo);
            }
            else {
                ret =  this.getMultipleLinkX(side,Link.prototype.links[name].positionFrom);
            }
        }
    }

    return ret;
};

Connectable.prototype.getLinkY = function (name, side) {
    var total = this.connectors[side].length;
    var ret;

    for (var i = 0; i < total; i++) {
        if (this.connectors[side][i] == name) {
            if (this.id == Link.prototype.links[name].to )
                ret = this.getMultipleLinkY(side,Link.prototype.links[name].positionTo);
            else
                ret = this.getMultipleLinkY(side,Link.prototype.links[name].positionFrom);
        }
    }

    return ret;
};

Connectable.prototype.getMultipleLinkX = function (side, positionOnSide) {
    var total = this.connectors[side].length + 1;

    switch (parseInt(side)) {
        case 0: return Math.round( this.x + (positionOnSide + 1) * this.width / total );
        case 1: return this.x + this.width;
        case 2: return Math.round( this.x + ( total - ( positionOnSide + 1 ) ) * this.width / total );
        case 3: return this.x;
    }

    return null;
};

Connectable.prototype.getMultipleLinkY = function (side, positionOnSide) {
    var total = this.connectors[side].length + 1;

    switch (parseInt(side)) {
        case 0: return this.y;
        case 1: return Math.round( this.y + ( positionOnSide + 1 ) * this.height / total );
        case 2: return this.y + this.height;
        case 3: return Math.round( this.y + ( total - ( positionOnSide + 1) ) * this.height / total );
    }

    return null;
};

Connectable.prototype.attributesToHtml = function () {
    var ret = '';

    for (var i = 0; i < this.getNumberAttributes(); i++) {
        ret += this.getAttribute(i).toHtml();

        if (i < this.getNumberAttributes() - 1)
            ret += '<br>';
    }

    return ret;
};

Connectable.prototype.getNumberAttributes = function () {
    return this.attributes.length;
};

Connectable.prototype.getAttribute = function (i) {
    return Attribute.prototype.attributes[this.attributes[i]];
};

Connectable.prototype.assignPositions = function (side) {
    var nConnectors = this.connectors[side].length;

    if ( nConnectors > 0 ) {
        if ( nConnectors == 1 ) {   // If is only one I don't need to calculate all the distances
            link = Link.prototype.links[this.connectors[side][0]];

            if (link.from == this.id)
                Link.prototype.links[link.id].positionFrom  = 0;
            else
                Link.prototype.links[link.id].positionTo = 0;

            return;
        }

        var unassignedConnectors = [];
        var unassignedAnchors = [];
        var i, j;
        var link;
        var distances = [];
        var anchorsX = [];
        var anchorsY = [];

        for (i = 0; i < nConnectors; i++) {
            unassignedConnectors.push(i);
            unassignedAnchors.push(i);
            distances[i] = [];

            for (j = 0; j < nConnectors; j++) {
                anchorsX[j] = this.getMultipleLinkX(side,j);
                anchorsY[j] = this.getMultipleLinkY(side,j);
            }
        }

        // Calculate all the distances
        for (i = 0; i < unassignedConnectors.length; i++)
            for (j=0; j < unassignedAnchors.length; j++) {
                link = Link.prototype.links[this.connectors[side][i]];

                if (link.from == this.id)
                    distances[i][j] = distance(anchorsX[j],anchorsY[j],Item.prototype.items[link.to].middleX,Item.prototype.items[link.to].middleY);
                else
                    distances[i][j] = distance(anchorsX[j],anchorsY[j],Item.prototype.items[link.from].middleX,Item.prototype.items[link.from].middleY);
            }

        var minDistance;
        var minConnectorIndex;
        var minAnchorIndex;

        // While there are unassigned anchors
        while (unassignedAnchors.length > 0) {
            minConnectorIndex = 0;
            minAnchorIndex = 0;
            minDistance = distances[unassignedConnectors[minConnectorIndex]][unassignedAnchors[minAnchorIndex]];

            //debug('supongo que el minimo es ' + minDistance + ' en ' + minConnectorIndex + ' ' + minAnchorIndex)

            for (i = 0; i < unassignedConnectors.length; i++) {
                for (j=0; j < unassignedAnchors.length; j++) {
                    if (distances[unassignedConnectors[i]][unassignedAnchors[j]] < minDistance) {
                        minDistance = distances[unassignedConnectors[i]][unassignedAnchors[j]];
                        minConnectorIndex = i;
                        minAnchorIndex = j;

                        //debug('he encontrado otro menor ' + minDistance + ' en ' + minConnectorIndex + ' ' + minAnchorIndex);
                    }
                }
            }

            link = Link.prototype.links[this.connectors[side][unassignedConnectors[minConnectorIndex]]];
            //debug(unassignedAnchors[minAnchorIndex]);
            //debug(link.id);

            // The one with the minimum distance gets the assigned
            if (link.from == this.id)
                Link.prototype.links[link.id].positionFrom  = unassignedAnchors[minAnchorIndex];
            else
                Link.prototype.links[link.id].positionTo = unassignedAnchors[minAnchorIndex];

            // The link and the anchor that gets it leaves the pending arrays
            unassignedConnectors[minConnectorIndex] = unassignedConnectors[unassignedConnectors.length - 1];
            unassignedConnectors.pop();

            // The link and the anchor that gets it leaves the pending arrays
            unassignedAnchors[minAnchorIndex] = unassignedAnchors[unassignedAnchors.length - 1];
            unassignedAnchors.pop();
        }
    }
};

Connectable.prototype.markLinksToBeRedrawn = function () {
    var i, j;

    for (i = 0; i < 4; i++) {
        for (j = 0; j < this.connectors[i].length; j++) {
            Link.prototype.links[this.connectors[i][j]].setNeedsRedraw(true);
        }
    }
};

Connectable.prototype.getIdFromName = function (name) {
    var ambiguous = false;
    var id = null;
    var i;

    for (i = 0; i < Connectable.prototype.connectableList.length; i++) {
        if (Connectable.prototype.connectableList[i].getFullyQualifiedName() == name) {
            if (id !== null) {
                ambiguous = true;
            }
            id = Connectable.prototype.connectableList[i].getId();
        }
    }

    if (!ambiguous) {
        // TODO : Remove this backwards compatibility
        // Start of to be removed
        if (id !== null) {
            return id;
        }

        for (i = 0; i < Connectable.prototype.connectableList.length; i++) {
            if (Connectable.prototype.connectableList[i].getName() == name) {
                if (id !== null) {
                    ambiguous = true;
                }
                id = Connectable.prototype.connectableList[i].getId();
            }
        }

        if (!ambiguous) {
            if (id === null) {
                throw new NameNotFoundException(name);
            }

            return id;
        } else {
            throw new AmbiguousNameException;
        }

        // End of to be removed
        // Reinstate:
        // if (id === null) {
        //     throw new NameNotFoundException(name);
        // }
        //
        // return id;
        // End of to be reinstated
    } else {
        throw new AmbiguousNameException;
    }
};

Connectable.prototype.getConnectableFromName = function (name) {
    return Item.prototype.items[this.getIdFromName(name)];
};

Connectable.prototype.getValidAttributeName = function (desiredName, attribute) {
    var valid = true;
    var i;

    for (i = 0; i < this.attributes.length; i++) {
        if (Attribute.prototype.attributes[this.attributes[i]].getId() !== attribute.getId() && Attribute.prototype.attributes[this.attributes[i]].getName() === desiredName) {
            valid = false;
            break;
        }
    }

    if (valid) {
        return desiredName;
    }

    var number = 1;

    while (!valid) {
        valid = true;

        for (i = 0; i < this.attributes.length; i++) {
            if (Attribute.prototype.attributes[this.attributes[i]].getId() !== attribute.getId() && Attribute.prototype.attributes[this.attributes[i]].getName() === desiredName + number) {
                valid = false
            }
        }

        if (valid) {
            return desiredName + number;
        }

        number++;
    }

    return null;
};

Connectable.prototype.addAttribute = function (attribute) {
    attribute.setOwner(this.getId());

    // Check that the name does not exist already
    var currentName = attribute.getName();
    attribute.setName(currentName);

    this.attributes.push(attribute.getId());

    if (undefined !== this.children && this.children.length > 0) {
        for (var i = 0; i < this.children.length; i++) {
            var ia = new InheritedAttribute(attribute.getId());

            Connectable.prototype.connectables[this.children[i]].addInheritedAttribute(ia);
        }
    }
};

Connectable.prototype.addInheritedAttribute = function (attribute) {
    this.attributes.push(attribute.getId());

    if (this.children.length > 0) {
        for (var i = 0; i < this.children.length; i++) {
            var ia = new InheritedAttribute(attribute.getParentId());

            Connectable.prototype.connectables[this.children[i]].addInheritedAttribute(ia);
        }
    }
};

Connectable.prototype.removeInheritedAttribute = function (parentAttribute) {
    var i, attribute;

    if (this.children.length > 0) {
        for (i = 0; i < this.children.length; i++) {
            Connectable.prototype.connectables[this.children[i]].removeInheritedAttribute(parentAttribute);
        }
    }

    for (i = 0; i < this.attributes.length; i++) {
        attribute = Attribute.prototype.attributes[this.attributes[i]];

        if (attribute instanceof InheritedAttribute && attribute.getParentId() == parentAttribute.getId()) {
            // This is the inherited attribute
            this.attributes.remove(attribute.getId());
            attribute.remove();
            break;
        }
    }
};

Connectable.prototype.deleteAttribute = function (attributeId) {
    this.attributes.remove(attributeId);

    if (this.children.length > 0) {
        for (var i = 0; i < this.children.length; i++)
            Connectable.prototype.connectables[this.children[i]].deleteInheritedAttribute(attributeId);
    }
};

Connectable.prototype.deleteInheritedAttribute = function (attributeId) {
    var attributeToRemove = null;
    var i;

    for (i = 0; i < this.getNumberAttributes(); i++) {
        if (this.getAttribute(i) instanceof InheritedAttribute && this.getAttribute(i).getParentId() == attributeId) {
            attributeToRemove = this.getAttribute(i).getId();
        }
    }

    if (attributeToRemove != null) {
        this.attributes.remove(attributeToRemove);

        if (this.children.length > 0) {
            for (i = 0; i < this.children.length; i++) {
                Connectable.prototype.connectables[this.children[i]].deleteInheritedAttribute(attributeId);
            }
        }

        this.reDrawLinks();
    }
};

Connectable.prototype.getAttributeFromName = function (attributeName) {
    for (var i = 0; i < this.attributes.length; i++)
        if (Attribute.prototype.attributes[this.attributes[i]].getName() == attributeName)
            return this.attributes[i];

    alert('Error: ' + this.getName() + ' does not have an attribute called ' + attributeName);

    return null;
};

Connectable.prototype.getNumberLinks = function () {
    return this.links.length;
};

Connectable.prototype.getLink = function (i) {
    return Link.prototype.links[this.links[i]];
};

Connectable.prototype.getFullyQualifiedName = function () {
    if (this.getModule() === '') {
        return this.getName();
    } else {
        return Container.prototype.containers[this.getModule()].getFullyQualifiedName() + '\\' + this.getName();
    }
};

Connectable.prototype.getFolder = function () {
    if (this.getModule() === '') {
        return '';
    } else {
        return Container.prototype.containers[this.getModule()].getFullyQualifiedName();
    }
};

Connectable.prototype.addDependantAttribute = function (attribute) {
    this.dependantAttributes.push(attribute);

    return this;
};

Connectable.prototype.removeDependantAttribute = function (attribute) {
    this.dependantAttributes.remove(attribute);

    return this;
};

Connectable.prototype.getType = function () {
    return this.type;
};