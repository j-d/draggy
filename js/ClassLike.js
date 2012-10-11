ClassLike.prototype = new Connectable();           // Inheritance
ClassLike.prototype.constructor = ClassLike;

function ClassLike () {} // Abstract class

ClassLike.prototype.innitClassLike = function (desiredId) {
    this.inheritingFrom = null;
    this.toString = null;

    this.innitConnectable(desiredId);

    this.children = [];
};

ClassLike.prototype.inheritFrom = function (parentId) {
    this.inheritingFrom = parentId;

    var parent = Item.prototype.items[parentId];

    parent.children.push(this.id);
};

ClassLike.prototype.inheritAttributes = function () {
    var parent = Item.prototype.items[this.inheritingFrom];

    for (var i = 0; i < parent.getNumberAttributes(); i++) {
        var ia = new InheritedAttribute(parent.getAttribute(i).getId());
        this.addInheritedAttribute(ia);
    }

    // Has to skip the ones that are already inherited
    // May need to inherit to the grandchildren
};

ClassLike.prototype.getParent = function () {
    if (this.inheritingFrom == null)
        return null;
    else
        return Connectable.prototype.connectables[this.inheritingFrom];
};

ClassLike.prototype.setToString = function (toString) {
    this.toString = toString;
};

ClassLike.prototype.getToString = function () {
    return this.toString;
};
