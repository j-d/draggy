ClassLike.prototype = new Connectable();           // Inheritance
ClassLike.prototype.constructor = ClassLike;

function ClassLike () {} // Abstract class

ClassLike.prototype.innitClassLike = function (desiredId) {
    this.inheritingFrom = null;
    this.toString = null;

    this.innitConnectable(desiredId);

    this.children = [];
};

ClassLike.prototype.setInheritingFrom = function (parentId) {
    var parent;

    if (parentId != null) {
        this.inheritingFrom = parentId;

        parent = Item.prototype.items[this.inheritingFrom];

        parent.children.push(this.id);
    }
    else { //Un-inherit
        parent = Item.prototype.items[this.inheritingFrom];

        parent.children.remove(this.id);

        this.inheritingFrom = null;
    }
};

ClassLike.prototype.getInheritedFrom = function () {
    return this.inheritingFrom;
};

ClassLike.prototype.inheritAttributes = function () {
    var parent = Item.prototype.items[this.inheritingFrom];
    var ia;

    for (var i = 0; i < parent.getNumberAttributes(); i++) {
        if (parent.getAttribute(i) instanceof InheritedAttribute)
            ia = new InheritedAttribute(parent.getAttribute(i).getParentId());
        else
            ia = new InheritedAttribute(parent.getAttribute(i).getId());

        this.addInheritedAttribute(ia);
    }

    // Has to skip the ones that are already inherited
    // May need to inherit to the grandchildren
};

ClassLike.prototype.unInheritAttributes = function () {
    var parent = Item.prototype.items[this.inheritingFrom];

    for (var i = 0; i < parent.getNumberAttributes(); i++) {
        var ia = parent.getAttribute(i);

        this.removeInheritedAttribute(ia);
    }

    // Uninherit to children
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

ClassLike.prototype.destroyClassLike = function () {
    this.destroyConnectable();
};