<?php
// Draggy\Autocode\Templates\PHP\Controller.php

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

use Draggy\Autocode\Templates\PHP\Base\ControllerBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Entity\Controller
 */
class Controller extends ControllerBase
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
        $file .= '// ' . $entity->getNamespace() . '\\Controller\\' . $entity->getName() . 'Controller.php' . "\n";
        $file .= $this->getBlurb();

        $file .= 'namespace ' . $entity->getNamespace() . '\\Controller;' . "\n";
        $file .= "\n";
        $file .= 'use Common\Symfony\Controller;' . "\n";
        $file .= '// use Symfony\\Component\\HttpFoundation\\Request;' . "\n";
        $file .= '// use Symfony\\Component\\HttpFoundation\\Response;' . "\n";
        $file .= '// use Symfony\\Component\\HttpFoundation\\RedirectResponse;' . "\n";
        $file .= '// use Symfony\\Component\\Security\\Core\\SecurityContext;' . "\n";
        $file .= "\n";
        $file .= '// use Doctrine\\Common\\Collections\\ArrayCollection;' . "\n";
        $file .= "\n";

        if ($entity->getCrudCreate() || $entity->getCrudUpdate()) {
            $file .= '// use use Common\\Html\\FormItemArray;' . "\n";
            $file .= "\n";
        }

        $file .= '// use ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . ';' . "\n";

        if ($entity->getHasRepository())
            $file .= '// use ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . 'Repository;' . "\n";

        if ($entity->getHasForm())
            $file .= '// use ' . $entity->getNamespace() . '\\Form\\' . $entity->getName() . 'Type;' . "\n";

        foreach ($entity->getAttributes() as $attr)
            if (!is_null($attr->getForeignEntity())) {
                $file .= '// use ' . $attr->getForeignEntity()->getNamespace() . '\\Entity\\' . $attr->getForeignEntity()->getName() . ';' . "\n";

                if ($attr->getForeignEntity()->getHasRepository()) {
                    $file .= '// use ' . $attr->getForeignEntity()->getNamespace() . '\\Entity\\' . $attr->getForeignEntity()->getName() . 'Repository;' . "\n";
                }
            }


        $file .= "\n";
        $file .= '// <user-additions' . ' part="use">' . "\n";

        if ($entity->getCrudCreate()) {
            $file .= 'use ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . ';' . "\n";
        }

        if ($entity->getCrudCreate() || $entity->getCrudUpdate()) {
            $file .= 'use Symfony\\Component\\HttpFoundation\\Request;' . "\n";
            $file .= 'use ' . $entity->getNamespace() . '\\Form\\' . $entity->getName() . 'Type;' . "\n";
        }

        if ($entity->getCrudRead()) {
            $file .= 'use ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . 'Repository;' . "\n";
        }

        $file .= '// </user-additions' . '>' . "\n";
        $file .= "\n";
        $file .= '/**' . "\n";
        $file .= ' * ' . $entity->getNamespace() . '\\Controller\\' . $entity->getName() . 'Controller' . "\n";
        $file .= ' */' . "\n";
        $file .= 'class ' . $entity->getName() . 'Controller extends Controller' . "\n";
        $file .= '{' . "\n";
        $file .= '    /*' . "\n";
        $file .= '    public function xxxAction(Request $request)' . "\n";
        $file .= '    {' . "\n";
        $file .= '        $em = $this->getManager();' . "\n";
        $file .= '        $xxx = $em->getRepository(\'' . $entity->getModule() . ':' . $entity->getName() . '\')->findXYZ();' . "\n";

        if ($entity->getHasRepository())
            $file .= '        $' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);' . "\n";

        foreach ($entity->getAttributes() as $attr)
            if (!is_null($attr->getForeignEntity())) {
                $file .= '        $xxx = $em->getRepository(\'' . $attr->getForeignEntity()->getModule() . ':' . $attr->getForeignEntity()->getName() . '\')->findXYZ();' . "\n";

                if ($attr->getForeignEntity()->getHasRepository())
                    $file .= '        $' . $attr->getForeignEntity()->getLowerName() . 'Repository = new ' . $attr->getForeignEntity()->getName() . 'Repository($em);' . "\n";
            }

        $file .= "\n";
        $file .= '        $user = $this->get(\'security.context\')->getToken()->getUser();' . "\n";
        $file .= '        if ($this->get(\'security.context\')->isGranted(\'ROLE_XXX\'))' . "\n";
        $file .= "\n";

        if ($entity->getHasForm()) {
            $file .= '        $' . $entity->getLowerName() . ' = new ' . $entity->getName() . '();' . "\n";
            $file .= '        $' . $entity->getLowerName() . 'Type = new ' . $entity->getName() . 'Type();' . "\n";
            $file .= "\n";
            $file .= '        $form = $this->createForm($' . $entity->getLowerName() . 'Type, $' . $entity->getLowerName() . ');' . "\n";
            $file .= "\n";
            $file .= '        if ($request->isMethod(\'POST\')) {' . "\n";
            $file .= '            $form->bind($request);' . "\n";
            $file .= "\n";
            $file .= '            if ($form->isValid()) {' . "\n";
            $file .= '                $em = $this->getManager();' . "\n";
            $file .= '                $em->persist($' . $entity->getLowerName() . ');' . "\n";
            $file .= '                $em->flush();' . "\n";
            $file .= "\n";
            $file .= '                $this->get(\'session\')->setFlash(\'info\', \'The ' . $entity->getName() . ' has been xxx successfully.\');' . "\n";
            $file .= "\n";
            $file .= '                return $this->redirect($this->generateUrl(\'path_to_target\'));' . "\n";
            $file .= '            }' . "\n";
            $file .= '        }' . "\n";
            $file .= "\n";
        }

        $file .= '        return (new Response())' . "\n";
        $file .= '            ->setStatusCode(403)' . "\n";
        $file .= '            ->setContent(\'Message here\');' . "\n";
        $file .= '        return new RedirectResponse($this->generateUrl(\'path_to_target\'));' . "\n";
        $file .= '        return $this->render(\'' . $entity->getModule() . ':Default:' . $entity->getLowerName() . '.html.twig.php\');' . "\n";
        $file .= '        return $this->render(' . "\n";
        $file .= '            \'' . $entity->getModule() . ':' . $entity->getName() . ':' . strtolower($entity->getName()) . '.html.twig.php\',' . "\n";
        $file .= '            [' . "\n";
        $file .= '                \'\' => $,' . "\n";
        $file .= '                \'form\' => $form->createView(),' . "\n";
        $file .= '            ],' . "\n";
        $file .= '            //$response / null,' . "\n";
        $file .= '            //$renderParameters' . "\n";
        $file .= '        );' . "\n";
        $file .= '    }' . "\n";
        $file .= '    */' . "\n";
        $file .= "\n";
        $file .= '    // <user-additions' . ' part="actions">' . "\n";
        $file .= '    // </user-additions' . '>' . "\n";

        if ($entity->getCrudRead()) {
            $file .= "\n";
            $file .= '    // <user-additions' . ' part="listAction">' . "\n";
            $file .= '    public function listAction()' . "\n";
            $file .= '    {' . "\n";
            $file .= '        $em = $this->getManager();' . "\n";
            $file .= '        $' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);' . "\n";
            $file .= "\n";
            $file .= '        $' . $entity->getLowerName() . 's = $' . $entity->getLowerName() . 'Repository->findAll();' . "\n";
            $file .= "\n";
            $file .= '        return $this->render(' . "\n";
            $file .= '            \'' . $entity->getModule() . ':' . $entity->getName() . ':list' . $entity->getName() . '.html.twig.php\',' . "\n";
            $file .= '            [' . "\n";
            $file .= '                \'' . $entity->getLowerName() . 's\' => $' . $entity->getLowerName() . 's,' . "\n";
            $file .= '            ]' . "\n";
            $file .= '        );' . "\n";
            $file .= '    }' . "\n";
            $file .= '    // </user-additions' . '>' . "\n";
        }

        if ($entity->getCrudCreate()) {
            $file .= "\n";
            $file .= '    // <user-additions' . ' part="addAction">' . "\n";
            $file .= '    public function addAction(Request $request)' . "\n";
            $file .= '    {' . "\n";
            if ($entity->getHasForm()) {
                $file .= '        $' . $entity->getLowerName() . ' = new ' . $entity->getName() . '();' . "\n";
                $file .= '        $' . $entity->getLowerName() . 'Type = new ' . $entity->getName() . 'Type();' . "\n";
                $file .= "\n";
                $file .= '        $form = $this->createForm($' . $entity->getLowerName() . 'Type, $' . $entity->getLowerName() . ');' . "\n";
                $file .= "\n";
                $file .= '        if ($request->isMethod(\'POST\')) {' . "\n";
                $file .= '            $form->bind($request);' . "\n";
                $file .= "\n";
                $file .= '            if ($form->isValid()) {' . "\n";
                $file .= '                $em = $this->getManager();' . "\n";
                $file .= '                $em->persist($' . $entity->getLowerName() . ');' . "\n";
                $file .= '                $em->flush();' . "\n";
                $file .= "\n";
                $file .= '                $this->get(\'session\')->setFlash(\'info\',\'The ' . $entity->getName() . ' has been created successfully.\');' . "\n";
                $file .= "\n";
                $file .= '                return $this->redirect($this->generateUrl(\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '\'));' . "\n";
                $file .= '            }' . "\n";
                $file .= '        }' . "\n";
                $file .= "\n";
            }
            $file .= '        return $this->render(' . "\n";
            $file .= '            \'' . $entity->getModule() . ':' . $entity->getName() . ':add' . $entity->getName() . '.html.twig.php\',' . "\n";
            $file .= '            [' . "\n";
            $file .= '                \'form\' => $form->createView(),' . "\n";
            $file .= '            ],' . "\n";
            $file .= '            null,' . "\n";
            $file .= '            new FormItemArray($' . $entity->getLowerName() . 'Type->getFields())' . "\n";
            $file .= '        );' . "\n";
            $file .= '    }' . "\n";
            $file .= '    // </user-additions' . '>' . "\n";
        }

        if ($entity->getCrudUpdate()) {
            $file .= "\n";
            $file .= '    // <user-additions' . ' part="editAction">' . "\n";
            $file .= '    public function editAction(Request $request, $id)' . "\n";
            $file .= '    {' . "\n";
            if ($entity->getHasForm()) {
                $file .= '        $em = $this->getManager();' . "\n";
                $file .= '        $' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);' . "\n";
                $file .= "\n";
                $file .= '        $' . $entity->getLowerName() . ' = $' . $entity->getLowerName() . 'Repository->findOneBy([\'id\'=>$id]);' . "\n";
                $file .= '        $' . $entity->getLowerName() . 'Type = new ' . $entity->getName() . 'Type();' . "\n";
                $file .= "\n";
                $file .= '        $form = $this->createForm($' . $entity->getLowerName() . 'Type, $' . $entity->getLowerName() . ');' . "\n";
                $file .= "\n";
                $file .= '        if ($request->isMethod(\'POST\')) {' . "\n";
                $file .= '            $form->bind($request);' . "\n";
                $file .= "\n";
                $file .= '            if ($form->isValid()) {' . "\n";
                $file .= '                $em->persist($' . $entity->getLowerName() . ');' . "\n";
                $file .= '                $em->flush();' . "\n";
                $file .= "\n";
                $file .= '                $this->get(\'session\')->setFlash(\'info\',\'The ' . $entity->getName() . ' has been edited successfully.\');' . "\n";
                $file .= "\n";
                $file .= '                return $this->redirect($this->generateUrl(\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '\'));' . "\n";
                $file .= '            }' . "\n";
                $file .= '        }' . "\n";
                $file .= "\n";
            }
            $file .= '        return $this->render(' . "\n";
            $file .= '            \'' . $entity->getModule() . ':' . $entity->getName() . ':edit' . $entity->getName() . '.html.twig.php\',' . "\n";
            $file .= '            [' . "\n";
            $file .= '                \'form\' => $form->createView(),' . "\n";
            $file .= '                \'id\' => $id,' . "\n";
            $file .= '            ],' . "\n";
            $file .= '            null,' . "\n";
            $file .= '            new FormItemArray($' . $entity->getLowerName() . 'Type->getFields())' . "\n";
            $file .= '        );' . "\n";
            $file .= '    }' . "\n";
            $file .= '    // </user-additions' . '>' . "\n";
        }

        if ($entity->getCrudDelete()) {
            $file .= "\n";
            $file .= '    // <user-additions' . ' part="deleteAction">' . "\n";
            $file .= '    public function deleteAction(Request $request, $id)' . "\n";
            $file .= '    {' . "\n";
            $file .= '        $em = $this->getManager();' . "\n";
            $file .= '        $' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);' . "\n";
            $file .= "\n";
            $file .= '        $' . $entity->getLowerName() . ' = $' . $entity->getLowerName() . 'Repository->findOneBy([\'id\'=>$id]);' . "\n";
            $file .= "\n";
            $file .= '        if (!$' . $entity->getLowerName() . ') {' . "\n";
            $file .= '            throw $this->createNotFoundException(\'No ' . $entity->getLowerName() . ' found for id \' . $id);' . "\n";
            $file .= '        }' . "\n";
            $file .= "\n";
            $file .= '        $em->remove($' . $entity->getLowerName() . ');' . "\n";
            $file .= '        $em->flush();' . "\n";
            $file .= "\n";
            $file .= '        $this->get(\'session\')->setFlash(\'info\',\'The ' . $entity->getName() . ' has been deleted successfully.\');' . "\n";
            $file .= "\n";
            $file .= '        return $this->redirect($this->generateUrl(\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '\'));' . "\n";
            $file .= '    }' . "\n";
            $file .= '    // </user-additions' . '>' . "\n";
        }

        $file .= '}';

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}