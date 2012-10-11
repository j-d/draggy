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

    this.repository = false;
}

Class.prototype.isPureManyToMany = function () {
    return this.getNumberAttributes() == 2 && this.getAttribute(0).getForeign() && this.getAttribute(1).getForeign();
};

Class.prototype.toXML = function () {
    var ret = '';

    ret += '<class ' +
        'name="' + this.getName() + '" ' +
        'top="' + parseInt($(this.hashId).css('top')) + '" ' +
        'left="' + parseInt($(this.hashId).css('left')) + '"' +
        (this.getParent() != null ? ' inheritingFrom="' + this.getParent().getName() + '"' : '' ) +
        (this.getRepository() ? ' repository="' + this.getRepository() + '"' : '' ) +
        (this.getToString() != null ? ' toString="' + Attribute.prototype.attributes[this.getToString()].getName() + '"' : '' ) +
        (this.getDescription() != null ? ' description="' + this.getDescription() + '"' : '' ) +
        (this.isPureManyToMany() ? ' manyToMany="true"' : '' ) +
    '';

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

Class.prototype.setRepository = function (repository) {
    this.repository = repository;
};

Class.prototype.getRepository = function () {
    return this.repository;
};

function addClass(name,container) {
    new Class(name,container);
}

function removeClass(name) {
    Connectable.prototype.getConnectableFromName(name).remove();
}