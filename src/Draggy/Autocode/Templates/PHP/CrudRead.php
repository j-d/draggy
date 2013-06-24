<?php
// Draggy\Autocode\Templates\PHP\CrudRead.php

/************************************************************************************************
 **  THIS IS AN AUTOMATICALLY GENERATED BASE FILE AND SHOULD NOT BE MANUALLY EDITED            **
 **  All user content should be placed within <user-additions part="(name)"></user-additions>  **
 ************************************************************************************************/

/*
 * This file was automatically generated with 'Autocode'
 * by Jose Diaz-Angulo <jose@diazangulo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the package's source code.
 */

namespace Draggy\Autocode\Templates\PHP;

use Draggy\Autocode\Templates\PHP\Base\CrudReadBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\CrudRead
 */
class CrudRead extends CrudReadBase
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
    /**
     * {@inheritDoc}
     */
    public function getFilename()
    {
        return 'list' . $this->getEntity()->getName() . '.html.twig';
    }

    public function render()
    {
        $entity = $this->getEntity();

        $file = '';

        $file .= '<?php' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '// <user-additions' . ' part="template">' . PHP_EOL;
        $file .= 'use Common\Twig as T;' . PHP_EOL;
        $file .= 'use Common\Html\Table;' . PHP_EOL;
        $file .= 'use Common\Html\Row;' . PHP_EOL;
        $file .= 'use Common\Html\Cell;' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= 'echo    \'{% extends \\\'CommonBundle:Default:base.html.twig\\\' %}\' . PHP_EOL;' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= 'echo    \'{% block title %}\', \'List ' . $entity->getPluralName() . '\', \' {% endblock %}\' . PHP_EOL;' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '$table = new Table();' . PHP_EOL;
        $file .= '$table' . PHP_EOL;
        $file .= '    ->addHeadingRow(' . PHP_EOL;

        foreach ($entity->getAttributes() as $attr) {
            $file .= '        \'' . $attr->getUpperName() . '\',' . PHP_EOL;
        }

        $file .= '        \'Actions\'' . PHP_EOL;
        $file .= '    );' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '$tableRow = new Row(' . PHP_EOL;
        $file .= '                $table,' . PHP_EOL;

        foreach ($entity->getAttributes() as $attr) {
            if ($attr->getPhpType() !== 'boolean') {
                $file .= '                \'{{ ' . $entity->getLowerName() . '.get' . $attr->getUpperName() . '() }}\',' . PHP_EOL;
            }
            else {
                $file .= '                new Cell(\'{{ ' . $entity->getLowerName() . '.get' . $attr->getUpperName() . '() ? \\\'Y\\\' : \\\'\\\' }}\', \'center\'),' . PHP_EOL;
            }
        }

        $file .= '                new Cell(' . PHP_EOL;

        $actionsArray = [];

        if ($entity->getCrudUpdate()) {
            $actionsArray[] = '                    T::a(\'Edit\',[\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '_edit\',[\'id\'=>\'{{ ' . $entity->getLowerName() . '.getId() }}\']])';
        }
        if ($entity->getCrudDelete()) {
            $actionsArray[] = '                    T::a(\'Delete\',[\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '_delete\',[\'id\'=>\'{{ ' . $entity->getLowerName() . '.getId() }}\']])';
        }

        $file .= implode(' . \' \' .' . PHP_EOL,$actionsArray) . PHP_EOL;

        $file .= '                    ,\'center\'' . PHP_EOL;
        $file .= '                )' . PHP_EOL;
        $file .= '            );' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= 'echo    \'{% block body %}\', PHP_EOL,' . PHP_EOL;
        $file .= '            \'{{ parent() }}\', PHP_EOL,' . PHP_EOL;
        $file .= '            \'{% if ' . $entity->getPluralLowerName() . ' is not empty %}\', PHP_EOL,' . PHP_EOL;
        $file .= '                $table->toHtmlSections(' . PHP_EOL;
        $file .= '                    true,' . PHP_EOL;
        $file .= '                    true,' . PHP_EOL;
        $file .= '                    \'{% for ' . $entity->getLowerName() . ' in ' . $entity->getPluralLowerName() . ' %}\' . PHP_EOL .' . PHP_EOL;
        $file .= '                        $tableRow->toHtml() .' . PHP_EOL;
        $file .= '                    \'{% endfor %}\' . PHP_EOL,' . PHP_EOL;
        $file .= '                    true,' . PHP_EOL;
        $file .= '                    true' . PHP_EOL;
        $file .= '                ),' . PHP_EOL;
        $file .= '            \'{% else %}\', PHP_EOL,' . PHP_EOL;
        $file .= '                T::P, PHP_EOL,' . PHP_EOL;
        $file .= '                    \'There are no ' . $entity->getPluralName() . ' at present.\', PHP_EOL,' . PHP_EOL;
        $file .= '                T::_P,' . PHP_EOL;
        $file .= '            \'{% endif %}\', PHP_EOL,' . PHP_EOL;
        $file .= '            T::a(\'Add  ' . $entity->getName() . '\',\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '_add\'),' . PHP_EOL;
        $file .= '        \'{% endblock %}\', PHP_EOL;' . PHP_EOL;
        $file .= '// </user-additions' . '>' . PHP_EOL;

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}
