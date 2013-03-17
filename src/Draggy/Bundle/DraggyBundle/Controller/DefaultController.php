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
            throw new \InvalidArgumentException( 'The model filename was not specified on the parameters file. ' . "\n" . 'Please add a line such as:' . "\n" . 'draggy.model_filename: \'file.xml\'' . "\n" . 'to the parameters configuration file.' );
        }

        if (empty( $file )) {
            throw new \InvalidArgumentException( 'The model filename was not specified on the parameters file. ' . "\n" . 'Please complete the line such as:' . "\n" . 'draggy.model_filename: \'file.xml\'' . "\n" . 'to the parameters configuration file.' );
        }

        if (substr($file, -4) !== '.xml') {
            throw new \InvalidArgumentException( 'The model filename has to end in the \'.xml\' extension.' );
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
        $file = $this->container->getParameter('draggy.model_filename');

        return $this->get('kernel')->getRootDir() . '/../doc/' . $file;
    }

    private function getModelHistoryFile()
    {
        $file = $this->container->getParameter('draggy.model_filename');

        return $this->get('kernel')->getRootDir() . '/../doc/history/' . str_replace(
            '.xml',
            '.' . time() . '.xml',
            $file
        );
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

        $namespace = 'Application';

        $targetFolder = $this->get('kernel')->getRootDir() . '/../src/';

        $project = new Project( $namespace );

        $project->setBase(true)->loadFile($modelFile)->setOverwrite(true) //->setDeleteUnmapped(true)
            ->setValidation(true)->setRoutesTemplate(new AutocodeTemplates\Routes())->setCrudReadTwigTemplate(
                new AutocodeTemplates\CrudReadTwig()
            )->setCrudCreateTwigTemplate(new AutocodeTemplates\CrudCreateUpdateTwig())->saveTo($targetFolder);

        return $this->render(
            'DraggyBundle:Default:generateEntities.html.twig',
            [
            'log' => $project->getLog()
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
            return $this->render(
                'DraggyBundle:Default:ajaxMessage.txt.twig',
                [
                'message' => $exception->getMessage(),
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
