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
class Entity extends CPPEntityTemplate implements RenderizableTemplateInterface
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
        return 'entity';
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

    public function getImportLines()
    {
        $lines = [];

        if ('' != $this->getEntity()->getParentEntity()) {
            $lines[] = 'import ' . str_replace('.base', '', $this->getEntity()->getParentEntity()->getName()) . ';';
        }

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ('object' == $attr->getType()) {
                $lines[] = 'import ' . str_replace('.base', '', $attr->getEntitySubtype()->getName()) . ';';
            }
        }

        return array_unique($lines, SORT_STRING);
    }

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
    public function getSetterDeclarationLine(CPPAttribute $attribute)
    {
        if ('object' === $attribute->getType()) {
            return $this->getEntity()->getProject()->getAutocodeProperty('base')
                ? $this->getEntity()->getNameBase() . ' ' . $this->getEntity()->getNameBase() . '::' . $attribute->getSetterName() . '(' . $attribute->getEntitySubtype()->getName() . ' _' . $attribute->getName() . ')'
                : $this->getEntity()->getName() . ' ' . $this->getEntity()->getName() . '::' . $attribute->getSetterName() . '(' . $attribute->getEntitySubtype()->getName() . ' _' . $attribute->getName() . ')';
        } else {
            return $this->getEntity()->getProject()->getAutocodeProperty('base')
                ? $this->getEntity()->getNameBase() . ' ' . $this->getEntity()->getNameBase() . '::' . $attribute->getSetterName() . '(' . $attribute->getType() . ' _' . $attribute->getName() . ')'
                : $this->getEntity()->getName() . ' ' . $this->getEntity()->getName() . '::' . $attribute->getSetterName() . '(' . $attribute->getType() . ' _' . $attribute->getName() . ')';
        }
    }

    public function getSetterCodeLinesBodyPart(CPPAttribute $attribute)
    {
        $lines = [];

        $lines[] = $attribute->getName() . ' = _' . $attribute->getLowerFullName() . ';';

        return $lines;
    }

    public function getSetterCodeLines(CPPAttribute $attribute)
    {
        $lines = [];

        $lines[] = $this->getSetterDeclarationLine($attribute);

        $lines[] = '{';

        $lines = array_merge($lines, $this->getSetterCodeLinesBodyPart($attribute));

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = 'return *this;';
        }

        $lines[] = '};';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Getters">
    public function getGetterCodeLines(CPPAttribute $attribute)
    {
        $lines = [];

        $base = $this->getEntity()->getProject()->getAutocodeProperty('base');

        if ('object' === $attribute->getType()) {
            $lines[] = $attribute->getStatic()
                ? $attribute->getEntitySubtype()->getName() . ' ' . ($base ? $this->getEntity()->getNameBase() : $this->getEntity()->getName()) . '::' . $attribute->getGetterName() . '()'
                : $attribute->getEntitySubtype()->getName() . ' ' . ($base ? $this->getEntity()->getNameBase() : $this->getEntity()->getName()) . '::' . $attribute->getGetterName() . '()';
        } else {
            $lines[] = $attribute->getStatic()
                ? $attribute->getType() . ' ' . ($base ? $this->getEntity()->getNameBase() : $this->getEntity()->getName()) . '::' . $attribute->getGetterName() . '()'
                : $attribute->getType() . ' ' . ($base ? $this->getEntity()->getNameBase() : $this->getEntity()->getName()) . '::' . $attribute->getGetterName() . '()';
        }

        $lines[] = '{';
        $lines[] =     'return ' . $attribute->getName() . ';';
        $lines[] = '};';

        return $lines;
    }
    // </editor-fold>

    public function getRequiredEntities()
    {
        $requiredEntities = [];

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if (!is_null($attr->getForeignEntity())) {
                $foreignEntity = $attr->getForeignEntity()->getFullyQualifiedName();

                if (!in_array($foreignEntity, $requiredEntities)) {
                    $requiredEntities[] = $foreignEntity;
                    $requiredEntities[] = $attr->getForeignEntity()->getFullyQualifiedBaseName();
                }
            }
        }

        return $requiredEntities;
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

    public function getConstructorLines()
    {
        $lines = [];

        if (!$this->getEntity()->getHasConstructor()) {
            $lines[] = '';
            $lines[] = '// Constructor';
            $lines[] = $this->getEntity()->getNameBase() . '::' . $this->getEntity()->getNameBase() . '()';
            $lines[] = '{';

            foreach ($this->getEntity()->getAttributes() as $attr) {
                if ('' != $attr->getDefaultValue()) {
                    $lines[] = $attr->getLowerFullName() . ' = ' . $attr->getDefaultValue() . ';';
                } elseif (in_array($attr->getType(), ['char', 'short', 'int', 'long', 'float', 'double', 'float', 'double'])) {
                    $lines[] = $attr->getLowerFullName() . ' = 0;';
                } elseif (in_array($attr->getType(), ['bool'])) {
                    $lines[] = $attr->getLowerFullName() . ' = false;';
                }
            }

            $lines[] = '};';
        }

        return $lines;
    }

    public function getSetterGetterLines(CPPAttribute $attribute)
    {
        $lines = [];

        if ($attribute->getSetter()) {
            $lines = array_merge($lines, $this->getSetterCodeLines($attribute));
        }

        if ($attribute->getGetter()) {
            if (0 !== count($lines)) {
                $lines[] = '';
            }

            $lines = array_merge($lines, $this->getGetterCodeLines($attribute));
        }

        return $lines;
    }

    public function getAllSetterGetterLines()
    {
        $lines = [];

        $lines[] = '';
        $lines[] = '// Setters and getters';

        $setterGetterLines = [];

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ( null === $this->getEntity()->getParentEntity() || !in_array($attr->getFullName(), array_keys($this->getEntity()->getParentEntity()->getAttributes())) ) {
                if (0 !== count($setterGetterLines)) {
                    $setterGetterLines[] = '';
                }

                $setterGetterLines = array_merge($setterGetterLines, $this->getSetterGetterLines($attr));
            }
        }

        $lines = array_merge($lines, $setterGetterLines);

        return $lines;
    }

    public function getFileLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->getConstructorLines());
        $lines = array_merge($lines, $this->getAllSetterGetterLines());

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
