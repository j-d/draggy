Interface.prototype = new Connectable();           // Inheritance
Interface.prototype.constructor = Interface;

Interface.prototype.interfaces = {};           // Static associative array
Interface.prototype.interfaceList = [];           // Static associative array

function Interface (name, container) {
    this.innitConnectable('Interface', container);

    Interface.prototype.interfaces[this.id] = this;
    Interface.prototype.interfaceList.push(this);

    if (name === undefined) {
        this.name = this.getValidName('Connectable', 'Interface', this.getFolder());
    } else {
        this.name = name;
    }

    $(
        '<div id="' + this.getId() + '" class="connectable interface" style="position: absolute;"></div>'
    ).appendTo(container === undefined ? 'body' : Container.prototype.getContainerByName(container).getHashId());

    this.setDrawn(true);

    this.reDraw();
}


Interface.prototype.toXML = function () {
    var ret = '';

    ret += '<interface ' +
        'name="' + this.getName() + '" ' +
        'top="' + parseInt($(this.hashId).css('top')) + '" ' +
        'left="' + parseInt($(this.hashId).css('left')) + '"' +
        (this.getDescription() != null ? ' description="' + this.getDescription() + '"' : '' ) +
        ' />' + '\n';

    return ret;
};

Interface.prototype.remove = function () {
    delete Interface.prototype.interfaces[this.id];
    Interface.prototype.interfaceList.remove(this);

    this.destroyConnectable();
};