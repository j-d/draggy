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