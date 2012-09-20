function Link (from, to, type, fromType, toType) {
    this.id = getUniqueId('Link');
    this.hashId = '#' + this.id;

    this.from = Item.prototype.getIdFromName(from);
    this.to = Item.prototype.getIdFromName(to);
    this.type = type;
    this.positionFrom = null;
    this.positionTo = null;
    this.needsRedraw = true;
    this.fromConnector = null;
    this.toConnector = null;
    this.shape = null;

    switch (type) {
        case 'Inheritance':
            this.fromType = null;
            this.toType = 'inheritance';
            Item.prototype.getItemByName(from).inheritingFrom = to;
            Item.prototype.getItemByName(from).reDraw();
            break;
        default:
            this.fromType = fromType;
            this.toType = toType;
            break;
    }

    Link.prototype.links[this.id] = this;
}

Link.prototype.links = {};      // Static associative array

Link.prototype.suffixes = [
    '-top',
    '-right',
    '-bottom',
    '-left'
];

Link.prototype.iconNames = {
    inheritance:    'icon-inheritance',
    one:            'icon-one',
    oneNull:        'icon-one-null',
    manyNull:       'icon-many-null'
};

Link.prototype.getId = function () {
    return this.id;
};

Link.prototype.getFrom = function () {
    return this.from;
};

Link.prototype.getTo = function () {
    return this.to;
};

Link.prototype.getType = function () {
    return this.type;
};

Link.prototype.toXML = function () {
    var ret = '';

    if (this.getType() == 'Inheritance') {
        ret += '<relation ' +
            'from="' + Item.prototype.getNameFromId(this.getFrom()) + '" ' +
            'to="' + Item.prototype.getNameFromId(this.getTo()) + '" ' +
            'type="' + this.getType() + '" />' + '\n';
    }
    else {
        ret += '<relation ' +
            'from="' + Item.prototype.getNameFromId(this.getFrom()) + '" ' +
            'to="' + Item.prototype.getNameFromId(this.getTo()) + '" ' +
            'type="' + this.getType() + '" ' +
            'fromType="' + this.fromType + '" ' +
            'toType="' + this.toType + '" />' + '\n';
    }

    //ret += '</relation>';

    return ret;
};

Link.prototype.reDraw = function () {
    drawLinkObjects(this.id,'class_' + this.from, 'class_' + this.to);
};

Link.prototype.reDrawLinks = function () {
    for (var i in Link.prototype.links)
        if (Link.prototype.links[i].needsRedraw)
            Link.prototype.links[i].reDraw();
};

Link.prototype.reDraw = function () {
    this.calculateDistance();

    Item.prototype.items[this.from].removeConnector(this.id);
    Item.prototype.items[this.to].removeConnector(this.id);

    Item.prototype.items[this.from].addConnector(this.fromConnector,this.id);
    Item.prototype.items[this.to].addConnector(this.toConnector,this.id);

    this.reLocate();

    this.needsRedraw = false;
};

Link.prototype.reLocate = function () {
    Item.prototype.items[this.from].assignPositions(this.fromConnector);
    Item.prototype.items[this.to].assignPositions(this.toConnector);

    this.draw();
};

Link.prototype.remove = function () {
    Item.prototype.items[this.from].removeConnector(this.id);
    Item.prototype.items[this.to].removeConnector(this.id);

    $(this.hashId).remove();
};

Link.prototype.calculateDistance = function () {
    if (this.needsRedraw) {
        var from = Item.prototype.items[this.from];
        var to =  Item.prototype.items[this.to];

        // Connector types
        // 0 = Top
        // 1 = Right
        // 2 = Bottom
        // 3 = Left

        // Minimum distance
        this.minimumDistance = distance(from.rightMiddleX, from.rightMiddleY, to.leftMiddleX, to.leftMiddleY);
        this.fromConnector = 1;
        this.toConnector = 3;

        if ( this.minimumDistance > distance(from.rightMiddleX, from.rightMiddleY, to.bottomMiddleX, to.bottomMiddleY) ) {
            this.minimumDistance = distance(from.rightMiddleX, from.rightMiddleY, to.bottomMiddleX, to.bottomMiddleY);
            this.fromConnector = 1;
            this.toConnector = 2;
        }

        if ( this.minimumDistance > distance(from.rightMiddleX, from.rightMiddleY, to.topMiddleX, to.topMiddleY) ) {
            this.minimumDistance = distance(from.rightMiddleX, from.rightMiddleY, to.topMiddleX, to.topMiddleY);
            this.fromConnector = 1;
            this.toConnector = 0;
        }

        if ( this.minimumDistance > distance(from.topMiddleX, from.topMiddleY, to.bottomMiddleX, to.bottomMiddleY) ) {
            this.minimumDistance = distance(from.topMiddleX, from.topMiddleY, to.bottomMiddleX, to.bottomMiddleY);
            this.fromConnector = 0;
            this.toConnector = 2;
        }

        if ( this.minimumDistance > distance(from.topMiddleX, from.topMiddleY, to.leftMiddleX, to.leftMiddleY) ) {
            this.minimumDistance = distance(from.topMiddleX, from.topMiddleY, to.leftMiddleX, to.leftMiddleY);
            this.fromConnector = 0;
            this.toConnector = 3;
        }

        if ( this.minimumDistance > distance(from.topMiddleX, from.topMiddleY, to.rightMiddleX, to.rightMiddleY) ) {
            this.minimumDistance = distance(from.topMiddleX, from.topMiddleY, to.rightMiddleX, to.rightMiddleY);
            this.fromConnector = 0;
            this.toConnector = 1;
        }

        if ( this.minimumDistance > distance(from.bottomMiddleX, from.bottomMiddleY, to.topMiddleX, to.topMiddleY) ) {
            this.minimumDistance = distance(from.bottomMiddleX, from.bottomMiddleY, to.topMiddleX, to.topMiddleY);
            this.fromConnector = 2;
            this.toConnector = 0;
        }

        if ( this.minimumDistance > distance(from.bottomMiddleX, from.bottomMiddleY, to.leftMiddleX, to.leftMiddleY) ) {
            this.minimumDistance = distance(from.bottomMiddleX, from.bottomMiddleY, to.leftMiddleX, to.leftMiddleY);
            this.fromConnector = 2;
            this.toConnector = 3;
        }

        if ( this.minimumDistance > distance(from.bottomMiddleX, from.bottomMiddleY, to.rightMiddleX, to.rightMiddleY) ) {
            this.minimumDistance = distance(from.bottomMiddleX, from.bottomMiddleY, to.rightMiddleX, to.rightMiddleY);
            this.fromConnector = 2;
            this.toConnector = 1;
        }

        if ( this.minimumDistance > distance(from.leftMiddleX, from.leftMiddleY, to.rightMiddleX, to.rightMiddleY) ) {
            this.minimumDistance = distance(from.leftMiddleX, from.leftMiddleY, to.rightMiddleX, to.rightMiddleY);
            this.fromConnector = 3;
            this.toConnector = 1;
        }

        if ( this.minimumDistance > distance(from.leftMiddleX, from.leftMiddleY, to.topMiddleX, to.topMiddleY) ) {
            this.minimumDistance = distance(from.leftMiddleX, from.leftMiddleY, to.topMiddleX, to.topMiddleY);
            this.fromConnector = 3;
            this.toConnector = 0;
        }

        if ( this.minimumDistance > distance(from.leftMiddleX, from.leftMiddleY, to.bottomMiddleX, to.bottomMiddleY) ) {
            this.minimumDistance = distance(from.leftMiddleX, from.leftMiddleY, to.bottomMiddleX, to.bottomMiddleY);
            this.fromConnector = 3;
            this.toConnector = 2;
        }
    }
};

Link.prototype.draw = function () {
    var fromX = Item.prototype.items[this.from].getLinkX(this.id,this.fromConnector);
    var fromY = Item.prototype.items[this.from].getLinkY(this.id,this.fromConnector);
    var toX = Item.prototype.items[this.to].getLinkX(this.id,this.toConnector);
    var toY = Item.prototype.items[this.to].getLinkY(this.id,this.toConnector);

    var width = Math.abs(toX - fromX);
    var left = Math.min(fromX, toX);
    var height = Math.abs(toY - fromY);
    var top = Math.min(fromY, toY);


    var shape = this.fromConnector * 10 + this.toConnector + (fromX < toX ? 'x0' : 'x1') + (fromY < toY ?  'y0' : 'y1');

    if (shape == this.shape) { // Only needs to be resized
        $(this.hashId).css('top',top).css('left',left).css('width',width).css('height',height);
        return;
    }

    $(this.hashId).remove();

    this.shape = shape;

    // Connector types
    // 0 = Top
    // 1 = Right
    // 2 = Bottom
    // 3 = Left

    var fromConnector = this.fromConnector;
    var toConnector = this.toConnector;

    var firstItem;
    var secondItem;
    var firstType;
    var secondType;

    var fromType = Link.prototype.iconNames[this.fromType] + Link.prototype.suffixes[fromConnector];
    var toType = Link.prototype.iconNames[this.toType] + Link.prototype.suffixes[toConnector];

    var div = '';

    div += '<div id="' + this.id + '" class="connector" style="width: ' + width + 'px; height: ' + height + 'px; left: ' + left + 'px; top: ' + top + 'px;">';

    if ( ( fromConnector == 1 && toConnector == 3 ) || ( fromConnector == 3 && toConnector == 1 ) ) { // Case ¯¯|__ or __|¯¯
        if (fromY < toY ^ fromConnector == 3 ) { // Case ¯¯|__
            firstItem =  'horizontalTopFrom';
            secondItem = 'horizontalBottomTo';
        }
        else { // Case __|¯¯
            firstItem =  'horizontalBottomFrom';
            secondItem = 'horizontalTopTo';
        }

        if (fromConnector == 3) {
            firstType = toType;
            secondType = fromType;
        }
        else {
            firstType = fromType;
            secondType = toType;
        }

        div +=  '<div class="' + firstItem + '">' +
                    '<div class="connectorMarker">' +
                        '<span class="' + firstType + '"></span>' +
                    '</div>' +
                '</div>' +
                '<div class="' + secondItem + '">' +
                    '<div class="connectorMarker">' +
                        '<span class="' + secondType + '"></span>' +
                    '</div>' +
                '</div>';
    }
    else if ( ( fromConnector == 0 && toConnector == 2 ) || ( fromConnector == 2 && toConnector == 0 ) ) { // Case '-, or ,-'
        if ( fromX < toX ^ fromConnector == 2 ) { // Case ,-'
            firstItem = 'verticalTopRight';
            secondItem = 'verticalBottomLeft';
        }
        else { // Case '-,
            firstItem = 'verticalTopLeft';
            secondItem = 'verticalBottomRight';
        }

        if (fromConnector == 0) {
            firstType = toType;
            secondType = fromType;
        }
        else {
            firstType = fromType;
            secondType = toType;
        }

        div +=  '<div class="' + firstItem + '">' +
                    '<div class="connectorMarker">' +
                        '<span class="' + firstType + '"></span>' +
                    '</div>' +
                '</div>' +
                '<div class="' + secondItem + '">' +
                    '<div class="connectorMarker">' +
                        '<span class="' + secondType + '"></span>' +
                    '</div>' +
                '</div>';
    } else { // Corner
        if ( ( fromConnector == 1 && toConnector == 0 ) || ( fromConnector == 0 && toConnector == 1 ) ) { // Case ¯¯|
            firstItem = 'cornerTopRight';

            if (fromConnector == 0) {
                firstType = toType;
                secondType = fromType;
            }
            else {
                firstType = fromType;
                secondType = toType;
            }
        }
        else if ( ( fromConnector == 1 && toConnector == 2 ) || ( fromConnector == 2 && toConnector == 1 ) ) { // Case _|
            firstItem = 'cornerBottomRight';

            if (fromConnector == 2) {
                firstType = toType;
                secondType = fromType;
            }
            else {
                firstType = fromType;
                secondType = toType;
            }
        }
        else if ( ( fromConnector == 0 && toConnector == 3 ) || ( fromConnector == 3 && toConnector == 0 ) ) { // Case |¯¯
            firstItem = 'cornerTopLeft';

            if (fromConnector == 0) {
                firstType = toType;
                secondType = fromType;
            }
            else {
                firstType = fromType;
                secondType = toType;
            }
        }
        else if ( ( fromConnector == 2 && toConnector == 3 ) || ( fromConnector == 3 && toConnector == 2 ) ) { // Case |_
            firstItem = 'cornerBottomLeft';

            if (fromConnector == 2) {
                firstType = toType;
                secondType = fromType;
            }
            else {
                firstType = fromType;
                secondType = toType;
            }
        }

        div +=  '<div class="' + firstItem + '">' +
                    '<div class="leftConnectorMarker">' +
                        '<span class="' + firstType + '"></span>' +
                    '</div>' +
                    '<div class="rightConnectorMarker">' +
                        '<span class="' + secondType + '"></span>' +
                    '</div>' +
                '</div>';
    }

    div += '</div>';

    $(div).appendTo('body');
};

function addLink(from, to, type, fromType, toType) {
    debug(type);
    debug(fromType);
    debug(toType);
    new Link(from, to, type, fromType, toType);
}

function removeLink(id) {
    Link.prototype.links[id].remove();
}