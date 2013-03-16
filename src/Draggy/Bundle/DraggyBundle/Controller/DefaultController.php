<?php

namespace Draggy\Bundle\DraggyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function draggyAction()
    {
        return $this->render('DraggyBundle:Default:index.html.twig');
    }

    public function generateAction()
    {
        return $this->render('DraggyBundle:Default:index.html.twig');
    }
}
