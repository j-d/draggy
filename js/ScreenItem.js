ScreenItem.prototype = new Item();           // Inheritance
ScreenItem.prototype.constructor = ScreenItem;

function ScreenItem () {
}

ScreenItem.prototype.innitScreenItem = function (desiredId) {
    this.innitItem(desiredId);
};

ScreenItem.prototype.destroyScreenItem = function () {
    $(this.hashId).remove();
    
    this.destroyItem();
};

ScreenItem.prototype.moveTo = function(x,y) {
    $(this.hashId).css('left',x);
    $(this.hashId).css('top',y);
};

ScreenItem.prototype.move = function(x,y) {
    $(this.hashId).css('left',(parseInt($(this.hashId).css('left')) + x) + 'px');
    $(this.hashId).css('top',(parseInt($(this.hashId).css('top')) + y) + 'px');
};

ScreenItem.prototype.getValidName = function (category, name) {
    var valid = true;
    var i;
    var arrayItems;

    if (category == 'Connectable') {
        arrayItems = Connectable.prototype.connectables
    }
    else if (category == 'Container') {
        arrayItems = Container.prototype.containers;
    }

    for (i in arrayItems)
        if (arrayItems[i].getName() == name) {
            valid = false;
            break;
        }

    if (valid)
        return name;

    var number = 1;

    while (!valid) {
        valid = true;

        for (i in arrayItems)
            if (arrayItems[i].getName() == name + number) {
                valid = false
            }

        if (valid)
            return name + number;

        number++;
    }
};