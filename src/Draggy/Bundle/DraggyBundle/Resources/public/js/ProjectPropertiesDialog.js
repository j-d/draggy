function ProjectPropertiesDialog() {
}

ProjectPropertiesDialog.prototype.openDialog = function () {
    var $projectLanguage = $('#project-language');
    var $projectORM = $('#project-orm');

    $projectLanguage.val(Draggy.prototype.getLanguage());
    $('#project-description').val(Draggy.prototype.getDescription());
    $projectORM.val(Draggy.prototype.getORM());
    $('#project-framework').val(Draggy.prototype.getFramework());

    // Can't edit if there are links
    if (Link.prototype.linkList.length === 0) {
        $projectORM.removeAttr('disabled');
    } else {
        $projectORM.attr('disabled','disabled');
    }

    // Can't edit if there are classes
    if (Connectable.prototype.connectableList.length === 0) {
        $projectLanguage.removeAttr('disabled');
    } else {
        $projectLanguage.attr('disabled','disabled');
    }

    $('#project-properties-dialog').dialog('open');
};

ProjectPropertiesDialog.prototype.commitChanges = function () {
    Draggy.prototype.setLanguage($('#project-language').val());
    Draggy.prototype.setDescription($('#project-description').val());
    Draggy.prototype.setORM($('#project-orm').val());
    Draggy.prototype.setFramework($('#project-framework').val());
};