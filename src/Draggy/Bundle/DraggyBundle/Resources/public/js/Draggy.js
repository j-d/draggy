function Draggy () { }

Draggy.prototype.issuedIds = [];

Draggy.prototype.language = null;
Draggy.prototype.description = null;
Draggy.prototype.orm = null;
Draggy.prototype.framework = null;

Draggy.prototype.saveAddress = null;
Draggy.prototype.previewAddress = null;
Draggy.prototype.generateAddress = null;
Draggy.prototype.ignoreFiles = [];
Draggy.prototype.configuration = {};
Draggy.prototype.currentConfiguration = {};

Draggy.prototype.addClass = function (name,container) {
    new Class(name,container);
};

Draggy.prototype.removeConnectable = function (connectableId) {
    Connectable.prototype.connectables[connectableId].remove();
};

Draggy.prototype.save = function () {
    $.ajax({
        type: 'POST',
        url: Draggy.prototype.saveAddress,
        data: { xml: this.getModelXML() },
        success: function (msg) {
            Notification.prototype.ok('The model was saved correctly.');
        },
        error: function (msg) {
            Notification.prototype.error('Error: ' + msg.responseText);
        }
    });
};

Draggy.prototype.statusMsg = function (msg) {
    $('#status').html(msg);

    setTimeout('$(\'#status\').html(\'<br>\');', 500);
};

Draggy.prototype.getModelXML = function () {
    var i;

    var ret = '';

    ret += '<\?xml version="1.0" encoding="UTF-8" ?>\n';
    ret += '<draggy>\n';

    ret += '\t<project>\n';
    ret += '\t\t<language>' + Draggy.prototype.getLanguage() + '</language>\n';

    if (Draggy.prototype.getFramework() !== '' && Draggy.prototype.getFramework() !== null && Draggy.prototype.getFramework() !== undefined) {
        ret += '\t\t<framework>' + Draggy.prototype.getFramework() + '</framework>\n';
    } else {
        ret += '\t\t<framework/>\n';
    }

    if (Draggy.prototype.getORM() !== '' && Draggy.prototype.getORM() !== null && Draggy.prototype.getORM() !== undefined) {
        ret += '\t\t<orm>' + Draggy.prototype.getORM() + '</orm>\n';
    } else {
        ret += '\t\t<orm/>\n';
    }

    if (Draggy.prototype.getDescription() != '' && Draggy.prototype.getDescription() != null && Draggy.prototype.getDescription() !== undefined) {
        ret += '\t\t<description>' + Draggy.prototype.getDescription() + '</description>\n';
    } else {
        ret += '\t\t<description/>\n';
    }

    ret += '\t</project>\n';

    for (i = 0; i < Container.prototype.containerList.length; i++) {
        ret += '\t' + Container.prototype.containerList[i].toXML();
    }

    ret += '\t<loose>\n';
    for (i = 0; i < Class.prototype.classList.length; i++) {
        if (Class.prototype.classList[i].getModule() == '') {
            ret += '\t\t' + Class.prototype.classList[i].toXML();
        }
    }
    for (i = 0; i < Abstract.prototype.abstractList.length; i++) {
        if (Abstract.prototype.abstractList[i].getModule() == '') {
            ret += '\t\t' + Abstract.prototype.abstractList[i].toXML();
        }
    }
    for (i = 0; i < Interface.prototype.interfaceList.length; i++) {
        if (Interface.prototype.interfaceList[i].getModule() == '') {
            ret += '\t\t' + Interface.prototype.interfaceList[i].toXML();
        }
    }
    for (i = 0; i < Trait.prototype.traitList.length; i++) {
        if (Trait.prototype.traitList[i].getModule() == '') {
            ret += '\t\t' + Trait.prototype.traitList[i].toXML();
        }
    }
    ret += '\t</loose>\n';

    ret += '\t<relationships>\n';
    for (i = 0; i < Link.prototype.linkList.length; i++) {
        ret += '\t\t' + Link.prototype.linkList[i].toXML();
    }
    ret += '\t</relationships>\n';

    ret += Autocode.prototype.toXML();

    /*
     ret += '\t<modules>\n';
     for (var i in Container.prototype.containers)
     ret += '\t\t' + Container.prototype.containers[i].toXML();
     ret += '\t</modules>\n';
     */

    ret += '</draggy>\n';

    return ret;
};

Draggy.prototype.getUniqueId = function (desiredId) {
    if (Draggy.prototype.issuedIds[desiredId] == undefined) {
        Draggy.prototype.issuedIds[desiredId] = true;
        return desiredId;
    }

    var number;

    for (number = 1; Draggy.prototype.issuedIds[desiredId + number] != undefined; number++) {
    }

    Draggy.prototype.issuedIds[desiredId + number] = true;
    return desiredId + number;
};

Draggy.prototype.addLink = function (from, to, type, fromAttributeName, toAttributeName) {
    new Link(from, to, type, fromAttributeName, toAttributeName);
};

Draggy.prototype.removeLink = function (linkId) {
    Link.prototype.links[linkId].remove();
};

Draggy.prototype.setLanguage = function (language) {
    Draggy.prototype.language = language;

    //Draggy.prototype.options = Draggy.prototype.allOptions[language];

    return this;
};

Draggy.prototype.getLanguage = function () {
    return Draggy.prototype.language;
};

Draggy.prototype.setDescription = function (description) {
    if (description !== '' && description !== null) {
        Draggy.prototype.description = description;
    } else {
        Draggy.prototype.description = null;
    }

    return this;
};

Draggy.prototype.getDescription = function () {
    return Draggy.prototype.description;
};


Draggy.prototype.getORM = function () {
    return Draggy.prototype.orm;
};

Draggy.prototype.setORM = function (orm) {
    Draggy.prototype.orm = orm;

//    for (var i in Draggy.prototype.allORMOptions[orm]) {
//        Draggy.prototype.options[i] = Draggy.prototype.allORMOptions[orm][i];
//    }

    return this;
};

Draggy.prototype.getFramework = function () {
    return Draggy.prototype.framework;
};

Draggy.prototype.setFramework = function (framework) {
    Draggy.prototype.framework = framework;

    return this;
};

Draggy.prototype.setIgnoreFiles = function(ignoreFiles){
    Draggy.prototype.ignoreFiles = ignoreFiles;
};

Draggy.prototype.getLanguages = function() {
    var languages = {};

    for (var i in Draggy.prototype.configuration.languages) {
        languages[i] = Draggy.prototype.configuration.languages[i]['name'];
    }

    return languages;
};

Draggy.prototype.getCurrentConfiguration = function() {
    return Draggy.prototype.currentConfiguration;
};

Draggy.prototype.updateConfiguration = function() {
    Draggy.prototype.currentConfiguration = jQuery.extend(true, {}, Draggy.prototype.configuration);

    var language  = Draggy.prototype.getLanguage();
    var framework = Draggy.prototype.getFramework();
    var orm       = Draggy.prototype.getORM();

    if (
        null !== language &&
        typeof Draggy.prototype.configuration.languages[language] != "undefined"
    ) {
        Draggy.prototype.currentConfiguration = Draggy.prototype.mergeConfigurations(
            Draggy.prototype.currentConfiguration,
            Draggy.prototype.configuration.languages[language]
        );
    }

    if (
        null !== framework &&
        typeof Draggy.prototype.currentConfiguration.frameworks[framework] != "undefined"
    ) {
        Draggy.prototype.currentConfiguration = Draggy.prototype.mergeConfigurations(
            Draggy.prototype.currentConfiguration,
            Draggy.prototype.currentConfiguration.frameworks[framework]
        );
    }

    if (
        null !== orm &&
        typeof Draggy.prototype.currentConfiguration.orms[orm] != "undefined"
    ) {
        Draggy.prototype.currentConfiguration = Draggy.prototype.mergeConfigurations(
            Draggy.prototype.currentConfiguration,
            Draggy.prototype.currentConfiguration.orms[orm]
        );
    }

    ContextMenu.prototype.disableMenus();
    ContextMenu.prototype.enableMenus();
};

Draggy.prototype.mergeArrays = function (target, source) {
    var myTarget = 0 !== target.length
        ? jQuery.extend(true, {}, target)
        : {};

    for (var i in source) {
        if (typeof target[i] == "undefined") {
            myTarget[i] = jQuery.extend(true, {}, source[i]);
        } else if (source[i] instanceof Object || source[i] instanceof Array) {
            myTarget[i] = Draggy.prototype.mergeArrays(target[i], source[i]);
        } else { // Is not like an array (is a value)
            myTarget[i] = source[i];
        }
    }

    return myTarget;
};

Draggy.prototype.mergeConfigurations = function (target, source) {
    var configurationParts = ['configuration', 'attributes', 'entities', 'relationships', 'autocode', 'languages', 'frameworks', 'orms'];

    var myTarget = 0 !== target.length
        ? jQuery.extend(true, {}, target)
        : {};

    for (var i = 0; i < configurationParts.length; i++) {
        if (typeof target[configurationParts[i]] != "undefined" && typeof source[configurationParts[i]] != "undefined") {
            myTarget[configurationParts[i]] = Draggy.prototype.mergeArrays(target[configurationParts[i]], source[configurationParts[i]]);
        }
    }

    return myTarget;
};

Draggy.prototype.getAutocodeProperties = function () {
    var properties = undefined !== Draggy.prototype.getCurrentConfiguration().autocode
        ? Draggy.prototype.getCurrentConfiguration().autocode.properties
        : {};

    var returnProperties = {};

    for (var i in properties) {
        if (properties[i].enabled) {
            returnProperties[i] = properties[i];
        }
    }

    return returnProperties;
};

Draggy.prototype.getAutocodeConfigurations = function () {
    var configurations = undefined !== Draggy.prototype.getCurrentConfiguration().autocode
        ? Draggy.prototype.getCurrentConfiguration().autocode.configurations
        : {};

    var returnConfigurations = {};

    for (var i in configurations) {
        if (configurations[i].enabled) {
            returnConfigurations[i] = configurations[i];
        }
    }

    return returnConfigurations;
};

Draggy.prototype.getAutocodeTemplates = function () {
    var templates = undefined !== Draggy.prototype.getCurrentConfiguration().autocode
        ? Draggy.prototype.getCurrentConfiguration().autocode.templates
        : {};

    var returnTemplates = {};

    for (var i in templates) {
        if (templates[i].enabled) {
            returnTemplates[i] = templates[i];
        }
    }

    return returnTemplates;
};

Draggy.prototype.getEntityTypes = function () {
    var entityTypes = undefined !== Draggy.prototype.getCurrentConfiguration().entities
        ? Draggy.prototype.getCurrentConfiguration().entities.types
        : {};

    var returnTypes = {};

    for (var i in entityTypes) {
        if (entityTypes[i].enabled) {
            returnTypes[i] = entityTypes[i];
        }
    }

    return returnTypes;
};

Draggy.prototype.getRelationshipTypes = function () {
    var relationshipTypes = undefined !== Draggy.prototype.getCurrentConfiguration().relationships
        ? Draggy.prototype.getCurrentConfiguration().relationships.types
        : {};

    var returnTypes = {};

    for (var i in relationshipTypes) {
        if (relationshipTypes[i].enabled) {
            returnTypes[i] = relationshipTypes[i];
        }
    }

    return returnTypes;
};

Draggy.prototype.getAttributeTypes = function () {
    var attributeTypes = undefined !== Draggy.prototype.getCurrentConfiguration().attributes
        ? Draggy.prototype.getCurrentConfiguration().attributes.types
        : {};

    var returnTypes = {};

    for (var i in attributeTypes) {
        if(attributeTypes[i].enabled) {
            returnTypes[i] = attributeTypes[i];
        }
    }

    return returnTypes;
};

Draggy.prototype.getAttributeProperties = function () {
    var attributeProperties = undefined !== Draggy.prototype.getCurrentConfiguration().attributes
        ? Draggy.prototype.getCurrentConfiguration().attributes.properties
        : {};

    var returnProperties = {};

    for (var i in attributeProperties) {
        if(attributeProperties[i].enabled) {
            returnProperties[i] = attributeProperties[i];
        }
    }

    return returnProperties;
};

Draggy.prototype.options = []; // TODO: Remove

Draggy.prototype.currentConfiguration = jQuery.extend(true, {}, Draggy.prototype.configuration);