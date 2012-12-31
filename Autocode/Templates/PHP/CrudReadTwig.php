<?php
// Autocode\Templates\PHP\CrudReadTwig.php

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

namespace Autocode\Templates\PHP;

use Autocode\Templates\PHP\Base\CrudReadTwigBase;
// <user-additions part="use">
// </user-additions>

/**
 * Autocode\Templates\PHP\Entity\CrudReadTwig
 */
class CrudReadTwig extends CrudReadTwigBase
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
    public function render()
    {
        $entity = $this->getEntity();

        $file = '';

        $file .= '<?php' . "\n";
        $file .= "\n";
        $file .= '// <user-additions' . ' part="template">' . "\n";
        $file .= 'use Common\Twig as T;' . "\n";
        $file .= 'use Common\Html\Table;' . "\n";
        $file .= 'use Common\Html\Row;' . "\n";
        $file .= 'use Common\Html\Cell;' . "\n";
        $file .= "\n";
        $file .= 'echo    T::extends_(\'CommonBundle:Default:base.html.twig\');' . "\n";
        $file .= "\n";
        $file .= 'echo    T::block_(\'title\'), \'Add ' . $entity->getName() . '\', T::_BLOCK;' . "\n";
        $file .= "\n";
        $file .= '$table = new Table();' . "\n";
        $file .= '$table' . "\n";
        $file .= '    ->addHeadingRow(' . "\n";

        foreach ($entity->getAttributes() as $attr) {
            $file .= '        \'' . $attr->getUpperName() . '\',' . "\n";
        }

        $file .= '        \'Actions\'' . "\n";
        $file .= '    );' . "\n";
        $file .= "\n";
        $file .= '$tableRow = new Row(' . "\n";
        $file .= '                $table,' . "\n";

        foreach ($entity->getAttributes() as $attr) {
            if ($attr->getPhpType() !== 'boolean') {
                $file .= '                \'{{ ' . $entity->getLowerName() . '.get' . $attr->getUpperName() . '() }}\',' . "\n";
            }
            else {
                $file .= '                new Cell(\'{{ ' . $entity->getLowerName() . '.get' . $attr->getUpperName() . '() ? \\\'Y\\\' : \\\'\\\' }}\', \'center\'),' . "\n";
            }
        }

        $file .= '                new Cell(' . "\n";

        $actionsArray = [];

        if ($entity->getCrudUpdate()) {
            $actionsArray[] = '                    T::a(\'Edit\',[\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '_edit\',[\'id\'=>\'{{ ' . $entity->getLowerName() . '.getId() }}\']])';
        }
        if ($entity->getCrudDelete()) {
            $actionsArray[] = '                    T::a(\'Delete\',[\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '_delete\',[\'id\'=>\'{{ ' . $entity->getLowerName() . '.getId() }}\']])';
        }

        $file .= implode(' . \' \' .' . "\n",$actionsArray) . "\n";

        $file .= '                    ,\'center\'' . "\n";
        $file .= '                )' . "\n";
        $file .= '            );' . "\n";
        $file .= "\n";
        $file .= 'echo    T::block(\'body\'),' . "\n";
        $file .= '            T::PARENT,' . "\n";
        $file .= '            T::IFNEMPTY(\'' . $entity->getPluralLowerName() . '\'),' . "\n";
        $file .= '                $table->toHtmlSections(' . "\n";
        $file .= '                    true,' . "\n";
        $file .= '                    true,' . "\n";
        $file .= '                    T::FOR_(\'' . $entity->getLowerName() . '\',\'' . $entity->getPluralLowerName() . '\') .' . "\n";
        $file .= '                        $tableRow->toHtml() .' . "\n";
        $file .= '                    T::_FOR,' . "\n";
        $file .= '                    true,' . "\n";
        $file .= '                    true' . "\n";
        $file .= '                ),' . "\n";
        $file .= '            T::ELSE_,' . "\n";
        $file .= '                T::P,' . "\n";
        $file .= '                    \'There are no ' . $entity->getPluralName() . ' at present.\',' . "\n";
        $file .= '                T::_P,' . "\n";
        $file .= '            T::_IF,' . "\n";
        $file .= '            T::a(\'Add  ' . $entity->getName() . '\',\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '_add\'),' . "\n";
        $file .= '        T::_BLOCK;' . "\n";
        $file .= '// </user-additions' . '>' . "\n";

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}