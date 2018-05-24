<?php

namespace EcommerceBundle\Controller;

use Composer\DependencyResolver\Request;
use EcommerceBundle\Entity\Livraison;
use EcommerceBundle\Form\LivraisonForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LivraisonController extends Controller
{



    public function DeleteAction(Request $request, $id){
        $Livraison=new Livraison();
        $em=$this->getDoctrine()->getManager();
        $Livraison=$em->getRepository("EcommerceBundle:Livraison")->find($id);
        $em->remove($Livraison);
        $em->flush();
        return $this->redirectToRoute('_affichelivraison');
    }





    public function rechercheAction (Request $request){
        $em=$this->getDoctrine()->getManager();
        $Livraisons=$em->getRepository("EcommerceBundle:Livraison")->findAll();
        if ($request->isMethod('POST')) {
            $nom = $request->get("nom");
            $Livraison=$em->getRepository("EcommerceBundle:Livraison")->findNomDQL($nom);
            return $this->render("@Ecommerce/Livraison/affiche.html.twig", array('p'=>$Livraison));
        }
        return $this->render("@Ecommerce/Livraison/recherche.html.twig",
            array('p'=>$Livraisons));
    }



    public function AfficheAction()
    {
        $em=$this->getDoctrine()->getManager();
        $livraison=$em->getRepository('EcommerceBundle:Livraison')->findAll();
        return $this->render('@Ecommerce/Livraison/affiche.html.twig',
            array(
                'p'=>$livraison
            ));
    }
}
