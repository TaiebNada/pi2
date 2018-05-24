<?php

namespace SOSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SOSBundle:Default:index.html.twig');
    }
}
