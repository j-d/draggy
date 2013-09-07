function ProjectPropertiesDialog() {
}

ProjectPropertiesDialog.prototype.openDialog = function () {
    var i;

    // General tab
    var $projectLanguage  = $('#project-language');
    var $projectFramework = $('#project-framework');
    var $projectORM       = $('#project-orm');

    $projectORM.attr('disabled', 'disabled').parents('tr').first().hide();
    $projectFramework.attr('disabled', 'disabled').parents('tr').first().hide();

    // Recreate the project languages
    $projectLanguage.find('option').remove();

    var languages = Draggy.prototype.getLanguages();

    for (i in languages) {
        $projectLanguage.append('<option value="' + i + '">' + languages[i] + '</option>');
    }

    var currentLanguage = Draggy.prototype.getLanguage();

    if (null !== currentLanguage && typeof languages[currentLanguage] != "undefined") {
        $projectLanguage.val(currentLanguage);

        ProjectPropertiesDialog.prototype.changedLanguage(currentLanguage);
    }
    var currentFramework = Draggy.prototype.getFramework();

    if (null !== currentFramework && typeof languages[currentFramework] != "undefined") {
        $projectFramework.val(currentFramework);

        ProjectPropertiesDialog.prototype.changedFramework(currentFramework);
    }

    var currentORM = Draggy.prototype.getORM();

    if (null !== currentORM && typeof languages[currentORM] != "undefined") {
        $projectORM.val(currentORM);

        ProjectPropertiesDialog.prototype.changedORM(currentORM);
    }

    $('#project-description').val(Draggy.prototype.getDescription());

    if (Connectable.prototype.connectableList.length === 0) {
        $projectLanguage.removeAttr('disabled');
        $projectFramework.removeAttr('disabled');
        $projectORM.removeAttr('disabled');
    } else {
        $projectLanguage.attr('disabled','disabled');
        $projectFramework.attr('disabled','disabled');
        $projectORM.attr('disabled','disabled');
    }

    this.loadAutocodeTab();

    $('#project-properties-dialog').dialog('open');
};

ProjectPropertiesDialog.prototype.changedLanguage = function (language) {
    Draggy.prototype.setLanguage(language);
    Draggy.prototype.updateConfiguration();

    var $projectFramework = $('#project-framework');
    var $projectORM       = $('#project-orm');

    $projectFramework.attr('disabled', 'disabled').find('option').remove();
    $projectORM.attr('disabled', 'disabled').find('option').remove();

    $projectFramework.attr('disabled', 'disabled').parents('tr').first().hide();
    $projectORM.attr('disabled', 'disabled').parents('tr').first().hide();

    var frameworks = Draggy.prototype.getCurrentConfiguration().frameworks;

    if (0 !== frameworks.length) {
        $projectFramework.append('<option value="">--None--</option>');

        for (var i in frameworks) {
            $projectFramework.append('<option value="' + i + '">' + frameworks[i].name + '</option>');
        }

        $projectFramework.removeAttr('disabled').parents('tr').first().show();

        var currentFramework = Draggy.prototype.getFramework();

        if (null !== currentFramework) {
            $projectFramework.val(currentFramework);
            ProjectPropertiesDialog.prototype.changedFramework(currentFramework);
        } else {
            Draggy.prototype.setORM(null);
        }
    } else {
        Draggy.prototype.setFramework(null);
        Draggy.prototype.setORM(null);
    }

    ProjectPropertiesDialog.prototype.updateAutocodeTab();
};

ProjectPropertiesDialog.prototype.changedFramework = function (framework) {
    Draggy.prototype.setFramework(framework);
    Draggy.prototype.updateConfiguration();

    var $projectORM = $('#project-orm');

    $projectORM.attr('disabled', 'disabled').find('option').remove();
    $projectORM.attr('disabled', 'disabled').parents('tr').first().hide();

    var orms = Draggy.prototype.getCurrentConfiguration().orms;

    if (0 !== orms.length) {
        $projectORM.append('<option value="">--None--</option>');

        for (var i in orms) {
            $projectORM.append('<option value="' + i + '">' + orms[i].name + '</option>');
        }

        $projectORM.removeAttr('disabled').parents('tr').first().show();

        var currentORM = Draggy.prototype.getORM();

        if (null !== currentORM) {
            $projectORM.val(currentORM);
            ProjectPropertiesDialog.prototype.changedORM(currentORM);
        }
    } else {
        Draggy.prototype.setORM(null);
    }

    ProjectPropertiesDialog.prototype.updateAutocodeTab();
};

ProjectPropertiesDialog.prototype.changedORM = function (orm) {
    Draggy.prototype.setORM(orm);
    Draggy.prototype.updateConfiguration();

    ProjectPropertiesDialog.prototype.updateAutocodeTab();
};

ProjectPropertiesDialog.prototype.updateAutocodeTab = function()
{
    var properties     = Draggy.prototype.getAutocodeProperties();
    var configurations = Draggy.prototype.getAutocodeConfigurations();
    var templates      = Draggy.prototype.getAutocodeTemplates();

    var i;

    var $autocodeProperties     = $('#autocode-properties');
    var $autocodeConfigurations = $('#autocode-configurations');
    var $autocodeTemplates      = $('#autocode-templates');

    $autocodeProperties.find('input').remove();
    $autocodeProperties.find('label').remove();

    for (i in properties) {
        $autocodeProperties.append(
            '<input id="autocode-property-' + i + '" type="checkbox">' +
            '<label for="autocode-property-' + i + '">' + properties[i].name + '?</label>'
        );

        $autocodeProperties.buttonset();
    }

    $autocodeConfigurations.show().find('table tr').remove();

    for (i in configurations) {
        $autocodeConfigurations.find('table').append(
            '<tr>' +
                '<td>' +
                    '<label for="autocode-configuration-' + i + '">' + configurations[i].name + ':</label>' +
                '</td>' +
                '<td>' +
                    '<input id="autocode-configuration-' + i + '" type="text" name="autocode-configuration-' + i + '" size="30" class="text ui-widget-content ui-corner-all" />' +
                '</td>' +
            '</tr>'
        );
    }

    if (0 === Object.keys(configurations).length) {
        $autocodeConfigurations.hide();
    }

    $autocodeTemplates.show().find('table tr').remove();

    for (i in templates) {
        $autocodeTemplates.find('table').append(
            '<tr>' +
                '<td>' +
                    '<label for="autocode-template-' + i + '">' + templates[i].name + ':</label>' +
                '</td>' +
                '<td>' +
                    '<input id="autocode-template-' + i + '" type="text" name="autocode-template-' + i + '" size="50" placeholder="' + templates[i].template + '" class="text ui-widget-content ui-corner-all" />' +
                '</td>' +
            '</tr>'
        );
    }

    if (0 === Object.keys(templates).length) {
        $autocodeTemplates.hide();
    }
};

ProjectPropertiesDialog.prototype.loadAutocodeTab = function () {
    var i;

    ProjectPropertiesDialog.prototype.updateAutocodeTab();

    var autocodeProperties     = Draggy.prototype.getAutocodeProperties();
    var autocodeConfigurations = Draggy.prototype.getAutocodeConfigurations();
    var autocodeTemplates      = Draggy.prototype.getAutocodeTemplates();

    for (i in autocodeProperties) {
        if (undefined === Autocode.prototype.getProperty(i)) {
            Autocode.prototype.setProperty(i, autocodeProperties[i].default);
        }

        if (Autocode.prototype.getProperty(i)) {
            $('#autocode-property-' + i).attr('checked', 'checked');
        } else {
            $('#autocode-property-' + i).removeAttr('checked');
        }

        $('#autocode-properties').buttonset();
    }

    for (i in autocodeConfigurations) {
        $('#autocode-configuration-' + i).val(Autocode.prototype.getConfiguration(i));
    }

    for (i in autocodeTemplates) {
        $('#autocode-template-' + i).val(Autocode.prototype.getTemplate(i));
    }
};

ProjectPropertiesDialog.prototype.commitChanges = function () {
    var i;

    // General tab
    Draggy.prototype.setLanguage($('#project-language').val());
    Draggy.prototype.setFramework($('#project-framework').val());
    Draggy.prototype.setORM($('#project-orm').val());
    Draggy.prototype.setDescription($('#project-description').val());

    // Autocode tab
    var autocodeProperties     = Draggy.prototype.getAutocodeProperties();
    var autocodeConfigurations = Draggy.prototype.getAutocodeConfigurations();
    var autocodeTemplates      = Draggy.prototype.getAutocodeTemplates();

    for (i in autocodeProperties) {
        Autocode.prototype.setProperty(i, $('#autocode-property-' + i).is(':checked'));
    }

    for (i in autocodeConfigurations) {
        Autocode.prototype.setConfiguration(i, $('#autocode-configuration-' + i).val());
    }

    for (i in autocodeTemplates) {
        Autocode.prototype.setTemplate(i, $('#autocode-template-' + i).val());
    }
};