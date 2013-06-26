<?php
// Draggy\Autocode\Templates\Base\EntityTemplate.php

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

namespace Draggy\Autocode\Templates\Base;

use Draggy\Autocode\Templates\EntityTemplate;
use Draggy\Autocode\Templates\Template;
use Draggy\Autocode\Entity;

/**
 * Draggy\Autocode\Templates\Entity\Base\EntityTemplate
 */
abstract class EntityTemplateBase extends Template
{
    // <editor-fold desc="Attributes">
    /**
     * @var Entity $entity
     */
    protected $entity;

    // </editor-fold>

    // <editor-fold desc="Setters and getters">
    /**
     * Set entity
     *
     * @param Entity $entity
     *
     * @return $this
     */
    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }
    // </editor-fold>

    // <editor-fold desc="Other methods">
    /**
     * EntityTemplate to string (Default)
     *
     * @return string
     */
    public function __toString()
    {
        return 'EntityTemplate';
    }
    // </editor-fold>
}
