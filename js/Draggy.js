function Draggy () { }

Draggy.prototype.issuedIds = [];

Draggy.prototype.addClass = function (name,container) {
    new Class(name,container);
};

Draggy.prototype.addAbstract = function (name, container) {
    new Abstract(name,container);
};

Draggy.prototype.removeConnectable = function (connectableId) {
    Connectable.prototype.connectables[connectableId].remove();
};

Draggy.prototype.save = function (file) {
    $.ajax({
        type:'POST',
        url:'save.php?f=' + file,
        data: { xml: this.getModelXML() },
        success:function () {
            alert('Saved successfully!');
            Draggy.prototype.statusMsg('Saved');
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

    for (i in Container.prototype.containers)
        ret += '\t' + Container.prototype.containers[i].toXML();

    ret += '\t<loose>\n';
    for (i in Class.prototype.classes)
        if (Class.prototype.classes[i].getModule() == '')
            ret += '\t\t' + Class.prototype.classes[i].toXML();
    for (i in Abstract.prototype.abstracts)
        if (Abstract.prototype.abstracts[i].getModule() == '')
            ret += '\t\t' + Abstract.prototype.abstracts[i].toXML();
    ret += '\t</loose>\n';

    ret += '\t<relationships>\n';
    for (i in Link.prototype.links)
        ret += '\t\t' + Link.prototype.links[i].toXML();
    ret += '\t</relationships>\n';

    /*
     ret += '\t<modules>\n';
     for (var i in Container.prototype.containers)
     ret += '\t\t' + Container.prototype.containers[i].toXML();
     ret += '\t</modules>\n';
     */

    ret += '</draggy>';

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

Draggy.prototype.addModule = function (name) {
    var c = new Container(name);
};

Draggy.prototype.removeModule = function (name) {
    Container.prototype.containers[name].remove();
};

Draggy.prototype.addLink = function (from, to, type, fromAttributeName, toAttributeName) {
    new Link(from, to, type, fromAttributeName, toAttributeName);
};

Draggy.prototype.removeLink = function (linkId) {
    Link.prototype.links[linkId].remove();
};