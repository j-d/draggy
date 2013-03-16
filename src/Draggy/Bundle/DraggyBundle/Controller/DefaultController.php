<?php

namespace Draggy\Bundle\DraggyBundle\Controller;

use Draggy\Exceptions\InvalidFileException;
use Draggy\Loader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function draggyAction()
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

        $fileFullPath = $this->get('kernel')->getRootDir() . '/../doc/' . $file;

        if (!is_writable($fileFullPath)) {

        }

        $loader = new Loader( $fileFullPath );

        return $this->render(
            'DraggyBundle:Default:draggy.html.twig',
            [
            'loaderJS' => $loader->getLoaderJS()
            ]
        );
    }

    public function generateAction()
    {
        return $this->render('DraggyBundle:Default:index.html.twig');
    }
}
