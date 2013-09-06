<?php
// Draggy\Autocode\Templates\PHP\Entity1.php

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

namespace Draggy\Autocode\Templates\CPP;

// <user-additions part="use">
use Draggy\Autocode\Attribute;
use Draggy\Autocode\CPPAttribute;
use Draggy\Autocode\Templates\RenderizableTemplateInterface;
use Draggy\Autocode\Templates\CPPEntityTemplate;
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\Entity1
 */
class EntityHeader extends CPPEntityTemplate implements RenderizableTemplateInterface
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
    public function getTemplateName()
    {
        return 'entity-header';
    }

    public function getFilename()
    {
        return $this->getEntity()->getNameBase() . '.h';
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getEntity()->getNameBase();
    }

//    public function getImportLines()
//    {
//        $lines = [];
//
//        if ('' != $this->getEntity()->getParentEntity()) {
//            $lines[] = 'import ' . str_replace('.base', '', $this->getEntity()->getParentEntity()->getName()) . ';';
//        }
//
//        foreach ($this->getEntity()->getAttributes() as $attr) {
//            if ('object' == $attr->getType()) {
//                $lines[] = 'import ' . str_replace('.base', '', $attr->getEntitySubtype()->getName()) . ';';
//            }
//        }
//
//        return array_unique($lines, SORT_STRING);
//    }

    // <editor-fold desc="Attributes">
    public function getAttributeLines(CPPAttribute $attribute)
    {
        $lines = [];

        if ('object' === $attribute->getType()) {
            $lines[] = $attribute->getEntitySubtype()->getName() . ' ' . $attribute->getName() . ';';
        } else {
            $lines[] = $attribute->getType() . ' ' . $attribute->getName() . ';';
        }

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Setters">
    public function getSetterDeclarationLines(CPPAttribute $attribute)
    {
        $lines = [];

        if ('object' === $attribute->getType()) {
            $lines[] = $this->getEntity()->getProject()->getAutocodeProperty('base')
                ? $this->getEntity()->getNameBase() . ' ' . $attribute->getSetterName() . '(' . $attribute->getEntitySubtype()->getName() . ' ' . $attribute->getName() . ');'
                : $this->getEntity()->getName() . ' ' . $attribute->getSetterName() . '(' . $attribute->getEntitySubtype()->getName() . ' ' . $attribute->getName() . ');';
        } else {
            $lines[] = $this->getEntity()->getProject()->getAutocodeProperty('base')
                ? $this->getEntity()->getNameBase() . ' ' . $attribute->getSetterName() . '(' . $attribute->getType() . ');'
                : $this->getEntity()->getName() . ' ' . $attribute->getSetterName() . '(' . $attribute->getType() . ');';
        }

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Getters">
    public function getGetterDeclarationLines(CPPAttribute $attribute)
    {
        $lines = [];

        if ('object' === $attribute->getType()) {
            $lines[] = $attribute->getStatic()
                ? $attribute->getEntitySubtype()->getName() . ' ' . $attribute->getGetterName() . '();'
                : $attribute->getEntitySubtype()->getName() . ' ' . $attribute->getGetterName() . '();';
        } else {
            $lines[] = $attribute->getStatic()
                ? $attribute->getType() . ' ' . $attribute->getGetterName() . '();'
                : $attribute->getType() . ' ' . $attribute->getGetterName() . '();';
        }

        return $lines;
    }
    // </editor-fold>
    public function getEntityDeclarationLine()
    {
        $line = '';

        if (!$this->getEntity()->getProject()->getBase()) {
            $line .= 'class ' . $this->getEntity()->getName();
        } else {
            $line .= 'class ' . $this->getEntity()->getNameBase();
        }

        if (null !== $this->getEntity()->getParentEntity()) {
            $line .= ': public ' . $this->getEntity()->getParentEntity()->getName();
        }

        return $line;
    }

    /**
     * @return CPPAttribute[]
     */
    public function getRenderAttributes()
    {
        $renderAttributes = [];

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ( null === $this->getEntity()->getParentEntity() || !in_array($attr->getFullName(), array_keys($this->getEntity()->getParentEntity()->getAttributes())) ) {
                $renderAttributes[] = $attr;
            }
        }

        return $renderAttributes;
    }

    public function getAllAttributeLines()
    {
        $lines = [];

        $renderAttributes = $this->getRenderAttributes();

        $lines[] = '// Attributes';
        $lines[] = 'protected:';
        $lines[] = '';

        if (0 !== count($renderAttributes)) {
            foreach ($renderAttributes as $attr) {
                $lines = array_merge($lines, $this->getAttributeLines($attr));
            }
        }

        return $lines;
    }

    public function getSetterGetterDeclarationLines(CPPAttribute $attribute)
    {
        $lines = [];

        if ($attribute->getSetter()) {
            $lines = array_merge($lines, $this->getSetterDeclarationLines($attribute));
        }

        if ($attribute->getGetter()) {
            $lines = array_merge($lines, $this->getGetterDeclarationLines($attribute));
        }

        return $lines;
    }

    public function getAllSetterGetterDeclarationLines()
    {
        $lines = [];

        $lines[] = '';
        $lines[] = '// Methods';
        $lines[] = 'public:';
        $lines[] = '';

        $setterGetterLines = [];

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ( null === $this->getEntity()->getParentEntity() || !in_array($attr->getFullName(), array_keys($this->getEntity()->getParentEntity()->getAttributes())) ) {
                if (0 !== count($setterGetterLines)) {
                    $setterGetterLines[] = '';
                }

                $setterGetterLines = array_merge($setterGetterLines, $this->getSetterGetterDeclarationLines($attr));
            }
        }

        $lines = array_merge($lines, $setterGetterLines);

        return $lines;
    }

    public function getFileLines()
    {
        $lines = [];

        $lines[] = $this->getEntityDeclarationLine();

        $lines[] = '{';

        $lines = array_merge($lines, $this->getAllAttributeLines());
        $lines = array_merge($lines, $this->getAllSetterGetterDeclarationLines());

        $lines[] = '};';

        return $lines;
    }

    public function render()
    {
        if (0 === count($this->getEntity()->getPrimaryAttributes())) {
            if ('' !== $this->getEntity()->getProject()->getORM()) {
                throw new \RuntimeException( 'The entity ' . $this->getEntity()->getName() . ' doesn\'t have a primary key.' );
            }
        }

        return parent::render();
    }
    // </user-additions>
    // </editor-fold>
}
