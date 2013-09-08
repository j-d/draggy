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
use Draggy\Autocode\Templates\RenderizableTemplateInterface;
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\Form
 */
class Form extends FormBase implements RenderizableTemplateInterface
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
     * {@inheritdoc}
     */
    public function getTemplateName()
    {
        return 'form';
    }

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
                    $lines[] = '$this->fields[\'' . $attr->getFullName() . '\'] = $this->' . $attr->getGetterName() . 'Field();';
                    $lines[] = '$this->fields[\'' . $attr->getFullName() . '\']';
                    $lines[] =     '->setParentForm($this);';
                    $lines[] = '$this->fields[\'' . $attr->getFullName() . '\']';
                    $lines[] =     '->setSymfonyExpanded(true)';

                    $line = '->setSymfonyProperty(\'xxx\'); // Possible choices: ';

                    foreach ($attr->getForeignEntity()->getAttributes() as $foreignAttr) {
                        if (null === $foreignAttr->getForeign() && 'boolean' !== $foreignAttr->getPhpType()) {
                            $line .= ' ' . $foreignAttr->getFullName();
                        }
                    }

                    $lines[] = $line;
                    $lines[] = '';

                    break;
                case 'Collection':
                    $lines[] = '$this->fields[\'' . $attr->getFullName() . '\'] = $this->' . $attr->getGetterName() . 'Field();';
                    $lines[] = '$' . $attr->getFullName() . ' = $this->fields[\'' . $attr->getFullName() . '\'];';
                    $lines[] = '$this->fields[\'' . $attr->getFullName() . '\']';
                    $lines[] =     '->setSymfonyAllowAdd(true)';
                    $lines[] =     '->setSymfonyAllowDelete(true);';
                    $lines[] = '';

                    break;
                default:
                    $lines[] = '$this->fields[\'' . $attr->getFullName() . '\'] = $this->' . $attr->getGetterName() . 'Field();';
                    break;
            }
        }

        return $this->commentAndIndentLines($lines);
    }

    public function getConstructorInsideLines()
    {
        $lines = [];

        $someCollections  = false;
        $constructorLines = [];

        foreach ($this->getEntity()->getFormAttributes() as $attr) {
            if ('Collection' !== $attr->getFormClassType()) {
                $constructorLines[] = '$this->fields[\'' . $attr->getFullName() . '\'] = $this->' . $attr->getGetterName() . 'Field();';
            } else {
                $someCollections = true;
                $constructorLines[] = '// $this->fields[\'' . $attr->getFullName() . '\'] = $this->' . $attr->getGetterName() . 'Field();';
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
        $lines[] =     $this->getUserAdditions('implements');
        $lines[] =     $this->getEndUserAdditions();
        $lines[] = '{';
        $lines[] =     $this->getUserAdditions('traitsUse');
        $lines[] =     $this->getEndUserAdditions();
        $lines[] = '';
        $lines[] =     $this->getUserAdditions('constructorDeclaration');
        $lines[] =     'public function __construct()';
        $lines[] =     $this->getEndUserAdditions();
        $lines[] =     '{';

        $lines = array_merge($lines, $this->getConstructorHelpLines());

        $lines[] = $this->getUserAdditions('constructor');

        $lines = array_merge($lines, $this->getConstructorInsideLines());

        $lines[] = $this->getEndUserAdditions();

        $lines[] =     '}';
        $lines[] = '';
        $lines[] =     $this->getUserAdditions('methods');
        $lines[] =     $this->getEndUserAdditions();
        $lines[] = '';
        $lines[] =     'public function buildForm(FormBuilderInterface $builder, array $options)';
        $lines[] =     '{';
        $lines[] =         '// parent::buildForm($builder, $options);';
        $lines[] =         '';
        $lines[] =         $this->getUserAdditions('buildForm');
        $lines[] =         'parent::buildForm($builder, $options);';
        $lines[] =         '';
        $lines[] =         '$builder->add(\'save\', \'submit\', [\'attr\' => [\'class\' => \'btn btn-primary\']]);';
        $lines[] =         $this->getEndUserAdditions();
        $lines[] =     '}';
        $lines[] = '}';

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
