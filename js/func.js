getUniqueId = function (desiredId) {
    if (getUniqueId.prototype.issuedIds[desiredId] == undefined) {
        getUniqueId.prototype.issuedIds[desiredId] = true;
        return desiredId;
    }

    var number;

    for (number = 1; getUniqueId.prototype.issuedIds[desiredId + number] != undefined; number++)
        ;

    getUniqueId.prototype.issuedIds[desiredId + number] = true;
    return desiredId + number;
};

getUniqueId.prototype.issuedIds = [];

function distance(x1, y1, x2, y2) {
    return Math.sqrt( Math.pow(x2-x1,2) + Math.pow(y2-y1,2) );
}
