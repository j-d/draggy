<?php
// Draggy\Autocode\Templates\PHP\Symfony2\Entity3.php

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

namespace Draggy\Autocode\Templates\PHP\Symfony2;

use Draggy\Autocode\Templates\PHP\Symfony2\Base\Entity3Base;
// <user-additions part="use">
use Draggy\Autocode\PHPAttribute;
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Symfony2\Entity\Entity3
 */
class Entity3 extends Entity3Base
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
        return 'Entity/' . parent::getPath();
    }

    public function getAttributeDocumentationLinesAssertPart(PHPAttribute $attribute)
    {
        $lines = [];

        if (!$attribute->getInverse() && $attribute->getEntity()->getProject()->getValidation() && !$attribute->getAutoIncrement()) {
            if ('array' !== $attribute->getType()) {
                $lines[] = '@Assert\\Type(type="' . $attribute->getSymfonyType() . '", message="' . $attribute->getTypeMessage() . '")';
            }

            if(!$attribute->getNull() && 'boolean' !== $attribute->getType()) {
                $lines[] = '@Assert\\NotBlank(message="' . $attribute->getRequiredMessage() . '")';
            }

            if ('string' === $attribute->getType()) {
                $lines[] = '@Assert\\Length(';

                $assertsArray = [];

                if (null !== $attribute->getMinSize()) {
                    $assertsArray[] =     'min = "' . $attribute->getMinSize() . '"';
                }

                $assertsArray[] =     'max = "' . $attribute->getSize() . '"';

                if (null !== $attribute->getMinSize()) {
                    if ($attribute->getSize() !== $attribute->getMinSize()) {
                        $assertsArray[] =     'minMessage = "' . $attribute->getMinMessage() . '"';
                    } else {
                        $assertsArray[] =     'exactMessage = "' . $attribute->getExactMessage() . '"';
                    }
                }

                if ( null === $attribute->getMinSize() || $attribute->getSize() !== $attribute->getMinSize()) {
                    $assertsArray[] =     'maxMessage = "' . $attribute->getMaxMessage() . '"';
                }

                for ($i = 0; $i < count($assertsArray) - 1; $i++) {
                    $assertsArray[$i] .= ',';
                }

                $lines = array_merge($lines, $assertsArray);

                $lines[] = ')';
            }

            if ($attribute->getEmail()) {
                $lines[] = '@Assert\\Email()';
            }
        }

        return $lines;
    }

    public function getAttributeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = $this->getAttributeDocumentationLinesBasePart($attribute);

        $assertLines = $this->getAttributeDocumentationLinesAssertPart($attribute);

        if (count($assertLines) > 0) {
            $lines[] = '';
            $lines = array_merge($lines, $assertLines);
        }

        return $lines;
    }

    public function getNamespaceLine()
    {
        $line = 'namespace ' . $this->getEntity()->getNamespace() . '\\Entity';

        if ($this->getEntity()->getProject()->getBase()) {
            $line .= '\\Base';
        }

        $line .= ';';

        return $line;
    }

    public function getUseLines()
    {
        $lines = [];

        if ($this->getEntity()->getProject()->getValidation()) {
            $lines[] = 'use Symfony\\Component\\Validator\\Constraints as Assert;';
        }

        if (count($this->getEntity()->getUniqueAttributes()) > 0) {
            $lines[] = 'use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;';
        }

        $lines = array_merge($lines, parent::getUseLines());

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
