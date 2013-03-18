function ProjectPropertiesDialog() {
}

ProjectPropertiesDialog.prototype.openDialog = function () {
    // General tab
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

    // Autocode tab
    var $base, $overwrite, $deleteUnmapped, $validation;
    $base = $("#autocode-base");
    $overwrite = $("#autocode-overwrite");
    $deleteUnmapped = $("#autocode-deleteUnmapped");
    $validation = $("#autocode-validation");

    if (Autocode.prototype.getBase()) {
        $base.attr('checked','checked');
    } else {
        $base.removeAttr('checked');
    }
    $base.button('refresh');

    if (Autocode.prototype.getOverwrite()) {
        $overwrite.attr('checked','checked');
    } else {
        $overwrite.removeAttr('checked');
    }
    $overwrite.button('refresh');

    if (Autocode.prototype.getDeleteUnmapped()) {
        $deleteUnmapped.attr('checked','checked');
    } else {
        $deleteUnmapped.removeAttr('checked');
    }
    $deleteUnmapped.button('refresh');

    if (Autocode.prototype.getValidation()) {
        $validation.attr('checked','checked');
    } else {
        $validation.removeAttr('checked');
    }
    $validation.button('refresh');

    $('#autocode-namespace').val(Autocode.prototype.getNamespace());
    $('#autocode-entityTemplate').val(Autocode.prototype.getEntityTemplate());
    $('#autocode-entityBaseTemplate').val(Autocode.prototype.getEntityBaseTemplate());
    $('#autocode-repositoryTemplate').val(Autocode.prototype.getRepositoryTemplate());
    $('#autocode-formTemplate').val(Autocode.prototype.getFormTemplate());
    $('#autocode-formBaseTemplate').val(Autocode.prototype.getFormBaseTemplate());
    $('#autocode-controllerTemplate').val(Autocode.prototype.getControllerTemplate());
    $('#autocode-fixturesTemplate').val(Autocode.prototype.getFixturesTemplate());
    $('#autocode-routesTemplate').val(Autocode.prototype.getRoutesTemplate());
    $('#autocode-routesRoutingTemplate').val(Autocode.prototype.getRoutesRoutingTemplate());
    $('#autocode-crudCreateTwigTemplate').val(Autocode.prototype.getCrudCreateTwigTemplate());
    $('#autocode-crudReadTwigTemplate').val(Autocode.prototype.getCrudReadTwigTemplate());
    $('#autocode-crudUpdateTwigTemplate').val(Autocode.prototype.getCrudUpdateTwigTemplate());

    $('#project-properties-dialog').dialog('open');
};

ProjectPropertiesDialog.prototype.commitChanges = function () {
    // General tab
    Draggy.prototype.setLanguage($('#project-language').val());
    Draggy.prototype.setDescription($('#project-description').val());
    Draggy.prototype.setORM($('#project-orm').val());
    Draggy.prototype.setFramework($('#project-framework').val());

    // Autocode tab
    Autocode.prototype.setBase($('#autocode-base').is(':checked'));
    Autocode.prototype.setOverwrite($('#autocode-overwrite').is(':checked'));
    Autocode.prototype.setDeleteUnmapped($('#autocode-deleteUnmapped').is(':checked'));
    Autocode.prototype.setValidation($('#autocode-validation').is(':checked'));

    Autocode.prototype.setNamespace($('#autocode-namespace').val());
    Autocode.prototype.setEntityTemplate($('#autocode-entityTemplate').val());
    Autocode.prototype.setEntityBaseTemplate($('#autocode-entityBaseTemplate').val());
    Autocode.prototype.setRepositoryTemplate($('#autocode-repositoryTemplate').val());
    Autocode.prototype.setFormTemplate($('#autocode-formTemplate').val());
    Autocode.prototype.setFormBaseTemplate($('#autocode-formBaseTemplate').val());
    Autocode.prototype.setControllerTemplate($('#autocode-controllerTemplate').val());
    Autocode.prototype.setFixturesTemplate($('#autocode-fixturesTemplate').val());
    Autocode.prototype.setRoutesTemplate($('#autocode-routesTemplate').val());
    Autocode.prototype.setRoutesRoutingTemplate($('#autocode-routesRoutingTemplate').val());
    Autocode.prototype.setCrudCreateTwigTemplate($('#autocode-crudCreateTwigTemplate').val());
    Autocode.prototype.setCrudReadTwigTemplate($('#autocode-crudReadTwigTemplate').val());
    Autocode.prototype.setCrudUpdateTwigTemplate($('#autocode-crudUpdateTwigTemplate').val());
};