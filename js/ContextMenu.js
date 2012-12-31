function ContextMenu () {
}

ContextMenu.prototype.initializeMenuOptions = function () {
    ContextMenu.prototype.backgroundMenuOptions = {};
    ContextMenu.prototype.moduleMenuOptions = {};

    var options = Draggy.prototype.options;

    if (options.classes) {
        ContextMenu.prototype.backgroundMenuOptions.addClass = {name: 'Add class', icon: 'class'};
        ContextMenu.prototype.moduleMenuOptions.addClass = {name: 'Add class', icon: 'class'};
    }

    if (options.abstracts) {
        ContextMenu.prototype.backgroundMenuOptions.addAbstract = {name: 'Add abstract class', icon: 'abstract'};
        ContextMenu.prototype.moduleMenuOptions.addAbstract = {name: 'Add abstract class', icon: 'abstract'};
    }

    if (options.interfaces) {
        ContextMenu.prototype.backgroundMenuOptions.addInterface = {name: 'Add interface', icon: 'interface'};
        ContextMenu.prototype.moduleMenuOptions.addInterface = {name: 'Add interface', icon: 'interface'};
    }

    if (options.traits) {
        ContextMenu.prototype.backgroundMenuOptions.addTrait = {name: 'Add trait', icon: 'trait'};
        ContextMenu.prototype.moduleMenuOptions.addTrait = {name: 'Add trait', icon: 'trait'};
    }

    if (options.classes || options.abstracts || options.interfaces || options.traits) {
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
                case 'addClass':
                    (new Class()).moveTo(left, top);
                    break;
                case 'addAbstract':
                    (new Abstract()).moveTo(left, top);
                    break;
                case 'addInterface':
                    (new Interface()).moveTo(left, top);
                    break;
                case 'addTrait':
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
                case 'addClass':
                    (new Class(undefined, containerName)).moveTo(left, top).setModule(containerId);
                    break;
                case 'addAbstract':
                    (new Abstract(undefined, containerName)).moveTo(left, top).setModule(containerId);
                    break;
                case 'addInterface':
                    (new Interface(undefined, containerName)).moveTo(left, top).setModule(containerId);
                    break;
                case 'addTrait':
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
            'addClass':         {name: 'Add class',             icon: 'class'},
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