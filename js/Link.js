function Link (from, to, type) {
    this.id = getValidName('Link');
    this.hashId = '#' + this.id;

    this.from = Class.prototype.getIdFromName(from);
    this.to = Class.prototype.getIdFromName(to);
    this.type = type;
    this.positionFrom = null;
    this.positionTo = null;
    this.needsRedraw = true;

    Link.prototype.links[this.id] = this;
}

Link.prototype.links = [];      // Static associative array

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
        'top="' + $(this.hashId).css('top') + '" ' +
        'left="' + $(this.hashId).css('left') + '">';

    ret += '</relation>';

    return ret;
};

Link.prototype.reDraw = function () {
    drawLinkObjects(this.id,'class_' + this.from, 'class_' + this.to);
};

Link.prototype.setProperties = function (distance, fromConnector, toConnector) {
    this.distance = distance;
    this.fromConnector = fromConnector;
    this.toConnector = toConnector;
};

Link.prototype.reDrawLinks = function () {
    for (var i in Link.prototype.links)
        if (Link.prototype.links[i].needsRedraw)
            Link.prototype.links[i].reDraw();
};

Link.prototype.reDraw = function () {
    this.calculateDistance();

    Class.prototype.classes[this.from].removeConnector(this.id);
    Class.prototype.classes[this.to].removeConnector(this.id);

    Class.prototype.classes[this.from].addConnector(this.fromConnector,this.id);
    Class.prototype.classes[this.to].addConnector(this.toConnector,this.id);

    Class.prototype.classes[this.from].assignPositions(this.fromConnector);
    Class.prototype.classes[this.to].assignPositions(this.toConnector);

    $(this.hashId).remove();

    drawLink(
        this.id,
        Class.prototype.classes[this.from].getLinkX(this.id,this.fromConnector),
        Class.prototype.classes[this.from].getLinkY(this.id,this.fromConnector),
        Class.prototype.classes[this.to].getLinkX(this.id,this.toConnector),
        Class.prototype.classes[this.to].getLinkY(this.id,this.toConnector),
        this.fromConnector,
        this.toConnector,
        'fromType',
        'toType'
    );

    this.needsRedraw = false;
};

Link.prototype.reLocate = function () {
    // Same as reDraw but doesn't calculate where is meant to be connecting to and from since it has not changed
    Class.prototype.classes[this.from].assignPositions(this.fromConnector);
    Class.prototype.classes[this.to].assignPositions(this.toConnector);

    $(this.hashId).remove();

    drawLink(
        this.id,
        Class.prototype.classes[this.from].getLinkX(this.id,this.fromConnector),
        Class.prototype.classes[this.from].getLinkY(this.id,this.fromConnector),
        Class.prototype.classes[this.to].getLinkX(this.id,this.toConnector),
        Class.prototype.classes[this.to].getLinkY(this.id,this.toConnector),
        this.fromConnector,
        this.toConnector,
        'fromType',
        'toType'
    );
};

Link.prototype.remove = function () {
    Class.prototype.classes[this.from].removeConnector(this.id);
    Class.prototype.classes[this.to].removeConnector(this.id);

    $(this.hashId).remove();
};

Link.prototype.calculateDistance = function () {
    if (this.needsRedraw) {
        var from = Class.prototype.classes[this.from];
        var to =  Class.prototype.classes[this.to];

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

function addLink(from, to, type) {
    new Link(from, to, type);
}

function removeLink(id) {
    Link.prototype.links[id].remove();
}