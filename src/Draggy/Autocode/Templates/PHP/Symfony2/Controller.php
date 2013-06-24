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
    /**
     * {@inheritDoc}
     */
    public function getFilename()
    {
        return $this->getEntity()->getName() . 'Controller.php';
    }

    public function getFilenameLine()
    {
        return '// ' . $this->getEntity()->getNamespace() . '\\Controller\\' . $this->getEntity()->getName() . 'Controller.php';
    }

    public function getNamespaceLine()
    {
        return 'namespace ' . $this->getEntity()->getNamespace() . '\\Controller;';
    }

    public function getUseLinesMandatoryPart()
    {
        $lines = [];

        $entity = $this->getEntity();

        $lines[] = 'use Common\Symfony\Controller;';
        $lines[] = '// use Symfony\\Component\\HttpFoundation\\Request;';
        $lines[] = '// use Symfony\\Component\\HttpFoundation\\Response;';
        $lines[] = '// use Symfony\\Component\\HttpFoundation\\RedirectResponse;';
        $lines[] = '// use Symfony\\Component\\Security\\Core\\SecurityContext;';
        $lines[] = '';
        $lines[] = '// use Doctrine\\Common\\Collections\\ArrayCollection;';
        $lines[] = '';

        if ($entity->getCrudCreate() || $entity->getCrudUpdate()) {
            $lines[] = '// use use Common\\Html\\FormItemArray;';
            $lines[] = '';
        }

        $lines[] = '// use ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . ';';

        if ($entity->getHasRepository())
            $lines[] = '// use ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . 'Repository;';

        if ($entity->getHasForm())
            $lines[] = '// use ' . $entity->getNamespace() . '\\Form\\' . $entity->getName() . 'Type;';

        foreach ($entity->getAttributes() as $attr) {
            if (null !== $attr->getForeignEntity()) {
                $lines[] = '// use ' . $attr->getForeignEntity()->getNamespace() . '\\Entity\\' . $attr->getForeignEntity()->getName() . ';';

                if ($attr->getForeignEntity()->getHasRepository()) {
                    $lines[] = '// use ' . $attr->getForeignEntity()->getNamespace() . '\\Entity\\' . $attr->getForeignEntity()->getName() . 'Repository;';
                }
            }
        }

        return $lines;
    }

    public function getUseLinesInsideUserAdditionsPart()
    {
        $lines = [];

        $entity = $this->getEntity();

        if ($entity->getCrudCreate()) {
            $lines[] = 'use ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . ';';
        }

        if ($entity->getCrudCreate() || $entity->getCrudUpdate()) {
            $lines[] = 'use Common\\Html\\FormItemArray;';
            $lines[] = 'use Symfony\\Component\\HttpFoundation\\Request;';
            $lines[] = 'use ' . $entity->getNamespace() . '\\Form\\' . $entity->getName() . 'Type;';
        }

        if ($entity->getCrudRead()) {
            $lines[] = 'use ' . $entity->getNamespace() . '\\Entity\\' . $entity->getName() . 'Repository;';
        }

        return $lines;
    }

    public function getUseLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->getUseLinesMandatoryPart());

        $lines[] = '';

        $lines[] = '// <user-additions' . ' part="use">';

        $lines = array_merge($lines, $this->getUseLinesInsideUserAdditionsPart());

        $lines[] = '// </user-additions' . '>';

        return $lines;
    }

    public function getControllerDocumentationLines()
    {
        $lines = [];

        $lines[] = $this->getEntity()->getNamespace() . '\\Controller\\' . $this->getEntity()->getName() . 'Controller';

        return $lines;
    }

    public function getControllerDeclarationLine()
    {
        return 'class ' . $this->getEntity()->getName() . 'Controller extends Controller';
    }

    public function getControllerHelpLines()
    {
        $lines = [];

        $entity = $this->getEntity();

        $lines[] = 'public function xxxAction(Request $request)';
        $lines[] = '{';
        $lines[] =     '$em = $this->getManager();';
        $lines[] =     '$xxx = $em->getRepository(\'' . $entity->getModule() . ':' . $entity->getName() . '\')->findXYZ();';
        $lines[] = '';

        if ($entity->getHasRepository()) {

            $lines[] = '$' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);';
            $lines[] = '';
        }

        $getRepositoryLines = [];

        foreach ($entity->getAttributes() as $attr) {
            if (null !== $attr->getForeignEntity()) {
                $getRepositoryLines[] = '$xxx = $em->getRepository(\'' . $attr->getForeignEntity()->getModule() . ':' . $attr->getForeignEntity()->getName() . '\')->findXYZ();';
            }
        }

        if (count($getRepositoryLines) > 0) {
            $lines = array_merge($lines, $getRepositoryLines);

            $lines[] = '';
        }

        $newRepositoryLines = [];

        foreach ($entity->getAttributes() as $attr) {
            if (null !== $attr->getForeignEntity() && $attr->getForeignEntity()->getHasRepository()) {
                $newRepositoryLines[] = '$' . $attr->getForeignEntity()->getLowerName() . 'Repository = new ' . $attr->getForeignEntity()->getName() . 'Repository($em);';
            }
        }

        if (count($newRepositoryLines) > 0) {
            $lines = array_merge($lines, $newRepositoryLines);

            $lines[] = '';
        }

        $lines[] = '$user = $this->get(\'security.context\')->getToken()->getUser();';
        $lines[] = 'if ($this->get(\'security.context\')->isGranted(\'ROLE_XXX\'))';
        $lines[] = '';

        if ($entity->getHasForm()) {
            $lines[] = '$' . $entity->getLowerName() . ' = new ' . $entity->getName() . '();';
            $lines[] = '$' . $entity->getLowerName() . 'Type = new ' . $entity->getName() . 'Type();';
            $lines[] = '';
            $lines[] = '$form = $this->createForm($' . $entity->getLowerName() . 'Type, $' . $entity->getLowerName() . ');';
            $lines[] = '';
            $lines[] = 'if ($request->isMethod(\'POST\')) {';
            $lines[] =     '$form->bind($request);';
            $lines[] = '';
            $lines[] =     'if ($form->isValid()) {';
            $lines[] =         '$em = $this->getManager();';
            $lines[] =         '$em->persist($' . $entity->getLowerName() . ');';
            $lines[] =         '$em->flush();';
            $lines[] = '';
            $lines[] =         '$this->get(\'session\')->getFlashBag()->add(\'info\', \'The ' . $entity->getName() . ' has been xxx successfully.\');';
            $lines[] = '';
            $lines[] =         'return $this->redirect($this->generateUrl(\'path_to_target\'));';
            $lines[] =     '}';
            $lines[] = '}';
            $lines[] = '';
        }

        $lines[] =     'return (new Response())';
        $lines[] =         '->setStatusCode(403)';
        $lines[] =         '->setContent(\'Message here\');';
        $lines[] =     'return new RedirectResponse($this->generateUrl(\'path_to_target\'));';
        $lines[] =     'return $this->render(\'' . $entity->getModule() . ':Default:' . $entity->getLowerName() . '.html.twig\');';
        $lines[] =     'return $this->render(';
        $lines[] =         '\'' . $entity->getModule() . ':' . $entity->getName() . ':' . strtolower($entity->getName()) . '.html.twig\',';
        $lines[] =         '[';
        $lines[] =             '\'\' => $,';
        $lines[] =             '\'form\' => $form->createView(),';
        $lines[] =         '],';
        $lines[] =         '//$response / null,';
        $lines[] =         '//$renderParameters';
        $lines[] =     ');';
        $lines[] = '}';

        return $lines;
    }

    public function getControllerUserAdditionsActionsLines()
    {
        $lines = [];

        $lines[] = '// <user-additions' . ' part="actions">';
        $lines[] = '// </user-additions' . '>';

        return $lines;
    }

    public function getControllerListActionLines()
    {
        $lines = [];

        $entity = $this->getEntity();

        if ($entity->getCrudRead()) {
            $lines[] = '';

            $lines[] = '// <user-additions' . ' part="listAction">';
            $lines[] = 'public function listAction()';
            $lines[] = '{';
            $lines[] =     '$em = $this->getManager();';
            $lines[] =     '$' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);';
            $lines[] = '';
            $lines[] =     '$' . $entity->getPluralLowerName() . ' = $' . $entity->getLowerName() . 'Repository->findBy([], [\'' . $entity->getPrimaryAttribute()->getName() . '\' => \'ASC\']);';
            $lines[] = '';
            $lines[] =     'return $this->render(';
            $lines[] =         '\'' . $entity->getModule() . ':' . $entity->getName() . ':list' . $entity->getName() . '.html.twig\',';
            $lines[] =         '[';
            $lines[] =             '\'' . $entity->getPluralLowerName() . '\' => $' . $entity->getPluralLowerName() . ',';
            $lines[] =         ']';
            $lines[] =     ');';
            $lines[] = '}';
            $lines[] = '// </user-additions' . '>';
        }

        return $lines;
    }

    public function getControllerAddActionLines()
    {
        $lines = [];

        $entity = $this->getEntity();

        if ($entity->getCrudCreate()) {
            $lines[] = '';

            $lines[] = '// <user-additions' . ' part="addAction">';
            $lines[] = 'public function addAction(Request $request)';
            $lines[] = '{';

            if ($entity->getHasForm()) {
                $lines[] = '$' . $entity->getLowerName() . ' = new ' . $entity->getName() . '();';
                $lines[] = '$' . $entity->getLowerName() . 'Type = new ' . $entity->getName() . 'Type();';
                $lines[] = '';
                $lines[] = '$form = $this->createForm($' . $entity->getLowerName() . 'Type, $' . $entity->getLowerName() . ');';
                $lines[] = '';
                $lines[] = 'if ($request->isMethod(\'POST\')) {';
                $lines[] =     '$form->bind($request);';
                $lines[] = '';
                $lines[] =     'if ($form->isValid()) {';
                $lines[] =         '$em = $this->getManager();';
                $lines[] =         '$em->persist($' . $entity->getLowerName() . ');';
                $lines[] =         '$em->flush();';
                $lines[] = '';
                $lines[] =         '$this->get(\'session\')->getFlashBag()->add(\'info\', \'The ' . $entity->getName() . ' has been created successfully.\');';
                $lines[] = '';
                $lines[] =         'return $this->redirect($this->generateUrl(\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '\'));';
                $lines[] =     '}';
                $lines[] = '}';
                $lines[] = '';
            }

            $lines[] =     'return $this->render(';
            $lines[] =         '\'' . $entity->getModule() . ':' . $entity->getName() . ':add' . $entity->getName() . '.html.twig\',';
            $lines[] =         '[';
            $lines[] =             '\'form\' => $form->createView(),';
            $lines[] =         '],';
            $lines[] =         'null,';
            $lines[] =         'new FormItemArray($' . $entity->getLowerName() . 'Type->getFields())';
            $lines[] =     ');';
            $lines[] = '}';
            $lines[] = '// </user-additions' . '>';
        }

        return $lines;
    }

    public function getControllerEditActionLines()
    {
        $lines = [];

        $entity = $this->getEntity();

        if ($entity->getCrudUpdate()) {
            $lines[] = '';

            $lines[] = '// <user-additions' . ' part="editAction">';
            $lines[] = 'public function editAction(Request $request, $id)';
            $lines[] = '{';

            if ($entity->getHasForm()) {
                $lines[] = '$em = $this->getManager();';
                $lines[] = '$' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);';
                $lines[] = '';
                $lines[] = '$' . $entity->getLowerName() . ' = $' . $entity->getLowerName() . 'Repository->findOneBy([\'id\' => $id]);';
                $lines[] = '';
                $lines[] = 'if(!$' . $entity->getLowerName() . ') {';
                $lines[] =     'throw $this->createNotFoundException(\'No ' . $entity->getLowerName() . ' found for id \' . $id);';
                $lines[] = '}';
                $lines[] = '';
                $lines[] = '$' . $entity->getLowerName() . 'Type = new ' . $entity->getName() . 'Type();';
                $lines[] = '';
                $lines[] = '$form = $this->createForm($' . $entity->getLowerName() . 'Type, $' . $entity->getLowerName() . ');';
                $lines[] = '';
                $lines[] = 'if ($request->isMethod(\'POST\')) {';
                $lines[] =     '$form->bind($request);';
                $lines[] = '';
                $lines[] =     'if ($form->isValid()) {';
                $lines[] =         '$em->persist($' . $entity->getLowerName() . ');';
                $lines[] =         '$em->flush();';
                $lines[] = '';
                $lines[] =         '$this->get(\'session\')->getFlashBag()->add(\'info\', \'The ' . $entity->getName() . ' has been edited successfully.\');';
                $lines[] = '';
                $lines[] =         'return $this->redirect($this->generateUrl(\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '\'));';
                $lines[] =     '}';
                $lines[] = '}';
                $lines[] = '';
            }

            $lines[] =     'return $this->render(';
            $lines[] =         '\'' . $entity->getModule() . ':' . $entity->getName() . ':edit' . $entity->getName() . '.html.twig\',';
            $lines[] =         '[';
            $lines[] =             '\'form\' => $form->createView(),';
            $lines[] =             '\'id\' => $id,';
            $lines[] =         '],';
            $lines[] =         'null,';
            $lines[] =         'new FormItemArray($' . $entity->getLowerName() . 'Type->getFields())';
            $lines[] =     ');';
            $lines[] = '}';
            $lines[] = '// </user-additions' . '>';
        }

        return $lines;
    }

    public function getControllerDeleteActionLines()
    {
        $lines = [];

        $entity = $this->getEntity();

        if ($entity->getCrudDelete()) {
            $lines[] = '';

            $lines[] = '// <user-additions' . ' part="deleteAction">';
            $lines[] = 'public function deleteAction(Request $request, $id)';
            $lines[] = '{';
            $lines[] =     '$em = $this->getManager();';
            $lines[] =     '$' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);';
            $lines[] = '';
            $lines[] =     '$' . $entity->getLowerName() . ' = $' . $entity->getLowerName() . 'Repository->findOneBy([\'id\' => $id]);';
            $lines[] = '';
            $lines[] =     'if (!$' . $entity->getLowerName() . ') {';
            $lines[] =         'throw $this->createNotFoundException(\'No ' . $entity->getLowerName() . ' found for id \' . $id);';
            $lines[] =     '}';
            $lines[] = '';
            $lines[] =     '$em->remove($' . $entity->getLowerName() . ');';
            $lines[] =     '$em->flush();';
            $lines[] = '';
            $lines[] =     '$this->get(\'session\')->getFlashBag()->add(\'info\', \'The ' . $entity->getName() . ' has been deleted successfully.\');';
            $lines[] = '';
            $lines[] =     'return $this->redirect($this->generateUrl(\'' . strtolower($entity->getModuleNoBundle()) . '_' . strtolower($entity->getName()) . '\'));';
            $lines[] = '}';
            $lines[] = '// </user-additions' . '>';
        }

        return $lines;
    }

    public function getControllerBodyLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->commentAndJustifyLines($this->getControllerHelpLines()));

        $lines[] = '';

        $lines = array_merge($lines, $this->getControllerUserAdditionsActionsLines());

        $lines = array_merge($lines, $this->getControllerListActionLines());
        $lines = array_merge($lines, $this->getControllerAddActionLines());
        $lines = array_merge($lines, $this->getControllerEditActionLines());
        $lines = array_merge($lines, $this->getControllerDeleteActionLines());

        return $lines;
    }

    public function getFileLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->surroundDocumentationBlock($this->getControllerDocumentationLines()));

        $lines[] = $this->getControllerDeclarationLine();

        $lines[] = '{';

        $lines = array_merge($lines, $this->getControllerBodyLines());

        $lines[] = '}';

        return $lines;
    }
    // </user-additions>
    // </editor-fold>
}
