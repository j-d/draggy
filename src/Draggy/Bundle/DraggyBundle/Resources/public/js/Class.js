Class.prototype = new ClassLike();           // Inheritance
Class.prototype.constructor = Class;

Class.prototype.classes = {};           // Static associative array
Class.prototype.classList = [];           // Static associative array

function Class (name, container) {
    this.innitClassLike('Class', container);

    Class.prototype.classes[this.id] = this;
    Class.prototype.classList.push(this);

    if (name == undefined) {
        this.name = this.getValidName('Connectable', 'Class', this.getFolder());
    } else {
        this.name = name;
    }

    $(
        '<div id="' + this.getId() + '" class="connectable class" style="position: absolute;"></div>'
    ).appendTo(container === undefined ? 'body' : Container.prototype.getContainerByName(container).getHashId());

    this.setDrawn(true);

    this.reDraw();

    this.repository = false;
    this.form = false;
    this.controller = false;
    this.fixtures = false;
    this.crud = null;
    this.routes = false;
    this.arrayAccess = false;

    this.type = 'class';
}

Class.prototype.isPureManyToMany = function () {
    return this.getNumberAttributes() == 2 &&
        this.getAttribute(0).getForeign() &&
        this.getAttribute(1).getForeign() &&
        (
            Link.prototype.links[this.getAttribute(0).getLink(0)].getType() == 'one-to-many' ||
            Link.prototype.links[this.getAttribute(1).getLink(0)].getType() == 'one-to-many'
        );
};

Class.prototype.toXML = function () {
    var ret = '';

    ret += '<class ' +
        'name="' + this.getName() + '" ' +
        'top="' + parseInt($(this.hashId).css('top')) + '" ' +
        'left="' + parseInt($(this.hashId).css('left')) + '"' +
        (this.getParent() != null ? ' inheritingFrom="' + this.getParent().getFullyQualifiedName() + '"' : '' ) +
        (this.getRepository() ? ' repository="' + this.getRepository() + '"' : '' ) +
        (this.getForm() ? ' form="' + this.getForm() + '"' : '' ) +
        (this.getController() ? ' controller="' + this.getController() + '"' : '' ) +
        (this.getFixtures() ? ' fixtures="' + this.getFixtures() + '"' : '' ) +
        (this.getToString() != null ? ' toString="' + Attribute.prototype.attributes[this.getToString()].getName() + '"' : '' ) +
        (this.getDescription() != null ? ' description="' + this.getDescription() + '"' : '' ) +
        (this.getCrud() != null ? ' crud="' + this.getCrud() + '"' : '' ) +
        (this.getRoutes() ? ' routes="' + this.getRoutes() + '"' : '' ) +
        (this.isPureManyToMany() ? ' manyToMany="true"' : '' ) +
        (this.getConstructor() ? ' constructor="true"' : '' ) +
        (this.getArrayAccess() ? ' arrayAccess="' + this.getArrayAccess() + '"' : '' ) +
    '';

    if (this.getNumberAttributes() == 0) {
        ret += ' />' + '\n';
    } else {
        ret += '>' + '\n';

        for (var i = 0; i < this.getNumberAttributes(); i++)
            ret += '\t\t\t' + this.getAttribute(i).toXML() + '\n';

        ret += '\t\t' + '</class>' + '\n';
    }

    return ret;
};

Class.prototype.remove = function () {
    delete Class.prototype.classes[this.id];
    Class.prototype.classList.remove(this);

    this.destroyClassLike();
};

Class.prototype.setRepository = function (repository) {
    this.repository = repository;
};

Class.prototype.getRepository = function () {
    return this.repository;
};

Class.prototype.setForm = function (form) {
    this.form = form;
};

Class.prototype.getForm = function () {
    return this.form;
};

Class.prototype.setController = function (controller) {
    this.controller = controller;
};

Class.prototype.getController = function () {
    return this.controller;
};

Class.prototype.setFixtures = function (fixtures) {
    this.fixtures = fixtures;
};

Class.prototype.getFixtures = function () {
    return this.fixtures;
};

Class.prototype.setCrud = function (crud) {
    if (crud) {
        this.crud = crud;
    } else {
        this.crud = null;
    }

    return this;
};

Class.prototype.setRoutes = function (routes) {
    this.routes = routes;
};

Class.prototype.getRoutes = function () {
    return this.routes;
};

Class.prototype.getCrud = function () {
    return this.crud;
};

Class.prototype.setArrayAccess = function (arrayAccess) {
    this.arrayAccess = arrayAccess;
};

Class.prototype.getArrayAccess = function () {
    return this.arrayAccess;
};
