<?php

namespace Animaux1Bundle\Controller;

use Animaux1Bundle\Entity\Animaux;
use Animaux1Bundle\Form\AnimauxType;
use Animaux1Bundle\Form\ProfilAnimalType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Zend\Json\Expr;

class AnimauxController extends Controller
{

    //backOffice
    public function afficheListeAnimauxAction()
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Animaux')->findAll();
        return $this->render('@Animaux1/BackOffice/ListeAnimaux.html.twig',
            array(
                'm'=>$modele
            ));
    }
    //affiche liste client pour un vet / ne9ssa
    public function afficheAnimauxClientAction()
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Animaux')->findAll();
        return $this->render('@Animaux1/FrontOffice/ListeAnimaux.html.twig',
            array(
                'm'=>$modele
            ));
    }
    //affiche carte suivi: client Front
    public function afficheSAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Animaux')->findBy( array('id' => $id));
        return $this->render('@Animaux1/FrontOffice/Animaux/carteSuiviClient.html.twig',
            array(
                'm'=>$modele
            ));
    }
    //affiche carte suivi vet front
    public function afficheSVEtAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Animaux')->findBy( array('id' => $id));
        return $this->render('@Animaux1/FrontOffice/Vet/carteSuiviVet.html.twig',
            array(
                'm'=>$modele
            ));
    }
    //ma liste Animaux front: client
    public function afficheMaListeAction()
    {
        $em=$this->getDoctrine()->getManager();
        $id= $this->getUser()->getId();
        $modele=$em->getRepository('Animaux1Bundle:Animaux')->findBy(array("User_id" => $id));
        return $this->render('@Animaux1/FrontOffice/ListeAnimaux.html.twig',
            array(
                'm'=>$modele
            ));
    }
    public function afficheMaListeVetAction()
    {
        $em=$this->getDoctrine()->getManager();
        $id= $this->getUser()->getId();
        $modele=$em->getRepository('Animaux1Bundle:Animaux')->findBy(array("vet" => $id));
        return $this->render('@Animaux1/FrontOffice/Vet/ListeAnimauxVet.html.twig',
            array(
                'm'=>$modele
            ));
    }

    //affiche profil animal : client front
    public function afficheDetailAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Animaux')->findBy( array('id' => $id));
        return $this->render('@Animaux1/FrontOffice/Animaux/detailAnimal.html.twig',
            array(
                'm'=>$modele
            ));
    }
    //ajout animal: client front
    public function ajoutProfil1Action(Request $request)
    {
        $voiture = new Animaux();
        $Form = $this->createForm(AnimauxType::class, $voiture);
        $Form->handleRequest($request);   //la methode post nouvelle session pr garder ce qui est saisoe ds le form
        if ($Form->isValid()) {
            if ($voiture->getTaille() === null) {
                $voiture->setTaille('100');
            }
            if ($voiture->getPoids() === null) {
                $voiture->setPoids('100');
            }
            /*if ($voiture->getDateVaccin() === null) {
                $voiture->setDateVaccin('');
            }
            if ($voiture->getTaille() === null) {
                $voiture->setTaille('100');
            }*/

            $voiture->setUserId($this->getUser()->getID());
            $file = $voiture->getImage();

             $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();


             $file->move($this->getParameter('brochures_directory'), $fileName);

             $voiture->setImage($fileName);

           // $voiture->setImage($request->get('image'));
            $em = $this->getDoctrine()->getManager(); //persist flush entityManager
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('maListe');
        }

        return $this->render('@Animaux1/FrontOffice/Animaux/AjoutProfil.html.twig', array('f' => $Form->createView()));
    }

    //Ajout VET info: front = Carte suivi
    public function UpdateSuiviAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository("Animaux1Bundle\Entity\Animaux")->find($id);
        $Form=$this->createForm(ProfilAnimalType::class,$modele);
        $Form->handleRequest($request);
        if($Form->isValid()){
            $em->persist($modele);
            $em->flush();
            return $this->redirectToRoute('maListeVet');
        }

        return $this->render('@Animaux1/FrontOffice/Animaux/AjoutSuivi.html.twig',
            array('f'=>$Form->createView()));

    }

    /*public function ajoutAction(Request $request)
    {
        $voiture = new Animaux();
        $Form = $this->createForm(AnimauxType::class, $voiture);
        $Form->handleRequest($request);   //la methode post nouvelle session pr garder ce qui est saisoe ds le form
        if ($Form->isValid()) {
            $file = $voiture->getFile();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();


            $file->move($this->getParameter('app.path.product_images'), $fileName);


            $voiture->setFile($fileName);
            $em = $this->getDoctrine()->getManager(); //persist flush entityManager

            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('liste');
        }

        return $this->render('@Animaux1/BackOffice/AjoutSuiviAnimal.html.twig', array('f' => $Form->createView()));

    }*/

    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    public function supprimerAction(Request $request, $id)
    {
        $voiture = new Animaux();
        $em = $this->getDoctrine()->getManager();
        $voiture = $em->getRepository("Animaux1Bundle\Entity\Animaux")->find($id);
        $em->remove($voiture);
        $em->flush();
        return $this->redirectToRoute('maListe');
    }
    public function supprimerSureAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Animaux')->findBy( array('id' => $id));
        return $this->render('@Animaux1/FrontOffice/Animaux/sureDelete.html.twig',
            array(
                'm'=>$modele
            ));
    }

    public function modifierProfilAction(Request $request,$id){

        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository("Animaux1Bundle\Entity\Animaux")->find($id);
        $Form=$this->createForm(AnimauxType::class,$modele);
        $Form->handleRequest($request);
        if($Form->isValid()){
            $em->persist($modele);
            $em->flush();
            return $this->redirectToRoute('maListe');
        }

        return $this->render('@Animaux1/FrontOffice/Animaux/ModifierProfil.html.twig',
            array('f'=>$Form->createView()));

    }
    public function rechercherAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $voitures = $em->getRepository("Animaux1Bundle:Animaux")->findAll();
        if ($request->isMethod('POST')) {
            $serie = $request->get("nom");
            $voitures = $em->getRepository("Animaux1Bundle\Entity\Animaux")->findBy(array("nom" => $serie));
        }
        return $this->render("@Animaux1/Animaux/recherche.html.twig",
            array('v' => $voitures));
    }

    //stat
   /* public function chartHistogrammeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $classes = new State();
        $animal = $em->getRepository('Animaux1Bundle:Animaux')->findAll();
        $classes->setNom('Animaux');
        foreach ($animal as $animals) {
            $classes->setNbAnimaux($classes->getNbAnimaux() + 1);
            if ($animals->getEspece() == 'Chien') {
                $classes->setNbChien($classes->getNbChien() + 1);
            }
            if ($animals->getEspece() == 'Chat') {
                $classes->setNbChat($classes->getNbChat() + 1);
            }
            if ($animals->getEspece() == 'Cheval') {
                $classes->setNbEquide($classes->getNbEquide() + 1);
            }
            if ($animals->getEspece() == 'Lapin') {
                $classes->setNbNac($classes->getNbNac() + 1);
            }
            if ($animals->getEspece() == 'Oisaux') {
                $classes->setNbPorcin($classes->getNbPorcin() + 1);
            }
            if ($animals->getEspece() == 'Bovin') {
                $classes->setNbBovin($classes->getNbBovin() + 1);
            }
            if ($animals->getEspece() == 'Ovin') {
                $classes->setNbOvin($classes->getNbOvin() + 1);
            }
            if ($animals->getEspece() == 'Caprin') {
                $classes->setNbCaprin($classes->getNbCaprin() + 1);
            }
            if ($animals->getEspece() == 'Autres') {
                $classes->setAutre($classes->getAutre() + 1);
            }
        }
        $categories = array();
        $nbAnimaux = array();
        $nbChien = array();
        $nbChat = array();
        $nbEquidé = array();
        $nbNac = array();
        $nbPorcin = array();
        $nbBovin = array();
        $nbOvin = array();
        $nbCaprin = array();
        $nbAutres = array();
        array_push($categories, $classes->getNom());
        array_push($nbAnimaux, $classes->getNbAnimaux());
        array_push($nbChien, $classes->getNbChien());
        array_push($nbChat, $classes->getNbChat());
        array_push($nbEquidé, $classes->getNbEquide());
        array_push($nbNac, $classes->getNbNac());
        array_push($nbPorcin, $classes->getNbPorcin());
        array_push($nbBovin, $classes->getNbBovin());
        array_push($nbOvin, $classes->getNbOvin());
        array_push($nbCaprin, $classes->getNbCaprin());
        array_push($nbAutres, $classes->getAutre());
        $series = array(array(

            'name' => 'Animaux',
            'type' => 'column',
            'color' => '#4572A7',
            'yAxis' => 0,
            'data' => $nbAnimaux,
        ),
            array('name' => 'Chien',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $nbChien,
            )
        ,
            array('name' => 'Chat',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $nbChat,
            )
        ,
            array('name' => 'Equidé',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $nbEquidé,
            )
        ,
            array('name' => 'Nac',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $nbNac,
            )
        ,
            array('name' => 'Porcin',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $nbPorcin,
            )
        ,
            array('name' => 'Bovin',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $nbBovin,
            )
        ,
            array('name' => 'Ovin',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $nbOvin,
            )
        ,
            array('name' => 'Caprin',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $nbCaprin,
            )
        ,
            array('name' => 'Autres',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $nbAutres,
            )


        );
        $yData = array(array(

            'labels' => array(

                'formatter' => new Expr('function() { return this.value + "" }'),
                'style' => array(
                    'color' => '#4572A7')
            ),
            'gridLineWidth' => 0,
            'title' => array(
                'text' => 'Nombre des Animaux',
                'style' => array('color' => '#4572A7')
            ),
        ),
        );

        $ob = new Highchart();
        $ob->chart->renderTo('container');
        $ob->chart->type('column');
        $ob->title->text('Statistique SOS');
        $ob->xAxis->categories($categories);
        $ob->yAxis($yData);
        $ob->legend->enabled(false);
        $formatter = new Expr('function () {
                    var unit = {
                     "Animaux": "Animaux",
                     "Chien": "Chien",
                     "Chat": "Chat",
                     "Equidé ": "Equidé ",
                     "Nac ": "Nac ",
                     "Porcin": "Porcin",
                     "Bovin": "Bovin",
                     "Ovin": "Ovin",
                     "Caprin": "Caprin",
                     "Caprin": "Caprin",
                     "Autres": "Autres",
                     
                 }[this.series.name];
                 return this.x + ": <b>" + this.y + "</b> " + unit;
             }');
        $ob->tooltip->formatter($formatter);
        $ob->series($series);
        return $this->render('@Graph/Graphe/histogramme.html.twig',
            array(
                'chart' => $ob
            ));
    }*/

}
