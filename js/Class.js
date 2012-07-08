Class.prototype = new Item();           // Inheritance
Class.prototype.constructor = Class;

Class.prototype.classes = {};           // Static associative array
Class.prototype.classIdsByName = {};    // Static associative array

function Class (name) {
    if (name == undefined)
        this.name = this.getValidName('Class');
    else
        this.name = name;

    this.innit('Class');

    Class.prototype.classes[this.id] = this;
    Class.prototype.classIdsByName[this.name] = this.id;
}

Class.prototype.setName = function (name) {
    this.name = this.getValidName(name);
};

Class.prototype.getName = function () {
    return this.name;
};

Class.prototype.getIdFromName = function(name) {
    return Class.prototype.classIdsByName[name];
};

Class.prototype.getClassByName = function(name) {
    return Class.prototype.classes[Class.prototype.classIdsByName[name]];
};

Class.prototype.toXML = function () {
    var ret = '';

    ret += '<class ' +
        'name="' + this.getName() + '" ' +
        'top="' + $(this.hashId).css('top') + '" ' +
        'left="' + $(this.hashId).css('left') + '">';

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

Class.prototype.makeInteractive = function () {
    var name = this.name; // Later it will be out of context

    // Make it draggable
    $(this.hashId).draggable({
        grid: [ 1,1 ],
        handle: 'div.handle',
        drag: function () {
            var c = Class.prototype.getClassByName(name);
            c.calculateMiddlePoints();
            c.markLinksToBeRedrawn();
            Link.prototype.reDrawLinks();
        },
        stop: function () {
            var c = Class.prototype.getClassByName(name);
            c.calculateMiddlePoints();
            c.markLinksToBeRedrawn();
            Link.prototype.reDrawLinks();
        }
    });

    var hashId = this.hashId;

    // Hover controls
    $(this.hashId).hover(
        function () {
            $(hashId + ' .controls').show();
        },
        function () {
            $(hashId + ' .controls').hide();
        }
    );

    // Edit name
    $(this.hashId + ' .name').click(function () {
        $('#edit-class-name-dialog input[name=name]').attr('value',$(hashId + ' .name').html());
        $('#edit-class-name-dialog input[name=class]').attr('value',name);

        $('#edit-class-name-dialog').dialog('open');
    });

    // Link class
    $(this.hashId + ' .controls .linkClass').click(function () {
        // Remove previous select items
        $('#link-class-name-dialog select option[name=destClass]').remove();

        // Add other classes
        for (i in Class.prototype.classes)
            $('<option value="' + Class.prototype.classes[i].getName() + '">' + Class.prototype.classes[i].getName() + '</option>').appendTo($('#link-class-name-dialog select[name=destClass]'));

        //$('#link-class-name-dialog input[name=name]').attr('value',$(this.hashId + ' .name').html());
        $('#link-class-name-dialog input[name=class]').attr('value',name);

        $('#link-class-name-dialog').dialog('open');
    });
};

function addClass(name) {
    var c = new Class(name);

    $(
        '<div id="' + c.getId() + '" class="class" style="position: absolute; top: ' + Math.floor((Math.random()*15)+1)*20 + 'px; left: ' + Math.floor((Math.random()*15)+1)*20 + 'px;">' +
            '<div class="handle"></div>' +
            '<div class="name">' + c.getName() + '</div>' +
            '<div class="controls" style="display: none;">' +
            '<span style="float: left;" class="ui-icon ui-icon-closethick" onclick="deleteClass(\'' + c.getName() + '\')"></span>' +
            '<span style="float: left;" class="ui-icon ui-icon-link linkClass" onclick=""></span>' +
            '</div>' +
            '</div>'
    ).appendTo('body');

    c.calculateMiddlePoints();
    c.makeInteractive(name);
}

function deleteClass(name) {
    for (var i in Class.prototype.classes)
        if (Class.prototype.classes[i].getName() == name) {
            $(this.hashId).remove();

            delete Class.prototype.classes[i];

            //alert('Deleted ' + name);
            break;
        }
}