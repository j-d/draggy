<?php
// Draggy\Autocode\Templates\PHP\Symfony2\Doctrine2\Entity4.php

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

namespace Draggy\Autocode\Templates\PHP\Symfony2\Doctrine2;

use Draggy\Autocode\Templates\PHP\Symfony2\Doctrine2\Base\Entity4Base;
// <user-additions part="use">
use Draggy\Autocode\PHPAttribute;
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Symfony2\Doctrine2\Entity\Entity4
 */
class Entity4 extends Entity4Base
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
    public function getCascadeOwnerPart(PHPAttribute $attribute)
    {
        $cascadeAttributes = [];

        if (in_array($attribute->getCascadePersist(), ['both', 'owner'])) {
            $cascadeAttributes[] = '"persist"';
        }

        if (in_array($attribute->getCascadeRemove(), ['both', 'owner'])) {
            $cascadeAttributes[] = '"remove"';
        }

        if (count($cascadeAttributes) > 0) {
            return ', cascade={' . implode(', ', $cascadeAttributes) . '}';
        } else {
            return '';
        }
    }

    public function getCascadeInversePart(PHPAttribute $attribute)
    {
        $cascadeAttributes = [];

        if (in_array($attribute->getCascadePersist(), ['both', 'inverse'])) {
            $cascadeAttributes[] = '"persist"';
        }

        if (in_array($attribute->getCascadeRemove(), ['both', 'inverse'])) {
            $cascadeAttributes[] = '"remove"';
        }

        if (count($cascadeAttributes) > 0) {
            return ', cascade={' . implode(', ', $cascadeAttributes) . '}';
        } else {
            return '';
        }
    }

    public function getAttributeDocumentationLinesORMPart(PHPAttribute $attribute)
    {
        $lines = [];

        if ($attribute->getPrimary()) {
            $lines[] = '@ORM\\Id';
        }

        // ORM
        if (null === $attribute->getForeign()) {
            $lines[] = '@ORM\\Column(name="' . $attribute->getName() . '", type="' . $attribute->getType() . '"' . ('string' === $attribute->getType() ? ', length=' . $attribute->getSize() : '') . ($attribute->getUnique() ? ', unique=true' : '') . ($attribute->getNull() ? ', nullable=true' : ($attribute->getPrimary() ? '' : ', nullable=false')) . ')';
        } else {
            switch ($attribute->getForeign()) {
                case 'ManyToOne':
                    if ($attribute->getOwnerSide()) {
                        $lines[] = '@ORM\\ManyToOne(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $attribute->getEntity()->getPluralLowerName() . '"' . $this->getCascadeOwnerPart($attribute) .')';
                        $lines[] = '@ORM\\JoinColumn(name="' . $attribute->getName() . '", referencedColumnName="' . $attribute->getForeignKey()->getName() . '")';
                    } else {
                        $lines[] = '@ORM\\OneToMany(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $attribute->getForeignKey()->getName() . '"' . $this->getCascadeInversePart($attribute->getForeignKey()) .')';
                    }

                    break;
                case 'OneToOne':
                    if ($attribute->getOwnerSide()) {
                        $lines[] = '@ORM\\OneToOne(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $attribute->getEntity()->getLowerName() . '"' . $this->getCascadeOwnerPart($attribute) . ')';
                        $lines[] = '@ORM\\JoinColumn(name="' . $attribute->getName() . '", referencedColumnName="' . $attribute->getForeignKey()->getName() . '")';
                    } else {
                        $lines[] = '@ORM\\OneToOne(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $attribute->getForeignKey()->getName() . '"' . $this->getCascadeInversePart($attribute->getForeignKey()) . ')';
                    }

                    break;
                case 'ManyToMany':
                    if ($attribute->getOwnerSide()) {
                        $lines[] = '@ORM\\ManyToMany(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $attribute->getReverseAttribute()->getName() . '")';
                        $lines[] = '@ORM\JoinTable(';
                        $lines[] =     'name="' . $attribute->getManyToManyEntityName() . '",';

                        //if ($attribute->getForeignEntity()->getName() === $attribute->getEntity()->getName()) { // Is reflexive? (Testing with the names for everything)
                            $lines[] = 'joinColumns={@ORM\JoinColumn(name="' . $attribute->getReverseAttribute()->getName() . '", referencedColumnName="' . $attribute->getEntity()->getPrimaryAttribute()->getName() . '")},';
                            $lines[] = 'inverseJoinColumns={@ORM\JoinColumn(name="' . $attribute->getName() . '", referencedColumnName="' . $attribute->getForeignKey()->getName() . '")}';
                        //} else {
                        //    $lines[] = 'joinColumns={@ORM\JoinColumn(referencedColumnName="' . $attribute->getEntity()->getPrimaryAttribute()->getName() . '")},';
                        //    $lines[] = 'inverseJoinColumns={@ORM\JoinColumn(referencedColumnName="' . $attribute->getForeignKey()->getName() . '")}';
                        //}

                        $lines[] = ')';
                    } else {
                        $lines[] = '@ORM\\ManyToMany(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $attribute->getReverseAttribute()->getName() . '")';
                    }

                    break;
                default:
                    throw new \Exception('foreignMethod not implemented (' . $attribute->getForeign() . ')');
            }
        }

        if ($attribute->getAutoIncrement() && !$attribute->getForeignTick()) {
            $lines[] = '@ORM\GeneratedValue(strategy="AUTO")';
        }

        return $lines;
    }

    public function getAttributeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = $this->getAttributeDocumentationLinesBasePart($attribute);

        $ormLines = $this->getAttributeDocumentationLinesORMPart($attribute);

        if (count($ormLines) > 0) {
            $lines[] = '';

            $lines = array_merge($lines, $ormLines);
        }

        $assertLines = $this->getAttributeDocumentationLinesAssertPart($attribute);

        if (count($assertLines) > 0) {
            $lines[] = '';

            $lines = array_merge($lines, $assertLines);
        }

        return $lines;
    }

    public function getUseLines()
    {
        $lines = [];

        $lines[] = 'use Doctrine\\ORM\\Mapping as ORM;';

        $useArrayCollection = false;
        foreach ($this->getEntity()->getAttributes() as $attr) {
            if (null !== $attr->getForeign()) {
                $useArrayCollection = true;
                break;
            }
        }

        if ($useArrayCollection) {
            $lines[] = 'use Doctrine\\Common\\Collections\\Collection;';
            $lines[] = 'use Doctrine\\Common\\Collections\\ArrayCollection;'; // Is needed when doing new ArrayCollection();
        }

        $lines = array_merge($lines, parent::getUseLines());

        return $lines;
    }

    public function getEntityDocumentationLines()
    {
        $lines = parent::getEntityDocumentationLines();

        $lines[] = '';

        $lines[] = $this->getEntity()->getProject()->getBase() || null !== $this->getEntity()->getParentEntity()
            ? '@ORM\\MappedSuperclass'
            : '@ORM\\Entity';

        if ($this->getEntity()->getProject()->getValidation()) {
            $uniqueAttributes = $this->getEntity()->getUniqueAttributes();

            if (count($uniqueAttributes) > 0) {
                $lines[] = '';

                foreach ($uniqueAttributes as $attr) {
                    $lines[] = '@DoctrineAssert\\UniqueEntity(fields="' . $attr->getName() . '", message="' . $attr->getUniqueMessage() . '")';
                }
            }
        }

        return $lines;
    }

    // <editor-fold desc="Setters">
    public function getSetterCodeDocumentationParameterLines(PHPAttribute $attribute)
    {
        $lines = parent::getSetterCodeDocumentationParameterLines($attribute);

        if (null !== $attribute->getForeign()) {
            $lines[] = '@param bool $_reverseCall';
        }

        return $lines;
    }

    public function getSetterParameters(PHPAttribute $attribute)
    {
        $parameters = parent::getSetterParameters($attribute);

        if (null !== $attribute->getForeign()) {
            $parameters[] = '$_reverseCall = true';
        }

        return $parameters;
    }

    public function getSetterCodeLinesBodyPart(PHPAttribute $attribute)
    {
        if (null === $attribute->getForeign()) {
            // Normal setter
            return parent::getSetterCodeLinesBodyPart($attribute);
        }

        $lines = [];

        $settingFromInverse = $attribute->getSettingFromInverse();

        $linesManySide = [
            'foreach (' . $attribute->getThisName() . ' as $' . $attribute->getSingleName() . ') {',
                'if (!$' . $attribute->getLowerFullName() . '->contains($' . $attribute->getSingleName() . ')) {',
                    $attribute->getThisSingleRemoverName() . '($' . $attribute->getSingleName() . ', $_reverseCall);',
                '} else {',
                    '$' . $attribute->getLowerFullName() . '->removeElement($' . $attribute->getSingleName() . ');',
                '}',
            '}',
            '',
            $attribute->getThisMultipleAdderName() . '($' . $attribute->getLowerFullName() . ', false, $_reverseCall);',
        ];

        if ('ManyToMany' === $attribute->getForeign()) {
            if (!$settingFromInverse) {
                $lines = array_merge($lines, $linesManySide);
            } else {
                $lines = array_merge($lines, $linesManySide);
            }
        } elseif ('ManyToOne' === $attribute->getForeign()) {
            if (!$settingFromInverse) {
                $lines[] = 'if ($' . $attribute->getLowerFullName() . ' !== ' . $attribute->getThisName() . ') {';
                $lines[] =     'if ($_reverseCall) {';
                $lines[] =         $attribute->getThisName() . ' = $' . $attribute->getLowerFullName() . ';';
                $lines[] =     '} else {';
                $lines[] =         'if (null !== ' . $attribute->getThisName() . ') {';
                $lines[] =             $attribute->getThisName() . '->' . $attribute->getReverseAttribute()->getSingleRemoverName() . '($this);';
                $lines[] =         '}';
                $lines[] = '';
                $lines[] =         $attribute->getThisName() . ' = $' . $attribute->getLowerFullName() . ';';
                $lines[] = '';
                $lines[] =         'if (null !== ' . $attribute->getThisName() . ' && !' . $attribute->getThisName() . '->' . $attribute->getReverseAttribute()->getSingleContainsName() . '($this)) {';
                $lines[] =             $attribute->getThisName() . '->' . $attribute->getReverseAttribute()->getSingleAdderName() . '($this);';
                $lines[] =         '}';
                $lines[] =     '}';
                $lines[] = '}';
            } else {
                $lines = array_merge($lines, $linesManySide);
            }
        } elseif ('OneToOne' === $attribute->getForeign()) {
            // If there is actually a change
            //   If I don't have to bother calling anyone back, just do it
            //   otherwise
            //     If it wasn't null, tell the previous one now is null
            //     Set it
            //     Tell the new one that needs to link to this. Can't say not to call back because perhaps it was linked to another one

            if (!$settingFromInverse) {
                $lines[] = 'if ($' . $attribute->getLowerFullName() . ' !== ' . $attribute->getThisName() . ') {';

                if ($attribute->getSetter()) {
                    $lines[] =     'if (!$_reverseCall) {';
                    $lines[] =         $attribute->getThisName() . ' = $' . $attribute->getLowerFullName() . ';';
                    $lines[] =     '} else {';
                    $lines[] =         'if (null !== ' . $attribute->getThisName() . ') {';

                    $lines[] = $attribute->getNull()
                        ? $attribute->getThisName() . '->' . $attribute->getSetterEntityName() . '(null, false);'
                        : $attribute->getThisName() . '->' . $attribute->getClearEntityName() . '();';

                    $lines[] =         '}';
                    $lines[] = '';
                    $lines[] =         $attribute->getThisName() . ' = $' . $attribute->getLowerFullName() . ';';
                    $lines[] = '';
                    $lines[] =         'if (null !== $' . $attribute->getLowerFullName() . ') {';
                    $lines[] =             '$' . $attribute->getName() . '->' . $attribute->getSetterEntityName() . '($this);';
                    $lines[] =         '}';
                    $lines[] =     '}';
                } else {
                    $lines[] = $attribute->getThisName() . ' = $' . $attribute->getLowerFullName() . ';';
                    $lines[] = '';
                    $lines[] = '// Reverse entity doesn\'t have a setter so the reverse call cannot be made';
                }

                $lines[] = '}';
            } else {
                $lines[] = 'if ($' . $attribute->getLowerFullName() . ' !== ' . $attribute->getThisName() . ') {';

                if ($attribute->getForeignKey()->getSetter()) {
                    $lines[] =     'if (!$_reverseCall) {';
                    $lines[] =         $attribute->getThisName() . ' = $' . $attribute->getLowerFullName() . ';';
                    $lines[] =     '} else {';
                    $lines[] =         'if (null !== ' . $attribute->getThisName() . ') {';

                    $lines[] = $attribute->getNull()
                        ? $attribute->getThisName() . '->' . $attribute->getForeignKey()->getSetterName() . '(null, false);'
                        : $attribute->getThisName() . '->' . $attribute->getForeignKey()->getClearName() . '();';

                    $lines[] =         '}';
                    $lines[] = '';
                    $lines[] =         $attribute->getThisName() . ' = $' . $attribute->getLowerFullName() . ';';
                    $lines[] = '';
                    $lines[] =         'if (null !== $' . $attribute->getLowerFullName() . ') {';
                    $lines[] =             '$' . $attribute->getName() . '->' . $attribute->getForeignKey()->getSetterName() . '($this);';
                    $lines[] =         '}';
                    $lines[] =     '}';
                } else {
                    $lines[] = $attribute->getThisName() . ' = $' . $attribute->getLowerFullName() . ';';
                    $lines[] = '';
                    $lines[] = '// Reverse entity doesn\'t have a setter so the reverse call cannot be made';
                }

                $lines[] = '}';
            }
        }

        return $lines;
    }

    public function getSetterCodeLines(PHPAttribute $attribute)
    {
        $lines = parent::getSetterCodeLines($attribute);

        // Needs to add a method to be able to set the value to null even if in theory is not allowed
        if ('OneToOne' === $attribute->getForeign() && !$attribute->getNull()) {
            $lines[] = '';

            $lines = array_merge($lines, $this->getClearCodeLines($attribute));
        }

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Adders">
    public function getSingleAdderCodeDocumentationParameterLines(PHPAttribute $attribute)
    {
        $lines = parent::getSingleAdderCodeDocumentationParameterLines($attribute);

        $lines[] = '@param bool $_reverseCall';

        return $lines;
    }

    public function getSingleAdderParameters(PHPAttribute $attribute)
    {
        $parameters = parent::getSingleAdderParameters($attribute);

        $parameters[] = '$_reverseCall = true';

        return $parameters;
    }

    public function getSingleAdderCodeLinesPostAssignmentPart(PHPAttribute $attribute)
    {
        $lines = parent::getSingleAdderCodeLinesPostAssignmentPart($attribute);

        $lines[] = '';
        $lines[] = 'if ($_reverseCall) {';

        if ('ManyToMany' === $attribute->getForeign()) {
            $lines[] = '$' . $attribute->getSingleName() . '->' . $attribute->getReverseAttribute()->getSingleAdderName() . '($this, $_allowRepeatedValues, false);';
        } elseif ('ManyToOne' === $attribute->getForeign() && !$attribute->getOwnerSide()) {
            $lines[] = '$' . $attribute->getSingleName() . '->' . $attribute->getReverseAttribute()->getSetterName() . '($this, false);';
        }

        $lines[] = '}';

        return $lines;
    }

    public function getMultipleAdderCodeDocumentationParameterLines(PHPAttribute $attribute)
    {
        $lines = parent::getMultipleAdderCodeDocumentationParameterLines($attribute);

        $lines[] = '@param bool $_reverseCall';

        return $lines;
    }

    public function getMultipleAdderParameters(PHPAttribute $attribute)
    {
        $parameters = parent::getMultipleAdderParameters($attribute);

        $parameters[] = '$_reverseCall = true';

        return $parameters;
    }

    public function getMultipleAdderCodeLinesAssignmentPart(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = $attribute->getThisSingleAdderName() . '($' . $attribute->getSingleName() . ', $_allowRepeatedValues, $_reverseCall);';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Contains">
    public function getSingleContainsCodeLinesBodyPart(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'return ' . $attribute->getThisName() .  '->contains($' . $attribute->getSingleName() . ');';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Removers">
    public function getSingleRemoverCodeDocumentationParameterLines(PHPAttribute $attribute)
    {
        $lines = parent::getSingleRemoverCodeDocumentationParameterLines($attribute);

        $lines[] = '@param bool $_reverseCall';

        return $lines;
    }

    public function getSingleRemoverParameters(PHPAttribute $attribute)
    {
        $parameters = parent::getSingleRemoverParameters($attribute);

        $parameters[] = '$_reverseCall = true';

        return $parameters;
    }

    public function getSingleRemoverCodeLinesBodyPart(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'if (' . $attribute->getThisName() . '->removeElement($' . $attribute->getSingleName() . ') && $_reverseCall) {';

        if ('ManyToMany' === $attribute->getForeign()) {
            $lines[] = '$' . $attribute->getSingleName() . '->' . $attribute->getReverseAttribute()->getSingleRemoverName() . '($this, false);';
        } elseif ('ManyToOne' === $attribute->getForeign() && !$attribute->getOwnerSide()) {
            $lines[] = '$' . $attribute->getSingleName() . '->' . $attribute->getReverseAttribute()->getSetterName() . '(null, false);';
        }

        $lines[] = '}';

        return $lines;
    }

    public function getMultipleRemoverCodeDocumentationParameterLines(PHPAttribute $attribute)
    {
        $lines = parent::getMultipleRemoverCodeDocumentationParameterLines($attribute);

        $lines[] = '@param bool $_reverseCall';

        return $lines;
    }

    public function getMultipleRemoverParameters(PHPAttribute $attribute)
    {
        $parameters = parent::getMultipleRemoverParameters($attribute);

        $parameters[] = '$_reverseCall = true';

        return $parameters;
    }

    public function getMultipleRemoverCodeLinesBodyCallPart(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = $attribute->getThisSingleRemoverName() . '($' . $attribute->getSingleName() . ', $_reverseCall);';

        return $lines;
    }
    // </editor-fold>

    // </user-additions>
    // </editor-fold>
}
