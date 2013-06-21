<?php
// Draggy\Autocode\Templates\PHP\Symfony2\Repository.php

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

use Draggy\Autocode\Templates\PHP\Symfony2\Base\RepositoryBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Symfony2\Entity\Repository
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
    public function getFilenameLine()
    {
        return '// ' . $this->getEntity()->getNamespace() . '\\Entity\\' . $this->getEntity()->getName() . 'Repository.php';
    }

    public function getDescriptionCodeLines()
    {
        return [];
    }
    
    public function getNamespaceLine()
    {
        return 'namespace ' . $this->getEntity()->getNamespace() . '\\Entity;';
    }
    
    public function getUseLines()
    {
        $lines = [];

        $lines[] = 'use Doctrine\\ORM\\EntityRepository;';
        $lines[] = 'use Doctrine\\Common\\Persistence\\ObjectManager;';
        $lines[] = 'use Doctrine\\ORM\\EntityManager;';
        $lines[] = 'use Doctrine\\ORM\\Mapping\\ClassMetadata;';

        $lines = array_merge($lines, $this->getUseLinesUserAdditionsPart());

        return $lines;
    }

    public function getRepositoryDocumentationLines()
    {
        $lines = [];

        $lines[] = $this->getEntity()->getNamespace() . '\\Entity\\' . $this->getEntity()->getName() . 'Repository';

        return $lines;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getFileLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getRepositoryDocumentationLines()));
        $lines[] = 'class ' . $this->getEntity()->getName() . 'Repository extends EntityRepository';
        $lines[] = '{';
        $lines[] =     '/**';
        $lines[] =     ' * @param EntityManager|ObjectManager $em The EntityManager to use.'; //ObjectManager|
        $lines[] =     ' */';
        $lines[] =     'function __construct($em)';
        $lines[] =     '{';
        $lines[] =         '/** @var ClassMetadata $metadata */';
        $lines[] =         '$metadata = $em->getClassMetadata(\'' . $this->getEntity()->getModule() . ':' . $this->getEntity()->getName() . '\');';
        $lines[] = '';
        $lines[] =         'parent::__construct($em, $metadata);';
        $lines[] =     '}';
        $lines[] = '';
        $lines[] =     $this->getUserAdditions('methods');
        $lines[] =     $this->getEndUserAdditions();
        $lines[] = '}';

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
