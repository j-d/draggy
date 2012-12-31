Abstract.prototype = new ClassLike();           // Inheritance
Abstract.prototype.constructor = Abstract;

Abstract.prototype.abstracts = {};           // Static associative array
Abstract.prototype.abstractList = [];           // Static associative array

function Abstract (name, container) {
    this.innitClassLike('Abstract', container);

    Abstract.prototype.abstracts[this.id] = this;
    Abstract.prototype.abstractList.push(this);

    if (name == undefined) {
        this.name = this.getValidName('Connectable', 'Abstract', this.getFolder());
    } else {
        this.name = name;
    }

    $(
        '<div id="' + this.getId() + '" class="connectable abstract" style="position: absolute;"></div>'
    ).appendTo(container === undefined ? 'body' : Container.prototype.getContainerByName(container).getHashId());

    this.setDrawn(true);

    this.reDraw();
}

Abstract.prototype.toXML = function () {
    var ret = '';

    ret += '<abstract ' +
        'name="' + this.getName() + '" ' +
        'top="' + parseInt($(this.hashId).css('top')) + '" ' +
        'left="' + parseInt($(this.hashId).css('left')) + '"' +
        (this.getParent() != null ? ' inheritingFrom="' + this.getParent().getFullyQualifiedName() + '"' : '' ) +
        (this.getToString() != null ? ' toString="' + Attribute.prototype.attributes[this.getToString()].getName() + '"' : '' ) +
        (this.getDescription() != null ? ' description="' + this.getDescription() + '"' : '' ) +
        (this.getConstructor() ? ' constructor="true"' : '' ) +
    '';

    if (this.getNumberAttributes() == 0)
        ret += ' />' + '\n';
    else {
        ret += '>' + '\n';

        for (var i = 0; i < this.getNumberAttributes(); i++)
            ret += '\t\t\t' + this.getAttribute(i).toXML() + '\n';

        ret += '\t\t' + '</abstract>' + '\n';
    }

    return ret;
};

Abstract.prototype.remove = function () {
    delete Abstract.prototype.abstracts[this.id];
    Abstract.prototype.abstractList.remove(this);

    this.destroyClassLike();
};