<?php
// Draggy\Autocode\Templates\PHP\Fixtures.php

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

use Draggy\Autocode\Templates\PHP\Base\FixturesBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\Fixtures
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
    public function render()
    {
        $entity = $this->getEntity();

        $file = '';

        $file .= '<?php' . "\n";
        $file .= '// ' . $entity->getNamespace() . '\\DataFixtures\\ORM\\' . $entity->getName() . 'Fixtures.php' . "\n";
        $file .= $this->getBlurb();

        $file .= 'namespace ' . $entity->getNamespace() . '\\DataFixtures\\ORM;' . "\n";
        $file .= "\n";
        $file .= 'use Doctrine\\Common\\DataFixtures\\AbstractFixture;' . "\n";
        $file .= 'use Doctrine\\Common\\Persistence\\ObjectManager;' . "\n";
        $file .= 'use Doctrine\\Common\\DataFixtures\\OrderedFixtureInterface;' . "\n";
        $file .= '//use Doctrine\\Common\\Collections\\ArrayCollection;' . "\n";
        $file .= "\n";
        $file .= 'use Symfony\\Component\\DependencyInjection\\ContainerAwareInterface;' . "\n";
        $file .= 'use Symfony\\Component\\DependencyInjection\\ContainerInterface;' . "\n";
        $file .= "\n";
        $file .= 'use ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . ';' . "\n";

        foreach ($entity->getAttributes() as $attr)
            if (!is_null($attr->getForeignEntity()))
                $file .= '// use ' . $attr->getForeignEntity()->getNamespace() . '\\Entity\\' . $attr->getForeignEntity()->getName() . ';' . "\n";

        $file .= "\n";
        $file .= '// <user-additions' . ' part="use">' . "\n";
        $file .= '// </user-additions' . '>' . "\n";
        $file .= "\n";
        $file .= '/**' . "\n";
        $file .= ' * ' . $entity->getNamespace() . '\\DataFixtures\\ORM\\' . $entity->getName() . 'Fixtures' . "\n";
        $file .= ' */' . "\n";
        $file .= 'class ' . $entity->getName() . 'Fixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface' . "\n";
        $file .= '{' . "\n";
        $file .= '    private $container;' . "\n";
        $file .= "\n";
        $file .= '    public function getOrder()' . "\n";
        $file .= '    {' . "\n";
        $file .= '        // <user-additions' . ' part="order">' . "\n";
        $file .= '        return .;' . "\n";
        $file .= '        // </user-additions' . '>' . "\n";
        $file .= '    }' . "\n";
        $file .= "\n";
        $file .= '    public function setContainer(ContainerInterface $container = null)' . "\n";
        $file .= '    {' . "\n";
        $file .= '        $this->container = $container;' . "\n";
        $file .= '    }' . "\n";
        $file .= "\n";
        $file .= '    public function load(ObjectManager $manager)' . "\n";
        $file .= '    {' . "\n";
        $file .= '        /*' . "\n";
        $file .= '        foreach (. as $' . $entity->getLowerName() . ') {' . "\n";
        $file .= '            $' . $entity->getLowerName() . 'Entity = (new ' . $entity->getName() . '())' . "\n";

        foreach ($entity->getAttributes() as $attr)
            if ($attr->getSetter())
                $file .= '                ' . ($attr->getNull() ? '//' : '') . '->set' . $attr->getUpperName() . '($' . $entity->getLowerName() . '[.])' . "\n";

        $file .= "\n";
        $file .= '            $manager->persist($' . $entity->getLowerName() . 'Entity);' . "\n";
        $file .= '        }' . "\n";
        $file .= "\n";
        $file .= '        $manager->flush();' . "\n";
        $file .= '        */' . "\n";
        $file .= "\n";
        $file .= '        // <user-additions' . ' part="load">' . "\n";
        $file .= '        // </user-additions' . '>' . "\n";
        $file .= '    }' . "\n";
        $file .= '}';

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}