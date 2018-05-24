<?php

namespace BoutiqueBundle\Controller;

use BoutiqueBundle\Entity\Reclamation;
use BoutiqueBundle\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ReclamationController extends Controller

{

    public function AjoutAction(Request $request) {
        $modele= new Reclamation();
        if($request->isMethod('POST')) {
            $modele->setNom($this->getUser());
            $modele->setEmail($this->getUser()->getEmail());
            $modele->setMobile($request->get('mobile'));
            $modele->setSubject($request->get('subject'));
            $modele->setImage($request->get('image'));
            //$modele->uploadProfilePicture();

/*
            $file = $request->get('image');
            $fileName = md5(uniqid('',true)).'.'.$file->guessExtension();
            $path = "C:\wampNada\www\ProjetPi\web\uploads\images\products" ;
            $file->move(
                $path,
                $fileName
            );
            $modele->setImage($fileName);

*/


            $em = $this->getDoctrine()->getManager();

            $em->persist($modele);
            $em->flush();
           return $this->redirectToRoute('affiche');
        }

      //     return $this->render('@Boutique\nada.html.twig');
    }


    public function AfficheAction()
    {
        $em=$this->getDoctrine()->getManager();
        $email= $this->getUser()->getEmail();
        $modele=$em->getRepository('BoutiqueBundle:Reclamation')->findBy(array("email" => $email));
        return $this->render('@Boutique\Reclamation\listeR.html.twig',
            array(
                'm'=>$modele
            ));
    }

    public function DeleteAction(Request $request, $id){
        $modele=new Reclamation();
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository("BoutiqueBundle:Reclamation")->find($id);
        $em->remove($modele);
        $em->flush();
        return $this->render('@Boutique\Dashboard\layout.html.twig');
    }



    public function rechercheAction (Request $request){
        $em=$this->getDoctrine()->getManager();
        $voitures=$em->getRepository("BoutiqueBundle:Reclamation")->recherche($request->get("chose"));



       /* if ($request->isMethod('POST')) {
            $email = $request->get("email");
            $voitures = $em->getRepository("BoutiqueBundle:Reclamation")->findBy(array("email" => $email));
        }*/
        return $this->render('@Boutique\Dashboard\reclamation.html.twig',
            array('m'=>$voitures));
    }



    public function traiterAction(Request $request)
    {
        /* $voitures= new Reclamation();
         $em=$this->getDoctrine()->getManager();
         $voitures=$em->getRepository("BoutiqueBundle:Reclamation")->findAll();

             $id = $request->get("id");
             $voitures = $em->getRepository("BoutiqueBundle:Reclamation")->findBy(array("id" => $id));
         $voitures->setEtat('nadaaaa');

         return $this->render('@Boutique\nada.html.twig',
             array('m'=>$voitures));
     */

        $id = $request->get("id");
       // $modele = new Reclamation();
        $em = $this->getDoctrine()->getManager();
        $modele = $em->getRepository("BoutiqueBundle:Reclamation")->find($id);
        $modele->setEtat('Traitee');
        $em = $this->getDoctrine()->getManager();

        $em->persist($modele);

        //$em->remove($modele);
        //$em->flush();

        $modeles=$em->getRepository("BoutiqueBundle:Reclamation")->findAll();
        return $this->render('@Boutique\Dashboard\reclamation.html.twig',
            array('m'=>$modeles));
    }







    public function Ajout2Action(Request $request){
        $modele= new Reclamation();
        $Form=$this->createForm(ReclamationType::class,$modele);
        $Form->handleRequest($request);
        if($Form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($modele);
            $em->flush();
            return $this->redirectToRoute('affiche');
        }

       return $this->render('@Boutique/ajout.html.twig',array('form'=>$Form->createView()));
    }







}


