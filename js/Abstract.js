Abstract.prototype = new ClassLike();           // Inheritance
Abstract.prototype.constructor = Abstract;

Abstract.prototype.abstracts = {};           // Static associative array

function Abstract (name,container) {
    this.innitClassLike('Abstract');

    if (name == undefined)
        this.name = this.getValidName('Abstract');
    else
        this.name = name;

    Abstract.prototype.abstracts[this.id] = this;

    if (container != undefined) {
        var c = Container.prototype.getContainerByName(container);
        c.addObject(this.id);
    }

    $(
        '<div id="' + this.getId() + '" class="connectable abstract" style="position: absolute; top: ' + Math.floor((Math.random()*15)+1)*20 + 'px; left: ' + Math.floor((Math.random()*15)+1)*20 + 'px;">' +
            '</div>'
    ).appendTo(container == undefined ? 'body' : c.hashId);


    this.reDraw();
};

Abstract.prototype.toXML = function () {
    var ret = '';

    ret += '<abstract ' +
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

        ret += '\t\t' + '</abstract>' + '\n';
    }

    return ret;
};

Abstract.prototype.remove = function () {
    this.itemRemove();

    for (var i in Abstract.prototype.abstracts)
        if (Abstract.prototype.abstracts[i].getName() == this.name) {
            delete Abstract.prototype.abstracts[i];
            break;
        }
};

function addAbstract(name,container) {
    new Abstract(name,container);
}

function removeAbstract(name) {
    Abstract.prototype.getItemByName(name).remove();
}