<?php
// Draggy\Autocode\Templates\EntityTemplate.php

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

namespace Draggy\Autocode\Templates;

// <user-additions part="use">
// </user-additions>

use Draggy\Autocode\Project;

/**
 * Draggy\Autocode\Templates\Entity\EntityTemplate
 */
abstract class ModuleTemplate extends Template
    // <user-additions part="implements">
    // </user-additions>
{
    // <editor-fold desc="Attributes">
    // <user-additions part="attributes">
    protected $module;

    protected $project;
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Setters and Getters">
    // <user-additions part="settersAndGetters">
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }
    // </user-additions>
    // </editor-fold>

    // <editor-fold desc="Other methods">
    // <user-additions part="otherMethods">
//    /**
//     * @return string
//     */
//    public function getPathAndFilename()
//    {
//        return $this->getPath() . $this->getFilename();
//    }
//
//    /**
//     * @return string
//     */
//    public function getFullPathAndFilename()
//    {
//        return $this->getPathAndFilename();
//    }

    /**
     * @return string
     */
    abstract public function render();

    abstract public function getPath();

    abstract public function getFilename();

    // </user-additions>
    // </editor-fold>
}
