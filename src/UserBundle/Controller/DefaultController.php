<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
        return $this->render('@User/Accueil.html.twig', array('m' => $user));
    }
    public function index1Action()
    {
        $user = $this->getUser();
        return $this->render('@User/layout.html.twig', array('m' => $user));
    }
    public function dashboardAction()
    {
        //$user = $this->getUser();
        return $this->render('@Boutique/Dashboard/layout.html.twig');
    }



}
