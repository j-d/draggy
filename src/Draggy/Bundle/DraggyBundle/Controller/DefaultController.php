<?php

namespace Draggy\Bundle\DraggyBundle\Controller;

use Draggy\Exceptions\InvalidFileException;
use Draggy\Loader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Application\DevBundle\Resources\AutocodeTemplates;
use Draggy\Autocode\Project;

class DefaultController extends Controller
{
    private function checkModelFile()
    {
        try {
            $file = $this->container->getParameter('draggy.model_filename');
        } catch (\InvalidArgumentException $e) {
            return $this->render(
                'DraggyBundle:Default:error.html.twig',
                [
                'message' => 'The model filename was not specified on the parameters file. ' . "\n" . 'Please add a line such as:' . "\n" . 'draggy.model_filename: \'file.xml\'' . "\n" . 'to the parameters configuration file.'
                ]
            );
        }

        if (empty( $file )) {
            return $this->render(
                'DraggyBundle:Default:error.html.twig',
                [
                'message' => 'The model filename was not specified on the parameters file. ' . "\n" . 'Please complete the line such as:' . "\n" . 'draggy.model_filename: \'file.xml\'' . "\n" . 'to the parameters configuration file.'
                ]
            );
        }

        return null;
    }

    private function getModelFile()
    {
        $file = $this->container->getParameter('draggy.model_filename');

        return $this->get('kernel')->getRootDir() . '/../doc/' . $file;
    }

    public function draggyAction()
    {
        if (null !== $this->checkModelFile()) {
            return $this->checkModelFile();
        }

        $modelFile = $this->getModelFile();

        if (!is_writable($modelFile)) {

        }

        $loader = new Loader( $modelFile );

        return $this->render(
            'DraggyBundle:Default:draggy.html.twig',
            [
            'loaderJS' => $loader->getLoaderJS()
            ]
        );
    }

    public function generateAction()
    {
        if (null !== $this->checkModelFile()) {
            return $this->checkModelFile();
        }

        $modelFile = $this->getModelFile();

        $namespace = 'Application';

        $targetFolder = $this->get('kernel')->getRootDir() . '/../src/';

        $project = new Project($namespace);

        $project
            ->setBase(true)
            ->loadFile($modelFile)
            ->setOverwrite(true)
            //->setDeleteUnmapped(true)
            ->setValidation(true)
            ->setRoutesTemplate(new AutocodeTemplates\Routes())
            ->setCrudReadTwigTemplate(new AutocodeTemplates\CrudReadTwig())
            ->setCrudCreateTwigTemplate(new AutocodeTemplates\CrudCreateUpdateTwig())
            ->saveTo($targetFolder);

        return $this->render(
            'DraggyBundle:Default:generateEntities.html.twig',
            [
            'log' => $project->getLog()
            ]
        );
    }
}
