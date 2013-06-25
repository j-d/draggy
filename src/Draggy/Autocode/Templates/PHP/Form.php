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
    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        return 'Form/Type/';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getEntity()->getName() . 'Type';
    }

    public function getDescriptionCodeLines()
    {
        return [];
    }
    
    public function getNamespaceLine()
    {
        return 'namespace ' . $this->getFullNamespace() . ';';
    }
    
    public function getUseLines()
    {
        $lines = [];
        
        $lines[] = 'use Symfony\\Component\\Form\\FormBuilderInterface;';
        $lines[] = 'use ' . $this->getEntity()->getFullyQualifiedFormBaseName() . ';';

        $lines = array_merge($lines, $this->getUseLinesUserAdditionsPart());
        
        return $lines;
    }

    public function getConstructorHelpLines()
    {
        $lines = [];

        foreach ($this->getEntity()->getFormAttributes() as $attr) {
            switch ($attr->getFormClassType()) {
                case 'Entity':
                    $lines[] = '$this->fields[\'' . $attr->getName() . '\'] = $this->get' . $attr->getUpperName() . 'Field();';
                    $lines[] = '$this->fields[\'' . $attr->getName() . '\']';
                    $lines[] =     '->setParentForm($this);';
                    $lines[] = '$this->fields[\'' . $attr->getName() . '\']';
                    $lines[] =     '->setSymfonyExpanded(true)';

                    $line = '->setSymfonyProperty(\'xxx\'); // Possible choices: ';

                    foreach ($attr->getForeignEntity()->getAttributes() as $foreignAttr) {
                        if (null === $foreignAttr->getForeign() && 'boolean' !== $foreignAttr->getPhpType()) {
                            $line .= ' ' . $foreignAttr->getName();
                        }
                    }

                    $lines[] = $line;
                    $lines[] = '';

                    break;
                case 'Collection':
                    $lines[] = '$this->fields[\'' . $attr->getName() . '\'] = $this->get' . $attr->getUpperName() . 'Field();';
                    $lines[] = '$' . $attr->getName() . ' = $this->fields[\'' . $attr->getName() . '\'];';
                    $lines[] = '$this->fields[\'' . $attr->getName() . '\']';
                    $lines[] =     '->setSymfonyAllowAdd(true)';
                    $lines[] =     '->setSymfonyAllowDelete(true);';
                    $lines[] = '';

                    break;
                default:
                    $lines[] = '$this->fields[\'' . $attr->getName() . '\'] = $this->get' . $attr->getUpperName() . 'Field();';
                    break;
            }
        }

        return $this->commentAndJustifyLines($lines);
    }

    public function getConstructorInsideLines()
    {
        $lines = [];

        $someCollections  = false;
        $constructorLines = [];

        foreach ($this->getEntity()->getFormAttributes() as $attr) {
            if ('Collection' !== $attr->getFormClassType()) {
                $constructorLines[] = '$this->fields[\'' . $attr->getName() . '\'] = $this->get' . $attr->getUpperName() . 'Field();';
            } else {
                $someCollections = true;
                $constructorLines[] = '// $this->fields[\'' . $attr->getName() . '\'] = $this->get' . $attr->getUpperName() . 'Field();';
            }
        }

        if ($someCollections) {
            $lines[] = '// To prevent loops Collections are not automatically added';
        }

        $lines = array_merge($lines, $constructorLines);

        return $lines;
    }

    public function getFileLines()
    {
        $lines[] = 'class ' . $this->getEntity()->getName() . 'Type extends ' . $this->getEntity()->getName() . 'TypeBase';
        $lines[] =     '// <user-additions' . ' part="implements">';
        $lines[] =     '// </user-additions' . '>';
        $lines[] = '{';
        $lines[] =     '// <user-additions' . ' part="traitsUse">';
        $lines[] =     '// </user-additions' . '>';
        $lines[] = '';
        $lines[] =     '// <user-additions' . ' part="constructorDeclaration">';
        $lines[] =     'public function __construct()';
        $lines[] =     '// </user-additions' . '>';
        $lines[] =     '{';

        $lines = array_merge($lines, $this->getConstructorHelpLines());

        $lines[] = '// <user-additions' . ' part="constructor">';

        $lines = array_merge($lines, $this->getConstructorInsideLines());

        $lines[] =     '    // </user-additions' . '>';
        $lines[] =     '}';
        $lines[] = '';
        $lines[] =     '// <user-additions' . ' part="methods">';
        $lines[] =     '// </user-additions' . '>';
        $lines[] = '';
        $lines[] =     'public function buildForm(FormBuilderInterface $builder, array $options)';
        $lines[] =     '{';
        $lines[] =     '    // parent::buildForm($builder, $options);';
        $lines[] =     '    ';
        $lines[] =     '    // <user-additions' . ' part="buildForm">';
        $lines[] =     '    parent::buildForm($builder, $options);';
        $lines[] =     '    // </user-additions' . '>';
        $lines[] =     '}';
        $lines[] = '}';

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
