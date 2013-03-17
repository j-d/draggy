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

    private function getModelHistoryFile()
    {
        $file = $this->container->getParameter('draggy.model_filename');

        return $this->get('kernel')->getRootDir() . '/../doc/history/' . str_replace('.xml', '.' . time() . '.xml', $file);
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

    public function saveAction(Request $request)
    {
        if (null !== $this->checkModelFile()) {
            return $this->checkModelFile();
        }

        $modelFile = $this->getModelFile();
        $modelHistoryFile = $this->getModelHistoryFile();

        if (!is_writable($modelFile)) {
            return $this->render(
                'DraggyBundle:Default:ajaxMessage.txt.twig',
                [
                'message' => sprintf('The model file located at \'%s\' is read only.', $modelFile),
                ]
            );
        }

        $modelHistoryFolder = pathinfo($modelHistoryFile, PATHINFO_DIRNAME);

        if (!is_dir($modelHistoryFolder)) {
            return $this->render(
                'DraggyBundle:Default:ajaxMessage.txt.twig',
                [
                'message' => sprintf('The model history folder located at \'%s\' does not exist.', $modelHistoryFolder),
                ]
            );
        }

        if (!is_writable($modelHistoryFile)) {
            return $this->render(
                'DraggyBundle:Default:ajaxMessage.txt.twig',
                [
                'message' => sprintf('The model file located at \'%s\' is read only.', $modelHistoryFile),
                ]
            );
        }

        $xmlString = $request->request->get('xml');

        if (empty($xmlString)) {
            return $this->render(
                'DraggyBundle:Default:ajaxMessage.txt.twig',
                [
                'message' => 'Wrong request.',
                ]
            );
        }

        $xml = simplexml_load_string($xmlString);

        if (false === $xml) {
            return $this->render(
                'DraggyBundle:Default:ajaxMessage.txt.twig',
                [
                'message' => 'There is something wrong on the xml that was received. It cannot be saved.',
                ]
            );
        }

        $xmlString = $xml->asXML();

        if (false === file_put_contents($modelFile, $xmlString)) {
            return $this->render(
                'DraggyBundle:Default:ajaxMessage.txt.twig',
                [
                'message' => 'The model file could not be saved.',
                ]
            );
        }

        if (false === file_put_contents($modelFile, $xmlString)) {
            return $this->render(
                'DraggyBundle:Default:ajaxMessage.txt.twig',
                [
                'message' => 'The model history file could not be saved.',
                ]
            );
        }

        return $this->render(
            'DraggyBundle:Default:ajaxMessage.txt.twig',
            [
            'message' => 'OK',
            ]
        );
    }
}
