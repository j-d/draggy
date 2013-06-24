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

        $useTypes = [];

        foreach ($this->getEntity()->getFormAttributes() as $attr) {
            if (in_array($attr->getFormClassType(), ['Entity', 'Collection']) && $attr->getForeignEntity()->getHasForm()) {
                $useTypes['use ' . $attr->getForeignEntity()->getNamespace() . '\\Form\\' . $attr->getForeignEntity()->getName() . 'Type;'] = true;
            }
        }

        if (count($useTypes) > 0) {
            $lines[] = '';
            $lines[] = implode("\n", array_keys($useTypes));
        }

        return $lines;
    }

    public function getFormName()
    {
        return strtolower(str_replace('\\', '_', substr($this->getEntity()->getNamespace(), 0, substr($this->getEntity()->getNamespace(), -6) == 'Bundle' ? -6 : null)) . '_' . $this->getEntity()->getName());
    }

    public function getFieldsAttributeLines()
    {
        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * @var array Form fields';
        $lines[] = ' */';
        $lines[] = 'protected $fields = [];';

        return $lines;
    }

    public function getFieldsAttributeGetterLines()
    {
        $lines = [];

        $lines[] = 'public function getFields()';
        $lines[] = '{';
        $lines[] =     'return $this->fields;';
        $lines[] = '}';

        return $lines;
    }

    public function getDefaultOptionsDataClassAttributeLines()
    {
        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * @var string';
        $lines[] = ' */';
        $lines[] = 'protected $defaultOptionsDataClass = \'' . $this->getEntity()->getNamespace() . '\\Entity\\' . $this->getEntity()->getName() . '\';';

        return $lines;
    }

    public function getDefaultOptionsDataClassSetterLines()
    {
        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * @param string $defaultOptionsDataClass';
        $lines[] = ' */';
        $lines[] = 'public function setDefaultOptionsDataClass($defaultOptionsDataClass)';
        $lines[] = '{';
        $lines[] =     '$this->defaultOptionsDataClass = $defaultOptionsDataClass;';
        $lines[] = '}';

        return $lines;
    }

    public function getDefaultOptionsDataClassGetterLines()
    {
        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * @return string';
        $lines[] = ' */';
        $lines[] = 'public function getDefaultOptionsDataClass()';
        $lines[] = '{';
        $lines[] =     'return $this->defaultOptionsDataClass;';
        $lines[] = '}';

        return $lines;
    }

    public function getDefaultOptionsEmptyDataAttributeLines()
    {
        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * @var null|string|callable';
        $lines[] = ' */';
        $lines[] = 'protected $defaultOptionsEmptyData;';

        return $lines;
    }

    public function getDefaultOptionsEmptyDataSetterLines()
    {
        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * @param null|string|callable $defaultOptionsEmptyData';
        $lines[] = ' */';
        $lines[] = 'public function setDefaultOptionsEmptyData($defaultOptionsEmptyData)';
        $lines[] = '{';
        $lines[] =     '$this->defaultOptionsEmptyData = $defaultOptionsEmptyData;';
        $lines[] = '}';

        return $lines;
    }

    public function getDefaultOptionsEmptyDataGetterLines()
    {
        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * @return null|string|callable';
        $lines[] = ' */';
        $lines[] = 'public function getDefaultOptionsEmptyData()';
        $lines[] = '{';
        $lines[] =     'return $this->defaultOptionsEmptyData;';
        $lines[] = '}';

        return $lines;
    }

    public function getAttributeFieldGetterLines()
    {
        $lines = [];

        foreach ($this->getEntity()->getFormAttributes() as $attr) {
            $lines = array_merge($lines, $attr->getFormClassLinesBasic($this->getFormName())); // TODO: Allow injection of PHPAttribute Template

            $lines[] = '';
        }

        unset($lines[count($lines) - 1]);

        return $lines;
    }

    public function getBuildFormLines()
    {
        $lines = [];

        $lines[] = 'public function buildForm(FormBuilderInterface $builder, array $options)';
        $lines[] = '{';
        $lines[] =     'foreach ($this->fields as $field) {';
        $lines[] =         '$builder->add(';
        $lines[] =             '$field[\'name\'],';
        $lines[] =             '$field[\'type\'],';
        $lines[] =             '$field[\'options\']';
        $lines[] =         ');';
        $lines[] =     '}';
        $lines[] = '}';

        return $lines;
    }

    public function getSetDefaultOptionsLines()
    {
        $lines = [];

        $lines[] = 'public function setDefaultOptions(OptionsResolverInterface $resolver)';
        $lines[] = '{';
        $lines[] =     '$defaults = [';
        $lines[] =         '\'data_class\' => $this->getDefaultOptionsDataClass()';
        $lines[] =     '];';
        $lines[] = '';
        $lines[] =     'if (null !== $this->getDefaultOptionsEmptyData()) {';
        $lines[] =         '$defaults[\'empty_data\'] = $this->getDefaultOptionsEmptyData();';
        $lines[] =     '}';
        $lines[] = '';
        $lines[] =     '$resolver->setDefaults($defaults);';
        $lines[] = '}';

        return $lines;
    }

    public function getGetNameLines()
    {
        $lines = [];

        $lines[] = 'public function getName()';
        $lines[] = '{';
        $lines[] =     'return \'' . $this->getFormName() . '\';';
        $lines[] = '}';

        return $lines;
    }

    public function getTypeBaseBodyPartLines()
    {
        $lines = [];

        // Attributes
        $lines = array_merge($lines, $this->getFieldsAttributeLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getDefaultOptionsDataClassAttributeLines());

        $lines[] = '';

        // Methods
        $lines = array_merge($lines, $this->getDefaultOptionsEmptyDataAttributeLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getAttributeFieldGetterLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getDefaultOptionsDataClassSetterLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getDefaultOptionsDataClassGetterLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getDefaultOptionsEmptyDataSetterLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getDefaultOptionsEmptyDataGetterLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getBuildFormLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getSetDefaultOptionsLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getGetNameLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getFieldsAttributeGetterLines());

        return $lines;
    }

    public function getFileLines()
    {
        $lines[] = 'abstract class ' . $this->getEntity()->getName() . 'TypeBase extends AbstractType';
        $lines[] = '{';

        $lines = array_merge($lines, $this->getTypeBaseBodyPartLines());

        $lines[] = '}';

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
