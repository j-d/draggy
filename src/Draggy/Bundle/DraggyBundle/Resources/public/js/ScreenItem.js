ScreenItem.prototype = new Item();           // Inheritance
ScreenItem.prototype.constructor = ScreenItem;

function ScreenItem () {
}

ScreenItem.prototype.innitScreenItem = function (desiredId) {
    this.innitItem(desiredId);
    this.drawn = false;
};

ScreenItem.prototype.destroyScreenItem = function () {
    $(this.hashId).remove();
    
    this.destroyItem();
};

ScreenItem.prototype.moveTo = function(x,y) {
    $(this.hashId).css({'left': x, 'top': y});

    return this;
};

ScreenItem.prototype.getValidName = function (category, desiredName, folder) {
    var valid = true;
    var i;
    var arrayItems;
    var fullyQualifiedDesiredName;

    if (folder === '') {
        fullyQualifiedDesiredName = desiredName;
    } else {
        fullyQualifiedDesiredName = folder + '\\' + desiredName;
    }

    if (category == 'Connectable') {
        arrayItems = Connectable.prototype.connectableList;
    } else if (category == 'Container') {
        arrayItems = Container.prototype.containerList;
    }

    for (i = 0; i < arrayItems.length; i++) {
        if (arrayItems[i].getId() !== this.getId() && arrayItems[i].getFullyQualifiedName() === fullyQualifiedDesiredName) {
            valid = false;
            break;
        }
    }

    if (valid) {
        return desiredName;
    }

    var number = 1;

    while (!valid) {
        valid = true;

        for (i = 0; i < arrayItems.length; i++) {
            if (arrayItems[i].getId() !== this.getId() && arrayItems[i].getFullyQualifiedName() === fullyQualifiedDesiredName + number) {
                valid = false
            }
        }

        if (valid) {
            return desiredName + number;
        }

        number++;
    }

    return null;
};

ScreenItem.prototype.getDrawn = function() {
    return this.drawn;
};

ScreenItem.prototype.setDrawn = function(drawn) {
    this.drawn = drawn;

    return this;
};