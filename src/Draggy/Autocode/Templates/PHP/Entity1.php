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

namespace Draggy\Autocode\Templates\PHP;

use Draggy\Autocode\Templates\PHP\Base\Entity1Base;
// <user-additions part="use">
use Draggy\Autocode\Attribute;
use Draggy\Autocode\PHPAttribute;
use Draggy\Autocode\Templates\RenderizableTemplateInterface;
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\Entity1
 */
class Entity1 extends Entity1Base implements RenderizableTemplateInterface
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
        return 'entity';
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        return $this->getEntity()->getProject()->getBase()
            ? 'Base/'
            : '';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getEntity()->getNameBase();
    }

    /**
     * Returns a condition to check for the $attribute type. It allows for one or more types, including objects.
     *
     * @param PHPAttribute $attribute
     * @param string[]     $allowedTypes     An array with the basic types, or a sub array in case of objects. E.g. ['integer', ['object'=>'MyClass']]
     *
     * @return string
     *
     * @throws \RuntimeException if the allowedTypes array is not well formed
     */
    protected function getTypeCheckLines(PHPAttribute $attribute, array $allowedTypes)
    {
        $phpTypes     = ['boolean', 'integer', 'float', 'string', 'array', 'object', 'null', 'NULL'];
        $phpFunctions = [
            'boolean' => 'is_bool',
            'integer' => 'is_numeric',
            'float'   => 'is_numeric',
            'string'  => 'is_string',
            'array'   => 'is_array'
        ];

        $names     = [];
        $condition = [];

        foreach ($allowedTypes as $type) {
            if ((!is_array($type) && !in_array($type, $phpTypes)) || (is_array($type) && !isset($type['object']))) {
                throw new \RuntimeException('Invalid allowedTypes passed to getTypeCheck (' . (!is_array($type) ? $type : current(array_keys($type))) . ').');
            }

            if (is_array($type)) {
                $names[] = $type['object'];

                $condition[] = '!$' . $attribute->getFullName() . ' instanceof ' . $type['object'];
            } else {
                /** @var string $type */
                $names[] = $type;

                if ('null' === $type || 'NULL' === $type) {
                    $condition[] = 'null !== $' . $attribute->getLowerFullName();
                } else {
                    $condition[] = '!' . $phpFunctions[$type] . '($' . $attribute->getLowerFullName() . ')';
                }
            }
        }

        if (count($names) > 2) {
            $types = implode(' or ', [implode(', ', array_slice($names, 0, -1)), end($names)]);
        } else {
            $types = implode(' or ', $names);
        }

        $lines = [];

        $lines[] = 'if (' . implode(' && ', $condition) . ') {';
        $lines[] =     'throw new \InvalidArgumentException(\'The attribute ' . $attribute->getLowerFullName() . ' on the class ' . $attribute->getEntity()->getName() . ' has to be ' . $types . ' (\' . gettype($' . $attribute->getLowerFullName() . ') . (\'object\' === gettype($' . $attribute->getLowerFullName() . ') ? \' \' . get_class($' . $attribute->getLowerFullName() . ') : \'\') . \' given).\');';
        $lines[] = '}';

        return $lines;
    }

    // <editor-fold desc="Attributes">
    public function getAttributeDocumentationLinesBasePart(PHPAttribute $attribute)
    {
        $lines = [];

        if (null !== $attribute->getDescription()) {
            $lines[] = $attribute->getDescription();
            $lines[] = '';
        }

        $lines[] = '@var ' . $attribute->getPhpAnnotationType() . ' $' . $attribute->getLowerFullName();

        return $lines;
    }

    public function getAttributeDocumentationLines(PHPAttribute $attribute)
    {
        return $this->getAttributeDocumentationLinesBasePart($attribute);
    }

    public function getAttributeLines(PHPAttribute $attribute)
    {
        if ('' !== $attribute->getEntity()->getProject()->getORM()) {
            if ('string' === $attribute->getType() && null === $attribute->getSize()) {
                throw new \RuntimeException('The attribute ' . $attribute->getFullName() . ' on the entity ' . $attribute->getEntity()->getName() . ' is a string but doesn\'t have size.');
            }
        }

        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getAttributeDocumentationLines($attribute)));

        if ($attribute->getEntity()->getProject()->getBase()) {
            if (!$attribute->getStatic()) {
                $line = 'protected $' . $attribute->getLowerFullName();
            } else {
                $line = 'protected static $' . $attribute->getLowerFullName();
            }

            if (null === $attribute->getDefaultValue()) {
                $line .= ';';
            } else {
                $defaultAttributeInit = $attribute->getDefaultValueAttributeInit();

                if ('' !== $defaultAttributeInit) {
                    $line .= ' = ' . $attribute->getDefaultValueAttributeInit() . ';';
                } else {
                    $line .= ';';
                }
            }

            $lines[] = $line;
        } else {
            if (null === $attribute->getDefaultValue()) {
                $lines[] = 'private $' . $attribute->getLowerFullName() . ';';
            } else {
                switch($attribute->getPhpType()) {
                    case 'string':
                        $lines[] = 'private $' . $attribute->getLowerFullName() . ' = \'' . str_replace('\'','\\\'',$attribute->getDefaultValue()) . '\';';
                        break;
                    default:
                        $lines[] = 'private $' . $attribute->getLowerFullName() . ' = ' . $attribute->getDefaultValue() . ';';
                }
            }
        }

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Setters">
    public function getSetterInnerValidationCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        if (null === $attribute->getPhpParameterType()) {
            if ('boolean' === $attribute->getPhpType()) {
                if (!$attribute->getNull()) {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['boolean']));
                } else {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['boolean', 'null']));
                }
            } elseif ('integer' === $attribute->getPhpType()) {
                if (!$attribute->getNull()) {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['integer']));
                } else {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['integer', 'null']));
                }
            } elseif ('float' === $attribute->getPhpType()) {
                if (!$attribute->getNull()) {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['float']));
                } else {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['float', 'null']));
                }
            } elseif ('string' === $attribute->getPhpType()) {
                if ('string' === $attribute->getType()) {
                    if (!$attribute->getNull()) {
                        $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['string']));

                        if (null !== $attribute->getMinSize()) {
                            $lines[] = '';

                            $lines[] = 'if (strlen($' . $attribute->getLowerFullName() . ') < ' . $attribute->getMinSize() . ') {';
                            $lines[] =     'throw new \InvalidArgumentException(\'On the attribute ' . $attribute->getLowerFullName() . ', the length of the string \' . $' . $attribute->getLowerFullName() . ' . \' is \' . strlen($' . $attribute->getLowerFullName() . ') . \' which is shorter than the minimum allowed (' . $attribute->getMinSize() . ').\');';
                            $lines[] = '}';
                        }
                    } else {
                        $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['string', 'null']));

                        if (null !== $attribute->getMinSize()) {
                            $lines[] = '';

                            $lines[] = 'if (strlen($' . $attribute->getLowerFullName() . ') < ' . $attribute->getMinSize() . ') {';
                            $lines[] =     'throw new \InvalidArgumentException(\'On the attribute ' . $attribute->getLowerFullName() . ', the length of the string \' . $' . $attribute->getLowerFullName() . ' . \' is \' . strlen($' . $attribute->getLowerFullName() . ') . \' which is shorter than the minimum allowed (' . $attribute->getMinSize() . ').\');';
                            $lines[] = '}';
                        }
                    }
                } elseif ('text' === $attribute->getType()) {
                    if (!$attribute->getNull()) {
                        $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['string']));
                    } else {
                        $lines = array_merge($lines, $this->getTypeCheckLines($attribute, ['string', 'null']));
                    }
                }
            } elseif ('OneToOne' === $attribute->getForeign()) {
                if ($attribute->getOwnerSide()) {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, [['object' => $attribute->getForeignEntity()->getName()], 'null']));
                } else {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, [['object' => $attribute->getForeignEntity()->getName()], 'null']));
                }
            }elseif ('ManyToOne' === $attribute->getForeign()) {
                if ($attribute->getOwnerSide()) {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, [['object' => $attribute->getForeignEntity()->getName()], 'null']));
                } else {
                    $lines = array_merge($lines, $this->getTypeCheckLines($attribute, [['object' => 'Collection'], 'null']));
                }
            }
        }

        return $lines;
    }

    public function getSetterCodeDocumentationParameterLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = '@param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerFullName();

        return $lines;
    }

    public function getSetterCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Set ' . $attribute->getLowerFullName();
        $lines[] = '';

        $lines = array_merge($lines, $this->getSetterCodeDocumentationParameterLines($attribute));

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '@return $this';
        }

        if (0 !== count($this->getSetterInnerValidationCodeLines($attribute))) {
            $lines[] = '';
            $lines[] = '@throws \InvalidArgumentException';
        }

        return $lines;
    }

    public function getSetterParameters(PHPAttribute $attribute)
    {
        $parameters = [];

        // It always has to allow for nulls because of when the foreign entity is being set and this doesn't have a match anymore
        $parameters[] = null === $attribute->getPhpParameterType()
            ? '$' . $attribute->getLowerFullName()
            : $attribute->getPhpParameterType() . ' $' . $attribute->getLowerFullName();

        return $parameters;
    }

    public function getSetterDeclarationLine(PHPAttribute $attribute)
    {
        return 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function ' . $attribute->getSetterName() . '(' . implode(', ', $this->getSetterParameters($attribute)) . ')';
    }

    public function getSetterCodeLinesBodyPart(PHPAttribute $attribute)
    {
        $lines = [];

        if ('integer' === $attribute->getPhpType()) {
            $lines[] = $attribute->getThisName() . ' = intval($' . $attribute->getLowerFullName() . ');';
        } elseif ('float' === $attribute->getPhpType()) {
            $lines[] = $attribute->getThisName() . ' = floatval($' . $attribute->getLowerFullName() . ');';
        } else {
            $lines[] = $attribute->getThisName() . ' = $' . $attribute->getLowerFullName() . ';';
        }

        return $lines;
    }

    public function getSetterCodeLines(PHPAttribute $attribute)
    {
        $validationLines = $this->getSetterInnerValidationCodeLines($attribute);

        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getSetterCodeDocumentationLines($attribute)));

        $lines[] = $this->getSetterDeclarationLine($attribute);

        $lines[] = '{';

        $lines = array_merge($lines, $validationLines);

        if (0 !== count($validationLines)) {
            $lines[] = '';
        }

        $lines = array_merge($lines, $this->getSetterCodeLinesBodyPart($attribute));

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = 'return $this;';
        }

        $lines[] = '}';

        return $lines;
    }

    public function getClearCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Clear ' . $attribute->getLowerFullName();

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '@return $this';
        }

        return $lines;
    }

    public function getClearCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getClearCodeDocumentationLines($attribute)));

        if ($attribute->getStatic()) {
            $lines[] = 'public static function ' . $attribute->getClearName() . '()';
        } else {
            $lines[] = 'public function ' . $attribute->getClearName() . '()';
        }

        $lines[] = '{';
        $lines[] =     $attribute->getThisName() . ' = null;';

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = 'return $this;';
        }

        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Getters">
    public function getGetterCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Get ' . $attribute->getLowerFullName();
        $lines[] = '';
        $lines[] = '@return ' . $attribute->getPhpAnnotationTypeBase();

        return $lines;
    }

    public function getGetterCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getGetterCodeDocumentationLines($attribute)));

        $lines[] = $attribute->getStatic()
            ? 'public static function ' . $attribute->getGetterName() . '()'
            : 'public function ' . $attribute->getGetterName() . '()';

        $lines[] = '{';
        $lines[] = 'return ' . $attribute->getThisName() . ';';
        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Adders">
    public function getSingleAdderCodeDocumentationParameterLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = '@param ' . $attribute->getPhpSingleTypeBase() . ' $' . $attribute->getSingleName();
        $lines[] = '@param bool $_allowRepeatedValues';

        return $lines;
    }

    public function getSingleAdderCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Add ' . $attribute->getSingleName();
        $lines[] = '';

        $lines = array_merge($lines, $this->getSingleAdderCodeDocumentationParameterLines($attribute));

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '@return $this';
        }

        return $lines;
    }

    public function getSingleAdderParameters(PHPAttribute $attribute)
    {
        $parameters = [];

        $parameters[] = ( '' !== $attribute->getPhpSingleParameterType() ? $attribute->getPhpSingleParameterType() . ' ' : '' ) . '$' . $attribute->getSingleName();
        $parameters[] = '$_allowRepeatedValues = false';

        return $parameters;
    }

    public function getSingleAdderDeclarationLine(PHPAttribute $attribute)
    {
        return 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function ' . $attribute->getSingleAdderName() . '(' . implode(', ', $this->getSingleAdderParameters($attribute)) . ')';
    }

    public function getSingleAdderCodeLinesPostAssignmentPart(PHPAttribute $attribute)
    {
        return [];
    }

    public function getSingleAdderCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getSingleAdderCodeDocumentationLines($attribute)));

        $lines[] = $this->getSingleAdderDeclarationLine($attribute);
        $lines[] = '{';

        $lines[] = 'if ($_allowRepeatedValues || !' . $attribute->getThisName() . '->contains($' . $attribute->getSingleName() . ')) {';
        $lines[] =     $attribute->getThisName() . '[] = $' . $attribute->getSingleName() . ';';

        $lines = array_merge($lines, $this->getSingleAdderCodeLinesPostAssignmentPart($attribute));

        $lines[] = '}';

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = 'return $this;';
        }

        $lines[] = '}';

        return $lines;
    }

    public function getMultipleAdderCodeDocumentationParameterLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = '@param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerFullName();
        $lines[] = '@param bool $_allowRepeatedValues';

        return $lines;
    }

    public function getMultipleAdderCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Add ' . $attribute->getLowerFullName();
        $lines[] = '';

        $lines = array_merge($lines, $this->getMultipleAdderCodeDocumentationParameterLines($attribute));

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '@return $this';
        }

        return $lines;
    }

    public function getMultipleAdderParameters(PHPAttribute $attribute)
    {
        $parameters = [];

        $parameters[] = $attribute->getPhpParameterTypeBase() . ' ' . '$' . $attribute->getLowerFullName();
        $parameters[] = '$_allowRepeatedValues = false';

        return $parameters;
    }

    public function getMultipleAdderDeclarationLine(PHPAttribute $attribute)
    {
        return 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function ' . $attribute->getMultipleAdderName() . '(' . implode(', ', $this->getMultipleAdderParameters($attribute)) . ')';
    }

    public function getMultipleAdderCodeLinesAssignmentPart(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = $attribute->getThisSingleAdderName() . '($' . $attribute->getSingleName() . ', $_allowRepeatedValues);';

        return $lines;
    }

    public function getMultipleAdderCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getMultipleAdderCodeDocumentationLines($attribute)));

        $lines[] = $this->getMultipleAdderDeclarationLine($attribute);
        $lines[] = '{';

        $lines[] = 'foreach ($' . $attribute->getLowerFullName() . ' as $' . $attribute->getSingleName() . ') {';

        $lines = array_merge($lines, $this->getMultipleAdderCodeLinesAssignmentPart($attribute));

        $lines[] = '}';

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = 'return $this;';
        }

        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Contains">
    public function getSingleContainsCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Contains ' . $attribute->getSingleName();
        $lines[] = '';
        $lines[] = '@param ' . $attribute->getPhpSingleTypeBase() /*. ($attribute->getEntity()->getProject()->getBase() ? 'Base' : '')*/ . ' $' . $attribute->getSingleName();
        $lines[] = '';
        $lines[] = '@return bool';

        return $lines;
    }

    public function getSingleContainsCodeLinesBodyPart(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'return in_array($' . $attribute->getSingleName() . ', ' . $attribute->getThisName() . ');';

        return $lines;
    }

    public function getSingleContainsCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getSingleContainsCodeDocumentationLines($attribute)));

        $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function ' . $attribute->getSingleContainsName() . '(' . ( '' !== $attribute->getPhpSingleParameterType() ? $attribute->getPhpSingleParameterType() . ' ' : '' ) . '$' . $attribute->getSingleName() . ')';
        $lines[] = '{';

        $lines = array_merge($lines, $this->getSingleContainsCodeLinesBodyPart($attribute));

        $lines[] = '}';

        return $lines;
    }

    public function getMultipleContainsCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Contains ' . $attribute->getLowerFullName();
        $lines[] = '';
        $lines[] = '@param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerFullName();
        $lines[] = '';
        $lines[] = '@return bool';

        return $lines;
    }

    public function getMultipleContainsCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getMultipleContainsCodeDocumentationLines($attribute)));

        $lines[] = 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function ' . $attribute->getMultipleContainsName() . '(' . (null !== $attribute->getPhpParameterTypeBase() ? $attribute->getPhpParameterTypeBase() . ' ' : '') . '$' . $attribute->getLowerFullName() . ')';
        $lines[] = '{';
        $lines[] =     'foreach ($' . $attribute->getLowerFullName() . ' as $' . $attribute->getSingleName() . ') {';
        $lines[] =         'if (!' . $attribute->getThisSingleContainsName() . '($' . $attribute->getSingleName() . ')) {';
        $lines[] =             'return false;';
        $lines[] =         '}';
        $lines[] =     '}';
        $lines[] = '';
        $lines[] = 'return true;';

        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Removers">
    public function getSingleRemoverCodeDocumentationParameterLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = '@param ' . $attribute->getPhpSingleTypeBase() /*. ($attribute->getEntity()->getProject()->getBase() ? 'Base' : '')*/ . ' $' . $attribute->getSingleName();

        return $lines;
    }

    public function getSingleRemoverCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Remove ' . $attribute->getSingleName();
        $lines[] = '';

        $lines = array_merge($lines, $this->getSingleRemoverCodeDocumentationParameterLines($attribute));

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '@return $this';
        }

        return $lines;
    }

    public function getSingleRemoverParameters(PHPAttribute $attribute)
    {
        $parameters = [];

        $parameters[] = ( '' !== $attribute->getPhpSingleParameterType() ? $attribute->getPhpSingleParameterType() . ' ' : '' ) . '$' . $attribute->getSingleName();

        return $parameters;
    }

    public function getSingleRemoverDeclarationLine(PHPAttribute $attribute)
    {
        return 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function ' . $attribute->getSingleRemoverName() . '(' . implode(', ', $this->getSingleRemoverParameters($attribute)) . ')';
    }

    public function getSingleRemoverCodeLinesBodyPart(PHPAttribute $attribute)
    {
        // Credit goes to http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key

        $lines = [];

        $lines[] = $attribute->getThisName() . ' = array_diff(' . $attribute->getThisName() . ', [$' . $attribute->getSingleName() . ']);';

        return $lines;
    }

    public function getSingleRemoverCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getSingleRemoverCodeDocumentationLines($attribute)));

        $lines[] = $this->getSingleRemoverDeclarationLine($attribute);
        $lines[] = '{';

        $lines = array_merge($lines, $this->getSingleRemoverCodeLinesBodyPart($attribute));

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = 'return $this;';
        }

        $lines[] = '}';

        return $lines;
    }

    public function getMultipleRemoverCodeDocumentationParameterLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = '@param ' . $attribute->getPhpAnnotationTypeBase() . ' $' . $attribute->getLowerFullName();

        return $lines;
    }

    public function getMultipleRemoverCodeDocumentationLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = 'Remove ' . $attribute->getLowerFullName();
        $lines[] = '';

        $lines = array_merge($lines, $this->getMultipleRemoverCodeDocumentationParameterLines($attribute));

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = '@return $this';
        }

        return $lines;
    }

    public function getMultipleRemoverParameters(PHPAttribute $attribute)
    {
        $parameters = [];

        $parameters[] = $attribute->getPhpParameterTypeBase() . ' ' . '$' . $attribute->getLowerFullName();

        return $parameters;
    }

    public function getMultipleRemoverDeclarationLine(PHPAttribute $attribute)
    {
        return 'public ' . ($attribute->getStatic() ? 'static ' : '') . 'function ' . $attribute->getMultipleRemoverName() . '(' . implode(', ', $this->getMultipleRemoverParameters($attribute)) . ')';
    }

    public function getMultipleRemoverCodeLinesBodyCallPart(PHPAttribute $attribute)
    {
        $lines = [];

        $lines[] = $attribute->getThisSingleRemoverName() . '($' . $attribute->getSingleName() . ');';

        return $lines;
    }

    public function getMultipleRemoverCodeLines(PHPAttribute $attribute)
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getMultipleRemoverCodeDocumentationLines($attribute)));

        $lines[] = $this->getMultipleRemoverDeclarationLine($attribute);
        $lines[] = '{';

        $lines[] = 'foreach ($' . $attribute->getLowerFullName() . ' as $' . $attribute->getSingleName() . ') {';

        $lines = array_merge($lines, $this->getMultipleRemoverCodeLinesBodyCallPart($attribute));

        $lines[] = '}';

        if (!$attribute->getStatic()) {
            $lines[] = '';
            $lines[] = 'return $this;';
        }

        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    public function getSetterGetterLines(PHPAttribute $attribute)
    {
        $lines = [];

        if ($attribute->getSetter()) {
            $lines = array_merge($lines, $this->getSetterCodeLines($attribute));
        }

        if ('Collection' === $attribute->getPhpParameterType() || 'array' === $attribute->getType()) {
            if (0 !== count($lines)) {
                $lines[] = '';
            }

            $lines = array_merge($lines, $this->getSingleAdderCodeLines($attribute));

            $lines[] = '';

            $lines = array_merge($lines, $this->getMultipleAdderCodeLines($attribute));

            $lines[] = '';

            $lines = array_merge($lines, $this->getSingleContainsCodeLines($attribute));

            $lines[] = '';

            $lines = array_merge($lines, $this->getMultipleContainsCodeLines($attribute));

            $lines[] = '';

            $lines = array_merge($lines, $this->getSingleRemoverCodeLines($attribute));

            $lines[] = '';

            $lines = array_merge($lines, $this->getMultipleRemoverCodeLines($attribute));
        }

        if ($attribute->getGetter()) {
            if (0 !== count($lines)) {
                $lines[] = '';
            }

            $lines = array_merge($lines, $this->getGetterCodeLines($attribute));
        }

        return $lines;
    }

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
        $lines[] = '@return string';

        return $lines;
    }

    public function getEntityToStringLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getEntityToStringDocumentationLines()));

        $lines[] = 'public function __toString()';
        $lines[] = '{';

        if (null === $this->getEntity()->getToString()) {
            $lines[] = '' !== $this->getEntity()->getProject()->getORM()
                ? 'return \'' . $this->getEntity()->getName() . '(\' . $this->' . $this->getEntity()->getPrimaryAttribute()->getFullName() . ' . \')\';'
                : 'return \'' . $this->getEntity()->getName() . '\';';
        } else {
            $lines[] = 'return strval($this->' . $this->getEntity()->getAttributeByName($this->getEntity()->getToString())->getFullName() . ');';
        }

        $lines[] = '}';

        return $lines;
    }
    // </editor-fold>

    // <editor-fold desc="Array access">
    public function getArrayAccessOffsetSetCodeDocumentationLines()
    {
        $lines = [];

        $lines[] = 'OffsetSet implementation of the \\ArrayAccess interface';
        $lines[] = '';
        $lines[] = '@param string $offset';
        $lines[] = '@param mixed  $value';
        $lines[] = '';
        $lines[] = '@throws \\InvalidArgumentException if the offset doesn\'t exist on this entity or doesn\'t allow to be set';

        return $lines;
    }

    public function getArrayAccessOffsetSetCodeLines()
    {
        $noOffsetMessage = 'Tried to access the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but that offset doesn\\\'t exist.';
        $noSetterMessage = 'Tried to set the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but is set to not allow setter access.';

        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getArrayAccessOffsetSetCodeDocumentationLines()));

        $lines[] = 'public function offsetSet($offset, $value)';
        $lines[] = '{';
        $lines[] = 'if (!$this->offsetExists($offset)) {' ;
        $lines[] =     'throw new \\InvalidArgumentException(\'' . $noOffsetMessage . '\');';
        $lines[] = '}';
        $lines[] = '';
        $lines[] = 'switch ($offset) {';

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ($attr->getSetter()) {
                $lines[] = 'case \'' . $attr->getFullName() . '\':';
                $lines[] =     '$this->' . $attr->getSetterName() . '($value);';
                $lines[] =     'break;';
            }
        }

        $lines[] = 'default:';
        $lines[] =     'throw new \\InvalidArgumentException(\'' . $noSetterMessage . '\');';
        $lines[] = '}';

        $lines[] = '}';

        return $lines;
    }

    public function getArrayAccessOffsetExitsCodeDocumentationLines()
    {
        $lines = [];

        $lines[] = 'OffsetExists implementation of the \\ArrayAccess interface';
        $lines[] = '';
        $lines[] = '@param string $offset';
        $lines[] = '';
        $lines[] = '@return bool';

        return $lines;
    }

    public function getArrayAccessOffsetExitsCodeLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getArrayAccessOffsetExitsCodeDocumentationLines()));

        $lines[] = 'public function offsetExists($offset)';
        $lines[] = '{';

        $attributes = [];
        foreach ($this->getEntity()->getAttributes() as $attr) {
            $attributes[] = '\'' . $attr->getFullName() . '\'';
        }

        $lines[] =     'return in_array($offset, [' . implode(', ', $attributes) . ']);';

        $lines[] = '}';

        return $lines;
    }

    public function getArrayAccessOffsetUnsetCodeDocumentationLines()
    {
        $lines = [];

        $lines[] = 'OffsetUnset implementation of the \\ArrayAccess interface';
        $lines[] = '';
        $lines[] = '@param string $offset';
        $lines[] = '';
        $lines[] = '@throws \\InvalidArgumentException if the offset doesn\'t exist on this entity or doesn\'t allow to be set';

        return $lines;
    }

    public function getArrayAccessOffsetUnsetCodeLines()
    {
        $noOffsetMessage = 'Tried to access the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but that offset doesn\\\'t exist.';
        $noSetterMessage = 'Tried to unset the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but is set to not allow setter access.';

        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getArrayAccessOffsetUnsetCodeDocumentationLines()));

        $lines[] = 'public function offsetUnset($offset)';
        $lines[] = '{';

        $lines[] = 'if (!$this->offsetExists($offset)) {' ;
        $lines[] =     'throw new \\InvalidArgumentException(\'' . $noOffsetMessage . '\');';
        $lines[] = '}';
        $lines[] = '';

        $lines[] = 'switch ($offset) {';

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ($attr->getSetter()) {
                $lines[] = 'case \'' . $attr->getFullName() . '\':';

                if ('' != $attr->getDefaultValueAttributeInit()) {
                    $lines[] = '$this->' . $attr->getSetterName() . '(' . $attr->getDefaultValueAttributeInit() . ');';
                } elseif ('' != $attr->getDefaultValueConstructorInit()) {
                    $lines[] = '$this->' . $attr->getSetterName() . '(' . $attr->getDefaultValueConstructorInit() . ');';
                } else {
                    $lines[] = '$this->' . $attr->getFullName() . ' = null;';
                }

                $lines[] = 'break;';
            }
        }

        $lines[] = 'default:';
        $lines[] =     'throw new \\InvalidArgumentException(\'' . $noSetterMessage . '\');';
        $lines[] = '}';

        $lines[] = '}';

        return $lines;
    }

    public function getArrayAccessOffsetGetCodeDocumentationLines()
    {
        $lines = [];

        $lines[] = 'OffsetGet implementation of the \\ArrayAccess interface';
        $lines[] = '';
        $lines[] = '@param string $offset';
        $lines[] = '';
        $lines[] = '@return mixed'; // TODO: Improve this
        $lines[] = '';
        $lines[] = '@throws \\InvalidArgumentException if the offset doesn\'t exist on this entity or doesn\'t allow to be retrieved';

        return $lines;
    }

    public function getArrayAccessOffsetGetCodeLines()
    {
        $noOffsetMessage = 'Tried to access the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but that offset doesn\\\'t exist.';
        $noGetterMessage = 'Tried to get the offset \' . $offset . \' of the entity \\\'' . $this->getEntity()->getName() . '\\\' as using the \\\\ArrayAccess interface but is set to not allow getter access.';

        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getArrayAccessOffsetGetCodeDocumentationLines()));

        $lines[] = 'public function offsetGet($offset)';
        $lines[] = '{';

        $lines[] = 'if (!$this->offsetExists($offset)) {' ;
        $lines[] =     'throw new \\InvalidArgumentException(\'' . $noOffsetMessage . '\');';
        $lines[] = '}';
        $lines[] = '';

        $lines[] = 'switch ($offset) {';

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ($attr->getSetter()) {
                $lines[] = 'case \'' . $attr->getFullName() . '\':';
                $lines[] =     'return $this->' . $attr->getGetterName() . '();';
            }
        }

        $lines[] = 'default:';
        $lines[] =     'throw new \\InvalidArgumentException(\'' . $noGetterMessage . '\');';
        $lines[] = '}';

        $lines[] = '}';

        return $lines;
    }

    public function getArrayAccessCodeLines()
    {
        $lines = [];

        $lines[] = '// <editor-fold desc="ArrayAccess">';

        $lines = array_merge($lines, $this->getArrayAccessOffsetSetCodeLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getArrayAccessOffsetExitsCodeLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getArrayAccessOffsetUnsetCodeLines());

        $lines[] = '';

        $lines = array_merge($lines, $this->getArrayAccessOffsetGetCodeLines());

        $lines[] = '// </editor-fold>';

        return $lines;
    }
    // </editor-fold>

    public function getNamespaceLine()
    {
        return 'namespace ' . $this->getFullNamespace() . ';';
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

    public function getUseLines()
    {
        $lines = [];

        if ( $this->getEntity()->getProject()->getBase() && $this->getEntity()->hasSetters() ) {
            $lines[] = $this->getEntityUseLine($this->getEntity());
        }

        if (null !== $this->getEntity()->getParentEntity()) {
            $lines[] = 'use ' . $this->getEntity()->getParentEntity()->getFullyQualifiedName() . ';';
        }

        foreach ($this->getRequiredEntities() as $requiredEntity) {
            if (substr($requiredEntity, 0, strlen($this->getEntity()->getNamespace())) !== $this->getEntity()->getNamespace()) {
                $lines[] = 'use ' . $requiredEntity . ';';
            }
        }

        if ($this->getEntity()->getProject()->getBase()) {
            foreach ($this->getEntity()->getAttributes() as $attr) {
                if (null !== $attr->getForeignEntity()) {
                    $lines[] = 'use ' . $attr->getForeignEntity()->getFullyQualifiedName() . ';';
                }

                if ($attr->isEntitySubtype()) {
                    $lines[] = $this->getEntityUseLine($this->getEntity()->getProject()->getEntityByFullyQualifiedName($attr->getSubtype()));
                }
            }
        }

        return array_unique($lines, SORT_STRING);
    }

    public function getEntityDocumentationLines()
    {
        $lines = [];

        $lines[] = !$this->getEntity()->getProject()->getBase()
            ? $this->getEntity()->getNamespace() . '\\Entity\\' . $this->getEntity()->getName()
            : $this->getEntity()->getNamespace() . '\\Entity\\Base\\' . $this->getEntity()->getName();

        return $lines;
    }

    public function getEntityDeclarationLine()
    {
        $line = '';

        if (!$this->getEntity()->getProject()->getBase()) {
            $line .= 'class ' . $this->getEntity()->getName();
        } else {
            $line .= 'abstract class ' . $this->getEntity()->getNameBase();
        }

        if (null !== $this->getEntity()->getParentEntity()) {
            $line .= ' extends ' . $this->getEntity()->getParentEntity()->getName();
        }

        return $line;
    }

    public function getImplementLines()
    {
        $lines = [];

        $implements = [];

        if ($this->getEntity()->getArrayAccess()) {
            $implements[] = '\\ArrayAccess';
        }

        if (count($implements) > 0) {
            $lines[] = 'implements ' . implode(', ', $implements);
        }

        return $lines;
    }

    /**
     * @return PHPAttribute[]
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

        $lines[] = '// <editor-fold desc="Attributes">';

        if (0 !== count($renderAttributes)) {
            foreach ($renderAttributes as $attr) {
                $lines = array_merge($lines, $this->getAttributeLines($attr));
                $lines[] = '';
            }
        }

        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getConstructorLines()
    {
        $lines = [];

        if (!$this->getEntity()->getHasConstructor() && $this->getEntity()->shouldHaveConstructor()) {
            $lines[] = '';
            $lines[] = '// <editor-fold desc="Constructor">';
            $lines[] = 'public function __construct()';
            $lines[] = '{';

            foreach ($this->getEntity()->getAttributes() as $attr) {
                $attributeDefaultValueConstructor = $attr->getDefaultValueConstructorInit();

                if ('' !== $attributeDefaultValueConstructor) {
                    $lines[] = '$this->' . $attr->getLowerFullName() . ' = ' . $attributeDefaultValueConstructor . ';';
                }
            }

            $lines[] = '}';
            $lines[] = '// </editor-fold>';
        }

        return $lines;
    }

    public function getAllSetterGetterLines()
    {
        $lines = [];

        $lines[] = '';
        $lines[] = '// <editor-fold desc="Setters and getters">';

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

        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getOtherMethodLines()
    {
        $lines = [];

        $lines[] = '';
        $lines[] = '// <editor-fold desc="Other methods">';

        $lines = array_merge($lines, $this->getEntityToStringLines());

        $lines[] = '// </editor-fold>';

        return $lines;
    }

    public function getArrayAccessLines()
    {
        $lines = [];

        if ($this->getEntity()->getArrayAccess()) {
            $lines[] = '';

            $lines = array_merge($lines, $this->getArrayAccessCodeLines());
        }

        return $lines;
    }

    public function getFileLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getEntityDocumentationLines()));

        $lines[] = $this->getEntityDeclarationLine();

        $lines = array_merge($lines, $this->getImplementLines());

        $lines[] = '{';

        $lines = array_merge($lines, $this->getAllAttributeLines());
        $lines = array_merge($lines, $this->getConstructorLines());
        $lines = array_merge($lines, $this->getAllSetterGetterLines());
        $lines = array_merge($lines, $this->getOtherMethodLines());
        $lines = array_merge($lines, $this->getArrayAccessLines());

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
