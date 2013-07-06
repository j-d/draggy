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
use Draggy\Autocode\PHPEntity;
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
    public function getPath()
    {
        return 'Controller/';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getEntity()->getName() . 'Controller';
    }

    public function getNamespaceLine()
    {
        return 'namespace ' . $this->getEntity()->getNamespace() . '\\Controller;';
    }

    public function getUseLineControllerPart()
    {
        return 'use Symfony\Bundle\FrameworkBundle\Controller\Controller;';
    }

    public function getUseLinesMandatoryPart()
    {
        $lines = [];

        /** @var PHPEntity $entity */
        $entity = $this->getEntity();

        $lines[] = $this->getUseLineControllerPart();

        if ($entity->getCrudCreate() || $entity->getCrudUpdate()) {
            $lines[] = 'use Symfony\\Component\\HttpFoundation\\Request;';
            $lines[] = 'use ' . $entity->getFullyQualifiedFormName() . ';';
        }

        if ($entity->getCrudCreate()) {
            $lines[] = 'use ' . $entity->getFullyQualifiedName() . ';';
        }

        if ($entity->getCrudRead() && $entity->getHasRepository()) {
            $lines[] = 'use ' . $entity->getFullyQualifiedRepositoryName() . ';';
        }

        if ($entity->getCrudRead() || $entity->getCrudRead() || $entity->getCrudRead() || $entity->getCrudRead()) {
            $lines[] = 'use Doctrine\ORM\EntityManager;';
        }

        $lines[] = '';
        $lines[] = '// use Symfony\\Component\\HttpFoundation\\Request;';
        $lines[] = '// use Symfony\\Component\\HttpFoundation\\Response;';
        $lines[] = '// use Symfony\\Component\\HttpFoundation\\RedirectResponse;';
        $lines[] = '// use Symfony\\Component\\Security\\Core\\SecurityContext;';
        $lines[] = '';
        $lines[] = '// use Doctrine\\Common\\Collections\\ArrayCollection;';
        $lines[] = '';

        $lines[] = '// use ' . $entity->getFullyQualifiedName() . ';';

        $attributeUses = [];

        foreach ($entity->getAttributes() as $attr) {
            if (null !== $attr->getForeignEntity()) {
                $attributeUses[] = '// use ' . $attr->getForeignEntity()->getFullyQualifiedName() . ';';

                if ($attr->getForeignEntity()->getHasRepository()) {
                    $attributeUses[] = '// use ' . $attr->getForeignEntity()->getFullyQualifiedRepositoryName() . ';';
                }
            }
        }

        $lines = array_merge($lines, array_unique($attributeUses));

        return $lines;
    }

    public function getUseLines()
    {
        $lines = [];

        $lines = array_merge($lines, $this->getUseLinesMandatoryPart());

        $lines[] = '';

        $lines = array_merge($lines, $this->getUseLinesUserAdditionsPart());

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
        $lines[] =     '/** @var EntityManager $em */';
        $lines[] =     '$em = $this->getDoctrine()->getManager();';
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
            $lines = array_merge($lines, array_unique($getRepositoryLines));

            $lines[] = '';
        }

        $newRepositoryLines = [];

        foreach ($entity->getAttributes() as $attr) {
            if (null !== $attr->getForeignEntity() && $attr->getForeignEntity()->getHasRepository()) {
                $newRepositoryLines[] = '$' . $attr->getForeignEntity()->getLowerName() . 'Repository = new ' . $attr->getForeignEntity()->getName() . 'Repository($em);';
            }
        }

        if (count($newRepositoryLines) > 0) {
            $lines = array_merge($lines, array_unique($newRepositoryLines));

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
            $lines[] =     '$form->submit($request->request->get($form->getName()));';
            $lines[] = '';
            $lines[] =     'if ($form->isValid()) {';
            $lines[] =         '/** @var EntityManager $em */';
            $lines[] =         '$em = $this->getDoctrine()->getManager();';
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

        $lines[] = $this->getUserAdditions('actions');
        $lines[] = $this->getEndUserAdditions();

        return $lines;
    }

    public function getControllerListActionLines()
    {
        $lines = [];

        $entity = $this->getEntity();

        if ($entity->getCrudRead()) {
            $lines[] = '';

            $lines[] = $this->getUserAdditions('listAction');
            $lines[] = 'public function listAction()';
            $lines[] = '{';
            $lines[] =     '/** @var EntityManager $em */';
            $lines[] =     '$em = $this->getDoctrine()->getManager();';
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
            $lines[] = $this->getEndUserAdditions();
        }

        return $lines;
    }

    public function getControllerAddActionLinesReturnPart()
    {
        $lines = [];

        $lines[] = 'return $this->render(';
        $lines[] =     '\'' . $this->getEntity()->getModule() . ':' . $this->getEntity()->getName() . ':add' . $this->getEntity()->getName() . '.html.twig\',';
        $lines[] =     '[';
        $lines[] =         '\'form\' => $form->createView(),';
        $lines[] =     '],';
        $lines[] =     'null';
        $lines[] = ');';

        return $lines;
    }

    public function getControllerAddActionLines()
    {
        $lines = [];

        $entity = $this->getEntity();

        if ($entity->getCrudCreate()) {
            $lines[] = '';

            $lines[] = $this->getUserAdditions('addAction');
            $lines[] = 'public function addAction(Request $request)';
            $lines[] = '{';

            if ($entity->getHasForm()) {
                $lines[] = '$' . $entity->getLowerName() . ' = new ' . $entity->getName() . '();';
                $lines[] = '$' . $entity->getLowerName() . 'Type = new ' . $entity->getName() . 'Type();';
                $lines[] = '';
                $lines[] = '$form = $this->createForm($' . $entity->getLowerName() . 'Type, $' . $entity->getLowerName() . ');';
                $lines[] = '';
                $lines[] = 'if ($request->isMethod(\'POST\')) {';
                $lines[] =     '$form->submit($request->request->get($form->getName()));';
                $lines[] = '';
                $lines[] =     'if ($form->isValid()) {';
                $lines[] =         '/** @var EntityManager $em */';
                $lines[] =         '$em = $this->getDoctrine()->getManager();';
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

            $lines = array_merge($lines, $this->getControllerAddActionLinesReturnPart());

            $lines[] = '}';
            $lines[] = $this->getEndUserAdditions();
        }

        return $lines;
    }

    public function getControllerEditActionLinesReturnPart()
    {
        $lines[] = 'return $this->render(';
        $lines[] =     '\'' . $this->getEntity()->getModule() . ':' . $this->getEntity()->getName() . ':edit' . $this->getEntity()->getName() . '.html.twig\',';
        $lines[] =     '[';
        $lines[] =         '\'form\' => $form->createView(),';
        $lines[] =         '\'id\' => $id,';
        $lines[] =     ']';
        $lines[] = ');';

        return $lines;
    }

    public function getControllerEditActionLines()
    {
        $lines = [];

        $entity = $this->getEntity();

        if ($entity->getCrudUpdate()) {
            $lines[] = '';

            $lines[] = $this->getUserAdditions('editAction');
            $lines[] = 'public function editAction(Request $request, $id)';
            $lines[] = '{';

            if ($entity->getHasForm()) {
                $lines[] = '/** @var EntityManager $em */';
                $lines[] = '$em = $this->getDoctrine()->getManager();';
                $lines[] = '$' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);';
                $lines[] = '';
                $lines[] = '$' . $entity->getLowerName() . ' = $' . $entity->getLowerName() . 'Repository->findOneBy([\'id\' => $id]);';
                $lines[] = '';
                $lines[] = 'if (null === $' . $entity->getLowerName() . ') {';
                $lines[] =     'throw $this->createNotFoundException(\'No ' . $entity->getLowerName() . ' found for id \' . $id);';
                $lines[] = '}';
                $lines[] = '';
                $lines[] = '$' . $entity->getLowerName() . 'Type = new ' . $entity->getName() . 'Type();';
                $lines[] = '';
                $lines[] = '$form = $this->createForm($' . $entity->getLowerName() . 'Type, $' . $entity->getLowerName() . ');';
                $lines[] = '';
                $lines[] = 'if ($request->isMethod(\'POST\')) {';
                $lines[] =     '$form->submit($request->request->get($form->getName()));';
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

            $lines = array_merge($lines, $this->getControllerEditActionLinesReturnPart());

            $lines[] = '}';
            $lines[] = $this->getEndUserAdditions();
        }

        return $lines;
    }

    public function getControllerDeleteActionLines()
    {
        $lines = [];

        $entity = $this->getEntity();

        if ($entity->getCrudDelete()) {
            $lines[] = '';

            $lines[] = $this->getUserAdditions('deleteAction');
            $lines[] = 'public function deleteAction(Request $request, $id)';
            $lines[] = '{';
            $lines[] =     '/** @var EntityManager $em */';
            $lines[] =     '$em = $this->getDoctrine()->getManager();';
            $lines[] =     '$' . $entity->getLowerName() . 'Repository = new ' . $entity->getName() . 'Repository($em);';
            $lines[] = '';
            $lines[] =     '$' . $entity->getLowerName() . ' = $' . $entity->getLowerName() . 'Repository->findOneBy([\'id\' => $id]);';
            $lines[] = '';
            $lines[] =     'if (null === $' . $entity->getLowerName() . ') {';
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
            $lines[] = $this->getEndUserAdditions();
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
