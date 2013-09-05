<?php

namespace Draggy\Autocode;

class JavaEntity extends Entity
{
    /**
     * {@inheritdoc}
     */
    public function shouldRender($templateName)
    {
        switch ($templateName) {
            case 'entity':
                return true;
            case 'entity-base':
                return $this->getProject()->getAutocodeProperty('base');
        }

        return false;
    }
}