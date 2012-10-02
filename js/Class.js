Class.prototype = new ClassLike();           // Inheritance
Class.prototype.constructor = Class;

Class.prototype.classes = {};           // Static associative array

function Class (name,container) {
    this.innitClassLike('Class');

    if (name == undefined)
        this.name = this.getValidName('Class');
    else
        this.name = name;

    Class.prototype.classes[this.id] = this;

    if (container != undefined) {
        var c = Container.prototype.getContainerByName(container);
        c.addObject(this.id);
    }

    $(
        '<div id="' + this.getId() + '" class="connectable class" style="position: absolute; top: ' + Math.floor((Math.random()*15)+1)*20 + 'px; left: ' + Math.floor((Math.random()*15)+1)*20 + 'px;">' +
        '</div>'
    ).appendTo(container == undefined ? 'body' : c.hashId);


    this.reDraw();
};

Class.prototype.toXML = function () {
    var ret = '';

    ret += '<class ' +
        'name="' + this.getName() + '" ' +
        'top="' + parseInt($(this.hashId).css('top')) + '" ' +
        'left="' + parseInt($(this.hashId).css('left')) + '"';

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
    for (var i in Class.prototype.classes)
        if (Class.prototype.classes[i].getName() == this.name) {
            delete Class.prototype.classes[i];
            break;
        }

    this.destroyConnectable();
};

function addClass(name,container) {
    new Class(name,container);
}

function removeClass(name) {
    Connectable.prototype.getConnectableFromName(name).remove();
}