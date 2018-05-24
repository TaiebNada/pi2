<?php

namespace BoutiqueBundle\Controller;

use BoutiqueBundle\Entity\Commentaire;
use BoutiqueBundle\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CommentaireController extends Controller
{
    public function affichecAction()
    {
        $ima=$this->getUser()->getImage();
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('BoutiqueBundle:Commentaire')->findAll();
        return $this->render('@Boutique/single.html.twig',
            array(
                'm'=>$modele
            , 'image'=>$ima));
    }



    public function ajoutcAction(Request $request){


        $ima=$this->getUser()->getImage();
        // $em=$this->getDoctrine()->getManager();
       // $modeles=$em->getRepository('BoutiqueBundle:Commentaire')->findAll();
        $modele= new Commentaire();
        $Form=$this->createForm(CommentaireType::class,$modele);
        $Form->handleRequest($request);
        if($Form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $modele->setImage($ima);
            $em->persist($modele);
            $em->flush();
            return $this->redirectToRoute('affichec');
        }

        return $this->render('@Boutique/nada.html.twig',array('form'=>$Form->createView()));
    }

    public function supprimercAction(Request $request, $id){
        $modele=new Commentaire();
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository("BoutiqueBundle:Commentaire")->find($id);
        $em->remove($modele);
        $em->flush();
        return $this->redirectToRoute('affichec');
    }





    public function ajoutc2Action(Request $request) {
        $modele= new Commentaire();
        if($request->isMethod('POST')) {
            $modele->setName($this->getUser());
            $modele->setContenu($request->get('contenu'));
            $modele->setImage($this->getUser()->getImage());
            $em = $this->getDoctrine()->getManager();
            $em->persist($modele);
            $em->flush();
            return $this->redirectToRoute('affichec');
        }

            return $this->render('@Boutique\single.html.twig');
    }


}
