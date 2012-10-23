Link.prototype = new ScreenItem();           // Inheritance
Link.prototype.constructor = Link;

Link.prototype.links = {};      // Static associative array

function Link (from, to, type, fromAttributeName, toAttributeName) {
    this.innitScreenItem('Link');

    this.from = Connectable.prototype.getIdFromName(from);
    this.to = Connectable.prototype.getIdFromName(to);
    this.type = type;
    this.positionFrom = null;
    this.positionTo = null;
    this.needsRedraw = true;
    this.fromConnector = null;
    this.toConnector = null;
    this.shape = null;
    this.fromAttribute = null;
    this.toAttribute = null;
    this.forceRender = false;
    this.broken = false;

    if (type != 'Inheritance') {
        this.fromAttribute = Connectable.prototype.connectables[this.from].getAttributeFromName(fromAttributeName);
        this.toAttribute = Connectable.prototype.connectables[this.to].getAttributeFromName(toAttributeName);

        var fromAttribute = Attribute.prototype.attributes[this.fromAttribute];
        var toAttribute = Attribute.prototype.attributes[this.toAttribute];

        if (fromAttribute instanceof InheritedAttribute)
            fromAttribute.getParent().links.push(this.getId());
        else
            fromAttribute.links.push(this.getId());

        if (toAttribute instanceof InheritedAttribute)
            toAttribute.getParent().links.push(this.getId());
        else
            toAttribute.links.push(this.getId());
    }
    else {
        Item.prototype.items[this.from].setInheritingFrom(this.to);

        if (System.prototype.runtime)
            Item.prototype.items[this.from].inheritAttributes();

        Item.prototype.items[this.from].reDraw();
    }

    this.adjustConnectors();

    Link.prototype.links[this.id] = this;

    if (System.prototype.runtime && Connectable.prototype.connectables[this.from].getModule() != Connectable.prototype.connectables[this.to].getModule())
        this.broken = true;
}

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
    many:           'icon-many',
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

Link.prototype.getFromAttribute = function () {
    return this.fromAttribute;
};

Link.prototype.getToAttribute = function () {
    return this.toAttribute;
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
            'type="' + this.getType() + '"' +
            ( this.getBroken() ? ' broken="' + this.getBroken() + '"' : '') +
            ' />' + '\n';
    }
    else {
        ret += '<relation ' +
            'from="' + Item.prototype.getNameFromId(this.getFrom()) + '" ' +
            'to="' + Item.prototype.getNameFromId(this.getTo()) + '" ' +
            'type="' + this.getType() + '" ' +
            ( this.getBroken() ? 'broken="' + this.getBroken() + '" ' : '') +
            'fromAttribute="' + Attribute.prototype.attributes[this.fromAttribute].getName() + '" ' +
            'toAttribute="' + Attribute.prototype.attributes[this.toAttribute].getName() + '" />' + '\n';
    }

    //ret += '</relation>';

    return ret;
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

    this.adjustConnectors();

    this.reLocate();

    this.needsRedraw = false;
};

Link.prototype.reLocate = function () {
    Item.prototype.items[this.from].assignPositions(this.fromConnector);
    Item.prototype.items[this.to].assignPositions(this.toConnector);

    this.draw();
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

    if (!this.forceRender && shape == this.shape) { // Only needs to be resized
        $(this.hashId).css('top',top).css('left',left).css('width',width).css('height',height);
        return;
    }

    this.forceRender = false;

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
            firstItem =  'horizontalTopFrom' + (this.getBroken() ? ' brokenLink' : '');
            secondItem = 'horizontalBottomTo' + (this.getBroken() ? ' brokenLink' : '');
        }
        else { // Case __|¯¯
            firstItem =  'horizontalBottomFrom' + (this.getBroken() ? ' brokenLink' : '');
            secondItem = 'horizontalTopTo' + (this.getBroken() ? ' brokenLink' : '');
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
            firstItem = 'verticalTopRight' + (this.getBroken() ? ' brokenLink' : '');
            secondItem = 'verticalBottomLeft' + (this.getBroken() ? ' brokenLink' : '');
        }
        else { // Case '-,
            firstItem = 'verticalTopLeft' + (this.getBroken() ? ' brokenLink' : '');
            secondItem = 'verticalBottomRight' + (this.getBroken() ? ' brokenLink' : '');
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
            firstItem = 'cornerTopRight' + (this.getBroken() ? ' brokenLink' : '');

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
            firstItem = 'cornerBottomRight' + (this.getBroken() ? ' brokenLink' : '');

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
            firstItem = 'cornerTopLeft' + (this.getBroken() ? ' brokenLink' : '');

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
            firstItem = 'cornerBottomLeft' + (this.getBroken() ? ' brokenLink' : '');

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

Link.prototype.adjustConnectors = function () {
    var newFrom;
    var newTo;

    switch (this.type) {
        case 'Inheritance':
            newFrom = null;
            newTo = 'inheritance';
            break;
        case 'OneToOne':
            newFrom = Attribute.prototype.attributes[this.fromAttribute].getNull() ? 'oneNull' : 'one';
            newTo = Attribute.prototype.attributes[this.toAttribute].getNull() ? 'oneNull' : 'one';
            break;
        case 'OneToMany':
            newFrom = Attribute.prototype.attributes[this.fromAttribute].getNull() ? 'oneNull' : 'one';
            newTo = Attribute.prototype.attributes[this.toAttribute].getNull() ? 'manyNull' : 'many';
            break;
        default:
            newFrom = '';
            newTo = '';
            break;
    }

    if ( newFrom != this.fromType || newTo != this.toType ) {
        this.forceRender = true;
        this.fromType = newFrom;
        this.toType = newTo;
    }
};

Link.prototype.setNeedsRedraw = function (needsRedraw) {
    this.needsRedraw = needsRedraw;
};

Link.prototype.setBroken = function (broken) {
    this.broken = broken;
};

Link.prototype.getBroken = function () {
    return this.broken;
};

Link.prototype.remove = function () {
    Item.prototype.items[this.from].removeConnector(this.id);
    Item.prototype.items[this.to].removeConnector(this.id);

    if (this.type != 'Inheritance') {
        var fromAttribute = Attribute.prototype.attributes[this.fromAttribute];
        var toAttribute = Attribute.prototype.attributes[this.toAttribute];

        if (fromAttribute instanceof InheritedAttribute)
            fromAttribute.getParent().links.remove(this.getId());
        else
            fromAttribute.links.remove(this.getId());

        if (toAttribute instanceof InheritedAttribute)
            toAttribute.getParent().links.remove(this.getId());
        else
            toAttribute.links.remove(this.getId());

        toAttribute.setForeign(false);
    }
    else {
        Item.prototype.items[this.from].unInheritAttributes();

        Item.prototype.items[this.from].setInheritingFrom(null);

        Item.prototype.items[this.from].reDraw();
    }

    Item.prototype.items[this.from].removeConnector(this.id);
    Item.prototype.items[this.to].removeConnector(this.id);

    for (var i in Link.prototype.links)
        if (Link.prototype.links[i].getId() == this.id) {
            delete Link.prototype.links[i];
            break;
        }

    delete Link.prototype.links[this.id];

    Connectable.prototype.connectables[this.to].reDraw();

    this.destroyScreenItem();
};