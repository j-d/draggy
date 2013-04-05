<?php
// Draggy\Autocode\Templates\PHP\Form.php

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

use Draggy\Autocode\Templates\PHP\Base\FormBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\Form
 */
class Form extends FormBase
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
        $file .= '// ' . $entity->getNamespace() . '\\Form\\' . $entity->getName() . 'Type.php' . "\n";
        $file .= $this->getBlurb();

        $file .= 'namespace ' . $entity->getNamespace() . '\\Form;' . "\n";
        $file .= "\n";
        $file .= 'use Common\\Html\\FormItem;' . "\n";
        $file .= 'use Symfony\\Component\\Form\\FormBuilderInterface;' . "\n";
        $file .= 'use ' . $entity->getNamespace() . '\\Form\\Base\\' . $entity->getName() . 'TypeBase;' . "\n";

        $useEntity = false;
        foreach ($entity->getFormAttributes() as $attr) {
            if (!is_null($attr->getForeign())) {
                $useEntity = true;
                break;
            }
        }

        if ($useEntity) {
            $file .= '// use Common\\Html\\Entity;' . "\n";
        }

        $useCollection = false;
        foreach ($entity->getFormAttributes() as $attr) {
            if ($attr->getFormClassType() === 'Collection') {
                $useCollection = true;
                break;
            }
        }

        if ($useCollection) {
            $file .= '// use Common\\Html\\Collection;' . "\n";
        }

        $file .= '// <user-additions' . ' part="use">' . "\n";
        $file .= '// </user-additions' . '>' . "\n";
        $file .= "\n";
        $file .= 'class ' . $entity->getName() . 'Type extends ' . $entity->getName() . 'TypeBase {' . "\n";
        $file .= '    /**' . "\n";
        $file .= '     * @var FormItem[] Form fields' . "\n";
        $file .= '     */' . "\n";
        $file .= '    protected $fields = [];' . "\n";
        $file .= '    ' . "\n";
        $file .= '    // <user-additions' . ' part="constructorDeclaration">' . "\n";
        $file .= '    public function __construct()' . "\n";
        $file .= '    // </user-additions>' . "\n";
        $file .= '    {' . "\n";
        foreach ($entity->getFormAttributes() as $attr) {
            switch ($attr->getFormClassType()) {
                case 'Entity':
                    //$file .= '//        /** @var Entity $' . $attr->getName() . ' */' . "\n";
                    $file .= '//        $this->fields[\'' . $attr->getName() . '\'] = $this->getField(\'' . $attr->getName() . '\');' . "\n";
                    $file .= '//        $this->fields[\'' . $attr->getName() . '\']' . "\n";
                    $file .= '//            ->setParentForm($this);' . "\n";
                    $file .= '//        $this->fields[\'' . $attr->getName() . '\']' . "\n";
                    $file .= '//            ->setSymfonyExpanded(true)' . "\n";
                    $file .= '//            ->setSymfonyProperty(\'xxx\'); // Possible choices: ';

                    foreach ($attr->getForeignEntity()->getAttributes() as $foreignAttr) {
                        if (is_null($foreignAttr->getForeign()) && $foreignAttr->getPhpType() !== 'boolean') {
                            $file .= ' ' . $foreignAttr->getName();
                        }
                    }

                    $file .= "\n";
                    $file .= '//' . "\n";

                    break;
                case 'Collection':
                    //$file .= '//        /** @var Collection $' . $attr->getName() . ' */' . "\n";
                    $file .= '//        $this->fields[\'' . $attr->getName() . '\'] = $this->getField(\'' . $attr->getName() . '\'); // To prevent loops Collections are not automatically added' . "\n";
                    $file .= '//        $' . $attr->getName() . ' = $this->fields[\'' . $attr->getName() . '\'];' . "\n";
                    $file .= '//        $this->fields[\'' . $attr->getName() . '\']' . "\n";
                    $file .= '//            ->setSymfonyAllowAdd(true)' . "\n";
                    $file .= '//            ->setSymfonyAllowDelete(true);' . "\n";
                    $file .= '//' . "\n";

                    break;
                default:
                    $file .= '//        $this->fields[\'' . $attr->getName() . '\'] = $this->getField(\'' . $attr->getName() . '\');' . "\n";
                    break;
            }
        }

        $file .= '        // <user-additions' . ' part="constructor">' . "\n";

        foreach ($entity->getFormAttributes() as $attr) {
            if ($attr->getFormClassType() !== 'Collection') {
                $file .= '        $this->fields[\'' . $attr->getName() . '\'] = $this->getField(\'' . $attr->getName() . '\');' . "\n";
            } else {
                $file .= '//        $this->fields[\'' . $attr->getName() . '\'] = $this->getField(\'' . $attr->getName() . '\'); // To prevent loops Collections are not automatically added' . "\n";
            }
        }

        $file .= '        // </user-additions' . '>' . "\n";
        $file .= '    }' . "\n";
        $file .= '    ' . "\n";
        $file .= '    public function buildForm(FormBuilderInterface $builder, array $options)' . "\n";
        $file .= '    {' . "\n";
        $file .= '//        parent::buildForm($builder, $options);' . "\n";
        $file .= '//' . "\n";

//        foreach ($entity->getFormAttributes() as $attr) {
//            switch ($attr->getFormClassType()) {
//                case 'Entity':
//                    $file .= '//        /** @var Entity $' . $attr->getName() . ' */' . "\n";
//                    $file .= '//        $' . $attr->getName() . ' = $this->fields[\'' . $attr->getName() . '\'];' . "\n";
//                    $file .= '//        $' . $attr->getName() . '' . "\n";
//                    $file .= '//            ->setParentForm($this);' . "\n";
//                    $file .= '//        $' . $attr->getName() . '' . "\n";
//                    $file .= '//            ->setSymfonyExpanded(true)' . "\n";
//                    $file .= '//            ->setSymfonyProperty(\'xxx\'); //';
//
//                    foreach ($attr->getForeignEntity()->getAttributes() as $foreignAttr) {
//                        if (is_null($foreignAttr->getForeign()) && $foreignAttr->getPhpType() !== 'boolean') {
//                            $file .= ' ' . $foreignAttr->getName();
//                        }
//                    }
//
//                    $file .= "\n";
//                    $file .= '//' . "\n";
//                    break;
//                case 'Collection':
//                    $file .= '//        /** @var Collection $' . $attr->getName() . ' */' . "\n";
//                    $file .= '//        $' . $attr->getName() . ' = $this->fields[\'' . $attr->getName() . '\'];' . "\n";
//                    $file .= '//        $' . $attr->getName() . '' . "\n";
//                    $file .= '//            ->setSymfonyAllowAdd(true)' . "\n";
//                    $file .= '//            ->setSymfonyAllowDelete(true);' . "\n";
//                    $file .= '//' . "\n";
//                    break;
//            }
//        }

//        $file .= '//        $this->addFormItem(' . "\n";
//        $file .= '//            $builder,' . "\n";
//
//        foreach ($entity->getFormAttributes() as $attr) {
//            $file .= '//            $this->fields[\'' . $attr->getName() . '\'],' . "\n";
//        }
//
//        $file .= '//        );' . "\n";
//        $file .= "\n";
        $file .= '        // <user-additions' . ' part="buildForm">' . "\n";
        $file .= '        parent::buildForm($builder, $options);' . "\n";
        $file .= '        // </user-additions' . '>' . "\n";
        $file .= '    }' . "\n";
        $file .= '}' . "\n";

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}