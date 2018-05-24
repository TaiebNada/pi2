<?php

namespace Animaux1Bundle\Controller;

use Animaux1Bundle\Entity\Demande;
use Animaux1Bundle\Form\DemandeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DemandeController extends Controller
{
    public function ajoutDemandeAction(Request $request)
    {
        $voiture = new Demande();
        $Form = $this->createForm(DemandeType::class, $voiture);
        $Form->handleRequest($request);   //la methode post nouvelle session pr garder ce qui est saisoe ds le form
        if ($Form->isValid()) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $voiture->setMail($user->getEmail());
            $voiture->setDateD(new \DateTime('now'));
            $voiture->setType('Non Traite');
            $file = $voiture->getImage();

            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();


            $file->move($this->getParameter('brochures_directory'), $fileName);

            $voiture->setImage($fileName);

            // $voiture->setImage($request->get('image'));
            $em = $this->getDoctrine()->getManager(); //persist flush entityManager
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('demandeRecu');
        }
        return $this->render('@Animaux1/FrontOffice/Demande/ajoutDemande.html.twig', array('f' => $Form->createView()));

    }
    public function demanderecuAction()
    {

        return $this->render('@Animaux1/FrontOffice/Demande/Message.html.twig');
    }

    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    public function listeDemandeAction()
    {
        $em=$this->getDoctrine()->getManager();
        $id= $this->getUser()->getId();
        $modele=$em->getRepository('Animaux1Bundle:Demande')->findAll();
        return $this->render('@Animaux1/BackOffice/Demande/listeDemande.html.twig',
            array(
                'm'=>$modele
            ));
    }
    public function detailDemandeAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Demande')->findBy( array('id' => $id));
        return $this->render('@Animaux1/BackOffice/Demande/detailDemande.html.twig',
            array(
                'm'=>$modele
            ));
    }
    public function afficheJustificatifAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Demande')->findBy( array('id' => $id));
        return $this->render('@Animaux1/BackOffice/Demande/Justificatif.html.twig',
            array(
                'm'=>$modele
            ));

    }
    public function pdfAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $email = $this->getUser()->getEmail();
        $modele = $em->getRepository('Animaux1Bundle:Demande')->findBy(array("mail" => $email));

        $snappy = $this->get('knp_snappy.pdf');

        $user=$this->getUser();
        $email=$this->getUser()->getEmail();
        $html =
        $this->renderView('@Animaux1/FrontOffice/Demande/pdf.html.twig',array('m'=>$modele,'user'=>$user, 'mail'=>$email));

        $filename = 'MesReclamationsPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }



}