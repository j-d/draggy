function Notification() {
}

Notification.prototype.animate = function (id, message, delay) {
    var $notification = $(id);
    $notification.find('.message').html(message);
    $notification.slideDown().delay(delay).slideUp();
};

Notification.prototype.ok = function (message, delay) {
    if (delay === undefined) {
        delay = 2000;
    }

    Notification.prototype.animate("#notification-ok", message, delay);
};

Notification.prototype.warning = function (message, delay) {
    if (delay === undefined) {
        delay = 2000;
    }

    Notification.prototype.animate("#notification-warning", message, delay);
};

Notification.prototype.error = function (message, delay) {
    if (delay === undefined) {
        delay = 3000;
    }

    Notification.prototype.animate("#notification-error", message, delay);
};
