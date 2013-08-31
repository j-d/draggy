Link.prototype = new ScreenItem();           // Inheritance
Link.prototype.constructor = Link;

Link.prototype.links = {};      // Static associative array
Link.prototype.linkList = [];

//Link.prototype.mode = 'JSPLUMB';
Link.prototype.mode = 'JS';

Link.prototype.suffixes = [
    '-top',
    '-right',
    '-bottom',
    '-left'
];

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
    this.broken  = false;
    this.cascadeRemove  = true;
    this.persist = true;

    if (type !== 'Inheritance') {
        if (!Draggy.prototype.options.linkClasses) {
            this.fromAttribute = Connectable.prototype.connectables[this.from].getAttributeFromName(fromAttributeName);
            var fromAttribute = Attribute.prototype.attributes[this.fromAttribute];

            if (fromAttribute instanceof InheritedAttribute) {
                fromAttribute.getParent().links.push(this.getId());
            } else {
                fromAttribute.links.push(this.getId());
            }
        }

        this.toAttribute = Connectable.prototype.connectables[this.to].getAttributeFromName(toAttributeName);
        var toAttribute = Attribute.prototype.attributes[this.toAttribute];

        if (toAttribute instanceof InheritedAttribute) {
            toAttribute.getParent().links.push(this.getId());
        } else {
            toAttribute.links.push(this.getId());
        }
    }
    else {
        Item.prototype.items[this.from].setInheritingFrom(this.to);

        if (System.prototype.runtime) {
            Item.prototype.items[this.from].inheritAttributes();
        }

        Item.prototype.items[this.from].reDraw();
    }

    if (Link.prototype.mode !== 'JSPLUMB') {
        this.adjustConnectors();
    }

    Link.prototype.links[this.id] = this;
    Link.prototype.linkList.push(this);

    if (System.prototype.runtime && Connectable.prototype.connectables[this.from].getModule() != Connectable.prototype.connectables[this.to].getModule()) {
        this.broken = true;
    }
}

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
            'from="' + Item.prototype.items[this.getFrom()].getFullyQualifiedName() + '" ' +
            'to="' + Item.prototype.items[this.getTo()].getFullyQualifiedName() + '" ' +
            'type="' + this.getType() + '"' +
            ( this.getBroken() ? ' broken="' + this.getBroken() + '"' : '') +
            ' />' + '\n';
    }
    else {
        ret += '<relation ';
        ret += 'from="' + Item.prototype.items[this.getFrom()].getFullyQualifiedName() + '" ';

        if (!Draggy.prototype.options.linkClasses) {
            ret += 'fromAttribute="' + Attribute.prototype.attributes[this.fromAttribute].getName() + '" ';
        }

        ret += 'to="' + Item.prototype.items[this.getTo()].getFullyQualifiedName() + '" ';
        ret += 'toAttribute="' + Attribute.prototype.attributes[this.toAttribute].getName() + '" ';
        ret += 'type="' + this.getType() + '" ';

        if ('Inheritance' !== this.getType()) {
            ret += 'persist="' + this.getPersist() + '" ';
            ret += 'remove="' + this.getRemove() + '" ';
        }

        if (this.getBroken()) {
            ret += 'broken="' + this.getBroken() + '" ';
        }

        ret += '/>' + '\n';
    }

    return ret;
};

Link.prototype.reDrawLinks = function () {
    for (var i = 0; i < Link.prototype.linkList.length; i++) {
        if (Link.prototype.linkList[i].needsRedraw) {
            Link.prototype.linkList[i].reDraw();
        }
    }
};

Link.prototype.reDraw = function () {
    if (Link.prototype.mode !== 'JSPLUMB') {
        this.calculateDistance();

        Item.prototype.items[this.from].removeConnector(this.id);
        Item.prototype.items[this.to].removeConnector(this.id);

        Item.prototype.items[this.from].addConnector(this.fromConnector,this.id);
        Item.prototype.items[this.to].addConnector(this.toConnector,this.id);

        this.adjustConnectors();

        this.reLocate();
    }

    this.draw();

    this.needsRedraw = false;
};

Link.prototype.reLocate = function () {
    Item.prototype.items[this.from].assignPositions(this.fromConnector);
    Item.prototype.items[this.to].assignPositions(this.toConnector);
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

Link.prototype.adjustConnectors = function () {
    var newFrom;
    var newTo;

    switch (this.type) {
        case 'Inheritance':
            newFrom = null;
            newTo = 'inheritance';
            break;
        case 'OneToOne':
            if (!Draggy.prototype.options.linkClasses) {
                newFrom = Attribute.prototype.attributes[this.fromAttribute].getNull() ? 'oneNull' : 'one';
            } else {
                newFrom = 'one';
            }

            newTo = Attribute.prototype.attributes[this.toAttribute].getNull() ? 'oneNull' : 'one';
            break;
        case 'OneToMany':
            if (!Draggy.prototype.options.linkClasses) {
                newFrom = Attribute.prototype.attributes[this.fromAttribute].getNull() ? 'oneNull' : 'one';
            } else {
                newFrom = 'one';
            }

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

Link.prototype.setPersist = function (persist) {
    this.cascadePersist = persist;
};

Link.prototype.getPersist = function () {
    return this.cascadePersist;
};

Link.prototype.setRemove = function (remove) {
    this.cascadeRemove = remove;
};

Link.prototype.getRemove = function () {
    return this.cascadeRemove;
};

Link.prototype.remove = function () {
    Item.prototype.items[this.from].removeConnector(this.id);
    Item.prototype.items[this.to].removeConnector(this.id);

    if (this.type !== 'Inheritance') {
        if (!Draggy.prototype.options.linkClasses) {
            var fromAttribute = Attribute.prototype.attributes[this.fromAttribute];

            if (fromAttribute instanceof InheritedAttribute)
                fromAttribute.getParent().links.remove(this.getId());
            else
                fromAttribute.links.remove(this.getId());
        }

        var toAttribute = Attribute.prototype.attributes[this.toAttribute];

        if (toAttribute instanceof InheritedAttribute)
            toAttribute.getParent().links.remove(this.getId());
        else
            toAttribute.links.remove(this.getId());

        toAttribute.setForeign(false);
    }
    else { // Type === Inheritance
        Item.prototype.items[this.from].unInheritAttributes();

        Item.prototype.items[this.from].setInheritingFrom(null);

        Item.prototype.items[this.from].reDraw();
    }

    Item.prototype.items[this.from].removeConnector(this.id);
    Item.prototype.items[this.to].removeConnector(this.id);

    delete Link.prototype.links[this.id];
    Link.prototype.linkList.remove(this);

    Connectable.prototype.connectables[this.to].reDraw();

    this.destroyScreenItem();
};

Link.prototype.reDrawConnectableLinks = function (connectable) {
    if (Link.prototype.mode === 'JSPLUMB') {
        jsPlumb.repaint(connectable.getId());
    } else {
        connectable.calculateMiddlePoints();
        connectable.markLinksToBeRedrawn();
        Link.prototype.reDrawLinks();
    }
};

Link.prototype.draw = function () {
    if (Link.prototype.mode === 'JSPLUMB') {
        if (!System.prototype.runtime) {
            //jsPlumb.draggable(jsPlumb.getSelector(".connectable"));

            jsPlumb.connect({
                source: this.from,
                target: this.to,
                //anchors:["RightMiddle", "LeftMiddle" ]
                //endpointStyle:{ fillStyle: 'yellow' }
                connector: [ 'Flowchart', {stub: 20} ],
                paintStyle: {
                    lineWidth: 2,
                    strokeStyle: "#F00",
                    joinstyle: "round"
                },
                hoverPaintStyle: {
                    lineWidth: 4,
                    strokeStyle: "#00F",
                    joinstyle: "round"
                },
    //            anchor: [ "Perimeter", { shape: "rectangle" } ],
                anchor: "Continuous",
                endpoint:'Blank',
                //endpoint:[ "Image", { src:"js/contextMenu/images/1353844791_trash.png" } ],
                overlays:[
//                    [ "Arrow", {
//                        location:1,
//                        id:'arrow',
//                        length:14,
//                        foldback:0.6
//                    }],
                    [ 'Custom', {
                        create: function () { return $('<div style="width: 10px; height: 10px; background-color: red;"></div>') },
                        location: 0.99
                    }]
                ]

            });
        }
        else {
            jsPlumb.repaint( [ this.from, this.to ] );
        }
    }
    else {
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

        this.setDrawn(true);
    }
};