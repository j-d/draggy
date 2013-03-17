function Autocode () { }

Autocode.prototype.base = true;
Autocode.prototype.overwrite = true;
Autocode.prototype.deleteUnmapped = false;
Autocode.prototype.validation = true;

Autocode.prototype.namespace = null;

Autocode.prototype.entityTemplate = null;
Autocode.prototype.entityBaseTemplate = null;
Autocode.prototype.repositoryTemplate = null;
Autocode.prototype.formTemplate = null;
Autocode.prototype.formBaseTemplate = null;
Autocode.prototype.controllerTemplate = null;
Autocode.prototype.fixturesTemplate = null;
Autocode.prototype.routesTemplate = null;
Autocode.prototype.routesRoutingTemplate = null;
Autocode.prototype.crudCreateTwigTemplate = null;
Autocode.prototype.crudReadTwigTemplate = null;
Autocode.prototype.crudUpdateTwigTemplate = null;

Autocode.prototype.setBase = function (base) {
    Autocode.prototype.base = base;
};

Autocode.prototype.getBase = function () {
    return Autocode.prototype.base;
};

Autocode.prototype.setOverwrite = function (overwrite) {
    Autocode.prototype.overwrite = overwrite;
};

Autocode.prototype.getOverwrite = function () {
    return Autocode.prototype.overwrite;
};

Autocode.prototype.setDeleteUnmapped = function (deleteUnmapped) {
    Autocode.prototype.deleteUnmapped = deleteUnmapped;
};

Autocode.prototype.getDeleteUnmapped = function () {
    return Autocode.prototype.deleteUnmapped;
};

Autocode.prototype.setValidation = function (validation) {
    Autocode.prototype.validation = validation;
};

Autocode.prototype.getValidation = function () {
    return Autocode.prototype.validation;
};

Autocode.prototype.setNamespace = function (namespace) {
    Autocode.prototype.namespace = namespace;
};

Autocode.prototype.getNamespace = function () {
    return Autocode.prototype.namespace;
};

Autocode.prototype.setEntityTemplate = function (entityTemplate) {
    Autocode.prototype.entityTemplate = entityTemplate;
};

Autocode.prototype.getEntityTemplate = function () {
    return Autocode.prototype.entityTemplate;
};

Autocode.prototype.setEntityBaseTemplate = function (entityBaseTemplate) {
    Autocode.prototype.entityBaseTemplate = entityBaseTemplate;
};

Autocode.prototype.getEntityBaseTemplate = function () {
    return Autocode.prototype.entityBaseTemplate;
};

Autocode.prototype.setRepositoryTemplate = function (repositoryTemplate) {
    Autocode.prototype.repositoryTemplate = repositoryTemplate;
};

Autocode.prototype.getRepositoryTemplate = function () {
    return Autocode.prototype.repositoryTemplate;
};

Autocode.prototype.setFormTemplate = function (formTemplate) {
    Autocode.prototype.formTemplate = formTemplate;
};

Autocode.prototype.getFormTemplate = function () {
    return Autocode.prototype.formTemplate;
};

Autocode.prototype.setFormBaseTemplate = function (formBaseTemplate) {
    Autocode.prototype.formBaseTemplate = formBaseTemplate;
};

Autocode.prototype.getFormBaseTemplate = function () {
    return Autocode.prototype.formBaseTemplate;
};

Autocode.prototype.setControllerTemplate = function (controllerTemplate) {
    Autocode.prototype.controllerTemplate = controllerTemplate;
};

Autocode.prototype.getControllerTemplate = function () {
    return Autocode.prototype.controllerTemplate;
};

Autocode.prototype.setFixturesTemplate = function (fixturesTemplate) {
    Autocode.prototype.fixturesTemplate = fixturesTemplate;
};

Autocode.prototype.getFixturesTemplate = function () {
    return Autocode.prototype.fixturesTemplate;
};

Autocode.prototype.setRoutesTemplate = function (routesTemplate) {
    Autocode.prototype.routesTemplate = routesTemplate;
};

Autocode.prototype.getRoutesTemplate = function () {
    return Autocode.prototype.routesTemplate;
};

Autocode.prototype.setRoutesRoutingTemplate = function (routesRoutingTemplate) {
    Autocode.prototype.routesRoutingTemplate = routesRoutingTemplate;
};

Autocode.prototype.getRoutesRoutingTemplate = function () {
    return Autocode.prototype.routesRoutingTemplate;
};

Autocode.prototype.setCrudCreateTwigTemplate = function (crudCreateTwigTemplate) {
    Autocode.prototype.crudCreateTwigTemplate = crudCreateTwigTemplate;
};

Autocode.prototype.getCrudCreateTwigTemplate = function () {
    return Autocode.prototype.crudCreateTwigTemplate;
};

Autocode.prototype.setCrudReadTwigTemplate = function (crudReadTwigTemplate) {
    Autocode.prototype.crudReadTwigTemplate = crudReadTwigTemplate;
};

Autocode.prototype.getCrudReadTwigTemplate = function () {
    return Autocode.prototype.crudReadTwigTemplate;
};

Autocode.prototype.setCrudUpdateTwigTemplate = function (crudUpdateTwigTemplate) {
    Autocode.prototype.crudUpdateTwigTemplate = crudUpdateTwigTemplate;
};

Autocode.prototype.getCrudUpdateTwigTemplate = function () {
    return Autocode.prototype.crudUpdateTwigTemplate;
};

Autocode.prototype.toXML = function () {
    var ret = "";

    ret += "\t<autocode>\n";

    ret += "\t\t<base>" + Autocode.prototype.getBase() + "</base>\n";
    ret += "\t\t<overwrite>" + Autocode.prototype.getOverwrite() + "</overwrite>\n";
    ret += "\t\t<delete-unmapped>" + Autocode.prototype.getDeleteUnmapped() + "</delete-unmapped>\n";
    ret += "\t\t<validation>" + Autocode.prototype.getValidation() + "</validation>\n";

    if (Autocode.prototype.getNamespace() !== null) {
        ret += "\t\t<namespace>" + Autocode.prototype.getNamespace() + "</namespace>\n";
    } else {
        ret += "\t\t<namespace/>\n";
    }
    
    ret += "\t\t<templates>\n";

    if (Autocode.prototype.getEntityTemplate() !== null) {
        ret += "\t\t\t<entity>" + Autocode.prototype.getEntityTemplate() + "</entity>\n";
    } else {
        ret += "\t\t\t<entity/>\n";
    }

    if (Autocode.prototype.getEntityBaseTemplate() !== null) {
        ret += "\t\t\t<entity-base>" + Autocode.prototype.getEntityBaseTemplate() + "</entity-base>\n";
    } else {
        ret += "\t\t\t<entity-base/>\n";
    }

    if (Autocode.prototype.getRepositoryTemplate() !== null) {
        ret += "\t\t\t<repository>" + Autocode.prototype.getRepositoryTemplate() + "</repository>\n";
    } else {
        ret += "\t\t\t<repository/>\n";
    }

    if (Autocode.prototype.getFormTemplate() !== null) {
        ret += "\t\t\t<form>" + Autocode.prototype.getFormTemplate() + "</form>\n";
    } else {
        ret += "\t\t\t<form/>\n";
    }

    if (Autocode.prototype.getFormBaseTemplate() !== null) {
        ret += "\t\t\t<form-base>" + Autocode.prototype.getFormBaseTemplate() + "</form-base>\n";
    } else {
        ret += "\t\t\t<form-base/>\n";
    }

    if (Autocode.prototype.getControllerTemplate() !== null) {
        ret += "\t\t\t<controller>" + Autocode.prototype.getControllerTemplate() + "</controller>\n";
    } else {
        ret += "\t\t\t<controller/>\n";
    }

    if (Autocode.prototype.getFixturesTemplate() !== null) {
        ret += "\t\t\t<fixtures>" + Autocode.prototype.getFixturesTemplate() + "</fixtures>\n";
    } else {
        ret += "\t\t\t<fixtures/>\n";
    }

    if (Autocode.prototype.getRoutesTemplate() !== null) {
        ret += "\t\t\t<routes>" + Autocode.prototype.getRoutesTemplate() + "</routes>\n";
    } else {
        ret += "\t\t\t<routes/>\n";
    }

    if (Autocode.prototype.getRoutesRoutingTemplate() !== null) {
        ret += "\t\t\t<routes-routing>" + Autocode.prototype.getRoutesRoutingTemplate() + "</routes-routing>\n";
    } else {
        ret += "\t\t\t<routes-routing/>\n";
    }

    if (Autocode.prototype.getCrudCreateTwigTemplate() !== null) {
        ret += "\t\t\t<crud-create-twig>" + Autocode.prototype.getCrudCreateTwigTemplate() + "</crud-create-twig>\n";
    } else {
        ret += "\t\t\t<crud-create-twig/>\n";
    }

    if (Autocode.prototype.getCrudReadTwigTemplate() !== null) {
        ret += "\t\t\t<crud-read-twig>" + Autocode.prototype.getCrudReadTwigTemplate() + "</crud-read-twig>\n";
    } else {
        ret += "\t\t\t<crud-read-twig/>\n";
    }

    if (Autocode.prototype.getCrudUpdateTwigTemplate() !== null) {
        ret += "\t\t\t<crud-update-twig>" + Autocode.prototype.getCrudUpdateTwigTemplate() + "</crud-update-twig>\n";
    } else {
        ret += "\t\t\t<crud-update-twig/>\n";
    }
    
    ret += "\t\t</templates>\n";

    ret += "\t</autocode>\n";

    return ret;
};
