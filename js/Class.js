Class.prototype = new Item();           // Inheritance
Class.prototype.constructor = Class;

Class.prototype.classes = {};           // Static associative array

function Class (name) {
    if (name == undefined)
        this.name = this.getValidName('Class');
    else
        this.name = name;

    this.innit('Class');

    Class.prototype.classes[this.id] = this;
    Item.prototype.itemIdsByName[this.name] = this.id;

    $(
        '<div id="' + this.getId() + '" class="class" style="position: absolute; top: ' + Math.floor((Math.random()*15)+1)*20 + 'px; left: ' + Math.floor((Math.random()*15)+1)*20 + 'px;">' +
            '<div class="handle"></div>' +
            '<div class="name">' + this.getName() + '</div>' +
            '<div class="controls" style="display: none;">' +
            '<span style="float: left;" class="ui-icon ui-icon-closethick" onclick="removeClass(\'' + this.getName() + '\')"></span>' +
            '<span style="float: left;" class="ui-icon ui-icon-link linkClass" onclick=""></span>' +
            '</div>' +
            '</div>'
    ).appendTo('body');

    this.calculateMiddlePoints();
    this.makeInteractive();
}

Class.prototype.toXML = function () {
    var ret = '';

    ret += '<class ' +
        'name="' + this.getName() + '" ' +
        'top="' + $(this.hashId).css('top') + '" ' +
        'left="' + $(this.hashId).css('left') + '">';

    ret += '</class>';

    return ret;
};

Class.prototype.makeInteractive = function () {
    var name = this.name; // Later it will be out of context

    // Make it draggable
    $(this.hashId).draggable({
        grid: [ 1,1 ],
        handle: 'div.handle',
        drag: function () {
            var c = Class.prototype.getItemByName(name);
            c.calculateMiddlePoints();
            c.markLinksToBeRedrawn();
            Link.prototype.reDrawLinks();
        },
        stop: function () {
            var c = Class.prototype.getItemByName(name);
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
        for (var i in Class.prototype.classes)
            $('<option value="' + Class.prototype.classes[i].getName() + '">' + Class.prototype.classes[i].getName() + '</option>').appendTo($('#link-class-name-dialog select[name=destClass]'));

        //$('#link-class-name-dialog input[name=name]').attr('value',$(this.hashId + ' .name').html());
        $('#link-class-name-dialog input[name=class]').attr('value',name);

        $('#link-class-name-dialog').dialog('open');
    });
};

Class.prototype.remove = function () {
    this.itemRemove();

    for (var i in Class.prototype.classes)
        if (Class.prototype.classes[i].getName() == this.name) {
            delete Class.prototype.classes[i];
            break;
        }
};

function addClass(name) {
    new Class(name);
}

function removeClass(name) {
    Class.prototype.getItemByName(name).remove();
}