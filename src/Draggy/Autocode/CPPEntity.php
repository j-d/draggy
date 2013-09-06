<?php

namespace Draggy\Autocode;

class CPPEntity extends Entity
{
    /**
     * {@inheritdoc}
     */
    public function shouldRender($templateName)
    {
        switch ($templateName) {
            case 'entity':
                return true;
            case 'entity-header':
                return true;
            case 'entity-base':
                return $this->getProject()->getAutocodeProperty('base');
            case 'entity-base-header':
                return $this->getProject()->getAutocodeProperty('base');
        }

        return false;
    }
}