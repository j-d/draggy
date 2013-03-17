<?php

namespace Draggy\Bundle\DraggyBundle\Controller;

use Draggy\Loader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Draggy\Autocode\Project;

class DefaultController extends Controller
{
    private function checkModelFile()
    {
        try {
            $file = $this->container->getParameter('draggy.model_filename');
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException( 'The model filename was not specified on the parameters file. ' . "\n" . 'Please add a line such as:' . "\n" . 'draggy.model_filename: \'file.xml\'' . "\n" . 'to the parameters configuration file.' );
        }

        if (empty( $file )) {
            throw new \InvalidArgumentException( 'The model filename was not specified on the parameters file. ' . "\n" . 'Please complete the line such as:' . "\n" . 'draggy.model_filename: \'file.xml\'' . "\n" . 'on the parameters configuration file.' );
        }

        try {
            $extension = $this->container->getParameter('draggy.model_xml_extension');
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException( 'The model filename extension was not specified on the parameters file. ' . "\n" . 'Please add a line such as:' . "\n" . 'draggy.model_xml_extension: \'.xml\'' . "\n" . 'to the parameters configuration file.' );
        }

        if (substr($file, -strlen($extension)) !== $extension) {
            throw new \InvalidArgumentException( sprintf(
                'The model filename has to end in the \'%s\' extension.',
                $extension
            ) );
        }
    }

    private function checkSaveable()
    {
        $this->checkModelFile();

        $modelFile        = $this->getModelFile();
        $modelHistoryFile = $this->getModelHistoryFile();

        if (!is_writable($modelFile)) {
            throw new \RuntimeException( sprintf('The model file located at \'%s\' is read only.', $modelFile) );
        }

        $modelHistoryFolder = pathinfo($modelHistoryFile, PATHINFO_DIRNAME);

        if (!is_dir($modelHistoryFolder)) {
            throw new \RuntimeException( sprintf(
                'The model history folder located at \'%s\' does not exist.',
                $modelHistoryFolder
            ) );
        }

        if (!is_writable($modelHistoryFolder)) {
            throw new \RuntimeException( sprintf(
                'The model history file located at \'%s\' is read only.',
                $modelHistoryFile
            ) );
        }
    }

    private function getModelFile()
    {
        $this->checkModelFile();

        try {
            $path = $this->container->getParameter('draggy.model_path');
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException( 'The model path was not specified on the parameters file. ' . "\n" . 'Please add a line such as:' . "\n" . 'draggy.model_path: \'%kernel.root_dir%/../doc/\'' . "\n" . 'to the parameters configuration file.' );
        }

        if (empty( $path )) {
            throw new \InvalidArgumentException( 'The model path was not specified on the parameters file. ' . "\n" . 'Please complete the line such as:' . "\n" . 'draggy.model_path: \'%kernel.root_dir%/../doc/\'' . "\n" . 'on the parameters configuration file.' );
        }

        $file = $this->container->getParameter('draggy.model_filename');

        return $path . $file;
    }

    private function getModelHistoryFile()
    {
        $this->checkModelFile();

        try {
            $historyPath = $this->container->getParameter('draggy.model_history_path');
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException( 'The model history path was not specified on the parameters file. ' . "\n" . 'Please add a line such as:' . "\n" . 'draggy.model_history_path: \'%kernel.root_dir%/../doc/history/\'' . "\n" . 'to the parameters configuration file.' );
        }

        if (empty( $historyPath )) {
            throw new \InvalidArgumentException( 'The model history path was not specified on the parameters file. ' . "\n" . 'Please complete the line such as:' . "\n" . 'draggy.model_history_path: \'%kernel.root_dir%/../doc/history/\'' . "\n" . 'on the parameters configuration file.' );
        }

        $file      = $this->container->getParameter('draggy.model_filename');
        $extension = $this->container->getParameter('draggy.model_xml_extension');

        return $historyPath . str_replace($extension, '.' . time() . $extension, $file);
    }

    public function draggyAction()
    {
        try {
            $this->checkModelFile();
        } catch (\Exception $exception) {
            return $this->render(
                'DraggyBundle:Default:error.html.twig',
                [
                'message' => $exception->getMessage()
                ]
            );
        }

        $modelFile = $this->getModelFile();

        try {
            $targetFolder = $this->container->getParameter('draggy.autocode.src_path');
        } catch (\Exception $exception) {
            $targetFolder = '(not defined)';
        }

        $saveable         = true;
        $noSaveableReason = '';

        try {
            $this->checkSaveable();
        } catch (\Exception $exception) {
            $saveable         = false;
            $noSaveableReason = $exception->getMessage();
        }

        $loader = new Loader( $modelFile );

        return $this->render(
            'DraggyBundle:Default:draggy.html.twig',
            [
            'loaderJS'         => $loader->getLoaderJS(),
            'saveable'         => $saveable,
            'noSaveableReason' => $noSaveableReason,
            'targetFolder'     => $targetFolder,
            ]
        );
    }

    public function generateAction()
    {
        try {
            $this->checkModelFile();
        } catch (\Exception $exception) {
            return $this->render(
                'DraggyBundle:Default:error.html.twig',
                [
                'message' => $exception->getMessage()
                ]
            );
        }

        $modelFile = $this->getModelFile();

        $targetFolder = $this->container->getParameter('draggy.autocode.src_path');

        $project = new Project();

        $project
            ->loadFile($modelFile)
            ->saveTo($targetFolder);

        return $this->render(
            'DraggyBundle:Default:generateEntities.html.twig',
            [
            'log' => $project->getLog()
            ]
        );
    }

    public function previewAction(Request $request)
    {
        $xmlString = $request->request->get('xml');

        if (empty( $xmlString )) {
            throw new \LogicException( 'Wrong request.' );
        }

        $xml = simplexml_load_string($xmlString);

        try {
            $targetFolder = $this->container->getParameter('draggy.autocode.src_path');
        } catch (\Exception $exception) {
            $targetFolder = '/dev/null/';
        }

        if (false === $xml) {
            throw new \LogicException( 'There is something wrong on the xml that was received. It cannot be saved.' );
        }

        $project = new Project();

        $project->loadDesign($xml);

        return $this->render(
            'DraggyBundle:Default:parts/autocodeChanges.html.twig',
            [
            'changes' => $project->getChanges($targetFolder)
            ]
        );
    }

    public function saveAction(Request $request)
    {
        try {
            $this->checkSaveable();

            $modelFile        = $this->getModelFile();
            $modelHistoryFile = $this->getModelHistoryFile();

            $xmlString = $request->request->get('xml');

            if (empty( $xmlString )) {
                throw new \LogicException( 'Wrong request.' );
            }

            $xml = simplexml_load_string($xmlString);

            if (false === $xml) {
                throw new \LogicException( 'There is something wrong on the xml that was received. It cannot be saved.' );
            }

            $xmlString = $xml->asXML();

            if (false === file_put_contents($modelFile, $xmlString)) {
                throw new \RuntimeException( 'The model file could not be saved.' );
            }

            if (false === file_put_contents($modelHistoryFile, $xmlString)) {
                throw new \RuntimeException( 'The model history file could not be saved.' );
            }
        } catch (\Exception $exception) {
            $response = $this->render(
                'DraggyBundle:Default:ajaxMessage.txt.twig',
                [
                'message' => $exception->getMessage(),
                ]
            );

            $response->setStatusCode(400);

            return $response;
        }

        return $this->render(
            'DraggyBundle:Default:ajaxMessage.txt.twig',
            [
            'message' => 'OK',
            ]
        );
    }
}
