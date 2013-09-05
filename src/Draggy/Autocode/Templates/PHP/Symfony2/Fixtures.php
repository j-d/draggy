<?php
// Draggy\Autocode\Templates\PHP\Symfony2\Fixtures.php

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

use Draggy\Autocode\Templates\PHP\Symfony2\Base\FixturesBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Symfony2\Entity\Fixtures
 */
class Fixtures extends FixturesBase
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
        return 'fixtures';
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        return 'DataFixtures/ORM/';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getEntity()->getName() . 'Fixtures';
    }

    public function getDescriptionCodeLines()
    {
        return [];
    }

    public function getNamespaceLine()
    {
        return 'namespace ' . $this->getEntity()->getNamespace() . '\\DataFixtures\\ORM;';
    }

    public function getUseLines()
    {
        $lines = [];

        $lines[] = 'use Doctrine\\Common\\DataFixtures\\AbstractFixture;';
        $lines[] = 'use Doctrine\\Common\\Persistence\\ObjectManager;';
        $lines[] = 'use Doctrine\\Common\\DataFixtures\\OrderedFixtureInterface;';
        $lines[] = '//use Doctrine\\Common\\Collections\\ArrayCollection;';
        $lines[] = '';
        $lines[] = 'use Symfony\\Component\\DependencyInjection\\ContainerAwareInterface;';
        $lines[] = 'use Symfony\\Component\\DependencyInjection\\ContainerInterface;';
        $lines[] = '';
        $lines[] = 'use ' . $this->getEntity()->getNamespace() . '\\Entity\\' . $this->getEntity()->getName() . ';';

        $attributeLines = [];

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if (null !== $attr->getForeignEntity()) {
                $attributeLines[] = '// use ' . $attr->getForeignEntity()->getNamespace() . '\\Entity\\' . $attr->getForeignEntity()->getName() . ';';
            }
        }

        $lines = array_merge($lines, array_unique($attributeLines));

        $lines = array_merge($lines, $this->getUseLinesUserAdditionsPart());

        return $lines;
    }

    public function getFixturesDocumentationLines()
    {
        $lines = [];

        $lines[] = $this->getEntity()->getNamespace() . '\\DataFixtures\\ORM\\' . $this->getEntity()->getName() . 'Fixtures';

        return $lines;
    }

    public function getFixturesDeclarationLines()
    {
        $lines = [];

        $lines[] =  'class ' . $this->getEntity()->getName() . 'Fixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface';

        return $lines;
    }

    public function getLoadMethodHelpLines()
    {
        $lines = [];

        $lines[] = '$' . $this->getEntity()->getPluralLowerName() . ' = [];';
        $lines[] = '';
        $lines[] = 'foreach ($' . $this->getEntity()->getPluralLowerName() . ' as $' . $this->getEntity()->getLowerName() . ') {';
        $lines[] =     '$' . $this->getEntity()->getLowerName() . 'Entity = (new ' . $this->getEntity()->getName() . '())';

        $linesSetters = [];

        foreach ($this->getEntity()->getAttributes() as $attr) {
            if ($attr->getSetter()) {
                $linesSetters[] = ($attr->getNull() ? '//' : '') . '->' . $attr->getSetterName() . '($' . $this->getEntity()->getLowerName() . '[\'' . $attr->getLowerName() . '\'])';
            }
        }

        // Find the last non-commented line and add a semicolon at the end
        $semicolonAdded = false;

        for ($i = count($linesSetters) - 1; $i >= 0; $i--) {
            if ('//' !== substr($linesSetters[$i], 0, 2)) {
                $linesSetters[$i] .= ';';
                $semicolonAdded = true;
                break;
            }
        }

        // If not found, then add it to the previous line which didn't have it
        if (!$semicolonAdded) {
            $lines[count($lines) - 1] .= ';';
        }

        $lines = array_merge($lines, $linesSetters);

        $lines[] = '';
        $lines[] =     '$manager->persist($' . $this->getEntity()->getLowerName() . 'Entity);';
        $lines[] = '}';
        $lines[] = '';
        $lines[] = '$manager->flush();';

        return $lines;
    }

    public function getFixturesCodeLines()
    {
        $lines = [];

        $lines[] = '/**';
        $lines[] = ' * @var ContainerInterface';
        $lines[] = ' */';
        $lines[] = 'private $container;';
        $lines[] = '';
        $lines[] = 'public function getOrder()';
        $lines[] = '{';
        $lines[] =     $this->getUserAdditions('order');
        $lines[] =     'return 10;';
        $lines[] =     $this->getEndUserAdditions();
        $lines[] = '}';
        $lines[] = '';
        $lines[] = 'public function setContainer(ContainerInterface $container = null)';
        $lines[] = '{';
        $lines[] =     '$this->container = $container;';
        $lines[] = '}';
        $lines[] = '';
        $lines[] = 'public function load(ObjectManager $manager)';
        $lines[] = '{';

        $helpLines = $this->getLoadMethodHelpLines();

        $lines = array_merge($lines, $this->commentAndJustifyLines($helpLines));

        $lines[] = '';
        $lines[] =     $this->getUserAdditions('load');

        $lines = array_merge($lines, $helpLines);

        $lines[] =     $this->getEndUserAdditions();
        $lines[] = '}';

        return $lines;
    }

    public function getFileLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getFixturesDocumentationLines()));
        $lines = array_merge($lines, $this->getFixturesDeclarationLines());

        $lines[] = '{';

        $lines = array_merge($lines, $this->getFixturesCodeLines());

        $lines[] = '}';

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
