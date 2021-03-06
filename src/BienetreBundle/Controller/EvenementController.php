<?php

namespace BienetreBundle\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use BienetreBundle\Form\CommentaireEvenementType;
use BienetreBundle\Entity\Mail;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BienetreBundle\Entity\CommentaireEvenement;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use BienetreBundle\Entity\State;
use BienetreBundle\Entity\Evenement;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Tests\Fixtures\ToString;
use Zend\Json\Expr;
use BienetreBundle\Entity\Participant;
use FOS\UserBundle\Model\User as BaseUser;
use BienetreBundle\Form\EvenementForm;
use FOS\UserBundle\Model\User;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints\Date;
class EvenementController extends Controller
{


    public function acceuilAction()
    {   $user=$this->getUser();
        return $this->render('@Bienetre/layout.html.twig',array("user"=>$user));
    }
    public function dashboardAction()
    {   $user=$this->getUser();
        return $this->render('@Bienetre/Evenement/dashboard.html.twig',array("user"=>$user));
    }
    public function AjoutAction(Request $request)
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementForm::class, $evenement);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $file = $evenement->getImageEvenement();

            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();


            $file->move($this->getParameter('brochures_directory'), $fileName);


            $evenement->setImageEvenement($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();

            return $this->redirectToRoute('_afficheevenement2');
        }

        return $this->render('@Bienetre/Evenement/ajout.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    public function UpdateAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository("BienetreBundle:Evenement")->find($id);
        $Form = $this->createForm(EvenementForm::class, $Evenement);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $file = $Evenement->getImageEvenement();

            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();


            $file->move($this->getParameter('brochures_directory'), $fileName);
            $em->persist($Evenement);
            $em->flush();
            return $this->redirectToRoute('_afficheevenement');
        }

        return $this->render('@Bienetre/Evenement/update.html.twig',
            array('form' => $Form->createView()));
    }


    public function ParticiperevenementAction(Request $request, $id)
    {$em = $this->getDoctrine()->getManager();
        $am = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository("BienetreBundle:Evenement")->find($id);
        $userc = $this->getUser();
        $Participant = $am->getRepository("BienetreBundle:Participant")->findOneBy(array('user'=>$userc,'evenement'=>$Evenement));
        if($Participant==null){
        $newParticipant = new Participant();
        $newParticipant->setEvenement($Evenement);

        $newParticipant->setUser($this->getUser());
        $x=1;
        $newParticipant->setParticiper(1);
            $am->persist($newParticipant);
            $am->flush();
        }else
        {
            $Participant->setParticiper(1);
        $am->persist($Participant);
        $am->flush();}





        $Evenement->setNbrParticipant(($Evenement->getNbrParticipant()) + 1);



        $em->persist($Evenement);
        $em->flush();
        return $this->redirectToRoute('_detailevenement', array('id' => $id,'Participant'=>$Participant
        ));
    }



    public function AnnulerevenementAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository("BienetreBundle:Evenement")->find($id);
        $am = $this->getDoctrine()->getManager();


        $userc = $this->getUser();
        $Participant = new Participant();
        $x = 0;
        $Participant = $am->getRepository("BienetreBundle:Participant")->findOneBy(array('user' => $userc, 'evenement' => $Evenement));
        if ($Participant != null) {
            $x = 0;
            $Participant->setParticiper(0);

            $am->persist($Participant);
            $am->flush();
        }
        $Evenement->setNbrParticipant(($Evenement->getNbrParticipant()) - 1);

        $em->persist($Evenement);
        $em->flush();
        return $this->redirectToRoute('_detailevenement', array('id' => $id,'Participant'=>$Participant));

    }

    public function DeleteAction(Request $request, $id)
    {
        $Evenement = new Evenement();
        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository("BienetreBundle:Evenement")->find($id);
        $em->remove($Evenement);
        $em->flush();
        return $this->redirectToRoute('_afficheevenement');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function detailAction(Request $request, $id)
    {
        $Evenement = new Evenement();
        $em = $this->getDoctrine()->getManager();
        $c = $this->getDoctrine()->getManager();
        $Eve = $em->getRepository("BienetreBundle:Evenement")->find($id);
        $Evenement = $em->getRepository("BienetreBundle:Evenement")->find($id);

        $CommentaireEvenement = new CommentaireEvenement();

        $formcommentaire = $this->createForm(CommentaireEvenementType::class, $CommentaireEvenement);
        $formcommentaire->handleRequest($request);
        $am = $this->getDoctrine()->getManager();
        $modele = $am->getRepository("BienetreBundle:CommentaireEvenement")->getCommentsForBlog($id);


        if ($formcommentaire->isValid()) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $CommentaireEvenement->setEvenementA($Eve);
            $CommentaireEvenement->setNomuser($user);
            $CommentaireEvenement->setEmailuser($user->getEmail());
            $c = $this->getDoctrine()->getManager();
            $c->persist($CommentaireEvenement);
            $c->flush();
            $em = $this->getDoctrine()->getManager();
            $Evenement = $em->getRepository("BienetreBundle:Evenement")->find($id);
        }
            $em->persist($Evenement);
            $em->flush();
        $userc = $this->getUser();
        $Participant = new Participant();
        $as = $this->getDoctrine()->getManager();
        $Participant = $as->getRepository("BienetreBundle:Participant")->findOneBy(array('user'=>$userc,'evenement'=>$Evenement));

        return $this->render("@Bienetre/Evenement/affichedetail2.html.twig", array('p' => $Evenement,
                'f' => $formcommentaire->createView(), 'm' => $modele, 'Participant' => $Participant));}



    public function RechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Eve = $em->getRepository("BienetreBundle:Evenement")->findAll();
        if ($request->isMethod('POST')) {
            $nom = $request->get("nom");
            $Eve = $em->getRepository("BienetreBundle:Evenement")->findNomDQL($nom);
            return $this->render("@Bienetre/Evenement/affiche.html.twig", array('p' => $Eve));
        }
        return $this->render("@Bienetre/Evenement/recherche.html.twig",
            array('p' => $Eve));
    }

    public function AfficheAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository('BienetreBundle:Evenement')->findAll();
        return $this->render('@Bienetre/Evenement/affiche.html.twig',
            array(
                'p' => $Evenement
            ));
    }

    public function Affiche2Action()
    {
        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository('BienetreBundle:Evenement')->findAll();
        return $this->render('@Bienetre/Evenement/affiche2.html.twig',
            array(
                'p' => $Evenement
            ));
    }
    public function Afficheancien2Action()
    {$date=new \DateTime();
        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository('BienetreBundle:Evenement')->getancien($date);
        return $this->render('@Bienetre/Evenement/affiche2.html.twig',
            array(
                'p' => $Evenement
            ));
    }
    public function Afficheprochain2Action()
    {$date=new \DateTime();
        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository('BienetreBundle:Evenement')->getprochain($date);
        return $this->render('@Bienetre/Evenement/affiche2.html.twig',
            array(
                'p' => $Evenement
            ));
    }

    public function detailcommentaireAction($id)
    {

        $am = $this->getDoctrine()->getManager();
        $modele = $am->getRepository("BienetreBundle:CommentaireEvenement")->getCommentsForBlog($id);
        return $this->render('@Bienetre/Evenement/affichecommentaireback.html.twig',
            array(
                'm' => $modele, 'ideve' => $id
            ));
    }

    public function chartHistogrammeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $classes = new State();
        $animal = $em->getRepository('BienetreBundle:Evenement')->findAll();
        $classes->setNom('Evenement');
        $j = 0;
        $f = 0;
        $m = 0;
        $a = 0;
        $ma = 0;
        $ju = 0;
        $juillet = 0;
        $aout = 0;
        $sept = 0;
        $oct = 0;
        $nov = 0;
        $dec = 0;
        foreach ($animal as $animals) {
            $moi = $animals->getDateEvenement();
            $mois=$moi->format('m');
            switch ($mois) {
                case 1 :
                    $j++;
                    break;
                case 2:
                    $f++;
                    break;
                case 3:
                    $m++;
                    break;
                case 4:
                    $a++;
                    break;
                case 5:
                    $ma++;
                    break;
                case 6:
                    $ju++;
                    break;
                case 7:
                    $juillet++;
                    break;
                case 8:
                    $aout++;
                    break;
                case 9:
                    $sept++;
                    break;
                case 10:
                    $oct++;
                    break;
                case 11:
                    $nov++;
                    break;
                case 12:
                    $dec++;
                    break;

            }
        }
        $aj = array();
        $af = array();
        $am = array();
        $aa = array();
        $ama = array();
        $aju = array();
        $ajuillet = array();
        $aaout = array();
        $asept = array();
        $aoct = array();
        $anov = array();
        $adec = array();
        $categories = array();
        array_push($categories, $classes->getNom());
        array_push($aj, $j);
        array_push($af, $f);
        array_push($am, $m);
        array_push($aa, $a);
        array_push($ama, $m);
        array_push($aju, $ju);
        array_push($ajuillet, $juillet);
        array_push($aaout, $aout);
        array_push($asept, $sept);
        array_push($aoct, $oct);
        array_push($anov, $nov);
        array_push($adec, $dec);
        $series = array(

            array('name' => 'Janvier',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $aj,
            )
        ,
            array('name' => 'Fevrier',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $af,
            )
        ,
            array('name' => 'Mars',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $am,
            )
        , array('name' => 'Avril',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $aa,
            )
        , array('name' => 'Mai',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $ama,
            )
        , array('name' => 'Juin',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $aju,
            )
        , array('name' => 'Juillet',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $ajuillet,
            )
        , array('name' => 'Aout',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $aaout,
            )
        , array('name' => 'Septembre',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $asept,
            )
        , array('name' => 'Octobre',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $aoct,
            )
        , array('name' => 'Novembre',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $anov,
            )
        , array('name' => 'Decembre',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 0,
                'data' => $adec,
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
                'text' => 'Nombre de Participants',
                'style' => array('color' => '#4572A7')
            ),
        ),
        );

        $ob = new Highchart();
        $ob->chart->renderTo('container');
        $ob->chart->type('column');
        $ob->title->text('Statistique Evenement');
        $ob->xAxis->categories($categories);
        $ob->yAxis($yData);
        $ob->legend->enabled(false);
        $formatter = new Expr('function () {
                    var unit = {
                     "Janvier": "Janvier",
                     "Fevrier": "Fevrier",
                     "Mars": "Mars",
                     "Avril": "Avril",
                     "Mai": "Mai",
                     "Juin": "Juin",
                     "Juillet": "Juillet",
                     "Aout": "Aout",
                     "Septembre": "Septembre",
                     "Octobre": "Octobre",
                     "Novembre": "Novembre",
                     "Decembre": "Decembre",
                     
                 }[this.series.name];
                 return this.x + ": <b>" + this.y + "</b> " + unit;
             }');
        $ob->tooltip->formatter($formatter);
        $ob->series($series);
        return $this->render('@Bienetre/Evenement/statitistique.html.twig', array('chart' => $ob));
    }




    public function indexAction(Request $request, $mailcomm)
    {
        $mail = new Mail();

        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        $message = \Swift_Message::newInstance()
            ->setSubject('Accusé de réception')

            ->setFrom($user->getEmail())
            ->setTo($mailcomm)
            ->setBody(

                'avertissement votre commentaire est inaproprie');
        $this->get('mailer')->send($message);
        return $this->redirect($this->generateUrl('my_app_mail_accusee'));

    }

    public function successaAction()
    {
        return $this->render('@Bienetre/Evenement/succes.html.twig');
    }

    public function AlllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository('BienetreBundle:Evenement')->findAll();
        $normalizer = new GetSetMethodNormalizer();
        $serializer = new Serializer(array(new DateTimeNormalizer('d/m/Y'), $normalizer),[new ObjectNormalizer()]);


        $formatted=$serializer->normalize($Evenement);
        return new JsonResponse($formatted);
    }

    public function AjouttAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement=new Evenement();
        $evenement->setNomEvenement($request->get("nomEvenement"));
        $evenement->setThemeEvenement($request->get("themeEvenement"));

        $evenement->setLieuEvenement($request->get("lieuEvenement"));
        $evenement->setImageEvenement($request->get("imageEvenement"));

        $evenement->setDescriptionEvenement($request->get("descriptionEvenement"));
        $evenement->setNbrMAXParticipant($request->get("nbrMAXParticipant"));
        $evenement->setNbrParticipant($request->get("nbrParticipant"));
        $date=new \DateTime($request->get(('dateEvenement')));
        $evenement->setIdutil($request->get("idutil"));
        $evenement->setDateEvenement($date);
        $em->persist($evenement);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($evenement);
        return new JsonResponse($formatted);
    }
    public function ParticiperrAction(Request $request,$id,$idutil)
    {
     $em = $this->getDoctrine()->getManager();
     $am = $this->getDoctrine()->getManager();
     $Evenement = $em->getRepository("BienetreBundle:Evenement")->find($id);

$Participant = $am->getRepository("BienetreBundle:Participant")->findOneBy(array('idutil'=>$idutil,'evenement'=>$Evenement));
if($Participant==null){
$newParticipant = new Participant();
$newParticipant->setEvenement($Evenement);

$newParticipant->setIdutil($idutil);
$x=1;
$newParticipant->setParticiper(1);
$am->persist($newParticipant);
$am->flush();
}else
    {
        $Participant->setParticiper(1);
        $am->persist($Participant);
        $am->flush();}

$Evenement->setNbrMaxParticipant(($Evenement->getNbrMaxParticipant()) + 1);
$em->persist($Evenement);
$em->flush();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($newParticipant);
        return new JsonResponse($formatted);

}
public function ExisteAction(Request $request,$id,$idutil)
{
    $em = $this->getDoctrine()->getManager();
    $am = $this->getDoctrine()->getManager();
    $Evenement = $em->getRepository("BienetreBundle:Evenement")->find($id);

    $Participant = $am->getRepository("BienetreBundle:Participant")->findOneBy(array('idutil'=>$idutil,'evenement'=>$Evenement));
    if($Participant==null){

         $y=0;
    }

    if($Participant!=null){$y=1;}
    $serializer=new Serializer([new ObjectNormalizer()]);
    $formatted=$serializer->normalize($y);
    return new JsonResponse($formatted);

}
    public function AjouttCommentaireAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $CommentaireEvenement = new CommentaireEvenement();
        $CommentaireEvenement->setComm($request->get("Comm"));

        $Eve = $em->getRepository("BienetreBundle:Evenement")->find($id);
        $CommentaireEvenement->setEvenementA($Eve);
        $CommentaireEvenement->setNomuser($request->get("Nom_user"));
        $CommentaireEvenement->setEmailuser($request->get("Email_user"));

        $CommentaireEvenement->setdateCommentaire($request->get("dateCommentaire"));

        $CommentaireEvenement->setIdutil($request->get("idutil"));
        $em->persist($CommentaireEvenement);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($CommentaireEvenement);
        return new JsonResponse($formatted);
    }
    public function AlllCommentaireAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $am = $this->getDoctrine()->getManager();
        $modele = $am->getRepository("BienetreBundle:CommentaireEvenement")->getCommentsForBlog($id);
        $normalizer = new GetSetMethodNormalizer();
        $serializer = new Serializer(array(new DateTimeNormalizer('d/m/Y'), $normalizer),[new ObjectNormalizer()]);


        $formatted=$serializer->normalize($modele);
        return new JsonResponse($formatted);
    }

    public function CommentaireuserAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $am = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository("BienetreBundle:CommentaireEvenement")->find($id);
        $userc = $this->getUser();
        $Participant = $am->getRepository("BienetreBundle:Participant")->findOneBy(array('user'=>$userc,'evenement'=>$Evenement));
        if($Participant==null){

            $y="0";
        }

        if($Participant!=null){$y="1";}
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($y);
        return new JsonResponse($formatted);

    }
    public function verifsuppAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $am = $this->getDoctrine()->getManager();
        $CommentaireEvenement = $em->getRepository("BienetreBundle:CommentaireEvenement")->findOneBy(array('idutil' => $id)) ;



        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($CommentaireEvenement);
        return new JsonResponse($formatted);

    }

    public function supprimerreveAction(Request $request, $id)
    {



        $em = $this->getDoctrine()->getManager();
        $Evenement = $em->getRepository('BienetreBundle:Evenement')->find($id);


        $em->remove($Evenement);

        $em->flush();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($Evenement);
        return new JsonResponse($formatted);
    }
    public function supprimerrcomAction(Request $request, $id)
    {



        $em = $this->getDoctrine()->getManager();
        $CommentaireEvenement = $em->getRepository('BienetreBundle:CommentaireEvenement')->find($id);


        $em->remove($CommentaireEvenement);

        $em->flush();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($CommentaireEvenement);
        return new JsonResponse($formatted);
    }



}

