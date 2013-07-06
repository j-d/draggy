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

    // Remove Generate button and show it when loaded
    var buttons = {'Close': GenerateEntitiesDialog.prototype.defaultButtons['Close']};

    $generateEntitiesDialog.dialog("option", "buttons", buttons);

    $("#autocode-changes-controls").hide();

    $.ajax({
        type: 'POST',
        url: Draggy.prototype.previewAddress,
        data: { xml: Draggy.prototype.getModelXML() },
        success: function (msg) {
            if (!(msg.indexOf("autocode-no-changes") != -1 || msg.indexOf("autocode-error") != -1)) {
                $('#generate-entities-dialog').dialog("option", "buttons", GenerateEntitiesDialog.prototype.defaultButtons);
            }

            $("#autocode-changes").html(msg);

            var ignoreFiles = Draggy.prototype.ignoreFiles;

            for (var i = 0; i < ignoreFiles.length; i++) {
                $("input.autocode-change-checkbox[value=\"" + ignoreFiles[i] + "\"]").removeAttr("checked");
            }

            $("#autocode-changes-controls").show();
        },
        error: function (msg) {
            Notification.prototype.error('Error loading the preview: ' + msg.responseText);
        }
    });

    $generateEntitiesDialog.dialog('open');
};

GenerateEntitiesDialog.prototype.commitChanges = function () {
};