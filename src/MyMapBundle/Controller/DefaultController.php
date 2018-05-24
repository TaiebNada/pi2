<?php

namespace MyMapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {$Latitudes='0';
    $Longitudes='0';
        return $this->render('@MyMap\Default\index.html.twig',array('Latitudes'=>$Latitudes,'Longitudes'=>$Longitudes));
    }
}
