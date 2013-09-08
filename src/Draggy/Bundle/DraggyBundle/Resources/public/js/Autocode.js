function Autocode () { }

Autocode.prototype.properties     = {};
Autocode.prototype.configurations = {};
Autocode.prototype.templates      = {};

Autocode.prototype.setProperty = function (property, value) {
    Autocode.prototype.properties[property] = value;
};

Autocode.prototype.getProperty = function (property) {
    return Autocode.prototype.properties[property];
};

Autocode.prototype.setConfiguration = function (configuration, value) {
    Autocode.prototype.configurations[configuration] = value;
};

Autocode.prototype.getConfiguration = function (configuration) {
    return Autocode.prototype.configurations[configuration];
};

Autocode.prototype.setTemplate = function (template, value) {
    Autocode.prototype.templates[template] = value;
};

Autocode.prototype.getTemplate = function (template) {
    return Autocode.prototype.templates[template];
};

Autocode.prototype.toXML = function () {
    var ret = "";

    var i;

    ret += "\t<autocode>\n";

    ret += "\t\t<properties>\n";

    for (var i in Draggy.prototype.getAutocodeProperties()) {
        ret += "\t\t\t<" + i + ">" + Autocode.prototype.getProperty(i) + "</" + i + ">\n";
    }

    ret += "\t\t</properties>\n";

    ret += "\t\t<configurations>\n";

    for (var i in Draggy.prototype.getAutocodeConfigurations()) {
        ret += null !== Autocode.prototype.getConfiguration(i) && undefined !== Autocode.prototype.getConfiguration(i)
            ? "\t\t\t<" + i + ">" + Autocode.prototype.getConfiguration(i) + "</" + i + ">\n"
            : "\t\t\t<" + i + "/>\n";
    }

    ret += "\t\t</configurations>\n";

    ret += "\t\t<templates>\n";

    for (var i in Draggy.prototype.getAutocodeTemplates()) {
        ret += null !== Autocode.prototype.getTemplate(i) && undefined !== Autocode.prototype.getTemplate(i)
            ? "\t\t\t<" + i + ">" + Autocode.prototype.getTemplate(i) + "</" + i + ">\n"
            : "\t\t\t<" + i + "/>\n";
    }

    ret += "\t\t</templates>\n";

    ret += "\t</autocode>\n";

    return ret;
};
