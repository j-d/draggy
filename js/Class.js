function Class (name) {
    if (name == undefined)
        this.name = this.getValidName('Class');
    else
        this.name = name;

    Class.prototype.classes[this.name] = this;
}

Class.prototype.classes = [];

Class.prototype.setName = function (name) {
    this.name = this.getValidName(name);
};

Class.prototype.getName = function () {
    return this.name;
};

Class.prototype.toXML = function () {
    var ret = '';

    ret += '<class ' +
        'name="' + this.getName() + '" ' +
        'top="' + $('#class_' + this.getName()).css('top') + '" ' +
        'left="' + $('#class_' + this.getName()).css('left') + '">';

    ret += '</class>';

    return ret;
};

Class.prototype.getValidName = function (name) {
    var valid = true;
    var i;

    for (i in Class.prototype.classes)
        if (Class.prototype.classes[i].getName() == name) {
            valid = false;
            break;
        }

    if (valid)
        return name;

    var number = 1;

    while (!valid) {
        valid = true;

        for (i in Class.prototype.classes)
            if (Class.prototype.classes[i].getName() == name + number) {
                valid = false
            }

        if (valid)
            return name + number;

        number++;
    }
};

Class.prototype.calculateConnectorPoints = function () {
    this.x = parseInt($('#class_' + this.name).css('left'));
    this.y = parseInt($('#class_' + this.name).css('top'));
    this.width = parseInt($('#class_' + this.name).outerWidth());
    this.height = parseInt($('#class_' + this.name).outerHeight());

    this.leftMiddleX = this.x;
    this.leftMiddleY = Math.round(this.y + this.height / 2);
    this.rightMiddleX = this.x + this.width;
    this.rightMiddleY = this.leftMiddleY;
    this.topMiddleX = Math.round(this.x + this.width / 2);
    this.topMiddleY = this.y;
    this.bottomMiddleX = this.topMiddleX;
    this.bottomMiddleY = this.y + this.height;
};

Class.prototype.moveTo = function(x,y) {
    $('#class_' + this.name).css('left',x);
    $('#class_' + this.name).css('top',y);
    this.calculateConnectorPoints();
};

Class.prototype.clearConnectors = function () {
    this.connectors = [[],[],[],[]];
};

Class.prototype.addConnector = function (where, distance) {
    this.connectors[where][this.connectors[where].length] = distance;
};

Class.prototype.getLinkX = function (name, where) {
    var total = this.connectors[where].length;

    if (total == 1) {
        switch (where) {
            case 0: return this.topMiddleX;
            case 1: return this.rightMiddleX;
            case 2: return this.bottomMiddleX;
            case 3: return this.leftMiddleX;
        }
    }
    else {
        for (i = 0; i < total; i++)
            if (this.connectors[where][i] == name) {
                if (this.name == Link.prototype.links[name].to )
                    return this.getMultipleLinkX(where,Link.prototype.links[name].positionTo);
                else
                    return this.getMultipleLinkX(where,Link.prototype.links[name].positionFrom);
            }
    }
};

Class.prototype.getLinkY = function (name, where) {
    var total = this.connectors[where].length;

    if (total == 1) {
        switch (where) {
            case 0: return this.topMiddleY;
            case 1: return this.rightMiddleY;
            case 2: return this.bottomMiddleY;
            case 3: return this.leftMiddleY;
        }
    }
    else {
        for (i = 0; i < total; i++)
            if (this.connectors[where][i] == name) {
                if (this.name == Link.prototype.links[name].to )
                    return this.getMultipleLinkY(where,Link.prototype.links[name].positionTo);
                else
                    return this.getMultipleLinkY(where,Link.prototype.links[name].positionFrom);
            }
    }
};

Class.prototype.getMultipleLinkX = function (where, count) {
    var total = this.connectors[where].length + 1;
    count++;

    switch (parseInt(where)) {
        case 0: return Math.round( this.x + count * this.width / total );
        case 1: return this.x + this.width;
        case 2: return Math.round( this.x + ( total - count ) * this.width / total );
        case 3: return this.x;
    }
};

Class.prototype.getMultipleLinkY = function (where, count) {
    var total = this.connectors[where].length + 1;
    count++;

    switch (parseInt(where)) {
        case 0: return this.y;
        case 1: return Math.round( this.y + count * this.height / total );
        case 2: return this.y + this.height;
        case 3: return Math.round( this.y + ( total - count ) * this.height / total );
    }
};

Class.prototype.assignPositions = function (where) {
    var nConnectors = this.connectors[where].length;

    if ( nConnectors > 0 ) {
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
                anchorsX[j] = this.getMultipleLinkX(where,j);
                anchorsY[j] = this.getMultipleLinkY(where,j);
            }
        }

        // Calculate all the distances
        for (i in unassignedConnectors)
            for (j in unassignedAnchors) {
                link = Link.prototype.links[this.connectors[where][i]];

                if (link.from == this.name)
                    distances[i][j] = distance(anchorsX[j],anchorsY[j],Class.prototype.classes[link.to].topMiddleX,Class.prototype.classes[link.to].leftMiddleY);
                else
                    distances[i][j] = distance(anchorsX[j],anchorsY[j],Class.prototype.classes[link.from].topMiddleX,Class.prototype.classes[link.from].leftMiddleY);
            }

        var minDistance;
        var minConnectorIndex;
        var minAnchorIndex;

        // While there are unassigned anchors
        while (unassignedAnchors.length > 0) {
            minConnectorIndex = 0;
            minAnchorIndex = 0;
            minDistance = distances[unassignedConnectors[minConnectorIndex]][unassignedAnchors[minAnchorIndex]];

            debug('supongo que el minimo es ' + minDistance + ' en ' + minConnectorIndex + ' ' + minAnchorIndex)

            for (i in unassignedConnectors) {
                for (j in unassignedAnchors) {
                    if (distances[unassignedConnectors[i]][unassignedAnchors[j]] < minDistance) {
                        minDistance = distances[unassignedConnectors[i]][unassignedAnchors[j]];
                        minConnectorIndex = i;
                        minAnchorIndex = j;

                        debug('he encontrado otro menor ' + minDistance + ' en ' + minConnectorIndex + ' ' + minAnchorIndex);
                    }
                }
            }

            link = Link.prototype.links[this.connectors[where][unassignedConnectors[minConnectorIndex]]];
            //debug(unassignedAnchors[minAnchorIndex]);
            //debug(link.id);

            // The one with the minimum distance gets the assigned
            if (link.from == this.name)
                Link.prototype.links[link.id].positionFrom  = unassignedAnchors[minAnchorIndex];
            else {
                Link.prototype.links[link.id].positionTo = unassignedAnchors[minAnchorIndex];
            }

            // The link and the anchor that gets it leaves the pending arrays
            unassignedConnectors[minConnectorIndex] = unassignedConnectors[unassignedConnectors.length - 1];
            unassignedConnectors.pop();

            // The link and the anchor that gets it leaves the pending arrays
            unassignedAnchors[minAnchorIndex] = unassignedAnchors[unassignedAnchors.length - 1];
            unassignedAnchors.pop();
        }
    }
};

function addClass(name) {
    var c = new Class(name);
    name = c.getName();

    $(
        '<div id="class_' + c.getName() + '" class="class" style="position: absolute; top: ' + Math.floor((Math.random()*15)+1)*20 + 'px; left: ' + Math.floor((Math.random()*15)+1)*20 + 'px;">' +
            '<div class="handle"></div>' +
            '<div class="name">' + c.getName() + '</div>' +
            '<div class="controls" style="display: none;">' +
            '<span style="float: left;" class="ui-icon ui-icon-closethick" onclick="deleteClass(\'' + name + '\')"></span>' +
            '<span style="float: left;" class="ui-icon ui-icon-link linkClass" onclick=""></span>' +
            '</div>' +
            '</div>'
    ).appendTo('body');

    c.calculateConnectorPoints();
    addClassInteractivity(name);
}

function deleteClass(name) {
    for (var i in Class.prototype.classes)
        if (Class.prototype.classes[i].getName() == name) {
            $('#class_' + name).remove();

            delete Class.prototype.classes[i];

            //alert('Deleted ' + name);
            break;
        }
}

function addClassInteractivity(name) {
    var classId = '#class_' + name;

    // Make it draggable
    $(classId).draggable({
        grid: [ 1,1 ],
        handle: 'div.handle',
        drag: function () {
            Class.prototype.classes[name].calculateConnectorPoints();
            Link.prototype.reDrawLinks();
        },
        stopb: function () {
            Class.prototype.classes[name].calculateConnectorPoints();
            Link.prototype.reDrawLinks();
        }
    });

    // Hover controls
    $(classId).hover(
        function () {
            $(classId + ' .controls').show();
        },
        function () {
            $(classId + ' .controls').hide();
        }
    );

    // Edit name
    $(classId + ' .name').click(function () {
        $('#edit-class-name-dialog input[name=name]').attr('value',$(classId + ' .name').html());
        $('#edit-class-name-dialog input[name=class]').attr('value',name);

        $('#edit-class-name-dialog').dialog('open');
    });

    // Link class
    $(classId + ' .controls .linkClass').click(function () {
        // Remove previous select items
        $('#link-class-name-dialog select option[name=destClass]').remove();

        // Add other classes
        for (i in Class.prototype.classes)
            $('<option value="' + Class.prototype.classes[i].getName() + '">' + Class.prototype.classes[i].getName() + '</option>').appendTo($('#link-class-name-dialog select[name=destClass]'));

        //$('#link-class-name-dialog input[name=name]').attr('value',$(classId + ' .name').html());
        $('#link-class-name-dialog input[name=class]').attr('value',name);

        $('#link-class-name-dialog').dialog('open');
    });
}