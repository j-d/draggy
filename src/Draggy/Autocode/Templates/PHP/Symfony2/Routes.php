<?php
// Draggy\Autocode\Templates\PHP\Symfony2\Routes.php

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

use Draggy\Autocode\Templates\PHP\Symfony2\Base\RoutesBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Symfony2\Entity\Routes
 */
class Routes extends RoutesBase
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
        return 'routes';
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {
        return 'Resources/config/';
    }

    public function getName()
    {
        return 'auto_' . $this->getEntity()->getLowerName();
    }

    /**
     * {@inheritDoc}
     */
    public function getFilename()
    {
        return $this->getName() . '.yml';
    }

    public function getCrudReadPart()
    {
        $entity = $this->getEntity();

        $file = '';

        $file .= '# <user-additions' . ' part="list">' . "\n";
        $file .= $entity->getListRoute() . ':' . "\n";
        $file .= '    pattern:  /' . strtolower($entity->getName()) . "\n";
        $file .= '    defaults: { _controller: ' . $entity->getModule() . ':' . $entity->getName() . ':list }' . "\n";
        $file .= '# </user-additions' . '>' . "\n";

        return $file;
    }

    public function getCrudCreatePart()
    {
        $entity = $this->getEntity();

        $file = '';

        $file .= '# <user-additions' . ' part="create">' . "\n";
        $file .= $entity->getAddRoute() . ':' . "\n";
        $file .= '    pattern:  /' . strtolower($entity->getName()) . '/add' . "\n";
        $file .= '    defaults: { _controller: ' . $entity->getModule() . ':' . $entity->getName() . ':add }' . "\n";
        $file .= '# </user-additions' . '>' . "\n";

        return $file;
    }

    public function getCrudUpdatePart()
    {
        $entity = $this->getEntity();

        $file = '';

        $id = $entity->getPrimaryAttribute();

        $file .= '# <user-additions' . ' part="edit">' . "\n";
        $file .= $entity->getEditRoute() . ':' . "\n";

        if (null === $id->getForeign()) {
            $file .= '    pattern:  /' . strtolower($entity->getName()) . '/edit/{' . $id->getName() . '}' . "\n";
        } else {
            $file .= '    pattern:  /' . strtolower($entity->getName()) . '/edit/{' . $id->getForeignEntity()->getPrimaryAttribute()->getName() . '}' . "\n";
        }

        $file .= '    defaults: { _controller: ' . $entity->getModule() . ':' . $entity->getName() . ':edit }' . "\n";
        $file .= '# </user-additions' . '>' . "\n";

        return $file;
    }

    public function getCrudDeletePart()
    {
        $entity = $this->getEntity();

        $file = '';

        $id = $entity->getPrimaryAttribute();

        $file .= '# <user-additions' . ' part="delete">' . "\n";
        $file .=  $entity->getDeleteRoute() . ':' . "\n";

        if (null === $id->getForeign()) {
            $file .= '    pattern:  /' . strtolower($entity->getName()) . '/delete/{' . $id->getName() . '}' . "\n";
        } else {
            $file .= '    pattern:  /' . strtolower($entity->getName()) . '/delete/{' . $id->getForeignEntity()->getPrimaryAttribute()->getName() . '}' . "\n";
        }

        $file .= '    defaults: { _controller: ' . $entity->getModule() . ':' . $entity->getName() . ':delete }' . "\n";
        $file .= '# </user-additions' . '>' . "\n";

        return $file;
    }

    public function getCrudEnablePart()
    {
        $entity = $this->getEntity();

        $file = '';

        $id = $entity->getPrimaryAttribute();

        $file .= '# <user-additions' . ' part="enable">' . "\n";
        $file .=  $entity->getEnableRoute() . ':' . "\n";
        $file .= '    pattern:  /' . strtolower($entity->getName()) . '/enable/{' . $id->getName() . '}' . "\n";
        $file .= '    defaults: { _controller: ' . $entity->getModule() . ':' . $entity->getName() . ':enable }' . "\n";
        $file .= '# </user-additions' . '>' . "\n";

        return $file;
    }

    public function getCrudDisablePart()
    {
        $entity = $this->getEntity();

        $file = '';

        $id = $entity->getPrimaryAttribute();

        $file .= '# <user-additions' . ' part="disable">' . "\n";
        $file .=  $entity->getDisableRoute() . ':' . "\n";
        $file .= '    pattern:  /' . strtolower($entity->getName()) . '/disable/{' . $id->getName() . '}' . "\n";
        $file .= '    defaults: { _controller: ' . $entity->getModule() . ':' . $entity->getName() . ':disable }' . "\n";
        $file .= '# </user-additions' . '>' . "\n";

        return $file;
    }

    public function render()
    {
        $entity = $this->getEntity();

        $file = '';

        $file .= $this->getHashBlurb();

        $file .= '### ' . $entity->getName() . ' ###' . "\n";

        $parts = [];

        if ($entity->getCrudRead()) {
            $parts[] = $this->getCrudReadPart();
        }

        if ($entity->getCrudCreate()) {
            $parts[] = $this->getCrudCreatePart();
        }

        if ($entity->getCrudUpdate()) {
            $parts[] = $this->getCrudUpdatePart();
        }

        if ($entity->getCrudDelete()) {
            $parts[] = $this->getCrudDeletePart();
        }

        $file .= implode("\n", $parts);

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}
