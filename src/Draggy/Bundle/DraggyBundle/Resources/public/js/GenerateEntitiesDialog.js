function GenerateEntitiesDialog() {
}

GenerateEntitiesDialog.prototype.openDialog = function () {
    $("#autocode-changes").html("Loading ...");

    $.ajax({
        type: 'POST',
        url: Draggy.prototype.previewAddress,
        data: { xml: Draggy.prototype.getModelXML() },
        success: function (msg) {
            Notification.prototype.ok('Msg to be done');

            $("#autocode-changes").html(msg);
        },
        error: function (msg) {
            Notification.prototype.error('Error loading the preview: ' + msg.responseText);
        }
    });

    $('#generate-entities-dialog').dialog('open');
};

GenerateEntitiesDialog.prototype.commitChanges = function () {
    
};