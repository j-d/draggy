function Link (from, to, type) {
    this.id = getValidName('Link');

    this.from = from;
    this.to = to;
    this.type = type;
    this.positionFrom = null;
    this.positionTo = null;

    Link.prototype.links[this.id] = this;
}

Link.prototype.links = [];

Link.prototype.getId = function () {
    return this.id;
};

Link.prototype.getFrom = function () {
    return this.from;
};

Link.prototype.getTo = function () {
    return this.to;
};

Link.prototype.getType = function () {
    return this.type;
};

Link.prototype.toXML = function () {
    var ret = '';

    ret += '<relation ' +
        'from="' + this.getFrom() + '" ' +
        'to="' + this.getTo() + '" ' +
        'type="' + this.getType() + '" ' +
        'top="' + $('#' + this.getId()).css('top') + '" ' +
        'left="' + $('#' + this.getId()).css('left') + '">';

    ret += '</relation>';

    return ret;
};

Link.prototype.reDraw = function () {
    drawLinkObjects(this.id,'class_' + this.from, 'class_' + this.to);
}

Link.prototype.setProperties = function (distance, fromConnector, toConnector) {
    this.distance = distance;
    this.fromConnector = fromConnector;
    this.toConnector = toConnector;
}

jsPlumb.Defaults.Anchor = "Continuous";

function addLink(from, to, type) {
    var l = new Link(from, to, type);

    //name = c.getName();

    //drawLinkObjects(l.getId(),Class.prototype.classes[from], Class.prototype.classes[to]);

/*    addClassInteractivity(name);*/

    jsPlumb.connect({
        source: from,
        target: to,
        connector:[ "Flowchart", { stub:1, gap:10 } ],
        paintStyle:{lineWidth:1,strokeStyle:'rgb(150,150,150)'},
        endpoints: [
            [ "Image", { src:"img/inheritance-left.png", cssClass:'inheritance-left' } ],
            [ "Image", { src:"img/inheritance-top.png" } ]
        ]
    });
}



