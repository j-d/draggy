<?php
// Draggy\Autocode\Templates\PHP\Symfony2\Controller.php

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

use Draggy\Autocode\Templates\PHP\Symfony2\Base\ControllerBase;
// <user-additions part="use">
// </user-additions>

/**
 * Draggy\Autocode\Templates\PHP\Symfony2\Entity\Controller
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

        $file .= '<?php' . PHP_EOL;
        $file .= '// ' . $entity->getNamespace() . '\\Controller\\' . $entity->getName() . 'Controller.php' . PHP_EOL;
        $file .= $this->getBlurb();

        $file .= 'namespace ' . $entity->getNamespace() . '\\Controller;' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= 'use Common\Symfony\Controller;' . PHP_EOL;
        $file .= '// use Symfony\\Component\\HttpFoundation\\Request;' . PHP_EOL;
        $file .= '// use Symfony\\Component\\HttpFoundation\\Response;' . PHP_EOL;
        $file .= '// use Symfony\\Component\\HttpFoundation\\RedirectResponse;' . PHP_EOL;
        $file .= '// use Symfony\\Component\\Security\\Core\\SecurityContext;' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '// use Doctrine\\Common\\Collections\\ArrayCollection;' . PHP_EOL;
        $file .= PHP_EOL;

        if ($entity->getCrudCreate() || $entity->getCrudUpdate()) {
            $file .= '// use use Common\\Html\\FormItemArray;' . PHP_EOL;
            $file .= PHP_EOL;
        }

        $file .= '// use ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . ';' . PHP_EOL;

        if ($entity->getHasRepository())
            $file .= '// use ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . 'Repository;' . PHP_EOL;

        if ($entity->getHasForm())
            $file .= '// use ' . $entity->getNamespace() . '\\Form\\' . $entity->getName() . 'Type;' . PHP_EOL;

        foreach ($entity->getAttributes() as $attr)
            if (!is_null($attr->getForeignEntity())) {
                $file .= '// use ' . $attr->getForeignEntity()->getNamespace() . '\\Entity\\' . $attr->getForeignEntity()->getName() . ';' . PHP_EOL;

                if ($attr->getForeignEntity()->getHasRepository()) {
                    $file .= '// use ' . $attr->getForeignEntity()->getNamespace() . '\\Entity\\' . $attr->getForeignEntity()->getName() . 'Repository;' . PHP_EOL;
                }
            }


        $file .= PHP_EOL;
        $file .= '// <user-additions' . ' part="use">' . PHP_EOL;

        if ($entity->getCrudCreate()) {
            $file .= 'use ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . ';' . PHP_EOL;
        }

        if ($entity->getCrudCreate() || $entity->getCrudUpdate()) {
            $file .= 'use Common\\Html\\FormItemArray;' . PHP_EOL;
            $file .= 'use Symfony\\Component\\HttpFoundation\\Request;' . PHP_EOL;
            $file .= 'use ' . $entity->getNamespace() . '\\Form\\' . $entity->getName() . 'Type;' . PHP_EOL;
        }

        if ($entity->getCrudRead()) {
            $file .= 'use ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . 'Repository;' . PHP_EOL;
        }

        $file .= '// </user-additions' . '>' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '/**' . PHP_EOL;
        $file .= ' * ' . $entity->getNamespace() . '\\Controller\\' . $entity->getName() . 'Controller' . PHP_EOL;
        $file .= ' */' . PHP_EOL;
        $file .= 'class ' . $entity->getName() . 'Controller extends Controller' . PHP_EOL;
        $file .= '{' . PHP_EOL;
        $file .= '    //public function xxxAction(Request $request)' . PHP_EOL;
        $file .= '    //{' . PHP_EOL;
        $file .= '    //    $em = $this->getManager();' . PHP_EOL;
        $file .= '    //    $xxx = $em->getRepository(\'' . $entity->getModule() . ':' . $entity->getName() . '\')->findXYZ();' . PHP_EOL;

        if ($entity->getHasRepository())
            $file .= '    //    $' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);' . PHP_EOL;

        foreach ($entity->getAttributes() as $attr)
            if (!is_null($attr->getForeignEntity())) {
                $file .= '    //    $xxx = $em->getRepository(\'' . $attr->getForeignEntity()->getModule() . ':' . $attr->getForeignEntity()->getName() . '\')->findXYZ();' . PHP_EOL;

                if ($attr->getForeignEntity()->getHasRepository())
                    $file .= '    //    $' . $attr->getForeignEntity()->getLowerName() . 'Repository = new ' . $attr->getForeignEntity()->getName() . 'Repository($em);' . PHP_EOL;
            }

        $file .= '    //' . PHP_EOL;
        $file .= '    //    $user = $this->get(\'security.context\')->getToken()->getUser();' . PHP_EOL;
        $file .= '    //    if ($this->get(\'security.context\')->isGranted(\'ROLE_XXX\'))' . PHP_EOL;
        $file .= '    //' . PHP_EOL;

        if ($entity->getHasForm()) {
            $file .= '    //    $' . $entity->getLowerName() . ' = new ' . $entity->getName() . '();' . PHP_EOL;
            $file .= '    //    $' . $entity->getLowerName() . 'Type = new ' . $entity->getName() . 'Type();' . PHP_EOL;
            $file .= '    //' . PHP_EOL;
            $file .= '    //    $form = $this->createForm($' . $entity->getLowerName() . 'Type, $' . $entity->getLowerName() . ');' . PHP_EOL;
            $file .= '    //' . PHP_EOL;
            $file .= '    //    if ($request->isMethod(\'POST\')) {' . PHP_EOL;
            $file .= '    //        $form->bind($request);' . PHP_EOL;
            $file .= '    //' . PHP_EOL;
            $file .= '    //        if ($form->isValid()) {' . PHP_EOL;
            $file .= '    //            $em = $this->getManager();' . PHP_EOL;
            $file .= '    //            $em->persist($' . $entity->getLowerName() . ');' . PHP_EOL;
            $file .= '    //            $em->flush();' . PHP_EOL;
            $file .= '    //' . PHP_EOL;
            $file .= '    //            $this->get(\'session\')->getFlashBag()->add(\'info\', \'The ' . $entity->getName() . ' has been xxx successfully.\');' . PHP_EOL;
            $file .= '    //' . PHP_EOL;
            $file .= '    //            return $this->redirect($this->generateUrl(\'path_to_target\'));' . PHP_EOL;
            $file .= '    //        }' . PHP_EOL;
            $file .= '    //    }' . PHP_EOL;
            $file .= '    //' . PHP_EOL;
        }

        $file .= '    //    return (new Response())' . PHP_EOL;
        $file .= '    //        ->setStatusCode(403)' . PHP_EOL;
        $file .= '    //       ->setContent(\'Message here\');' . PHP_EOL;
        $file .= '    //    return new RedirectResponse($this->generateUrl(\'path_to_target\'));' . PHP_EOL;
        $file .= '    //    return $this->render(\'' . $entity->getModule() . ':Default:' . $entity->getLowerName() . '.html.twig\');' . PHP_EOL;
        $file .= '    //    return $this->render(' . PHP_EOL;
        $file .= '    //        \'' . $entity->getModule() . ':' . $entity->getName() . ':' . strtolower($entity->getName()) . '.html.twig\',' . PHP_EOL;
        $file .= '    //        [' . PHP_EOL;
        $file .= '    //            \'\' => $,' . PHP_EOL;
        $file .= '    //            \'form\' => $form->createView(),' . PHP_EOL;
        $file .= '    //        ],' . PHP_EOL;
        $file .= '    //        //$response / null,' . PHP_EOL;
        $file .= '    //        //$renderParameters' . PHP_EOL;
        $file .= '    //    );' . PHP_EOL;
        $file .= '    //}' . PHP_EOL;
        $file .= PHP_EOL;
        $file .= '    // <user-additions' . ' part="actions">' . PHP_EOL;
        $file .= '    // </user-additions' . '>' . PHP_EOL;

        if ($entity->getCrudRead()) {
            $file .= PHP_EOL;
            $file .= '    // <user-additions' . ' part="listAction">' . PHP_EOL;
            $file .= '    public function listAction()' . PHP_EOL;
            $file .= '    {' . PHP_EOL;
            $file .= '        $em = $this->getManager();' . PHP_EOL;
            $file .= '        $' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);' . PHP_EOL;
            $file .= PHP_EOL;
            $file .= '        $' . $entity->getPluralLowerName() . ' = $' . $entity->getLowerName() . 'Repository->findBy([], [\'' . $entity->getPrimaryAttribute()->getName() . '\' => \'ASC\']);' . PHP_EOL;
            $file .= PHP_EOL;
            $file .= '        return $this->render(' . PHP_EOL;
            $file .= '            \'' . $entity->getModule() . ':' . $entity->getName() . ':list' . $entity->getName() . '.html.twig\',' . PHP_EOL;
            $file .= '            [' . PHP_EOL;
            $file .= '                \'' . $entity->getPluralLowerName() . '\' => $' . $entity->getPluralLowerName() . ',' . PHP_EOL;
            $file .= '            ]' . PHP_EOL;
            $file .= '        );' . PHP_EOL;
            $file .= '    }' . PHP_EOL;
            $file .= '    // </user-additions' . '>' . PHP_EOL;
        }

        if ($entity->getCrudCreate()) {
            $file .= PHP_EOL;
            $file .= '    // <user-additions' . ' part="addAction">' . PHP_EOL;
            $file .= '    public function addAction(Request $request)' . PHP_EOL;
            $file .= '    {' . PHP_EOL;
            if ($entity->getHasForm()) {
                $file .= '        $' . $entity->getLowerName() . ' = new ' . $entity->getName() . '();' . PHP_EOL;
                $file .= '        $' . $entity->getLowerName() . 'Type = new ' . $entity->getName() . 'Type();' . PHP_EOL;
                $file .= PHP_EOL;
                $file .= '        $form = $this->createForm($' . $entity->getLowerName() . 'Type, $' . $entity->getLowerName() . ');' . PHP_EOL;
                $file .= PHP_EOL;
                $file .= '        if ($request->isMethod(\'POST\')) {' . PHP_EOL;
                $file .= '            $form->bind($request);' . PHP_EOL;
                $file .= PHP_EOL;
                $file .= '            if ($form->isValid()) {' . PHP_EOL;
                $file .= '                $em = $this->getManager();' . PHP_EOL;
                $file .= '                $em->persist($' . $entity->getLowerName() . ');' . PHP_EOL;
                $file .= '                $em->flush();' . PHP_EOL;
                $file .= PHP_EOL;
                $file .= '                $this->get(\'session\')->getFlashBag()->add(\'info\', \'The ' . $entity->getName() . ' has been created successfully.\');' . PHP_EOL;
                $file .= PHP_EOL;
                $file .= '                return $this->redirect($this->generateUrl(\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '\'));' . PHP_EOL;
                $file .= '            }' . PHP_EOL;
                $file .= '        }' . PHP_EOL;
                $file .= PHP_EOL;
            }
            $file .= '        return $this->render(' . PHP_EOL;
            $file .= '            \'' . $entity->getModule() . ':' . $entity->getName() . ':add' . $entity->getName() . '.html.twig\',' . PHP_EOL;
            $file .= '            [' . PHP_EOL;
            $file .= '                \'form\' => $form->createView(),' . PHP_EOL;
            $file .= '            ],' . PHP_EOL;
            $file .= '            null,' . PHP_EOL;
            $file .= '            new FormItemArray($' . $entity->getLowerName() . 'Type->getFields())' . PHP_EOL;
            $file .= '        );' . PHP_EOL;
            $file .= '    }' . PHP_EOL;
            $file .= '    // </user-additions' . '>' . PHP_EOL;
        }

        if ($entity->getCrudUpdate()) {
            $file .= PHP_EOL;
            $file .= '    // <user-additions' . ' part="editAction">' . PHP_EOL;
            $file .= '    public function editAction(Request $request, $id)' . PHP_EOL;
            $file .= '    {' . PHP_EOL;
            if ($entity->getHasForm()) {
                $file .= '        $em = $this->getManager();' . PHP_EOL;
                $file .= '        $' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);' . PHP_EOL;
                $file .= PHP_EOL;
                $file .= '        $' . $entity->getLowerName() . ' = $' . $entity->getLowerName() . 'Repository->findOneBy([\'id\' => $id]);' . PHP_EOL;
                $file .= PHP_EOL;
                $file .= '        if(!$' . $entity->getLowerName() . ') {' . PHP_EOL;
                $file .= '            throw $this->createNotFoundException(\'No ' . $entity->getLowerName() . ' found for id \' . $id);' . PHP_EOL;
                $file .= '        }' . PHP_EOL;
                $file .= PHP_EOL;
                $file .= '        $' . $entity->getLowerName() . 'Type = new ' . $entity->getName() . 'Type();' . PHP_EOL;
                $file .= PHP_EOL;
                $file .= '        $form = $this->createForm($' . $entity->getLowerName() . 'Type, $' . $entity->getLowerName() . ');' . PHP_EOL;
                $file .= PHP_EOL;
                $file .= '        if ($request->isMethod(\'POST\')) {' . PHP_EOL;
                $file .= '            $form->bind($request);' . PHP_EOL;
                $file .= PHP_EOL;
                $file .= '            if ($form->isValid()) {' . PHP_EOL;
                $file .= '                $em->persist($' . $entity->getLowerName() . ');' . PHP_EOL;
                $file .= '                $em->flush();' . PHP_EOL;
                $file .= PHP_EOL;
                $file .= '                $this->get(\'session\')->getFlashBag()->add(\'info\', \'The ' . $entity->getName() . ' has been edited successfully.\');' . PHP_EOL;
                $file .= PHP_EOL;
                $file .= '                return $this->redirect($this->generateUrl(\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '\'));' . PHP_EOL;
                $file .= '            }' . PHP_EOL;
                $file .= '        }' . PHP_EOL;
                $file .= PHP_EOL;
            }
            $file .= '        return $this->render(' . PHP_EOL;
            $file .= '            \'' . $entity->getModule() . ':' . $entity->getName() . ':edit' . $entity->getName() . '.html.twig\',' . PHP_EOL;
            $file .= '            [' . PHP_EOL;
            $file .= '                \'form\' => $form->createView(),' . PHP_EOL;
            $file .= '                \'id\' => $id,' . PHP_EOL;
            $file .= '            ],' . PHP_EOL;
            $file .= '            null,' . PHP_EOL;
            $file .= '            new FormItemArray($' . $entity->getLowerName() . 'Type->getFields())' . PHP_EOL;
            $file .= '        );' . PHP_EOL;
            $file .= '    }' . PHP_EOL;
            $file .= '    // </user-additions' . '>' . PHP_EOL;
        }

        if ($entity->getCrudDelete()) {
            $file .= PHP_EOL;
            $file .= '    // <user-additions' . ' part="deleteAction">' . PHP_EOL;
            $file .= '    public function deleteAction(Request $request, $id)' . PHP_EOL;
            $file .= '    {' . PHP_EOL;
            $file .= '        $em = $this->getManager();' . PHP_EOL;
            $file .= '        $' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);' . PHP_EOL;
            $file .= PHP_EOL;
            $file .= '        $' . $entity->getLowerName() . ' = $' . $entity->getLowerName() . 'Repository->findOneBy([\'id\' => $id]);' . PHP_EOL;
            $file .= PHP_EOL;
            $file .= '        if (!$' . $entity->getLowerName() . ') {' . PHP_EOL;
            $file .= '            throw $this->createNotFoundException(\'No ' . $entity->getLowerName() . ' found for id \' . $id);' . PHP_EOL;
            $file .= '        }' . PHP_EOL;
            $file .= PHP_EOL;
            $file .= '        $em->remove($' . $entity->getLowerName() . ');' . PHP_EOL;
            $file .= '        $em->flush();' . PHP_EOL;
            $file .= PHP_EOL;
            $file .= '        $this->get(\'session\')->getFlashBag()->add(\'info\', \'The ' . $entity->getName() . ' has been deleted successfully.\');' . PHP_EOL;
            $file .= PHP_EOL;
            $file .= '        return $this->redirect($this->generateUrl(\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '\'));' . PHP_EOL;
            $file .= '    }' . PHP_EOL;
            $file .= '    // </user-additions' . '>' . PHP_EOL;
        }

        $file .= '}';

        return $file;
    }
    // </user-additions>
    // </editor-fold>
}
