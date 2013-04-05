<?php
// Draggy\Autocode\Templates\PHP\FormBase1.php

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

use Draggy\Autocode\Templates\PHP\Base\FormBase1Base;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\FormBase1
 */
class FormBase1 extends FormBase1Base
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

        $formName = strtolower(str_replace('\\','_',substr($entity->getNamespace(),0,substr($entity->getNamespace(),-6) == 'Bundle' ? -6 : null)) . '_' . $entity->getName());

        $file = '';

        $file .= '<?php' . "\n";
        $file .= '// ' . $entity->getNamespace() . '\\Form\\Base\\' . $entity->getName() . 'TypeBase.php' . "\n";
        $file .= $this->getBlurb();

        $file .= 'namespace ' . $entity->getNamespace() . '\\Form\\Base;' . "\n";
        $file .= "\n";
        $file .= 'use Symfony\\Component\\Form\\AbstractType;' . "\n";
        $file .= 'use Symfony\\Component\\Form\\FormBuilderInterface;' . "\n";
        $file .= 'use Symfony\\Component\\OptionsResolver\\OptionsResolverInterface;' . "\n";
        $file .= "\n";
        $file .= 'use Common\\Html\\FormItem;' . "\n";

        $usesIncluded = [];

        foreach ($entity->getFormAttributes() as $attr) {
            $type = $attr->getFormClassType();

            if (!isset($usesIncluded[$type])) {
                $file .= 'use Common\\Html\\' . $type . ';' . "\n";
                $usesIncluded[$type] = true;
            }
        }

        $useTypes = [];
        foreach ($entity->getFormAttributes() as $attr) {
            if (in_array($attr->getFormClassType(), ['Entity', 'Collection']) && $attr->getForeignEntity()->getHasForm()) {
                $useTypes['use ' . $attr->getForeignEntity()->getNamespace() . '\\Form\\' . $attr->getForeignEntity()->getName() . 'Type;'] = true;
            }
        }

        if (count($useTypes) > 0) {
            $file .= implode("\n", array_keys($useTypes)) . "\n";
        }

        $file .= "\n";
        $file .= 'abstract class ' . $entity->getName() . 'TypeBase extends AbstractType {' . "\n";
        $file .= '    /**' . "\n";
        $file .= '     * @var FormItem[] Form fields' . "\n";
        $file .= '     */' . "\n";
        $file .= '    protected $_fields;' . "\n";
        $file .= '    ' . "\n";
        $file .= '    public function __construct()' . "\n";
        $file .= '    {' . "\n";
        $file .= '        $this->_fields = [' . "\n";

        $fields = [];

        foreach ($entity->getFormAttributes() as $attr) {
            $fields[]     = $attr->getFormClass($formName);
        }

        if (count($fields) > 0) {
            $file .= implode(',' . "\n",$fields);
            $file .= "\n";
        }

        $file .= '        ];' . "\n";
        $file .= '    }' . "\n";
        $file .= '    ' . "\n";
        $file .= '    /**' . "\n";
        $file .= '     * Shortcut for adding FormItems' . "\n";
        $file .= '     *' . "\n";
        $file .= '     * @param FormBuilderInterface $builder' . "\n";
        $file .= '     * @param FormItem             $item' . "\n";
        $file .= '     * @param ...                  $furtherItems' . "\n";
        $file .= '     */' . "\n";
        $file .= '    protected function addFormItem(FormBuilderInterface $builder, FormItem $item)' . "\n";
        $file .= '    {' . "\n";
        $file .= '        for ($i = 1; $i < func_num_args(); $i++) {' . "\n";
        $file .= '            $builder->add(' . "\n";
        $file .= '                func_get_arg($i)->getName(),' . "\n";
        $file .= '                func_get_arg($i)->getSymfonyType(),' . "\n";
        $file .= '                func_get_arg($i)->getSymfonyOptions()' . "\n";
        $file .= '            );' . "\n";
        $file .= '        }' . "\n";
        $file .= '    }' . "\n";
        $file .= '    ' . "\n";
        $file .= '    public function buildForm(FormBuilderInterface $builder, array $options)' . "\n";
        $file .= '    {' . "\n";
        $file .= '        foreach ($this->fields as $field) {' . "\n";
        $file .= '            $builder->add(' . "\n";
        $file .= '                $field->getName(),' . "\n";
        $file .= '                $field->getSymfonyType(),' . "\n";
        $file .= '                $field->getSymfonyOptions()' . "\n";
        $file .= '            );' . "\n";
        $file .= '        }' . "\n";
        $file .= '    }' . "\n";
        $file .= '    ' . "\n";
        $file .= '    public function setDefaultOptions(OptionsResolverInterface $resolver)' . "\n";
        $file .= '    {' . "\n";
        $file .= '        $resolver->setDefaults([' . "\n";
        $file .= '            \'data_class\' => \'' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . '\'' . "\n";
        $file .= '        ]);' . "\n";
        $file .= '    }' . "\n";
        $file .= '    ' . "\n";
        $file .= '    public function getName()' . "\n";
        $file .= '    {' . "\n";
        $file .= '        return \'' . $formName . '\';' . "\n";
        $file .= '    }' . "\n";
        $file .= '    ' . "\n";
        $file .= '    public function getFields()' . "\n";
        $file .= '    {' . "\n";
        $file .= '        return $this->fields;' . "\n";
        $file .= '    }' . "\n";
        $file .= '}' . "\n";

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}