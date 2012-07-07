function Link (from, to, type) {
    this.id = getValidName('Link');

    this.from = from;
    this.to = to;
    this.type = type;
    this.positionFrom = null;
    this.positionTo = null;

    Link.prototype.links[this.id] = this;
}

Link.prototype.links = [];

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

    ret += '<relation ' +
        'from="' + this.getFrom() + '" ' +
        'to="' + this.getTo() + '" ' +
        'type="' + this.getType() + '" ' +
        'top="' + $('#' + this.getId()).css('top') + '" ' +
        'left="' + $('#' + this.getId()).css('left') + '">';

    ret += '</relation>';

    return ret;
};

Link.prototype.reDraw = function () {
    drawLinkObjects(this.id,'class_' + this.from, 'class_' + this.to);
}

Link.prototype.setProperties = function (distance, fromConnector, toConnector) {
    this.distance = distance;
    this.fromConnector = fromConnector;
    this.toConnector = toConnector;
}

Link.prototype.reDrawLinks = function () {
    // Remove existing links
    $('div.connector').remove();

    // Calculate all distances and positions
    for (var i in Link.prototype.links)
        Link.prototype.links[i].calculateDistance();

    // Make objects aware of how many links they have
    for (var i in Class.prototype.classes)
        Class.prototype.classes[i].clearConnectors();

    for (var i in Link.prototype.links) {
        Class.prototype.classes[Link.prototype.links[i].from].addConnector(Link.prototype.links[i].fromConnector,i);
        Class.prototype.classes[Link.prototype.links[i].to].addConnector(Link.prototype.links[i].toConnector,i);
    }

    // Assign positions to multiple links
    for (var i in Class.prototype.classes)
        for (var j in [0,1,2,3])
            Class.prototype.classes[i].assignPositions(j);

    // Draw every link asking the class for the coordinates
    for (var i in Link.prototype.links) {
        drawLink(
            Link.prototype.links[i].id,
            Class.prototype.classes[Link.prototype.links[i].from].getLinkX(Link.prototype.links[i].id,Link.prototype.links[i].fromConnector),
            Class.prototype.classes[Link.prototype.links[i].from].getLinkY(Link.prototype.links[i].id,Link.prototype.links[i].fromConnector),
            Class.prototype.classes[Link.prototype.links[i].to].getLinkX(Link.prototype.links[i].id,Link.prototype.links[i].toConnector),
            Class.prototype.classes[Link.prototype.links[i].to].getLinkY(Link.prototype.links[i].id,Link.prototype.links[i].toConnector),
            Link.prototype.links[i].fromConnector,
            Link.prototype.links[i].toConnector,
            'fromType',
            'toType'
        );
    }
}

function addLink(from, to, type) {
    var l = new Link(from, to, type);
    //name = c.getName();

    //drawLinkObjects(l.getId(),Class.prototype.classes[from], Class.prototype.classes[to]);

/*    addClassInteractivity(name);*/
}

function distance(x1, y1, x2, y2) {
    return Math.sqrt( Math.pow(x2-x1,2) + Math.pow(y2-y1,2) );
}



Link.prototype.calculateDistance = function () {
    var from = Class.prototype.classes[this.from];
    var to =  Class.prototype.classes[this.to];

    // Connector types
    // 0 = Top
    // 1 = Right
    // 2 = Bottom
    // 3 = Left

    // Minimum distance
    this.minimumDistance = distance(from.rightMiddleX, from.rightMiddleY, to.leftMiddleX, to.leftMiddleY);
    this.minimumFromX = from.rightMiddleX;
    this.minimumFromY = from.rightMiddleY;
    this.minimumToX = to.leftMiddleX;
    this.minimumToY = to.leftMiddleY;
    this.fromConnector = 1;
    this.toConnector = 3;

    if ( this.minimumDistance > distance(from.rightMiddleX, from.rightMiddleY, to.bottomMiddleX, to.bottomMiddleY) ) {
        this.minimumDistance = distance(from.rightMiddleX, from.rightMiddleY, to.bottomMiddleX, to.bottomMiddleY);
        this.minimumFromX = from.rightMiddleX;
        this.minimumFromY = from.rightMiddleY;
        this.minimumToX = to.bottomMiddleX;
        this.minimumToY = to.bottomMiddleY;
        this.fromConnector = 1;
        this.toConnector = 2;
    }

    if ( this.minimumDistance > distance(from.rightMiddleX, from.rightMiddleY, to.topMiddleX, to.topMiddleY) ) {
        this.minimumDistance = distance(from.rightMiddleX, from.rightMiddleY, to.topMiddleX, to.topMiddleY);
        this.minimumFromX = from.rightMiddleX;
        this.minimumFromY = from.rightMiddleY;
        this.minimumToX = to.topMiddleX;
        this.minimumToY = to.topMiddleY;
        this.fromConnector = 1;
        this.toConnector = 0;
    }

    if ( this.minimumDistance > distance(from.topMiddleX, from.topMiddleY, to.bottomMiddleX, to.bottomMiddleY) ) {
        this.minimumDistance = distance(from.topMiddleX, from.topMiddleY, to.bottomMiddleX, to.bottomMiddleY);
        this.minimumFromX = from.topMiddleX;
        this.minimumFromY = from.topMiddleY;
        this.minimumToX = to.bottomMiddleX;
        this.minimumToY = to.bottomMiddleY;
        this.fromConnector = 0;
        this.toConnector = 2;
    }

    if ( this.minimumDistance > distance(from.topMiddleX, from.topMiddleY, to.leftMiddleX, to.leftMiddleY) ) {
        this.minimumDistance = distance(from.topMiddleX, from.topMiddleY, to.leftMiddleX, to.leftMiddleY);
        this.minimumFromX = from.topMiddleX;
        this.minimumFromY = from.topMiddleY;
        this.minimumToX = to.leftMiddleX;
        this.minimumToY = to.leftMiddleY;
        this.fromConnector = 0;
        this.toConnector = 3;
    }

    if ( this.minimumDistance > distance(from.topMiddleX, from.topMiddleY, to.rightMiddleX, to.rightMiddleY) ) {
        this.minimumDistance = distance(from.topMiddleX, from.topMiddleY, to.rightMiddleX, to.rightMiddleY);
        this.minimumFromX = from.topMiddleX;
        this.minimumFromY = from.topMiddleY;
        this.minimumToX = to.rightMiddleX;
        this.minimumToY = to.rightMiddleY;
        this.fromConnector = 0;
        this.toConnector = 1;
    }

    if ( this.minimumDistance > distance(from.bottomMiddleX, from.bottomMiddleY, to.topMiddleX, to.topMiddleY) ) {
        this.minimumDistance = distance(from.bottomMiddleX, from.bottomMiddleY, to.topMiddleX, to.topMiddleY);
        this.minimumFromX = from.bottomMiddleX;
        this.minimumFromY = from.bottomMiddleY;
        this.minimumToX = to.topMiddleX;
        this.minimumToY = to.topMiddleY;
        this.fromConnector = 2;
        this.toConnector = 0;
    }

    if ( this.minimumDistance > distance(from.bottomMiddleX, from.bottomMiddleY, to.leftMiddleX, to.leftMiddleY) ) {
        this.minimumDistance = distance(from.bottomMiddleX, from.bottomMiddleY, to.leftMiddleX, to.leftMiddleY);
        this.minimumFromX = from.bottomMiddleX;
        this.minimumFromY = from.bottomMiddleY;
        this.minimumToX = to.leftMiddleX;
        this.minimumToY = to.leftMiddleY;
        this.fromConnector = 2;
        this.toConnector = 3;
    }

    if ( this.minimumDistance > distance(from.bottomMiddleX, from.bottomMiddleY, to.rightMiddleX, to.rightMiddleY) ) {
        this.minimumDistance = distance(from.bottomMiddleX, from.bottomMiddleY, to.rightMiddleX, to.rightMiddleY);
        this.minimumFromX = from.bottomMiddleX;
        this.minimumFromY = from.bottomMiddleY;
        this.minimumToX = to.rightMiddleX;
        this.minimumToY = to.rightMiddleY;
        this.fromConnector = 2;
        this.toConnector = 1;
    }

    if ( this.minimumDistance > distance(from.leftMiddleX, from.leftMiddleY, to.rightMiddleX, to.rightMiddleY) ) {
        this.minimumDistance = distance(from.leftMiddleX, from.leftMiddleY, to.rightMiddleX, to.rightMiddleY);
        this.minimumFromX = from.leftMiddleX;
        this.minimumFromY = from.leftMiddleY;
        this.minimumToX = to.rightMiddleX;
        this.minimumToY = to.rightMiddleY;
        this.fromConnector = 3;
        this.toConnector = 1;
    }

    if ( this.minimumDistance > distance(from.leftMiddleX, from.leftMiddleY, to.topMiddleX, to.topMiddleY) ) {
        this.minimumDistance = distance(from.leftMiddleX, from.leftMiddleY, to.topMiddleX, to.topMiddleY);
        this.minimumFromX = from.leftMiddleX;
        this.minimumFromY = from.leftMiddleY;
        this.minimumToX = to.topMiddleX;
        this.minimumToY = to.topMiddleY;
        this.fromConnector = 3;
        this.toConnector = 0;
    }

    if ( this.minimumDistance > distance(from.leftMiddleX, from.leftMiddleY, to.bottomMiddleX, to.bottomMiddleY) ) {
        this.minimumDistance = distance(from.leftMiddleX, from.leftMiddleY, to.bottomMiddleX, to.bottomMiddleY);
        this.minimumFromX = from.leftMiddleX;
        this.minimumFromY = from.leftMiddleY;
        this.minimumToX = to.bottomMiddleX;
        this.minimumToY = to.bottomMiddleY;
        this.fromConnector = 3;
        this.toConnector = 2;
    }

    //drawLink(id,minimumFromX,minimumFromY,minimumToX,minimumToY,fromConnector,toConnector);
}

function drawLink(id,fromX, fromY, toX, toY, fromConnector, toConnector, fromType, toType) {
    // Connector types
    // 0 = Top
    // 1 = Right
    // 2 = Bottom
    // 3 = Left

    var width = Math.abs(toX - fromX);
    var left = Math.min(fromX, toX);
    var height = Math.abs(toY - fromY);
    var top = Math.min(fromY, toY);
    var firstClass;
    var secondClass;
    var firstType;
    var secondType;

    var fromSuffix;
    var toSuffix;

    switch (fromConnector) {
        case 0:
            fromSuffix = '-top';
            break;
        case 1:
            fromSuffix = '-right';
            break;
        case 2:
            fromSuffix = '-bottom';
            break;
        case 3:
            fromSuffix = '-left';
            break;
    }

    switch (toConnector) {
        case 0:
            toSuffix = '-top';
            break;
        case 1:
            toSuffix = '-right';
            break;
        case 2:
            toSuffix = '-bottom';
            break;
        case 3:
            toSuffix = '-left';
            break;
    }

    fromType = 'many-null';
    toType = 'inheritance';

    switch (fromType) {
        case 'inheritance':
            fromType = 'icon-inheritance' + fromSuffix;
            break;
        case 'one':
            fromType = 'icon-one' + fromSuffix;
            break;
        case 'one-null':
            fromType = 'icon-one-null' + fromSuffix;
            break;
        case 'many-null':
            fromType = 'icon-many-null' + fromSuffix;
            break;
    }

    switch (toType) {
        case 'inheritance':
            toType = 'icon-inheritance' + toSuffix;
            break;
        case 'one':
            toType = 'icon-one' + toSuffix;
            break;
        case 'one-null':
            toType = 'icon-one-null' + toSuffix;
            break;
        case 'many-null':
            toType = 'icon-many-null' + toSuffix;
            break;
    }

    var div = '';

    div += '<div id="' + id + '" class="connector" style="width: ' + width + 'px; height: ' + height + 'px; left: ' + left + 'px; top: ' + top + 'px;">';

    if ( ( fromConnector == 1 && toConnector == 3 ) || ( fromConnector == 3 && toConnector == 1 ) ) { // Case ¯¯|__ or __|¯¯
        if (fromY < toY ^ fromConnector == 3 ) { // Case ¯¯|__
            firstClass =  'horizontalTopFrom';
            secondClass = 'horizontalBottomTo';
        }
        else { // Case __|¯¯
            firstClass =  'horizontalBottomFrom';
            secondClass = 'horizontalTopTo';
        }

        if (fromConnector == 3) {
            firstType = toType;
            secondType = fromType;
        }
        else {
            firstType = fromType;
            secondType = toType;
        }

        div +=  '<div class="' + firstClass + '">' +
                    '<div class="connectorMarker">' +
                        '<span class="' + firstType + '"></span>' +
                    '</div>' +
                '</div>' +
                '<div class="' + secondClass + '">' +
                    '<div class="connectorMarker">' +
                        '<span class="' + secondType + '"></span>' +
                    '</div>' +
                '</div>';
    }
    else if ( ( fromConnector == 0 && toConnector == 2 ) || ( fromConnector == 2 && toConnector == 0 ) ) { // Case '-, or ,-'
        if ( fromX < toX ^ fromConnector == 2 ) { // Case ,-'
            firstClass = 'verticalTopRight';
            secondClass = 'verticalBottomLeft';
        }
        else { // Case '-,
            firstClass = 'verticalTopLeft';
            secondClass = 'verticalBottomRight';
        }

        if (fromConnector == 0) {
            firstType = toType;
            secondType = fromType;
        }
        else {
            firstType = fromType;
            secondType = toType;
        }

        div +=  '<div class="' + firstClass + '">' +
                    '<div class="connectorMarker">' +
                        '<span class="' + firstType + '"></span>' +
                    '</div>' +
                '</div>' +
                '<div class="' + secondClass + '">' +
                    '<div class="connectorMarker">' +
                        '<span class="' + secondType + '"></span>' +
                    '</div>' +
                '</div>';
    } else { // Corner
        if ( ( fromConnector == 1 && toConnector == 0 ) || ( fromConnector == 0 && toConnector == 1 ) ) { // Case ¯¯|
            firstClass = 'cornerTopRight';

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
            firstClass = 'cornerBottomRight';

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
            firstClass = 'cornerTopLeft';

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
            firstClass = 'cornerBottomLeft';

            if (fromConnector == 2) {
                firstType = toType;
                secondType = fromType;
            }
            else {
                firstType = fromType;
                secondType = toType;
            }
        }

        div +=  '<div class="' + firstClass + '">' +
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
}