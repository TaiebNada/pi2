<?php

namespace Animaux1Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Animaux1\Default\index.html.twig');
    }


}
