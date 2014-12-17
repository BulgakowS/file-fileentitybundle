<?php

namespace Brainx2\File\FileEntityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('Brainx2FileFileEntityBundle:Default:index.html.twig', array('name' => $name));
    }
}
