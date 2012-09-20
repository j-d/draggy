function Item () {
}

Item.prototype.items = {};              // Static associative array
Item.prototype.itemIdsByName = {};      // Static associative array

Item.prototype.innit = function (desiredId) {
    this.id = getUniqueId(desiredId);

    this.hashId = '#' + this.id;
    this.connectors = [[],[],[],[]];
    this.connectorsSide = {};
    this.inheritingFrom = null;

    Item.prototype.items[this.id] = this;
    Item.prototype.itemIdsByName[this.name] = this.id;

    this.attributes = [];
    this.module = '';
};

Item.prototype.getIdFromName = function(name) {
    return Item.prototype.itemIdsByName[name];
};

Item.prototype.getNameFromId = function(id) {
    return Item.prototype.items[id].getName();
}

Item.prototype.getItemByName = function(name) {
    return Item.prototype.items[Item.prototype.itemIdsByName[name]];
};

Item.prototype.getId = function () {
    return this.id;
};

Item.prototype.setName = function (desiredName) {
    var newName = this.getValidName(desiredName);

    delete(Item.prototype.itemIdsByName[this.name]);
    Item.prototype.itemIdsByName[newName] = this.id;

    this.name = newName;
};

Item.prototype.getName = function () {
    return this.name;
};

Item.prototype.setModule = function (module) {
    if (this.module != '')
        Container.prototype.containers[this.module].removeObject(this.id);

    this.module = module;

    if (this.module != '') {
        var c = Container.prototype.containers[this.module];

        c.addObject(this.id);
        var x = $(this.hashId).offset().left - $(c.hashId).offset().left;
        var y = $(this.hashId).offset().top - $(c.hashId).offset().top;
        $(this.hashId).appendTo(c.hashId);
        $(this.hashId).css('left',x);
        $(this.hashId).css('top',y);
    }
    else {
        $(this.hashId).appendTo('body');
    }

};

Item.prototype.getModule = function () {
    return this.module;
};

Item.prototype.calculateMiddlePoints = function () {
    //this.x = parseInt($(this.hashId).css('left'));
    //this.y = parseInt($(this.hashId).css('top'));

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

Item.prototype.moveTo = function(x,y) {
    $(this.hashId).css('left',x);
    $(this.hashId).css('top',y);

    this.calculateMiddlePoints();
};

Item.prototype.move = function(x,y) {
    $(this.hashId).css('left',(parseInt($(this.hashId).css('left')) + x) + 'px');
    $(this.hashId).css('top',(parseInt($(this.hashId).css('top')) + y) + 'px');

    this.calculateMiddlePoints();
};

Item.prototype.clearConnectors = function () {
    this.connectors = [[],[],[],[]];
};

Item.prototype.addConnector = function (side, linkId) {
    this.connectors[side].push(linkId);

    // If it exists is because is a self-connector, etc
    this.connectorsSide[linkId] = side;

    for (var i = 0; i < this.connectors[side].length - 1; i++)
        Link.prototype.links[this.connectors[side][i]].reLocate(); // Needs to be redrawn since it position is now different
};

Item.prototype.removeConnector = function (linkId) {
    var side = this.connectorsSide[linkId];
    var i;

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

Item.prototype.getLinkX = function (name, side) {
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

Item.prototype.getLinkY = function (name, side) {
    var total = this.connectors[side].length;

    for (i = 0; i < total; i++)
        if (this.connectors[side][i] == name) {
            if (this.id == Link.prototype.links[name].to )
                return this.getMultipleLinkY(side,Link.prototype.links[name].positionTo);
            else
                return this.getMultipleLinkY(side,Link.prototype.links[name].positionFrom);
        }
};

Item.prototype.getMultipleLinkX = function (side, positionOnSide) {
    var total = this.connectors[side].length + 1;

    switch (parseInt(side)) {
        case 0: return Math.round( this.x + (positionOnSide + 1) * this.width / total );
        case 1: return this.x + this.width;
        case 2: return Math.round( this.x + ( total - ( positionOnSide + 1 ) ) * this.width / total );
        case 3: return this.x;
    }
};

Item.prototype.getMultipleLinkY = function (side, positionOnSide) {
    var total = this.connectors[side].length + 1;

    switch (parseInt(side)) {
        case 0: return this.y;
        case 1: return Math.round( this.y + ( positionOnSide + 1 ) * this.height / total );
        case 2: return this.y + this.height;
        case 3: return Math.round( this.y + ( total - ( positionOnSide + 1) ) * this.height / total );
    }
};

Item.prototype.assignPositions = function (side) {
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

        /*debug('Matriz distancias:');
        for (i in distances) {
            var linea = '';

            for (j in distances[i])
                linea += Math.round(distances[i][j]*100)/100 + " &nbsp; ";

            debug(linea);
        }*/

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

Item.prototype.markLinksToBeRedrawn = function () {
    var i, j;

    for (i = 0; i < 4; i++)
        for (j = 0; j < this.connectors[i].length; j++)
            Link.prototype.links[this.connectors[i][j]].needsRedraw = true;
};

Item.prototype.getValidName = function (name) {
    var valid = true;
    var i;

    for (i in Item.prototype.items)
        if (Item.prototype.items[i].getName() == name) {
            valid = false;
            break;
        }

    if (valid)
        return name;

    var number = 1;

    while (!valid) {
        valid = true;

        for (i in Item.prototype.items)
            if (Item.prototype.items[i].getName() == name + number) {
                valid = false
            }

        if (valid)
            return name + number;

        number++;
    }
};

Item.prototype.itemRemove = function () {
    for (var i in Item.prototype.items)
        if (Item.prototype.items[i].getName() == this.name) {
            // Remove all links that depended on it
            for (var j = 0; j < 4; j++)
                while (this.connectors[j].length > 0) {
                    removeLink(this.connectors[j][0]);
                }

            $(this.hashId).remove();
            delete Item.prototype.items[i];
            break;
        }
};

Item.prototype.reDrawLinks = function () {
    this.calculateMiddlePoints();
    this.markLinksToBeRedrawn();
    Link.prototype.reDrawLinks();
};

Item.prototype.makeInteractive = function () {
    var name = this.name; // Later it will be out of context

    // Make it draggable
    $(this.hashId).draggable({
        grid: [ 1,1 ],
        //handle: 'div.handle',
        drag: function () {
            Item.prototype.getItemByName(name).reDrawLinks();
        },
        stop: function () {
            Item.prototype.getItemByName(name).reDrawLinks();
        }
    });

    var hashId = this.hashId;
    var id = this.id;

    // Hover controls
    $(this.hashId).hover(
        function () {
            $(hashId + ' .controls').show();
        },
        function () {
            $(hashId + ' .controls').hide();
        }
    );

    // Edit dialog
    $(this.hashId).dblclick(function () {
        $('#edit-item-dialog input[name=name]').attr('value',$(hashId + ' .name').html());
        $('#edit-item-dialog input[name=currentname]').attr('value',$(hashId + ' .name').html());

        $('#edit-item-dialog #edit-attributes tbody tr').remove();

        var item = Item.prototype.items[id];

        for (var i = 0; i < item.attributes.length; i++)
            $(getAttributeRow(
                i,
                item.attributes[i].getName(),
                item.attributes[i].getType(),
                item.attributes[i].getSize(),
                item.attributes[i].getNull(),
                item.attributes[i].getPrimary(),
                item.attributes[i].getForeign(),
                item.attributes[i].getAutoincrement(),
                item.attributes[i].getUnique(),
                item.attributes[i].getDefault(),
                item.attributes[i].getDescription()

            )).appendTo('#edit-item-dialog #edit-attributes tbody');

        $('#edit-item-dialog').dialog('open');
    });

    // Link item
    $(this.hashId + ' .controls .linkClass').click(function () {
        // Remove previous select items
        $('#link-item-dialog select[name=destinationItem] option').remove();

        // Add other items
        for (var i in Item.prototype.items)
            $('<option value="' + Item.prototype.items[i].getName() + '">' + Item.prototype.items[i].getName() + '</option>').appendTo($('#link-item-dialog select[name=destinationItem]'));

        //$('#link-class-name-dialog input[name=name]').attr('value',$(this.hashId + ' .name').html());
        $('#link-item-dialog input[name=class]').attr('value',name);

        $('#link-item-dialog').dialog('open');
    });
};

Item.prototype.addAttribute = function (name, type, size, nul, primary, foreign, autoincrement, unique, def, description) {
    this.attributes.push(new Attribute(name, type, size, nul, primary, foreign, autoincrement, unique, def, description));
    this.reDraw();
};

Item.prototype.attributesToHtml = function () {
    var ret = '';

    if (this.inheritingFrom != null) {
        var parent = Item.prototype.getItemByName(this.inheritingFrom);

        for (var i = 0; i < parent.attributes.length; i++) {
            ret += parent.attributes[i].inheritedToHtml();

            if (i < parent.attributes.length - 1)
                ret += '<br>';
        }

        if (this.attributes.length > 0)
            ret += '<br>';
    }

    for (var i = 0; i < this.attributes.length; i++) {
        ret += this.attributes[i].toHtml();

        if (i < this.attributes.length - 1)
            ret += '<br>';
    }

    return ret;
};

Item.prototype.getNumberAttributes = function () {
    return this.attributes.length;
};

Item.prototype.getAttribute = function (i) {
    return this.attributes[i];
};

Item.prototype.reDraw = function () {
    $(this.hashId).html(
        //'<div class="handle"></div>' +
        '<div class="name">' + this.getName() + '</div>' +
            '<div class="attributes">' + this.attributesToHtml() + '</div>' +
            '<div class="controls" style="display: none;">' +
            '<span style="float: left;" class="ui-icon ui-icon-closethick" onclick="removeClass(\'' + this.getName() + '\')"></span>' +
            '<span style="float: left;" class="ui-icon ui-icon-link linkClass" onclick=""></span>' +
            '</div>'
    );

    this.calculateMiddlePoints();

    this.makeInteractive();
};