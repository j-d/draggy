Container.prototype = new ScreenItem();           // Inheritance
Container.prototype.constructor = Container;

Container.prototype.containers = {};
Container.prototype.containerList = [];
Container.prototype.containerIdsByName = {};      // Static associative array

function Container (desiredName) {
    this.innitScreenItem('Container');

    this.objects = {};
    this.objectList = [];

    if (desiredName === undefined) {
        this.setName(this.getValidName('Container','Module'));
    } else {
        this.setName(desiredName);
    }

    Container.prototype.containers[this.id] = this;
    Container.prototype.containerList.push(this);

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
    ).appendTo('#draggy-area');

    this.setDrawn(true);

    //this.reDraw();

    this.makeInteractive();
}

Container.prototype.makeInteractive = function () {
    var id = this.id;
    var hashId = this.hashId;
    var name = this.getName();
    var container = $(this.hashId);

    // Make it draggable
    container.draggable({
        grid: [ 1,1 ],
        handle: 'div.handle',
        drag: function () {
            var c = Container.prototype.getContainerByName(name);

            for (var i = 0; i < c.objectList.length; i++) {
                c.objectList[i].reDrawLinks();
            }
        },
        stop: function () {
            var c = Container.prototype.getContainerByName(name);

            for (var i = 0; i < c.objectList.length; i++) {
                c.objectList[i].reDrawLinks();
            }
        }
    });

    // Enable items to drop onto it
    container.droppable({
        greedy: true,
        hoverClass: 'droppable-hover',
        accept: '.connectable',
        drop: function( event, ui ) {
            //$(hashId).css("background-color",'#F00');
            Item.prototype.items[ui.draggable.attr('id')].setModule(id);
        }
    });

    // Make it resizable
    container.resizable();

    // Hover controls
    container.hover(
        function () {
            $(hashId + ' > .controls').show();
        },
        function () {
            $(hashId + ' > .controls').hide();
        }
    );

    // Edit dialog
    container.dblclick(function () {
        EditModuleDialog.prototype.openDialog(id);
    });

    // Control clicks
    container.find('.controls .removeModule').click(function () {
        Item.prototype.items[id].remove();
    });

    container.find('.controls .addSection').click(function () {
        alert('not implemented');
    });
};

Container.prototype.setName = function (name) {
    delete(Container.prototype.containerIdsByName[this.name]);
    Container.prototype.containerIdsByName[name] = this.id;

    this.name = name;

    return this;
};

Container.prototype.addObject = function (object) {
    if (this.objects[object] == undefined) { // Is not already there
        this.objects[object] = Item.prototype.items[object];
        this.objectList.push(Item.prototype.items[object]);
    }
};

Container.prototype.removeObject = function (object) {
    delete(this.objects[object]);
    this.objectList.remove(Item.prototype.items[object]);
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


    for (var i = 0; i < Connectable.prototype.connectableList.length; i++) {
        if (Connectable.prototype.connectableList[i].getModule() == this.getId()) {
            ret2 += '\t\t' + Connectable.prototype.connectableList[i].toXML();
        }
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

Container.prototype.moveTo = function(x, y, width, height) {
    $(this.hashId).css({'left': x, 'top': y, 'width': width, 'height': height});
};

Container.prototype.remove = function () {
    for (var i = 0; i < this.objectList.length; i++) {
        this.objectList[i].remove();
    }

    delete Container.prototype.containers[this.id];
    Container.prototype.containerList.remove(this);

    this.destroyScreenItem();
};

Container.prototype.reDraw = function () {
    $(this.hashId).find('.handle').html(this.getName());
};

Container.prototype.adjustMinimumSizes = function () {
    var minimumHeight = 0, minimumWidth = 0;
    var object;

    for (var i = 0; i < this.objectList.length; i++) {
        object = $(this.objectList[i].getHashId());
        minimumWidth = Math.max(minimumWidth, object.position().left + object.outerWidth());
        minimumHeight = Math.max(minimumHeight, object.position().top + object.outerHeight());
    }

    var container = $(this.hashId);

    container.resizable('option','minWidth',minimumWidth).resizable('option','minHeight',minimumHeight);

    if (container.outerWidth() < minimumWidth) {
        container.outerWidth(minimumWidth);
    }

    if (container.outerHeight() < minimumHeight) {
        container.outerHeight(minimumHeight);
    }
};

Container.prototype.getFullyQualifiedName = function () {
    return this.getName();
};