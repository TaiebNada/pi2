<?php

namespace Animaux1Bundle\Controller;

use Animaux1Bundle\Entity\CommentaireVet;
use Animaux1Bundle\Form\CommentaireVetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CommentaireVetController extends Controller
{
    public function afficheAction()
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:CommentaireVet')->findAll();
        return $this->render('@Animaux1/FrontOffice/Commentaire/ListeCom.html.twig',
            array(
                'm'=>$modele
            ));
    }

    public function ajoutAction(Request $request){
        $modele= new CommentaireVet();
        $Form=$this->createForm(CommentaireVetType::class,$modele);
        $Form->handleRequest($request);
        if($Form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($modele);
            $em->flush();
            return $this->redirectToRoute('listeCom');
        }

        return $this->render('@Animaux1/FrontOffice/Commentaire/AjoutCom.html.twig',array('f'=>$Form->createView()));
    }

}
