<?php

namespace Animaux1Bundle\Controller;

use Animaux1Bundle\Entity\ProfilAnimal;
use Animaux1Bundle\Entity\Animaux;
use Animaux1Bundle\Form\ProfilAnimalType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProfilAnimalController extends Controller
{
    /**
     * @Route("/ajoutProfil")
     */
    public function ajoutProfilAction(Request $request)
    {
        $voiture = new ProfilAnimal();
        $Form = $this->createForm(ProfilAnimalType::class, $voiture);
        $Form->handleRequest($request);   //la methode post nouvelle session pr garder ce qui est saisoe ds le form
        if ($Form->isValid()) {

           $voiture->setUserId($this->getUser()->getID());
            $file = $voiture->getImageprofil();

            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();


            $file->move($this->getParameter('brochures_directory'), $fileName);


            $voiture->setImageprofil($fileName);
            $em = $this->getDoctrine()->getManager(); //persist flush entityManager
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('maListe');
        }

        return $this->render('@Animaux1/FrontOffice/Animaux/AjoutProfil.html.twig', array('f' => $Form->createView()));
    }

}
