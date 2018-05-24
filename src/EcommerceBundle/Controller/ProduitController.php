<?php

namespace EcommerceBundle\Controller;


use EcommerceBundle\Entity\Produit;
use EcommerceBundle\Form\ProduitForm;
use EcommerceBundle\Entity\Commentaire;
use EcommerceBundle\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class ProduitController extends Controller
{private function generateUniqueFileName()
{
    return md5(uniqid());
}


    public function AjoutAction(Request $request){
        $produit = new Produit();
        $form = $this->createForm(ProduitForm::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $produit->getImage();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move($this->getParameter('image_directory'), $fileName);
            $produit->setImage($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('_afficheproduit');
        }
        return $this->render('@Ecommerce/Produit/ajout.html.twig', array(
            'form' => $form->createView(),));
    }

    public function UpdateAction(Request $request,$id){

        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository("EcommerceBundle:Produit")->find($id);
        $Form=$this->createForm(ProduitForm::class,$produit);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid()){
            $file = $produit->getImage();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move($this->getParameter('image_directory'), $fileName);
            $produit->setImage($fileName);
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('_afficheproduit');
        }

        return $this->render('@Ecommerce/Produit/update.html.twig',
            array('form'=>$Form->createView()));

    }


    public function DeleteAction(Request $request, $id){
        $Produit=new Produit();
        $em=$this->getDoctrine()->getManager();
        $Produit=$em->getRepository("EcommerceBundle:Produit")->find($id);
        $em->remove($Produit);
        $em->flush();
        return $this->redirectToRoute('_afficheproduit');
    }





    public function rechercheAction (Request $request){
        $em=$this->getDoctrine()->getManager();
        $Produits=$em->getRepository("EcommerceBundle:Produit")->findAll();
        if ($request->isMethod('POST')) {
            $nom = $request->get("nom");
            $Produit=$em->getRepository("EcommerceBundle:Produit")->findNomDQL($nom);
            return $this->render("@Ecommerce/Produit/affiche.html.twig", array('p'=>$Produit));
        }
        return $this->render("@Ecommerce/Produit/recherche.html.twig",
            array('p'=>$Produits));
    }

    public function ratingAction (Request $request){

        if ($request->isMethod('POST')) {
            $em=$this->getDoctrine()->getManager();
            $id=$request->get("id");

            $r = $request->get("rating");
            $Produit=$em->getRepository("EcommerceBundle:Produit")->find($id);
            $MoyenneRating=(($Produit->getNombreDeVote()*$Produit->getRating())+$r)/($Produit->getNombreDeVote()+1);
            $Produit->setRating($MoyenneRating);
            $Produit->setNombreDeVote($Produit->getNombreDeVote()+1);
            $em->persist($Produit);
            $em->flush();

        }
        return $this->redirectToRoute('_affichefrontproduit');
    }



    public function AfficheAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository('EcommerceBundle:Produit')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $produit, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('@Ecommerce/Produit/affiche.html.twig',
            array(
                'p'=>$pagination
            ));
    }
    public function Affiche2Action(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository('EcommerceBundle:Produit')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $produit, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('@Ecommerce/Produit/affichefront.html.twig',
            array(
                'p'=>$pagination
            ));
    }

    public function afficheSingleAction(Request $request,$id,$nom,$prix,$image,$quantite){
        return $this->render('@Ecommerce/produit/single.html.twig', array(
            'id'=>$id,'nom' => $nom,'prix' => $prix,'image'=>$image,'quantite'=>$quantite));
    }

    public function afficheCategorieAction (Request $request,$categorie){
        $em=$this->getDoctrine()->getManager();

        $Produit=$em->getRepository("EcommerceBundle:Produit")->findCategorieDQL($categorie);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $Produit, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('@Ecommerce/Produit/affichefront.html.twig',
            array(
                'p'=>$pagination
            ));

    }
}
