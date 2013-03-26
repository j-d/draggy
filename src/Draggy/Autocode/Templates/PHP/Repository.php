<?php
// Draggy\Autocode\Templates\PHP\Repository.php

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

use Draggy\Autocode\Templates\PHP\Base\RepositoryBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\Repository
 */
class Repository extends RepositoryBase
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
     * @inheritDoc
     */
    public function render()
    {
        $entity = $this->getEntity();

        $file = '';

        $file .= '<?php' . "\n";
        $file .= '// ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . 'Repository.php' . "\n";
        $file .= $this->getBlurb();
        $file .= 'namespace ' . $entity->getNamespace() . '\\Entity;' . "\n";
        $file .= "\n";
        $file .= 'use Doctrine\\ORM\\EntityRepository;' . "\n";
        $file .= 'use Doctrine\\Common\\Persistence\\ObjectManager;' . "\n";
        $file .= 'use Doctrine\\ORM\\EntityManager;' . "\n";
        $file .= 'use Doctrine\\ORM\\Mapping\\ClassMetadata;' . "\n";
        $file .= '// <user-additions' . ' part="use">' . "\n";
        $file .= '// </user-additions' . '>' . "\n";
        $file .= "\n";
        $file .= '/**' . "\n";
        $file .= ' * ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . 'Repository' . "\n";
        $file .= ' */' . "\n";
        $file .= 'class ' . $entity->getName() . 'Repository extends EntityRepository' . "\n";
        $file .= '{' . "\n";
        $file .= '    /**' . "\n";
        $file .= '     * @param EntityManager|ObjectManager $em The EntityManager to use.' . "\n"; //ObjectManager|
        $file .= '     */' . "\n";
        $file .= '    function __construct($em)' . "\n";
        $file .= '    {' . "\n";
        $file .= '        /** @var ClassMetadata $metadata */' . "\n";
        $file .= '        $metadata = $em->getClassMetadata(\'' . $entity->getModule() . ':' . $entity->getName() . '\');' . "\n";
        $file .= "\n";
        $file .= '        parent::__construct($em,$metadata);' . "\n";
        $file .= '    }' . "\n";
        $file .= "\n";
        $file .= '    // <user-additions' . ' part="methods">' . "\n";
        $file .= '    // </user-additions' . '>' . "\n";
        $file .= '}';

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}