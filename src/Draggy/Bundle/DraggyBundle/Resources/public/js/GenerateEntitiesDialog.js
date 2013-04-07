function GenerateEntitiesDialog() {
}

GenerateEntitiesDialog.prototype.defaultButtons = null;

GenerateEntitiesDialog.prototype.openDialog = function () {
    var $generateEntitiesDialog = $('#generate-entities-dialog');

    if (null === GenerateEntitiesDialog.prototype.defaultButtons) {
        GenerateEntitiesDialog.prototype.defaultButtons = $generateEntitiesDialog.dialog("option", "buttons");
    }

    $generateEntitiesDialog.dialog("option", "buttons", GenerateEntitiesDialog.prototype.defaultButtons);

    $("#autocode-changes").html("Loading ...");
    $("#generate-entities-messages").show();
    $("#generate-entities-success").hide();

    $.ajax({
        type: 'POST',
        url: Draggy.prototype.previewAddress,
        data: { xml: Draggy.prototype.getModelXML() },
        success: function (msg) {
            //Notification.prototype.ok('Msg to be done');

            if (msg.indexOf("autocode-no-changes") != -1 || msg.indexOf("autocode-error") != -1) {
                var buttons = {'Close': GenerateEntitiesDialog.prototype.defaultButtons['Close']};

                $('#generate-entities-dialog').dialog("option", "buttons", buttons);
            }

            $("#autocode-changes").html(msg);
        },
        error: function (msg) {
            Notification.prototype.error('Error loading the preview: ' + msg.responseText);
        }
    });

    $generateEntitiesDialog.dialog('open');
};

GenerateEntitiesDialog.prototype.commitChanges = function () {
};