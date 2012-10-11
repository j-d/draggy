Attribute.prototype = new Item();           // Inheritance
Attribute.prototype.constructor = Attribute;

Attribute.prototype.attributes = {};

function Attribute (name, id) {
    this.innitItem(id == undefined ? 'attribute' : id);

    this.owner = null;
    this.name = name;
    this.type = null;
    this.size = null;
    this.null = false;
    this.primary = false;
    this.foreign = false;
    this.autoincrement = false;
    this.unique = false;
    this.default = null;
    this.description = null;
    this.links = [];

    this.setter = true;
    this.getter = true;

    Attribute.prototype.attributes[this.id] = this;
}

Attribute.prototype.setType = function (type) {
    switch (type) {
        case 'array':
        case 'bigint':
        case 'boolean':
        case 'date':
        case 'datetime':
        case 'decimal':
        case 'integer':
        case 'object':
        case 'smallint':
        case 'string':
        case 'text':
        case 'time':
            this.type = type;
            break;
        default:
            this.type = null;
    }
};

Attribute.prototype.getType = function () {
    return this.type;
};

Attribute.prototype.setSize = function (size) {
    if (size != '')
        this.size = size;
};

Attribute.prototype.getSize = function () {
    return this.size;
};

Attribute.prototype.setNull = function (n) {
    this.null = n;
};

Attribute.prototype.getNull = function () {
    return this.null;
};

Attribute.prototype.setPrimary = function (primary) {
    this.primary = primary;
};

Attribute.prototype.getPrimary = function () {
    return this.primary;
};

Attribute.prototype.setForeign = function (foreign) {
    this.foreign = foreign;
};

Attribute.prototype.getForeign = function () {
    return this.foreign;
};

Attribute.prototype.setAutoincrement = function (autoincrement) {
    this.autoincrement = autoincrement;
};

Attribute.prototype.getAutoincrement = function () {
    return this.autoincrement;
};

Attribute.prototype.setUnique = function (unique) {
    this.unique = unique;
};

Attribute.prototype.getUnique = function () {
    return this.unique;
};

Attribute.prototype.setDefault = function (def) {
    if (def != '')
        this.default = def;
    else
        this.default = null;
};

Attribute.prototype.getDefault = function () {
    return this.default;
};

Attribute.prototype.setOwner = function (owner) {
    this.owner = owner;
}

Attribute.prototype.getOwner = function () {
    return this.owner;
};

Attribute.prototype.getInherited = function () {
    return false;
};

Attribute.prototype.toHtml = function () {
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

    var ret = '<span class="' + iconName + '"></span> ' + this.getName();

    if (this.getType() != null)
        ret += ': <span class="attribute-information">' + this.getType() + '</span>';

    if (this.getSize() != null)
        ret += '<span class="attribute-information">(' + this.getSize() + ')</span>';

    return  ret;
};

Attribute.prototype.toXML = function () {
    return '<attribute ' +
        'id="' + this.getId() + '" ' +
        'name="' + this.getName() + '" ' +
        'type="' + this.getType() + '" ' +
        (this.getSize() != null ? 'size="' + this.getSize() + '" ' : '') +
        (this.getNull() ? 'null="' + this.getNull() + '" ' : '') +
        (this.getPrimary() ? 'primary="' + this.getPrimary() + '" ' : '' ) +
        (this.getForeign() ? 'foreign="' + this.getForeign() + '" ' : '' ) +
        (this.getAutoincrement() ? 'autoincrement="' + this.getAutoincrement() + '" ' : '' ) +
        (this.getUnique() ? 'unique="' + this.getUnique() + '" ' : '' ) +
        (this.getDefault() != null ? 'default="' + this.getDefault() + '" ' : '' ) +
        (this.getDescription() != null ? 'description="' + this.getDescription() + '" ' : '' ) +
        (!this.getSetter() ? 'setter="' + this.getSetter() + '" ' : '' ) +
        (!this.getGetter() ? 'getter="' + this.getGetter() + '" ' : '' ) +
    '/>';
};

Attribute.prototype.copyFrom = function (attr) {
    this.setOwner(attr.getOwner());
    this.setName(attr.getName());
    this.setType(attr.getType());
    this.setSize(attr.getSize());
    this.setNull(attr.getNull());
    this.setPrimary(attr.getPrimary());
    this.setForeign(attr.getForeign());
    this.setAutoincrement(attr.getAutoincrement());
    this.setUnique(attr.getUnique());
    this.setDefault(attr.getDefault());
    this.setDescription(attr.getDescription());
};

Attribute.prototype.getNumberLinks = function () {
    return this.links.length;
};

Attribute.prototype.getLink = function (i) {
    return this.links[i];
};

Attribute.prototype.setSetter = function (setter) {
    this.setter = setter;
};

Attribute.prototype.getSetter = function () {
    return this.setter;
};

Attribute.prototype.setGetter = function (getter) {
    this.getter = getter;
};

Attribute.prototype.getGetter = function () {
    return this.getter;
};