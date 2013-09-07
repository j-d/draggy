ClassLike.prototype = new Connectable();           // Inheritance
ClassLike.prototype.constructor = ClassLike;

function ClassLike () {} // Abstract class

ClassLike.prototype.innitClassLike = function (desiredId, container) {
    this.inheritingFrom = null;
    this.toString = null;
    this.constructor = false;

    this.innitConnectable(desiredId, container);

    this.children = [];
};

ClassLike.prototype.setInheritingFrom = function (parentId) {
    var parent;

    if (parentId != null) {
        this.inheritingFrom = parentId;

        parent = Item.prototype.items[this.inheritingFrom];

        parent.children.push(this.id);
    } else { //Un-inherit
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
    if (this.inheritingFrom == null) {
        return null;
    } else {
        return Connectable.prototype.connectables[this.inheritingFrom];
    }
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

ClassLike.prototype.setConstructor = function (c) {
    this.constructor = c;

    return this;
};

ClassLike.prototype.getConstructor = function () {
    return this.constructor;
};

ClassLike.prototype.canInheritFrom = function (potentialParent) {
    var i, j;
    var attribute;

    for (i = 0; i < potentialParent.getNumberAttributes(); i++) {
        attribute = potentialParent.getAttribute(i);

        for (j = 0; j < this.getNumberAttributes(); j++) {
            if (attribute.getName() === this.getAttribute(j).getName()) {
                return false;
            }
        }
    }

    if (this.children.length > 0) {
        for (i = 0; i < this.children.length; i++) {
            if (!Connectable.prototype.connectables[this.children[i]].canInheritFrom(potentialParent)) {
                return false;
            }
        }
    }

    return true;
};

ClassLike.prototype.getChildren = function ()
{
    return this.children;
};

ClassLike.prototype.getImplementing = function()
{
    var r = [];
    var link;


    for (var i in this.links) {
        link = Link.prototype.links[this.links[i]];

        if (undefined !== link && link.getType() === 'implements' && link.getFrom() === this.getId()) {
            r.push(link.getTo());
        }
    }

    return r;
};