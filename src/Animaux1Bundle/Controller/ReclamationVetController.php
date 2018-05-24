<?php

namespace Animaux1Bundle\Controller;

use Animaux1Bundle\Entity\ReclamationVet;
use Animaux1Bundle\Form\ReclamationVetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ReclamationVetController extends Controller
{
    /**
     * @Route("ajoutReclamation")
     */
    public function ajoutReclamationAction(Request $request, $id)
    {
        $voiture = new ReclamationVet();
        $Form = $this->createForm(ReclamationVetType::class, $voiture);
        $Form->handleRequest($request);   //la methode post nouvelle session pr garder ce qui est saisoe ds le form
        if ($Form->isValid()) {


            $voiture->setMail($this->getUser()->getEmail());
            $voiture->setNom($this->getUser());
            $voiture->setIdVet($id);
            $file = $voiture->getImage();

            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();


            $file->move($this->getParameter('brochures_directory'), $fileName);


            $voiture->setImage($fileName);
            $voiture->setDateR(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager(); //persist flush entityManager
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('reclamation');
        }

        return $this->render('@Animaux1/FrontOffice/ReclamationVet/AjoutReclamation.html.twig', array('f' => $Form->createView()));
    }

    public function afficheReclamationFrontAction()
    {
        $em=$this->getDoctrine()->getManager();
        $email= $this->getUser()->getEmail();
        $modele=$em->getRepository('Animaux1Bundle:ReclamationVet')->findBy(array("mail" => $email));
        return $this->render('@Animaux1/FrontOffice/Reclamation/ListeReclamationVet.html.twig',
            array(
                'm'=>$modele
            ));
    }
//liste reclamation: back :admin
    public function afficheListeReclamationAction()
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:ReclamationVet')->findAll();
        return $this->render('@Animaux1/BackOffice/ListeReclamation.html.twig',
            array(
                'm'=>$modele
            ));
    }
    public function afficheRecAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:ReclamationVet')->findBy(array('id' => $id));
        return $this->render('@Animaux1/BackOffice/DetailRec.html.twig',
            array(
                'm'=>$modele
            ));
    }

    public function afficheMsgAction()
    {

        return $this->render('@Animaux1/FrontOffice/ReclamationVet/Message.html.twig');
    }



}
