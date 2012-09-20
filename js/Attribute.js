function Attribute (name, type, size, nul, primary, foreign, autoincrement, unique, def, description) {
    this.id = getUniqueId('attribute');
    this.name = name;
    this.type = type == undefined ? null : type;
    this.size = size == undefined ? null : size;
    this.null = nul == undefined ? false : nul;
    this.primary = primary == undefined ? false : primary;
    this.foreign = foreign == undefined ? false : foreign;
    this.autoincrement = autoincrement == undefined ? false : autoincrement;
    this.unique = unique == undefined ? false : unique;
    this.default = def == undefined ? '' : def;
    this.description = description == undefined ? '' : description;
}

Attribute.prototype.setName = function (name) {
    this.name = name;
};

Attribute.prototype.getName = function () {
    return this.name;
};

Attribute.prototype.setType = function (type) {
    this.type = type;
};

Attribute.prototype.getType = function () {
    return this.type;
};

Attribute.prototype.setSize = function (size) {
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
    this.default = def;
};

Attribute.prototype.getDefault = function () {
    return this.default;
};

Attribute.prototype.setDescription = function (description) {
    this.description = description;
};

Attribute.prototype.getDescription = function () {
    return this.description;
};

Attribute.prototype.inheritedToHtml = function () {
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

    var ret = '<span class="' + iconName + '"></span> <span class="inherited-attribute">' + this.getName() + '</span>';

    if (this.getType() != null)
        ret += ': <span class="attribute inherited-attribute">' + this.getType() + '</span>';

    if (this.getSize() != '')
        ret += '<span class="attribute inherited-attribute">(' + this.getSize() + ')</span>';

    return  ret;
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
        ret += ': <span class="attribute">' + this.getType() + '</span>';

    if (this.getSize() != '')
        ret += '<span class="attribute">(' + this.getSize() + ')</span>';

    return  ret;
};

Attribute.prototype.toXML = function () {
    return '<attribute ' +
        'name="' + this.getName() + '" ' +
        'type="' + this.getType() + '" ' +
        (this.getSize() != null ? 'size="' + this.getSize() + '" ' : '') +
        (this.getNull() ? 'null="' + this.getNull() + '" ' : '') +
        (this.getPrimary() ? 'primary="' + this.getPrimary() + '" ' : '' ) +
        (this.getForeign() ? 'foreign="' + this.getForeign() + '" ' : '' ) +
        (this.getAutoincrement() ? 'autoincrement="' + this.getAutoincrement() + '" ' : '' ) +
        (this.getUnique() ? 'unique="' + this.getUnique() + '" ' : '' ) +
        (this.getDefault() != '' ? 'default="' + this.getDefault() + '" ' : '' ) +
        (this.getDescription() != '' ? 'description="' + this.getDescription() + '" ' : '' ) +
    '/>';
};