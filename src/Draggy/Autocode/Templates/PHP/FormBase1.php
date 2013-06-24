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
    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        return 'Form/Base/';
    }

    /**
     * {@inheritDoc}
     */
    public function getFilename()
    {
        return $this->getEntity()->getName() . 'TypeBase.php';
    }

    public function getFilenameLine()
    {
        return '// ' . $this->getEntity()->getNamespace() . '\\Form\\Base\\' . $this->getEntity()->getName() . 'TypeBase.php';
    }

    public function getDescriptionCodeLines()
    {
        return [];
    }

    public function getNamespaceLine()
    {
        return 'namespace ' . $this->getEntity()->getNamespace() . '\\Form\\Base;';
    }

    public function getUseLines()
    {
        $lines = [];

        $lines[] = 'use Symfony\\Component\\Form\\AbstractType;';
        $lines[] = 'use Symfony\\Component\\Form\\FormBuilderInterface;';
        $lines[] = 'use Symfony\\Component\\OptionsResolver\\OptionsResolverInterface;';
        $lines[] = '';
        $lines[] = 'use Common\\Html\\FormItem;';

        $usesIncluded = [];

        foreach ($this->getEntity()->getFormAttributes() as $attr) {
            $type = $attr->getFormClassType();

            if (!isset($usesIncluded[$type])) {
                $lines[] = 'use Common\\Html\\' . $type . ';';
                $usesIncluded[$type] = true;
            }
        }

        $useTypes = [];

        foreach ($this->getEntity()->getFormAttributes() as $attr) {
            if (in_array($attr->getFormClassType(), ['Entity', 'Collection']) && $attr->getForeignEntity()->getHasForm()) {
                $useTypes['use ' . $attr->getForeignEntity()->getNamespace() . '\\Form\\' . $attr->getForeignEntity()->getName() . 'Type;'] = true;
            }
        }

        if (count($useTypes) > 0) {
            $lines[] = implode("\n", array_keys($useTypes));
        }

        return $lines;
    }

    public function getFormName()
    {
        return strtolower(str_replace('\\', '_', substr($this->getEntity()->getNamespace(), 0, substr($this->getEntity()->getNamespace(), -6) == 'Bundle' ? -6 : null)) . '_' . $this->getEntity()->getName());
    }

    public function getFileLines()
    {
        $lines[] = 'abstract class ' . $this->getEntity()->getName() . 'TypeBase extends AbstractType';
        $lines[] = '{';
        $lines[] = '    /**';
        $lines[] = '     * @var FormItem[] Form fields';
        $lines[] = '     */';
        $lines[] = '    protected $fields = [];';
        $lines[] = '    ';

        $lines[] = '    /**';
        $lines[] = '     * @var string';
        $lines[] = '     */';
        $lines[] = '    protected $defaultOptionsDataClass = \'' . $this->getEntity()->getNamespace() . '\\Entity\\' . $this->getEntity()->getName() . '\';';
        $lines[] = '    ';
        $lines[] = '    /**';
        $lines[] = '     * @var null|string|callable';
        $lines[] = '     */';
        $lines[] = '    protected $defaultOptionsEmptyData;';
        $lines[] = '    ';

        foreach ($this->getEntity()->getFormAttributes() as $attr) {
            $lines = array_merge($lines, $attr->getFormClassLines($this->getFormName()));
            $lines[] = '';
        }

        $lines[] = '    /**';
        $lines[] = '     * @param string $defaultOptionsDataClass';
        $lines[] = '     */';
        $lines[] = '    public function setDefaultOptionsDataClass($defaultOptionsDataClass)';
        $lines[] = '    {';
        $lines[] = '        $this->defaultOptionsDataClass = $defaultOptionsDataClass;';
        $lines[] = '    }';
        $lines[] = '    ';

        $lines[] = '    /**';
        $lines[] = '     * @return string';
        $lines[] = '     */';
        $lines[] = '    public function getDefaultOptionsDataClass()';
        $lines[] = '    {';
        $lines[] = '        return $this->defaultOptionsDataClass;';
        $lines[] = '    }';
        $lines[] = '    ';

        $lines[] = '    /**';
        $lines[] = '     * @param null|string|callable $defaultOptionsEmptyData';
        $lines[] = '     */';
        $lines[] = '    public function setDefaultOptionsEmptyData($defaultOptionsEmptyData)';
        $lines[] = '    {';
        $lines[] = '        $this->defaultOptionsEmptyData = $defaultOptionsEmptyData;';
        $lines[] = '    }';
        $lines[] = '    ';

        $lines[] = '    /**';
        $lines[] = '     * @return null|string|callable';
        $lines[] = '     */';
        $lines[] = '    public function getDefaultOptionsEmptyData()';
        $lines[] = '    {';
        $lines[] = '        return $this->defaultOptionsEmptyData;';
        $lines[] = '    }';
        $lines[] = '    ';

        $lines[] = '    /**';
        $lines[] = '     * Shortcut for adding FormItems';
        $lines[] = '     *';
        $lines[] = '     * @param FormBuilderInterface $builder';
        $lines[] = '     * @param FormItem             $item';
        $lines[] = '     * @param ...                  $furtherItems';
        $lines[] = '     */';
        $lines[] = '    protected function addFormItem(FormBuilderInterface $builder, FormItem $item)';
        $lines[] = '    {';
        $lines[] = '        for ($i = 1; $i < func_num_args(); $i++) {';
        $lines[] = '            $builder->add(';
        $lines[] = '                func_get_arg($i)->getName(),';
        $lines[] = '                func_get_arg($i)->getSymfonyType(),';
        $lines[] = '                func_get_arg($i)->getSymfonyOptions()';
        $lines[] = '            );';
        $lines[] = '        }';
        $lines[] = '    }';
        $lines[] = '    ';
        $lines[] = '    public function buildForm(FormBuilderInterface $builder, array $options)';
        $lines[] = '    {';
        $lines[] = '        foreach ($this->fields as $field) {';
        $lines[] = '            $builder->add(';
        $lines[] = '                $field->getName(),';
        $lines[] = '                $field->getSymfonyType(),';
        $lines[] = '                $field->getSymfonyOptions()';
        $lines[] = '            );';
        $lines[] = '        }';
        $lines[] = '    }';
        $lines[] = '    ';
        $lines[] = '    public function setDefaultOptions(OptionsResolverInterface $resolver)';
        $lines[] = '    {';
        $lines[] = '        $defaults = [';
        $lines[] = '            \'data_class\' => $this->getDefaultOptionsDataClass()';
        $lines[] = '        ];';
        $lines[] = '        ';
        $lines[] = '        if (null !== $this->getDefaultOptionsEmptyData()) {';
        $lines[] = '            $defaults[\'empty_data\'] = $this->getDefaultOptionsEmptyData();';
        $lines[] = '        }';
        $lines[] = '        ';
        $lines[] = '        $resolver->setDefaults($defaults);';
        $lines[] = '    }';
        $lines[] = '    ';
        $lines[] = '    public function getName()';
        $lines[] = '    {';
        $lines[] = '        return \'' . $this->getFormName() . '\';';
        $lines[] = '    }';
        $lines[] = '    ';
        $lines[] = '    public function getFields()';
        $lines[] = '    {';
        $lines[] = '        return $this->fields;';
        $lines[] = '    }';
        $lines[] = '}';
        $lines[] = '';

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
