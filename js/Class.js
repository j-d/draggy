Class.prototype = new Item();           // Inheritance
Class.prototype.constructor = Class;

Class.prototype.classes = {};           // Static associative array

function Class (name,container) {
    if (name == undefined)
        this.name = this.getValidName('Class');
    else
        this.name = name;

    this.innit('Class');

    Class.prototype.classes[this.id] = this;

    if (container != undefined) {
        var c = Container.prototype.getContainerByName(container);
        c.addObject(this.id);
    }

    $(
        '<div id="' + this.getId() + '" class="item class" style="position: absolute; top: ' + Math.floor((Math.random()*15)+1)*20 + 'px; left: ' + Math.floor((Math.random()*15)+1)*20 + 'px;">' +
        '</div>'
    ).appendTo(container == undefined ? 'body' : c.hashId);


    this.reDraw();
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
        for (var i = 0; i < this.getNumberAttributes(); i++)
            ret += '\t\t\t' + this.getAttribute(i).toXML() + '\n';

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

function addClass(name,container) {
    new Class(name,container);
}

function removeClass(name) {
    Class.prototype.getItemByName(name).remove();
}