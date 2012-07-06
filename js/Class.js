function Class (name) {
    if (name == undefined) {
        this.name = this.getValidName('Class');
        this.id = this.name;
    }
    else {
        this.name = name;
        this.id = this.name;
    }

    Class.prototype.classes[this.name] = this;
}

Class.prototype.classes = [];

Class.prototype.setName = function (name) {
    this.name = this.getValidName(name);
};

Class.prototype.getName = function () {
    return this.name;
};

Class.prototype.getId = function () {
    return this.id;
};

Class.prototype.toXML = function () {
    var ret = '';

    ret += '<class ' +
        'name="' + this.getName() + '" ' +
        'top="' + $('#' + this.getName()).css('top') + '" ' +
        'left="' + $('#' + this.getName()).css('left') + '">';

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

Class.prototype.moveTo = function(x,y) {
    $('#' + this.id).css('left',x);
    $('#' + this.id).css('top',y);
};

Class.prototype.clearConnectors = function () {
    this.connectors = [[],[],[],[]];
};

Class.prototype.addConnector = function (where, distance) {
    this.connectors[where][this.connectors[where].length] = distance;
};

function addClass(name) {
    var c = new Class(name);
    name = c.getName();

    $(
        '<div id="' + c.getId() + '" class="class" style="position: absolute; top: ' + Math.floor((Math.random()*15)+1)*20 + 'px; left: ' + Math.floor((Math.random()*15)+1)*20 + 'px;">' +
            '<div class="handle"></div>' +
            '<div class="name">' + c.getName() + '</div>' +
            '<div class="controls" style="display: none;">' +
            '<span style="float: left;" class="ui-icon ui-icon-closethick" onclick="deleteClass(\'' + name + '\')"></span>' +
            '<span style="float: left;" class="ui-icon ui-icon-link linkClass" onclick=""></span>' +
            '</div>' +
            '</div>'
    ).appendTo('body');

    c.addInteractivity(name);
}

function deleteClass(name) {
    for (var i in Class.prototype.classes)
        if (Class.prototype.classes[i].getName() == name) {
            $('#' + name).remove();

            delete Class.prototype.classes[i];

            //alert('Deleted ' + name);
            break;
        }
}

Class.prototype.addInteractivity = function () {
    var classId = '#' + this.id;

    // Make it draggable
    $(classId).draggable({
        grid: [ 1,1 ],
        handle: 'div.handle',
        drag: function () {
            jsPlumb.repaintEverything();
        },
        stop: function () {
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

    /*
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
    */
}