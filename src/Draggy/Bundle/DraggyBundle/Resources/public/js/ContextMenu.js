function ContextMenu () {
}

ContextMenu.prototype.initializeMenuOptions = function () {
    ContextMenu.prototype.backgroundMenuOptions = {};
    ContextMenu.prototype.moduleMenuOptions = {};

    var entities    = Draggy.prototype.getEntityTypes();
    var showDivisor = false;

    for (var i in entities) {
        showDivisor = true;
        ContextMenu.prototype.backgroundMenuOptions['add-' + i] = {name: 'Add ' + entities[i].name, icon: i};
        ContextMenu.prototype.moduleMenuOptions['add-' + i] = {name: 'Add ' + entities[i].name, icon: i};
    }

    if (showDivisor) {
        ContextMenu.prototype.backgroundMenuOptions.sep1 = '---------';
        ContextMenu.prototype.moduleMenuOptions.sep1 = '---------';
    }

    ContextMenu.prototype.backgroundMenuOptions.addModule = {name: 'Add module', icon: 'module'};
    ContextMenu.prototype.backgroundMenuOptions.sep2 = '---------';
    ContextMenu.prototype.backgroundMenuOptions.disableContext = {name: 'Disable context menu'};
    ContextMenu.prototype.backgroundMenuOptions.sep3 = '---------';

    ContextMenu.prototype.moduleMenuOptions.disableContext = {name: 'Disable context menu'};
};

ContextMenu.prototype.enableMenus = function () {
    ContextMenu.prototype.initializeMenuOptions();

    // Background menu
    $.contextMenu({
        selector: '#contextual-menu-overlay',
        callback: function(key, options) {
            var $contextMenu = options.$menu;

            var left = $contextMenu.css('left');
            var top = $contextMenu.css('top');

            switch (key) {
                case 'add-class':
                    (new Class()).moveTo(left, top);
                    break;
                case 'add-abstract':
                    (new Abstract()).moveTo(left, top);
                    break;
                case 'add-interface':
                    (new Interface()).moveTo(left, top);
                    break;
                case 'add-trait':
                    (new Trait()).moveTo(left, top);
                    break;
                case 'addModule':
                    (new Container()).moveTo(left, top);
                    break;
                case 'disableContext':
                    ContextMenu.prototype.disableMenus();
                    break;

            }
        },
        items: ContextMenu.prototype.backgroundMenuOptions,
        //trigger: "left",
        zIndex: 2000
    });

    // Module menu
    $.contextMenu({
        selector: 'div.container',
        callback: function(key, options) {
            var containerId = options.$trigger.attr('id');
            var $container = $('#' + containerId);

            var $contextMenu = options.$menu;

            var left = (parseInt($contextMenu.css('left')) - parseInt($container.css('left'))) + 'px';
            var top = (parseInt($contextMenu.css('top')) - parseInt($container.css('top'))) + 'px';
            var containerName = Container.prototype.containers[containerId].getName();

            switch (key) {
                case 'add-class':
                    (new Class(undefined, containerName)).moveTo(left, top).setModule(containerId);
                    break;
                case 'add-abstract':
                    (new Abstract(undefined, containerName)).moveTo(left, top).setModule(containerId);
                    break;
                case 'add-interface':
                    (new Interface(undefined, containerName)).moveTo(left, top).setModule(containerId);
                    break;
                case 'add-trait':
                    (new Trait(undefined, containerName)).moveTo(left, top).setModule(containerId);
                    break;
                case 'disableContext':
                    ContextMenu.prototype.disableMenus();
                    break;

            }
        },
        items: ContextMenu.prototype.moduleMenuOptions,
        //trigger: "left",
        zIndex: 2000
    });

    // Class menu
    $.contextMenu({
        selector: 'div.class',
        callback: function(key, options) {
            var $contextMenu = options.$menu;
            var left = $contextMenu.css('left');
            var top = $contextMenu.css('top');

            switch (key) {
                case 'addClass':
                    (new Class()).moveTo(left, top);
                    break;
                case 'disableContext':
                    ContextMenu.prototype.disableMenus();
                    break;

            }
        },
        items: {
            'addClass':         {name: 'Add class', icon: 'class'},
            'sep2':             '---------',
            'disableContext':   {name: 'Disable context menu'},
            'sep3':             '---------'
        },
        //trigger: "left",
        zIndex: 2000
    });

    $('#contextMenus').hide();
};

ContextMenu.prototype.disableMenus = function () {
    $.contextMenu('destroy');

    $('#contextMenus').show();
};