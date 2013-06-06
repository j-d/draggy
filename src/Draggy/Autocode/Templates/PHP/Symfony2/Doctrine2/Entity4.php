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
    public function getCascadePart(PHPAttribute $attribute)
    {
        $cascadeAttributes = [];

        if ($attribute->getCascadePersist()) {
            $cascadeAttributes[] = '"persist"';
        }

        if ($attribute->getCascadeRemove()) {
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
                        $lines[] = '@ORM\\ManyToOne(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $attribute->getEntity()->getPluralLowerName() . '"' . $this->getCascadePart($attribute) .')';
                        $lines[] = '@ORM\\JoinColumn(name="' . $attribute->getName() . '", referencedColumnName="' . $attribute->getForeignKey()->getName() . '")';
                    } else {
                        $lines[] = '@ORM\\OneToMany(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $attribute->getForeignKey()->getName() . '")';
                    }
                    break;
                case 'OneToOne':
                    if ($attribute->getOwnerSide()) {
                        $lines[] = '@ORM\\OneToOne(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", inversedBy="' . $attribute->getEntity()->getLowerName() . '"' . $this->getCascadePart($attribute) . ')';
                        $lines[] = '@ORM\\JoinColumn(name="' . $attribute->getName() . '", referencedColumnName="' . $attribute->getForeignKey()->getName() . '")';
                    } else {
                        $lines[] = '@ORM\\OneToOne(targetEntity="' . $attribute->getForeignEntity()->getFullyQualifiedName() . '", mappedBy="' . $attribute->getForeignKey()->getName() . '")';
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
    // </user-additions>
    // </editor-fold>
}
