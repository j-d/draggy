function EditModuleDialog() {
}

EditModuleDialog.prototype.container = null;

EditModuleDialog.prototype.openDialog = function (containerId) {
    var c = EditModuleDialog.prototype.container = Container.prototype.containers[containerId];

    $('#edit-module-name').attr('value', c.getName());
    $('#edit-module-description').attr('value', c.getDescription());

    $('#edit-module-dialog').dialog('open');
};

EditModuleDialog.prototype.commitChanges = function () {
    var newName = $('#edit-module-name').val();

    var c = EditModuleDialog.prototype.container;

    // Change name
    if (c.getName() !== newName) {
        c.setName(newName);
    }

    var description = $('#edit-module-description');

    if (description.val() != '')
        c.setDescription(description.val());

    // Redraw
    c.reDraw();
};