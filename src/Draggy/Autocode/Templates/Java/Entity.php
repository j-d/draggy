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

namespace Draggy\Autocode\Templates\Java;

// <user-additions part="use">
use Draggy\Autocode\Attribute;
use Draggy\Autocode\JavaAttribute;
use Draggy\Autocode\Templates\RenderizableTemplateInterface;
use Draggy\Autocode\Templates\JavaEntityTemplate;
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\Entity1
 */
class Entity extends JavaEntityTemplate implements RenderizableTemplateInterface
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
        return $this->getEntity()->getProject()->getAutocodeProperty('base')
            ? 'base/'
            : '';
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
            $lines[] = 'import ' . str_replace('.base', '', $this->getFullPackage($this->getEntity()->getParentEntity()) . '.' . $this->getEntity()->getParentEntity()->getName()) . ';';
        }

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ('object' == $attr->getType()) {
                $lines[] = 'import ' . str_replace('.base', '', $this->getFullPackage($attr->getEntitySubtype()) . '.' . $attr->getEntitySubtype()->getName()) . ';';
            }
        }

        return array_unique($lines, SORT_STRING);
    }

    // <editor-fold desc="Attributes">
    public function getAttributeDocumentationLinesBasePart(JavaAttribute $attribute)
    {
        $lines = [];

        if (null !== $attribute->getDescription()) {
            $lines[] = $attribute->getDescription();
            $lines[] = '';
        }

        $lines[] = '@var ' . $attribute->getType() . ' ' . $attribute->getLowerFullName();

        return $lines;
    }

    public function getAttributeDocumentationLines(JavaAttribute $attribute)
    {
        return $this->getAttributeDocumentationLinesBasePart($attribute);
    }

    public function getAttributeLines(JavaAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getAttributeDocumentationLines($attribute)));

        if ('object' === $attribute->getType()) {
            $lines[] = 'protected ' . $attribute->getEntitySubtype()->getName() . ' ' . $attribute->getName() . ';';
        } else {
            $lines[] = 'protected ' . $attribute->getType() . ' ' . $attribute->getName() . ';';
        }

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Setters">
    public function getSetterCodeDocumentationParameterLines(JavaAttribute $attribute)
    {
        $lines = [];

        $lines[] = '@param ' . $attribute->getType() . ' ' . $attribute->getLowerFullName();

        return $lines;
    }

    public function getSetterCodeDocumentationLines(JavaAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Set ' . $attribute->getLowerFullName();
        $lines[] = '';

        $lines = array_merge($lines, $this->getSetterCodeDocumentationParameterLines($attribute));

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '@return this';
        }

        return $lines;
    }

    public function getSetterDeclarationLine(JavaAttribute $attribute)
    {
        if ('object' === $attribute->getType()) {
            return $this->getEntity()->getProject()->getAutocodeProperty('base')
                ? 'public ' . ($attribute->getStatic() ? 'static ' : '') . $this->getEntity()->getNameBase() . ' ' . $attribute->getSetterName() . '(' . $attribute->getEntitySubtype()->getName() . ' ' . $attribute->getName() . ')'
                : 'public ' . ($attribute->getStatic() ? 'static ' : '') . $this->getEntity()->getName() . ' ' . $attribute->getSetterName() . '(' . $attribute->getEntitySubtype()->getName() . ' ' . $attribute->getName() . ')';
        } else {
            return $this->getEntity()->getProject()->getAutocodeProperty('base')
                ? 'public ' . ($attribute->getStatic() ? 'static ' : '') . $this->getEntity()->getNameBase() . ' ' . $attribute->getSetterName() . '(' . $attribute->getType() . ' ' . $attribute->getName() . ')'
                : 'public ' . ($attribute->getStatic() ? 'static ' : '') . $this->getEntity()->getName() . ' ' . $attribute->getSetterName() . '(' . $attribute->getType() . ' ' . $attribute->getName() . ')';
        }
    }

    public function getSetterCodeLinesBodyPart(JavaAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'this.' . $attribute->getName() . ' = ' . $attribute->getLowerFullName() . ';';

        return $lines;
    }

    public function getSetterCodeLines(JavaAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getSetterCodeDocumentationLines($attribute)));

        $lines[] = $this->getSetterDeclarationLine($attribute);

        $lines[] = '{';

        $lines = array_merge($lines, $this->getSetterCodeLinesBodyPart($attribute));

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = 'return this;';
        }

        $lines[] = '}';

        return $lines;
    }

    // </editor-fold>

    // <editor-fold desc="Getters">
    public function getGetterCodeDocumentationLines(JavaAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Get ' . $attribute->getLowerFullName();
        $lines[] = '';
        $lines[] = '@return ' . ('object' === $attribute->getType() ? $attribute->getEntitySubtype()->getName() : $attribute->getType());

        return $lines;
    }

    public function getGetterCodeLines(JavaAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getGetterCodeDocumentationLines($attribute)));

        if ('object' === $attribute->getType()) {
            $lines[] = $attribute->getStatic()
                ? 'public static ' . $attribute->getEntitySubtype()->getName() . ' ' . $attribute->getGetterName() . '()'
                : 'public ' . $attribute->getEntitySubtype()->getName() . ' ' . $attribute->getGetterName() . '()';
        } else {
            $lines[] = $attribute->getStatic()
                ? 'public static ' . $attribute->getType() . ' ' . $attribute->getGetterName() . '()'
                : 'public ' . $attribute->getType() . ' ' . $attribute->getGetterName() . '()';
        }

        $lines[] = '{';
        $lines[] = 'return this.' . $attribute->getName() . ';';
        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="toString">
    public function getEntityToStringDocumentationLines()
    {
        $lines = [];


        $line = $this->getEntity()->getName() . ' to string ';

        $line .= null === $this->getEntity()->getToString()
            ? '(Default)'
            : '(' . $this->getEntity()->getToString() . ')';

        $lines[] = $line;

        $lines[] = '';
        $lines[] = '@return String';

        return $lines;
    }

    public function getEntityToStringLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getEntityToStringDocumentationLines()));

        $lines[] = 'public String toString()';
        $lines[] = '{';

        if (null === $this->getEntity()->getToString()) {
            $lines[] = 'return "' . $this->getEntity()->getName() . '";';
        } else {
            $lines[] = 'return this.' . $this->getEntity()->getAttributeByName($this->getEntity()->getToString())->getFullName() . ');';
        }

        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    public function getPackageLine()
    {
        return 'package ' . $this->getFullPackage() . ';';
    }

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

    public function getEntityDeclarationLine()
    {
        $line = '';

        if (!$this->getEntity()->getProject()->getBase()) {
            $line .= 'public class ' . $this->getEntity()->getName();
        } else {
            $line .= 'public abstract class ' . $this->getEntity()->getNameBase();
        }

        if (null !== $this->getEntity()->getParentEntity()) {
            $line .= ' extends ' . $this->getEntity()->getParentEntity()->getName();
        }

        return $line;
    }

    /**
     * @return JavaAttribute[]
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

        if (0 !== count($renderAttributes)) {
            foreach ($renderAttributes as $attr) {
                $lines = array_merge($lines, $this->getAttributeLines($attr));
                $lines[] = '';
            }
        }

        $lines[] = '// End of attributes';

        return $lines;
    }

    public function getConstructorLines()
    {
        $lines = [];

        if (!$this->getEntity()->getHasConstructor()) {
            $lines[] = '';
            $lines[] = '// Constructor';
            $lines[] = 'public ' . $this->getEntity()->getNameBase() . '()';
            $lines[] = '{';

            foreach ($this->getEntity()->getAttributes() as $attr) {
                if ('' != $attr->getDefaultValue()) {
                    if ('String' === $attr->getType()) {
                        $lines[] = 'this.' . $attr->getLowerFullName() . ' = new String("' . $attr->getDefaultValue() . '");';
                    } else {
                        $lines[] = 'this.' . $attr->getLowerFullName() . ' = ' . $attr->getDefaultValue() . ';';
                    }
                }
            }

            $lines[] = '}';
            $lines[] = '// End of constructor';
        }

        return $lines;
    }

    public function getSetterGetterLines(JavaAttribute $attribute)
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

        $lines[] = '// End of setters and getters';

        return $lines;
    }

    public function getOtherMethodLines()
    {
        $lines = [];

        $lines[] = '';
        $lines[] = '// Other methods';

        $lines = array_merge($lines, $this->getEntityToStringLines());

        $lines[] = '// End of other methods';

        return $lines;
    }

    public function getFileLines()
    {
        $lines = [];

        $lines[] = $this->getEntityDeclarationLine();

        $lines[] = '{';

        $lines = array_merge($lines, $this->getAllAttributeLines());
        $lines = array_merge($lines, $this->getConstructorLines());
        $lines = array_merge($lines, $this->getAllSetterGetterLines());
        $lines = array_merge($lines, $this->getOtherMethodLines());

        $lines[] = '}';

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
