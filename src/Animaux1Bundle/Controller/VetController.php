<?php

namespace Animaux1Bundle\Controller;

use Animaux1Bundle\Entity\Vet;
use Animaux1Bundle\Form\VetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class VetController extends Controller
{
    //affiche liste vet : FrontOffice : client
    public function afficheFrontAction()
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Vet')->findAll();
        return $this->render('@Animaux1/FrontOffice/Vet/ListeVet.html.twig',
            array(
                'm'=>$modele
            ));
    }
    //affiche liste vet: backOffice: admin
    public function afficheBackAction()
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Vet')->findAll();
        return $this->render('@Animaux1/BackOffice/ListeVet.html.twig',
            array(
                'm'=>$modele
            ));
    }
    //affiche detail vet : client front
    public function afficheDetailAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Vet')->findBy( array('id' => $id));
        return $this->render('@Animaux1/FrontOffice/Vet/AfficherDetail.html.twig',
            array(
                'm'=>$modele
            ));
    }
//affiche detail vet Admin: back
    public function afficheDetailVetAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Vet')->findBy( array('id' => $id));
        return $this->render('@Animaux1/BackOffice/AfficheProfilVet.html.twig',
            array(
                'm'=>$modele
            ));
    }
    public function afficheProfilAction($id)
    {
        //$id=$this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Vet')->findBy( array('id' => $id));
        return $this->render('@Animaux1/FrontOffice/Vet/AfficheProfil.html.twig',
            array(
                'm'=>$modele
            ));
    }

    //won't use it , since vet s'inscrit wa7dou
    public function ajoutAction(Request $request){
        $modele= new Vet();
        $Form=$this->createForm(VetType::class,$modele);
        $Form->handleRequest($request);
        if($Form->isValid()){

            $file = $modele->getImagevet();

            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();


            $file->move($this->getParameter('brochures_directory'), $fileName);


            $modele->setImagevet($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($modele);
            $em->flush();
            return $this->redirectToRoute('listeVetBack');
        }

        return $this->render('@Animaux1/BackOffice/AjoutVet.html.twig',array('f'=>$Form->createView()));
    }
    //Vet front: modifier profil
    public function modifierProfilAction(Request $request,$id){

        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository("Animaux1Bundle\Entity\Vet")->find($id);
        $Form=$this->createForm(VetType::class,$modele);
        $Form->handleRequest($request);
        if($Form->isValid()){
            $em->persist($modele);
            $em->flush();
            return $this->redirectToRoute('maListeVet');
        }

        return $this->render('@Animaux1/FrontOffice/Vet/ModifierProfil.html.twig',
            array('f'=>$Form->createView()));

    }

    public function preDeleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Vet')->findBy( array('id' => $id));
        return $this->render('@Animaux1/BackOffice/preDelete.html.twig',
            array(
                'm'=>$modele
            ));
    }
    //supprimer vet : admin backOffice
    public function supprimerAction(Request $request, $id)
    {
        $voiture = new Vet();
        $em = $this->getDoctrine()->getManager();
        $voiture = $em->getRepository("Animaux1Bundle\Entity\Vet")->find($id);
        $em->remove($voiture);
        $em->flush();
        return $this->redirectToRoute('listeVetBack');
    }

}
