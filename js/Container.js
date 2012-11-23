Container.prototype = new ScreenItem();           // Inheritance
Container.prototype.constructor = Container;

Container.prototype.containers = {};
Container.prototype.containerIdsByName = {};      // Static associative array

function Container (desiredName) {
    this.innitScreenItem('Container');

    this.objects = {};

    if (desiredName == undefined)
        this.setName(this.getValidName('Container','Module'));
    else
        this.setName(desiredName);

    Container.prototype.containers[this.id] = this;

    $(
        '<div id="' + this.getId() + '" class="container" style="position: absolute; width: 100px; height: 100px; top: ' + Math.floor((Math.random()*15)+1)*20 + 'px; left: ' + Math.floor((Math.random()*15)+1)*20 + 'px;">' +
            '<div class="handle">' +
                this.getName() +
            '</div>' +
            '<div class="controls" style="display: none;">' +
                '<span style="float: left;" class="ui-icon ui-icon-closethick removeModule"></span>' +
                '<span style="float: left;" class="ui-icon ui-icon-plusthick addSection"></span>' +
            '</div>' +
        '</div>'
    ).appendTo('body');

    //this.reDraw();

    var name = this.name; // Later it will be out of context

    this.makeInteractive();
}

Container.prototype.makeInteractive = function () {
    var id = this.id;
    var hashId = this.hashId;
    var name = this.getName();

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

    // Enable items to drop onto it
    $(this.hashId).droppable({
        accept: '.connectable',
        drop: function( event, ui ) {
            //$(hashId).css("background-color",'#F00');
            Item.prototype.items[ui.draggable.attr('id')].setModule(id);
        }
    });

    // Make it resizable
    $(this.hashId).resizable();

    // Hover controls
    $(this.hashId).hover(
        function () {
            $(hashId + ' > .controls').show();
        },
        function () {
            $(hashId + ' > .controls').hide();
        }
    );

    // Control clicks
    $(this.hashId + ' .controls .removeModule').click(function () {
        Item.prototype.items[id].remove();
    });

    $(this.hashId + ' .controls .addSection').click(function () {
        alert('not implemented');
    });
};

Container.prototype.setName = function (name) {
    delete(Container.prototype.containerIdsByName[this.name]);
    Container.prototype.containerIdsByName[name] = this.id;

    this.name = name;
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
        'left="' + (parseInt($(this.hashId).css('left'))+1) + '" ' +
        'top="' + (parseInt($(this.hashId).css('top'))+1) + '" ' +
        'width="' + parseInt($(this.hashId).css('width')) + '" ' +
        'height="' + parseInt($(this.hashId).css('height')) + '"';


    for (var i in Connectable.prototype.connectables) {
        if (Connectable.prototype.connectables[i].getModule() == this.getId())
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

Container.prototype.remove = function () {
    for (var i in this.objects)
        this.objects[i].remove();

    this.destroyScreenItem();
};