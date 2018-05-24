<?php

namespace BienetreBundle\Controller;

use BienetreBundle\Form\CommentaireEvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BienetreBundle\Entity\CommentaireEvenement;

class CommentaireEvenementController extends Controller
{


    /**
     * @Route("/UpdateCommentaire")
     */
    public function SupprimerCommentaireAction(Request $request,$id,$ideve)
    {
        $CommentaireEvenement=new CommentaireEvenement();
        $em=$this->getDoctrine()->getManager();
        $CommentaireEvenement=$em->getRepository("BienetreBundle:CommentaireEvenement")->find($id);
        $em->remove($CommentaireEvenement);
        $em->flush();
        return $this->redirectToRoute('_affichecommentaire', array('id'=>$ideve));
    }

}
