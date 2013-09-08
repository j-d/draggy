Attribute.prototype = new Item();           // Inheritance
Attribute.prototype.constructor = Attribute;

Attribute.prototype.attributes = {};

function Attribute (name, id)
{
    this.innitItem(id == undefined ? 'attribute' : id);

    this.owner = null;
    this.name = name;
    this.type = null;
    this.subtype = null;
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
    this.minSize = null;
    this.email = false;
    this.min = null;
    this.max = null;

    this.static = false;

    Attribute.prototype.attributes[this.id] = this;
}

Attribute.prototype.remove = function ()
{
    delete Attribute.prototype.attributes[this.id];

    this.destroyItem();
};

Attribute.prototype.setType = function (type)
{
    if (type != this.type) {
        if (undefined !== Draggy.prototype.getAttributeTypes()[type]) {
            this.type = type;
        } else {
            this.type = null;
        }

        // Update linked attributes
        if (this.links.length > 0) {
            for (var i = 0; i < this.links.length; i++) {
                if (Link.prototype.links[this.links[i]].getFromAttribute() == this.getId()) {
                    Attribute.prototype.attributes[Link.prototype.links[this.links[i]].getToAttribute()].setType(type);
                    Connectable.prototype.connectables[Link.prototype.links[this.links[i]].getTo()].reDraw();
                }
            }
        }
    }
};

Attribute.prototype.getType = function ()
{
    return this.type;
};

Attribute.prototype.setSubtype = function (subtype)
{
    if (subtype !== this.subtype) {
        var oldSubtype = this.subtype;

        if (subtype === '') {
            subtype = null;
        }

        if (subtype !== null) {
            this.subtype = subtype;
        }

        var attributeTypes = Draggy.prototype.getAttributeTypes();

        if (oldSubtype !== '' && oldSubtype !== null && undefined === attributeTypes[oldSubtype]) { // It was a class subtype
            Connectable.prototype.getConnectableFromName(oldSubtype).removeDependantAttribute(this.getId());
        }

        if (subtype !== '' && subtype !== null && subtype !== undefined && undefined === attributeTypes[subtype]) { // Is a class subtype
            Connectable.prototype.getConnectableFromName(subtype).addDependantAttribute(this.getId());
        }

        // Update linked attributes
        if (this.links.length > 0) {
            for (var i = 0; i < this.links.length; i++) {
                if (Link.prototype.links[this.links[i]].getFromAttribute() == this.getId()) {
                    Attribute.prototype.attributes[Link.prototype.links[this.links[i]].getToAttribute()].setSubtype(subtype);
                    Connectable.prototype.connectables[Link.prototype.links[this.links[i]].getTo()].reDraw();
                }
            }
        }
    }
};

Attribute.prototype.getSubtype = function ()
{
    return this.subtype;
};

Attribute.prototype.setName = function (desiredName)
{
    // Before runtime the attribute names are assumed to be correct. This is because it could happen that an attribute
    // is required that has not been loaded yet. Otherwise it has to check that it is available.

    this.name = System.prototype.runtime
        ? Connectable.prototype.connectables[this.getOwner()].getValidAttributeName(desiredName, this)
        : desiredName;
};

Attribute.prototype.setSize = function (size)
{
    if (size != this.size) {
        if (size != '') {
            this.size = size;
        } else {
            this.size = null;
        }

        // Update linked attributes
        if (this.links.length > 0) {
            for (var i = 0; i < this.links.length; i++) {
                if (Link.prototype.links[this.links[i]].getFromAttribute() == this.getId()) {
                    Attribute.prototype.attributes[Link.prototype.links[this.links[i]].getToAttribute()].setSize(size);
                    Connectable.prototype.connectables[Link.prototype.links[this.links[i]].getTo()].reDraw();
                }
            }
        }
    }
};

Attribute.prototype.getSize = function ()
{
    return this.size;
};

Attribute.prototype.setMinSize = function (size)
{
    if (size != this.minSize) {
        if (size != '') {
            this.minSize = size;
        } else {
            this.minSize = null;
        }

        // Update linked attributes
        if (this.links.length > 0) {
            for (var i = 0; i < this.links.length; i++) {
                if (Link.prototype.links[this.links[i]].getFromAttribute() == this.getId()) {
                    Attribute.prototype.attributes[Link.prototype.links[this.links[i]].getToAttribute()].setMinSize(size);
                }
            }
        }
    }
};

Attribute.prototype.getMinSize = function ()
{
    return this.minSize;
};

Attribute.prototype.setEmail = function (email)
{
    if (email != this.email) {
        this.email = email;

        // Update linked attributes
        if (this.links.length > 0) {
            for (var i = 0; i < this.links.length; i++)
                if (Link.prototype.links[this.links[i]].getFromAttribute() == this.getId()) {
                    Attribute.prototype.attributes[Link.prototype.links[this.links[i]].getToAttribute()].setEmail(email);
                }
        }
    }
};

Attribute.prototype.getEmail = function ()
{
    return this.email;
};

Attribute.prototype.setNull = function (n)
{
    this.null = n;
};

Attribute.prototype.getNull = function ()
{
    return this.null;
};

Attribute.prototype.setPrimary = function (primary)
{
    this.primary = primary;
};

Attribute.prototype.getPrimary = function ()
{
    return this.primary;
};

Attribute.prototype.setForeign = function (foreign)
{
    this.foreign = foreign;
};

Attribute.prototype.getForeign = function ()
{
    return this.foreign;
};

Attribute.prototype.setAutoincrement = function (autoincrement)
{
    this.autoincrement = autoincrement;
};

Attribute.prototype.getAutoincrement = function ()
{
    return this.autoincrement;
};

/**
 *
 * @param unique
 * @return {Attribute}
 */
Attribute.prototype.setUnique = function (unique)
{
    this.unique = unique;

    return this;
};

/**
 * @return {boolean}
 */
Attribute.prototype.getUnique = function ()
{
    return this.unique;
};

Attribute.prototype.setDefault = function (def)
{
    if (def != '') {
        this.default = def;
    } else {
        this.default = null;
    }

    return this;
};

Attribute.prototype.getDefault = function ()
{
    return this.default;
};

Attribute.prototype.setOwner = function (owner)
{
    this.owner = owner;
};

Attribute.prototype.getOwner = function ()
{
    return this.owner;
};

Attribute.prototype.getInherited = function ()
{
    return false;
};

Attribute.prototype.toHtml = function ()
{
    var iconName = '';

    if (this.getPrimary()) {
        if (!this.getForeign()) {
            iconName = this.getNull() ? 'icon-primary-null' : 'icon-primary-not-null';
        } else {
            iconName = this.getNull() ? 'icon-primary-foreign-null' : 'icon-primary-foreign-not-null';
        }
    } else if (this.getForeign()) {
        iconName = this.getNull() ? 'icon-foreign-null' : 'icon-foreign-not-null';
    } else {
        iconName = this.getNull() ? 'icon-field-null' : 'icon-field-not-null';
    }

    var ret = '<span class="' + iconName + '"></span> ' + this.getName();

    if (null !== this.getType()) {
        ret += ': <span class="attribute-information">' + this.getType();

        if (this.getSubtype() !== null) {
            ret += ' (' + this.getSubtype() + ')';
        }

        ret += '</span>';
    }

    if (this.getSize() != null) {
        ret += '<span class="attribute-information">(' + this.getSize() + ')</span>';
    }

    return  ret;
};

Attribute.prototype.toXML = function ()
{
    return '<attribute ' +
        'id="' + this.getId() + '" ' +
        'name="' + this.getName() + '" ' +
        (this.getType() != null ? 'type="' + this.getType() + '" ' : '') +
        (this.getSubtype() != null ? 'subtype="' + this.getSubtype() + '" ' : '') +
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
        (this.getMinSize() != null ? 'minSize="' + this.getMinSize() + '" ' : '') +
        (this.getEmail() ? 'email="' + this.getEmail() + '" ' : '' ) +
        (this.getMin() != null ? 'min="' + this.getMin() + '" ' : '') +
        (this.getMax() != null ? 'max="' + this.getMax() + '" ' : '') +
        (this.getStatic() ? 'static="' + this.getStatic() + '" ' : '') +
    '/>';
};

Attribute.prototype.copyFrom = function (attr)
{
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
    this.setMinSize(attr.getMinSize());
    this.setEmail(attr.getEmail());
    this.setMin(attr.getMin());
    this.setMax(attr.getMax());
};

Attribute.prototype.getNumberLinks = function ()
{
    return this.links.length;
};

Attribute.prototype.getLink = function (i)
{
    return this.links[i];
};

Attribute.prototype.setSetter = function (setter)
{
    this.setter = setter;
};

Attribute.prototype.getSetter = function ()
{
    return this.setter;
};

Attribute.prototype.setGetter = function (getter)
{
    this.getter = getter;
};

Attribute.prototype.getGetter = function ()
{
    return this.getter;
};

Attribute.prototype.setMin = function (min)
{
    if (min != this.min) {
        if (min != '') {
            this.min = min;
        } else {
            this.min = null;
        }

        // Update linked attributes
        if (this.links.length > 0) {
            for (var i = 0; i < this.links.length; i++) {
                if (Link.prototype.links[this.links[i]].getFromAttribute() == this.getId()) {
                    Attribute.prototype.attributes[Link.prototype.links[this.links[i]].getToAttribute()].setMin(min);
                }
            }
        }
    }
};

Attribute.prototype.getMin = function ()
{
    return this.min;
};

Attribute.prototype.setMax = function (max)
{
    if (max != this.max) {
        if (max != '') {
            this.max = max;
        } else {
            this.max = null;
        }

        // Update linked attributes
        if (this.links.length > 0) {
            for (var i = 0; i < this.links.length; i++) {
                if (Link.prototype.links[this.links[i]].getFromAttribute() == this.getId()) {
                    Attribute.prototype.attributes[Link.prototype.links[this.links[i]].getToAttribute()].setMax(max);
                }
            }
        }
    }
};

Attribute.prototype.getMax = function ()
{
    return this.max;
};

/**
 * Set static
 *
 * @param {boolean} staticAttribute
 *
 * @return {*}
 */
Attribute.prototype.setStatic = function (staticAttribute)
{
    this.static = staticAttribute;

    return this;
};

/**
 * Get static
 *
 * @return {boolean}
 */
Attribute.prototype.getStatic = function ()
{
    return this.static;
};