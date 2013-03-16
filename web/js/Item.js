function Item () { }

Item.prototype.items = {};                       // Static associative array

Item.prototype.innitItem = function (desiredId) {
    this.id = Draggy.prototype.getUniqueId(desiredId);
    this.hashId = '#' + this.id;
    this.name = null;
    this.description = null;

    Item.prototype.items[this.id] = this;
};

Item.prototype.destroyItem = function () {
    delete Item.prototype.items[this.id];
};

Item.prototype.getId = function () {
    return this.id;
};

Item.prototype.getHashId = function () {
    return this.hashId;
};

Item.prototype.setName = function (name) {
    this.name = name;
};

Item.prototype.getName = function () {
    return this.name;
};

Item.prototype.setDescription = function (description) {
    if (description != '')
        this.description = description;
    else
        this.description = null;
};

Item.prototype.getDescription = function () {
    return this.description;
};