ScreenItem.prototype = new Item();           // Inheritance
ScreenItem.prototype.constructor = ScreenItem;

function ScreenItem () {
}

ScreenItem.prototype.innitScreenItem = function (desiredId) {
    this.innitItem(desiredId);
};

ScreenItem.prototype.destroyScreenItem = function () {
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
