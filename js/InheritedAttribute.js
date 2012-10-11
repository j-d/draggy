InheritedAttribute.prototype = new Item();           // Inheritance
InheritedAttribute.prototype.constructor = InheritedAttribute;

function InheritedAttribute (parentAttributeId) {
    this.innitItem('inheritedAttribute');

    this.attribute = parentAttributeId;
    this.links = [];

    Attribute.prototype.attributes[this.id] = this;
}

InheritedAttribute.prototype.getId = function () {
    return this.id;
};

InheritedAttribute.prototype.getParentId = function () {
    return this.attribute;
};

InheritedAttribute.prototype.getName = function () {
    return this.getAttribute().getName();
};

InheritedAttribute.prototype.getAttribute = function () {
    return Attribute.prototype.attributes[this.attribute];
};

InheritedAttribute.prototype.getType = function () {
    return this.getAttribute().getType();
};

InheritedAttribute.prototype.getSize = function () {
    return this.getAttribute().getSize();
};

InheritedAttribute.prototype.getNull = function () {
    return this.getAttribute().getNull();
};

InheritedAttribute.prototype.getPrimary = function () {
    return this.getAttribute().getPrimary();
};

InheritedAttribute.prototype.getForeign = function () {
    return this.getAttribute().getForeign();
};

InheritedAttribute.prototype.getAutoincrement = function () {
    return this.getAttribute().getAutoincrement();
};

InheritedAttribute.prototype.getUnique = function () {
    return this.getAttribute().getUnique();
};

InheritedAttribute.prototype.getDefault = function () {
    return this.getAttribute().getDefault();
};

InheritedAttribute.prototype.getDescription = function () {
    return this.getAttribute().getDescription();
};

InheritedAttribute.prototype.getOwner = function () {
    return this.getAttribute().getOwner();
};

InheritedAttribute.prototype.getInherited = function () {
    return true;
};

InheritedAttribute.prototype.getSetter = function () {
    return this.getAttribute().getSetter();
};

InheritedAttribute.prototype.getGetter = function () {
    return this.getAttribute().getGetter();
};

InheritedAttribute.prototype.toHtml = function () {
    var iconName = '';

    if (this.getPrimary()) {
        if (!this.getForeign())
            iconName = this.getNull() ? 'icon-primary-null' : 'icon-primary-not-null';
        else
            iconName = this.getNull() ? 'icon-primary-foreign-null' : 'icon-primary-foreign-not-null';
    }
    else if (this.getForeign())
        iconName = this.getNull() ? 'icon-foreign-null' : 'icon-foreign-not-null';
    else
        iconName = this.getNull() ? 'icon-field-null' : 'icon-field-not-null';

    var ret = '<span class="' + iconName + '"></span> <span class="inherited-attribute-name">' + this.getName() + '</span>';

    if (this.getType() != null)
        ret += ': <span class="attribute-information">' + this.getType() + '</span>';

    if (this.getSize() != null)
        ret += '<span class="attribute-information">(' + this.getSize() + ')</span>';

    return  ret;
};

InheritedAttribute.prototype.toXML = function () {
    return '<attribute ' +
        'id="' + this.getParentId() + '" ' +
        (this.getInherited() ? 'inherited="' + this.getInherited() + '" ' : '' ) +
        '/>';
};

Attribute.prototype.getNumberLinks = function () {
    return this.links.length;
};

Attribute.prototype.getLink = function (i) {
    return this.links[i];
};