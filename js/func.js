getUniqueId = function (desiredId) {
    if (getUniqueId.prototype.issuedIds[desiredId] == undefined) {
        getUniqueId.prototype.issuedIds[desiredId] = true;
        return desiredId;
    }

    var number;

    for (number = 1; getUniqueId.prototype.issuedIds[desiredId + number] != undefined; number++)
        ;

    getUniqueId.prototype.issuedIds[desiredId + number] = true;
    return desiredId + number;
};

getUniqueId.prototype.issuedIds = [];

function distance(x1, y1, x2, y2) {
    return Math.sqrt( Math.pow(x2-x1,2) + Math.pow(y2-y1,2) );
}

function statusMsg(msg) {
    $('#status').html(msg);

    setTimeout('$(\'#status\').html(\'<br>\');', 500);
}

function save() {
    $.ajax({
        type:'POST',
        url:'save.php',
        data: { xml: getModelXML() },
        success:function () {
            alert('Saved successfully!');
            statusMsg('Saved');
        }
    });
}

function getModelXML() {
    var ret = '';

    ret += '<\?xml version="1.0" encoding="UTF-8" ?>\n';
    ret += '<draggy>\n';

    for (var i in Container.prototype.containers)
        ret += '\t' + Container.prototype.containers[i].toXML();

    ret += '\t<classes>\n';
    for (var i in Class.prototype.classes)
        if (Class.prototype.classes[i].getModule() == '')
            ret += '\t\t' + Class.prototype.classes[i].toXML();
    ret += '\t</classes>\n';

    ret += '\t<relationships>\n';
    for (var i in Link.prototype.links)
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
}

// Add to the Array prototype

if(!Array.prototype.indexOf){
    Array.prototype.indexOf= function(what, i){
        i= i || 0;
        var L= this.length;
        while(i< L){
            if(this[i]=== what) return i;
            ++i;
        }
        return -1;
    }
}

Array.prototype.remove= function(){
    var what, a= arguments, L= a.length, ax;
    while(L && this.length){
        what= a[--L];
        while((ax= this.indexOf(what))!= -1){
            this.splice(ax, 1);
        }
    }
    return this;
};

