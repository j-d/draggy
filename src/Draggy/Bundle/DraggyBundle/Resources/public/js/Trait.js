Trait.prototype = new Connectable();           // Inheritance
Trait.prototype.constructor = Trait;

Trait.prototype.traits = {};           // Static associative array
Trait.prototype.traitList = [];           // Static associative array

function Trait (name, container) {
    this.innitConnectable('Trait', container);

    Trait.prototype.traits[this.id] = this;
    Trait.prototype.traitList.push(this);

    if (name == undefined) {
        this.name = this.getValidName('Connectable', 'Trait', this.getFolder());
    } else {
        this.name = name;
    }

    $(
        '<div id="' + this.getId() + '" class="connectable trait" style="position: absolute;"></div>'
    ).appendTo(container === undefined ? 'body' : Container.prototype.getContainerByName(container).getHashId());

    this.setDrawn(true);

    this.reDraw();
}


Trait.prototype.toXML = function () {
    var ret = '';

    ret += '<trait ' +
        'name="' + this.getName() + '" ' +
        'top="' + parseInt($(this.hashId).css('top')) + '" ' +
        'left="' + parseInt($(this.hashId).css('left')) + '"' +
        (this.getDescription() != null ? ' description="' + this.getDescription() + '"' : '' ) +
        '';

    if (this.getNumberAttributes() == 0)
        ret += ' />' + '\n';
    else {
        ret += '>' + '\n';

        for (var i = 0; i < this.getNumberAttributes(); i++)
            ret += '\t\t\t' + this.getAttribute(i).toXML() + '\n';

        ret += '\t\t' + '</trait>' + '\n';
    }

    return ret;
};

Trait.prototype.remove = function () {
    delete Trait.prototype.traits[this.id];
    Trait.prototype.traitList.remove(this);

    this.destroyConnectable();
};