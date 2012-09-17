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

    $(
        '<div id="' + this.getId() + '" class="class" style="position: absolute; top: ' + Math.floor((Math.random()*15)+1)*20 + 'px; left: ' + Math.floor((Math.random()*15)+1)*20 + 'px;">' +
        '</div>'
    ).appendTo('body');

    this.reDraw();
}

Class.prototype.reDraw = function () {
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

Class.prototype.toXML = function () {
    var ret = '';

    ret += '<class ' +
        'name="' + this.getName() + '" ' +
        'top="' + $(this.hashId).css('top') + '" ' +
        'left="' + $(this.hashId).css('left') + '"';

    if (this.getNumberAttributes() == 0)
        ret += ' />' + '\n';
    else {
        ret += '>' + '\n';

        var a;
        for (var i = 0; i < this.getNumberAttributes(); i++) {
            a = this.getAttribute(i);

            ret += '\t\t\t' + '<attribute ' +
                'name="' + a.getName() + '" ' +
                'type="' + a.getType() + '" ' +
                'size="' + a.getSize() + '" ' +
                'null="' + a.getNull() + '" ' +
                'primary="' + a.getPrimary() + '" ' +
                'foreign="' + a.getForeign() + '" ' +
                'autoincrement="' + a.getAutoincrement() + '" ' +
                'unique="' + a.getUnique() + '" ' +
                'default="' + a.getDefault() + '" ' +
                'description="' + a.getDescription() + '" ' +
                '/>' + '\n';
        }

        ret += '\t\t' + '</class>' + '\n';
    }

    return ret;
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