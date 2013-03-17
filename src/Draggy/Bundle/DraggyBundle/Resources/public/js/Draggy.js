function Draggy () { }

Draggy.prototype.issuedIds = [];
Draggy.prototype.language = null;
Draggy.prototype.description = null;
Draggy.prototype.orm = null;
Draggy.prototype.framework = null;
Draggy.prototype.saveAddress = null;

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
    ret += '\t\t<description>' + Draggy.prototype.getDescription() + '</description>\n';

    if (Draggy.prototype.getORM() !== '' && Draggy.prototype.getORM() !== undefined) {
        ret += '\t\t<orm>' + Draggy.prototype.getORM() + '</orm>\n';
    } else {
        ret += '\t\t<orm/>\n';
    }

    if (Draggy.prototype.getFramework() !== '' && Draggy.prototype.getFramework() !== undefined) {
        ret += '\t\t<framework>' + Draggy.prototype.getFramework() + '</framework>\n';
    } else {
        ret += '\t\t<framework/>\n';
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

    Draggy.prototype.options = Draggy.prototype.allOptions[language];

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

    for (var i in Draggy.prototype.allORMOptions[orm]) {
        Draggy.prototype.options[i] = Draggy.prototype.allORMOptions[orm][i];
    }

    return this;
};

Draggy.prototype.getFramework = function () {
    return Draggy.prototype.framework;
};

Draggy.prototype.setFramework = function (framework) {
    Draggy.prototype.framework = framework;

    return this;
};

Draggy.prototype.allOptions = {
    'PHP': {
        classes: true,
        abstracts: true,
        interfaces: true,
        traits: true
    },
    'JS':  {
        classes: true,
        abstracts: true,
        interfaces: false,
        traits: false
    }
};

Draggy.prototype.allORMOptions = {
    '': {
        oneToOne: true,
        oneToMany: true,
        manyToOne: true,
        manyToMany: true,
        inheritance: true,
        linkClasses: true
    },
    'Doctrine2': {
        oneToOne: true,
        oneToMany: true,
        manyToOne: false,
        manyToMany: false,
        inheritance: true,
        linkClasses: false
    }
};

// Defaults (static)
Draggy.prototype.setLanguage('PHP');
Draggy.prototype.description = null;
Draggy.prototype.setORM('');
Draggy.prototype.setFramework('Symfony2');
