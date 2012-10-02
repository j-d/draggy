ClassLike.prototype = new Connectable();           // Inheritance
ClassLike.prototype.constructor = ClassLike;

function ClassLike () {
}

ClassLike.prototype.innitClassLike = function (desiredId) {
    this.inheritingFrom = null;
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