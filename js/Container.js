function Container () {

}

Container.prototype.containers = {};
Container.prototype.containerIdsByName = {};      // Static associative array

function Container (name) {
    this.id = getUniqueId('Container');
    this.hashId = '#' + this.id;
    this.objects = {};

    if (name == undefined)
        this.setName(this.getValidName('Container'));
    else
        this.setName(name);

    Container.prototype.containers[this.id] = this;

    $(
        '<div id="' + this.getId() + '" class="container" style="position: absolute; width: 100px; height: 100px; top: ' + Math.floor((Math.random()*15)+1)*20 + 'px; left: ' + Math.floor((Math.random()*15)+1)*20 + 'px;">' +
            '<div class="handle">' +
                this.getName() +
            '</div>' +
        '</div>'
    ).appendTo('body');

    //this.reDraw();

    var name = this.name; // Later it will be out of context

    // Make it draggable
    $(this.hashId).draggable({
        grid: [ 1,1 ],
        handle: 'div.handle',
        drag: function (event, ui) {
            var c = Container.prototype.getContainerByName(name);

            for (var i in c.objects) {
                c.objects[i].reDrawLinks();
            }
        },
        stop: function () {
            //Item.prototype.getItemByName(name).reDrawLinks();
        }
    });

    var id = this.id;
    var hashId = this.hashId;

    $(this.hashId).droppable({
        accept: '.class',
        drop: function( event, ui ) {
            //$(hashId).css("background-color",'#F00');
            Item.prototype.items[ui.draggable.attr('id')].setModule(id);
        }
    });

    $(this.hashId).resizable();
}

Container.prototype.getId = function () {
    return this.id;
};

Container.prototype.setName = function (name) {
    delete(Container.prototype.containerIdsByName[this.name]);
    Container.prototype.containerIdsByName[name] = this.id;

    this.name = name;
};

Container.prototype.getName = function () {
    return this.name;
};

Container.prototype.addObject = function (object) {
    this.objects[object] = Item.prototype.items[object];
};

Container.prototype.removeObject = function (object) {
    delete(this.objects[object]);
};

Container.prototype.getContainerByName = function(name) {
    return Container.prototype.containers[Container.prototype.containerIdsByName[name]];
};

Container.prototype.toXML = function () {
    var ret = '';
    var ret2 = '';

    ret += '<module ' +
        'name="' + this.getName() + '" ' +
        'left="' + $(this.hashId).css('left') + '" ' +
        'top="' + $(this.hashId).css('top') + '" ' +
        'width="' + $(this.hashId).css('width') + '" ' +
        'height="' + $(this.hashId).css('height') + '"';


    for (var i in Item.prototype.items) {
        if (Item.prototype.items[i].getModule() == this.getId())
            ret2 += '\t\t' + Item.prototype.items[i].toXML();
    }

    if (ret2 == '')
        ret += ' />' + '\n';
    else {
        ret += '>' + '\n';
        ret += ret2;
        ret += "\t" + '</module>' + '\n';
    }

    return ret;
};

Container.prototype.moveTo = function(x,y,width,height) {
    $(this.hashId).css('left',x);
    $(this.hashId).css('top',y);
    $(this.hashId).css('width',width);
    $(this.hashId).css('height',height);
};

function addContainer(name,x,y,width,height) {
    var c = new Container(name);

    if (x != undefined)
        c.moveTo(x,y,width,height);
}

function removeContainer(name) {
    Container.prototype.containers[name].remove();
}