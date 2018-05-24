<?php

namespace EcommerceBundle\Controller;


use EcommerceBundle\Entity\Livreur;
use EcommerceBundle\Form\LivreurForm;
use EcommerceBundle\Entity\Commentaire;
use EcommerceBundle\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class LivreurController extends Controller
{private function generateUniqueFileName()
{
    return md5(uniqid());
}


    public function AjoutAction(Request $request){
        $livreur = new Livreur();
        $form = $this->createForm(LivreurForm::class, $livreur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $livreur->getImage();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move($this->getParameter('image_directory'), $fileName);
            $livreur->setImage($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($livreur);
            $em->flush();
            return $this->redirectToRoute('_affichelivreur');
        }
        return $this->render('@Ecommerce/Livreur/ajout.html.twig', array(
            'form' => $form->createView(),));
    }

    public function UpdateAction(Request $request,$id){

        $em=$this->getDoctrine()->getManager();
        $livreur=$em->getRepository("EcommerceBundle:Livreur")->find($id);
        $Form=$this->createForm(LivreurForm::class,$livreur);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid()){
            $file = $livreur->getImage();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move($this->getParameter('image_directory'), $fileName);
            $livreur->setImage($fileName);
            $em->persist($livreur);
            $em->flush();
            return $this->redirectToRoute('_affichelivreur');
        }

        return $this->render('@Ecommerce/Livreur/update.html.twig',
            array('form'=>$Form->createView()));

    }


    public function DeleteAction(Request $request, $id){
        $Livreur=new Livreur();
        $em=$this->getDoctrine()->getManager();
        $Livreur=$em->getRepository("EcommerceBundle:Livreur")->find($id);
        $em->remove($Livreur);
        $em->flush();
        return $this->redirectToRoute('_affichelivreur');
    }





    public function rechercheAction (Request $request){
        $em=$this->getDoctrine()->getManager();
        $Livreurs=$em->getRepository("EcommerceBundle:Livreur")->findAll();
        if ($request->isMethod('POST')) {
            $nom = $request->get("nom");
            $Livreur=$em->getRepository("EcommerceBundle:Livreur")->findNomDQL($nom);
            return $this->render("@Ecommerce/Livreur/affiche.html.twig", array('p'=>$Livreur));
        }
        return $this->render("@Ecommerce/livreur/recherche.html.twig",
            array('p'=>$Livreurs));
    }



    public function AfficheAction()
    {
        $em=$this->getDoctrine()->getManager();
        $livreur=$em->getRepository('EcommerceBundle:Livreur')->findAll();
        return $this->render('@Ecommerce/livreur/affiche.html.twig',
            array(
                'p'=>$livreur
            ));
    }
    public function Affiche2Action()
    {
        $em=$this->getDoctrine()->getManager();
        $livreur=$em->getRepository('EcommerceBundle:Livreur')->findAll();
        return $this->render('@Ecommerce/Livreur/affichefront.html.twig',
            array(
                'p'=>$livreur
            ));
    }

    public function afficheSingleAction(Request $request,$id,$nom,$prix,$image){
        $em=$this->getDoctrine()->getManager();

        $modele=$em->getRepository('EcommerceBundle:Commentaire')->findAll();
        return $this->render('@Ecommerce/livreur/single.html.twig', array(
            'id'=>$id,'nom' => $nom,'prix' => $prix,'image'=>$image,'m'=>$modele));
    }

    public function afficheCategorieAction ($categorie){
        $em=$this->getDoctrine()->getManager();

        $Livreur=$em->getRepository("EcommerceBundle:Livreur")->findCategorieDQL($categorie);
        return $this->render("@Ecommerce/Livreur/affichefront.html.twig", array('p'=>$Livreur));

    }
}
