Connectable.prototype = new ScreenItem();           // Inheritance
Connectable.prototype.constructor = Connectable;

Connectable.prototype.connectables = {};

function Connectable() { }

Connectable.prototype.innitConnectable = function (desiredId) {
    this.innitScreenItem(desiredId);
    this.connectors = [[],[],[],[]];
    this.connectorsSide = {};
    this.attributes = [];
    this.module = '';
    this.links = [];

    Connectable.prototype.connectables[this.id] = this;
};

Connectable.prototype.setName = function (desiredName) {
    this.name = this.getValidName('Connectable',desiredName);
};

Connectable.prototype.destroyConnectable = function () {
    for (var j = 0; j < 4; j++)
        while (this.connectors[j].length > 0) {
            Link.prototype.links[this.connectors[j][0]].remove();
        }

    delete Connectable.prototype.connectables[this.id];
    this.destroyScreenItem();
};

Connectable.prototype.makeInteractive = function () {
    var id = this.getId(); // Later it will be out of context
    var hashId = this.getHashId();

    // Make it draggable
    $(this.hashId).draggable({
        grid: [ 1,1 ],
        //handle: 'div.handle',
        drag: function () {
            Item.prototype.items[id].reDrawLinks();
        },
        stop: function () {
            Item.prototype.items[id].reDrawLinks();
        }
    });

    // Hover controls
    $(this.hashId).hover(
        function () {
            $(hashId + ' > .controls').show();
        },
        function () {
            $(hashId + ' > .controls').hide();
        }
    );

    // Edit dialog
    $(this.hashId).dblclick(function () {
        EditItemDialog.prototype.openDialog(id);
    });

    // Control clicks
    $(this.hashId + ' .controls .linkConnectable').click(function () {
        LinkClassDialog.prototype.openDialog(id);
    });

    $(this.hashId + ' .controls .removeConnectable').click(function () {
        Draggy.prototype.removeConnectable(id);
    });
};

Connectable.prototype.calculateMiddlePoints = function () {
    this.x = $(this.hashId).offset().left;
    this.y = $(this.hashId).offset().top;

    this.width = parseInt($(this.hashId).outerWidth());
    this.height = parseInt($(this.hashId).outerHeight());

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

Connectable.prototype.clearConnectors = function () {
    this.connectors = [[],[],[],[]];
};

Connectable.prototype.addConnector = function (side, linkId) {
    this.connectors[side].push(linkId);

    // If it exists is because is a self-connector, etc
    this.connectorsSide[linkId] = side;
    this.links.push(linkId);

    for (var i = 0; i < this.connectors[side].length - 1; i++)
        Link.prototype.links[this.connectors[side][i]].reLocate(); // Needs to be redrawn since it position is now different
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
    this.calculateMiddlePoints();
    this.markLinksToBeRedrawn();
    Link.prototype.reDrawLinks();
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

    if (this.children) {
        for (var i = 0; i < this.children.length; i++)
            Connectable.prototype.connectables[this.children[i]].reDraw();
    }

    if (this instanceof Class && this.isPureManyToMany())
        $(this.getHashId()).addClass('manyToMany');
    else
        $(this.getHashId()).removeClass('manyToMany');
};

Connectable.prototype.setModule = function (module) {
    if (this.module != '')
        Container.prototype.containers[this.module].removeObject(this.id);

    this.module = module;

    if (this.module != '') {
        var c = Container.prototype.containers[this.module];

        c.addObject(this.id);
        var x = $(this.hashId).offset().left - $(c.hashId).offset().left;
        var y = $(this.hashId).offset().top - $(c.hashId).offset().top;
        $(this.hashId).appendTo(c.hashId);
        this.moveTo(x,y);
        this.calculateMiddlePoints();
    }
    else {
        $(this.hashId).appendTo('body');
    }

};

Connectable.prototype.getModule = function () {
    return this.module;
};

Connectable.prototype.getLinkX = function (name, side) {
    var total = this.connectors[side].length;

    for (i = 0; i < total; i++)
        if (this.connectors[side][i] == name) {
            if (this.id == Link.prototype.links[name].to )
                var ret = this.getMultipleLinkX(side,Link.prototype.links[name].positionTo);
            else
                var ret =  this.getMultipleLinkX(side,Link.prototype.links[name].positionFrom);
        }

    return ret;
};

Connectable.prototype.getLinkY = function (name, side) {
    var total = this.connectors[side].length;

    for (i = 0; i < total; i++)
        if (this.connectors[side][i] == name) {
            if (this.id == Link.prototype.links[name].to )
                return this.getMultipleLinkY(side,Link.prototype.links[name].positionTo);
            else
                return this.getMultipleLinkY(side,Link.prototype.links[name].positionFrom);
        }
};

Connectable.prototype.getMultipleLinkX = function (side, positionOnSide) {
    var total = this.connectors[side].length + 1;

    switch (parseInt(side)) {
        case 0: return Math.round( this.x + (positionOnSide + 1) * this.width / total );
        case 1: return this.x + this.width;
        case 2: return Math.round( this.x + ( total - ( positionOnSide + 1 ) ) * this.width / total );
        case 3: return this.x;
    }
};

Connectable.prototype.getMultipleLinkY = function (side, positionOnSide) {
    var total = this.connectors[side].length + 1;

    switch (parseInt(side)) {
        case 0: return this.y;
        case 1: return Math.round( this.y + ( positionOnSide + 1 ) * this.height / total );
        case 2: return this.y + this.height;
        case 3: return Math.round( this.y + ( total - ( positionOnSide + 1) ) * this.height / total );
    }
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

    for (i = 0; i < 4; i++)
        for (j = 0; j < this.connectors[i].length; j++)
            Link.prototype.links[this.connectors[i][j]].needsRedraw = true;
};

Connectable.prototype.getIdFromName = function (name) {
    for (var i in Connectable.prototype.connectables)
        if (Connectable.prototype.connectables[i].getName() == name)
            return Connectable.prototype.connectables[i].getId();

    return null;
};

Connectable.prototype.getConnectableFromName = function (name) {
    return Item.prototype.items[this.getIdFromName(name)];
};

Connectable.prototype.addAttribute = function (attribute) {
    attribute.setOwner(this.getId());

    this.attributes.push(attribute.getId());

    if (this.children) {
        for (var i = 0; i < this.children.length; i++) {
            var ia = new InheritedAttribute(attribute.getId());

            Connectable.prototype.connectables[this.children[i]].addInheritedAttribute(ia);
        }
    }
};

Connectable.prototype.addInheritedAttribute = function (attribute) {
    this.attributes.push(attribute.getId());

    if (this.children) {
        for (var i = 0; i < this.children.length; i++) {
            var ia = new InheritedAttribute(attribute.getParentId());

            Connectable.prototype.connectables[this.children[i]].addInheritedAttribute(ia);
        }
    }
};

Connectable.prototype.removeInheritedAttribute = function (parentAttribute) {
    var i, attribute;

    for (i = 0; i < this.attributes.length; i++) {
        attribute = Attribute.prototype.attributes[this.attributes[i]];

        if (attribute instanceof InheritedAttribute && attribute.getParentId() == parentAttribute.getId()) {
            // This is the inherited attribute
            this.attributes.remove(attribute.getId());
            attribute.remove();
            break;
        }
    }



    //this.attributes.remove(parentAttribute.getId());

    if (this.children) {
        for (i = 0; i < this.children.length; i++) {
            Connectable.prototype.connectables[this.children[i]].removeInheritedAttribute(parentAttribute);
        }
    }
};

Connectable.prototype.deleteAttribute = function (attributeId) {
    this.attributes.remove(attributeId);

    if (this.children) {
        for (var i = 0; i < this.children.length; i++)
            Connectable.prototype.connectables[this.children[i]].deleteInheritedAttribute(attributeId);
    }
};

Connectable.prototype.deleteInheritedAttribute = function (attributeId) {
    var attributeToRemove = null;

    for (var i = 0; i < this.getNumberAttributes(); i++)
        if (this.getAttribute(i) instanceof InheritedAttribute && this.getAttribute(i).getParentId() == attributeId)
            attributeToRemove = this.getAttribute(i).getId();

    if (attributeToRemove != null) {
        this.attributes.remove(attributeToRemove);

        if (this.children) {
            for (var i = 0; i < this.children.length; i++)
                Connectable.prototype.connectables[this.children[i]].deleteInheritedAttribute(attributeId);
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