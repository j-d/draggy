function AnalyseDialog() {
}

AnalyseDialog.prototype.checks = [];

AnalyseDialog.prototype.openDialog = function () {
    var $analyseDialog   = $('#analyse-dialog');
    var $analyseMessages = $('#analyse-messages');

    $analyseMessages.find('div').remove();

    $analyseDialog.dialog('open');

    for (var i = 0; i < AnalyseDialog.prototype.checks.length; i++) {
        AnalyseDialog.prototype.checks[i]();
    }



//    if (null === AnalyseDialog.prototype.defaultButtons) {
//        AnalyseDialog.prototype.defaultButtons = $analyseDialog.dialog("option", "buttons");
//    }
//
//    $analyseDialog.dialog("option", "buttons", AnalyseDialog.prototype.defaultButtons);
//
//    $("#analyse-changes").html("Loading ...");
//    $("#generate-entities-messages").show();
//    $("#generate-entities-success").hide();

};

AnalyseDialog.prototype.addCheck = function(check) {
    AnalyseDialog.prototype.checks.push(check);
};

AnalyseDialog.prototype.addInformationMessage = function(message) {
    $('#analyse-messages').append('<div class="analyse-information">' + message + '</div>');
};

AnalyseDialog.prototype.addWarningMessage = function(message) {
    $('#analyse-messages').append('<div class="analyse-warning">' + message + '</div>');
};

AnalyseDialog.prototype.addErrorMessage = function(message) {
    $('#analyse-messages').append('<div class="analyse-error">' + message + '</div>');
};

AnalyseDialog.prototype.prettyAnd = function(msgs) {
    var message  = '';

    if (msgs.length > 1) {
        message = msgs.slice(0, msgs.length - 1).join(', ') + ' and ' + msgs[msgs.length - 1];
    } else {
        message = msgs[0];
    }

    return message;
};

// Checks

// Summary of what you have
AnalyseDialog.prototype.addCheck(function() {
    var containers = Container.prototype.containerList.length;
    var classes    = Class.prototype.classList.length;
    var abstracts  = Abstract.prototype.abstractList.length;
    var interfaces = Interface.prototype.interfaceList.length;
    var links      = Link.prototype.linkList.length;
    var attributes = Object.keys(Attribute.prototype.attributes).length;

    if (containers + classes + abstracts + interfaces + links + attributes > 0) {
        var msgs = [];

        if (containers > 0) {
            msgs.push(containers + ' module' + (containers > 1 ? 's' : ''));
        }

        if (classes > 0) {
            msgs.push(classes + ' class' + (classes > 1 ? 'es' : ''));
        }

        if (abstracts > 0) {
            msgs.push(abstracts + ' abstract class' + (abstracts > 1 ? 'es' : ''));
        }

        if (interfaces > 0) {
            msgs.push(interfaces + ' interface' + (interfaces > 1 ? 's' : ''));
        }

        if (links > 0) {
            msgs.push(links + ' relationship' + (links > 1 ? 's' : ''));
        }

        if (attributes > 0) {
            msgs.push(attributes + ' attribute' + (attributes > 1 ? 's' : ''));
        }

        AnalyseDialog.prototype.addInformationMessage('Your model contains ' + AnalyseDialog.prototype.prettyAnd(msgs) + '.');
    }
});

// Check that modules end in 'Bundle' when using PHP / Symfony 2
AnalyseDialog.prototype.addCheck(function() {
    if (
        'php' === Draggy.prototype.getLanguage() &&
        'symfony2' === Draggy.prototype.getFramework()
    ) {
        var moduleName;

        for (var i = 0; i < Container.prototype.containerList.length; i++) {
            moduleName = Container.prototype.containerList[i].getName();

            if ('Bundle' !== moduleName.substr(-6)) {
                AnalyseDialog.prototype.addErrorMessage('You are working on a Symfony2 project and it is good practise that all the modules end with <strong>Bundle</strong>. The module <strong>' + moduleName + '</strong> does not comply with this. The default Symfony2 installation will not allow you to run without correcting this.');
            }
        }
    }
});

// Find strategy pattern
AnalyseDialog.prototype.addCheck(function() {
    var i, j, c, a, st, inte;

    for (i = 0; i < Class.prototype.classList.length; i++) {
        c = Class.prototype.classList[i];

        for (j = 0; j < c.getNumberAttributes(); j++) {
            a = c.getAttribute(j);

            if (!a.getInherited() && 'object' === a.getType() && null != a.getSubtype()) {
                st = a.getSubtype().split("\\");

                inte = Connectable.prototype.getConnectableFromName(st[st.length - 1]);

                if (inte instanceof Interface) {
                    AnalyseDialog.prototype.addInformationMessage('It seems that you are using the <strong>Strategy design pattern</strong> on the <strong>' + c.getName() + '</strong> class (attribute <strong>' + a.getName() + '</strong>) with the <strong>' + inte.getName() + '</strong> interface.');
                }
            }
        }
    }
});

// Find bridge pattern
AnalyseDialog.prototype.addCheck(function() {
    var i, j, c, a, st, inte;

    for (i = 0; i < Abstract.prototype.abstractList.length; i++) {
        c = Abstract.prototype.abstractList[i];

        for (j = 0; j < c.getNumberAttributes(); j++) {
            a = c.getAttribute(j);

            if (!a.getInherited() && 'object' === a.getType() && null != a.getSubtype()) {
                st = a.getSubtype().split("\\");

                inte = Connectable.prototype.getConnectableFromName(st[st.length - 1]);

                if (inte instanceof Interface && c.getImplementing().indexOf(inte.getId()) == -1) {
                    AnalyseDialog.prototype.addInformationMessage('It seems that you are using the <strong>Bridge design pattern</strong> on the <strong>' + c.getName() + '</strong> class (attribute <strong>' + a.getName() + '</strong>) with the <strong>' + inte.getName() + '</strong> interface.');
                }
            }
        }
    }
});

// Find composite pattern
AnalyseDialog.prototype.addCheck(function() {
    var i, j, c, a, st, cl, ab;

    for (i = 0; i < Class.prototype.classList.length; i++) {
        c = Class.prototype.classList[i];

        for (j = 0; j < c.getNumberAttributes(); j++) {
            a = c.getAttribute(j);

            if (!a.getInherited() && ('object' === a.getType() || 'array' === a.getType()) && null != a.getSubtype()) {
                st = a.getSubtype().split("\\");

                cl = Connectable.prototype.getConnectableFromName(st[st.length - 1]);

                if (null !== c.getInheritedFrom()) {
                    ab = Connectable.prototype.connectables[c.getInheritedFrom()];

                    if (ab instanceof Abstract && ab.getChildren().length > 1) {
                        AnalyseDialog.prototype.addInformationMessage('It seems that you are using the <strong>Composite design pattern</strong> on the <strong>' + c.getName() + '</strong> class (attribute <strong>' + a.getName() + '</strong>) and the <strong>' + cl.getName() + '</strong> abstract class.');
                    }
                }
            }
        }
    }
});

// Find decorator pattern
AnalyseDialog.prototype.addCheck(function() {
    var i, j, c, a, st, inte;

    for (i = 0; i < Abstract.prototype.abstractList.length; i++) {
        c = Abstract.prototype.abstractList[i];

        for (j = 0; j < c.getNumberAttributes(); j++) {
            a = c.getAttribute(j);

            if (!a.getInherited() && 'object' === a.getType() && null != a.getSubtype()) {
                st = a.getSubtype().split("\\");

                inte = Connectable.prototype.getConnectableFromName(st[st.length - 1]);

                if (inte instanceof Interface && c.getImplementing().indexOf(inte.getId()) != -1) {
                    if ('' == inte.getDescription() || 'Decorator' !== inte.getName().substr(-9)) {
                        AnalyseDialog.prototype.addWarningMessage('It seems that you are using the <strong>Decorator design pattern</strong> on the <strong>' + c.getName() + '</strong> class (attribute <strong>' + a.getName() + '</strong>) with the <strong>' + inte.getName() + '</strong> interface, however, the name of the interface doesn\'t end with <strong>Decorator</strong> and there is no documentation on the Interface.');
                    } else {
                        AnalyseDialog.prototype.addInformationMessage('It seems that you are using the <strong>Decorator design pattern</strong> on the <strong>' + c.getName() + '</strong> class (attribute <strong>' + a.getName() + '</strong>) with the <strong>' + inte.getName() + '</strong> interface.');
                    }
                }
            }
        }
    }
});