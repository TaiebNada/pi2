<?php

namespace BoutiqueBundle\Controller;
namespace BoutiqueBundle\Controller;
use BoutiqueBundle\Entity\Mail;
use BoutiqueBundle\Entity\Reclamation;
use BoutiqueBundle\Form\MailType;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\HttpFoundation\Request;
use Swift_Message;
use Symfony\Component\HttpFoundation\Response;


use Symfony\Component\HttpFoundation\Session\Session;




use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Boutique/layout.html.twig');
    }

    public function premail1Action(Request $request)
    {
        $nom = $request->get('nom');
        $email = $request->get('email');
        $id = $request->get('id');

        return $this->render('@Boutique/Dashboard/premail.html.twig',
            array('nom' => $nom, 'email' => $email, 'id' => $id));
    }


    public function loginSessionAction(Request $request)
    {

        //$session = $request->getSession();
        // if($request->isMethod('POST')) {
        //$user = $_POST['user'];
        $user = $request->get('password');

        $password = $request->get('password');
        return $this->render('@Boutique/nada.html.twig',
            array('m' => $user));


    }


    public function nbAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $voitures = $em->getRepository("BoutiqueBundle:Reclamation")->char();


        //$counter=mysql_query("SELECT COUNT(*) AS id FROM discussion Group By titre");
        return $this->render('@Boutique/nada.html.twig',
            array('m' => $voitures));
    }

    public function dashboardAction(Request $request)
    {
        $nom = $this->getUser();
        return $this->render('@Boutique/Dashboard/layout.html.twig', array('nom' => $nom));
    }

    public function reclamationAction()
    {
        return $this->render('@Boutique/Dashboard/reclamation.html.twig');
    }

    public function AfficheAction()
    {
        $em = $this->getDoctrine()->getManager();
        $modele = $em->getRepository('BoutiqueBundle:Reclamation')->findAll();
        return $this->render('@Boutique\Dashboard\reclamation.html.twig',
            array(
                'm' => $modele
            ));
    }


    public function mailAction(Request $request)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($request->get('titre'))
            ->setFrom('send@example.com')
            ->setTo($request->get('sendTo'))
            ->setBody(
                $request->get('sujet'))/*$this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    '@Boutique/nada.html.twig'),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;
        $this->get('mailer')->send($message);

        /* $id=$request->get('id');
         /*$modele=new Reclamation();
         $em=$this->getDoctrine()->getManager();
         $modele=$em->getRepository("BoutiqueBundle:Reclamation")->find($id);
 */


        return $this->render('@Boutique/Dashboard/layout.html.twig',
            array('titre' => $request->get('titre'), 'sendTo' => $request->get('sendTo')));
    }


    public function index1Action(Request $request)
    {
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Accusé de réception')
                ->setFrom('nada.taieb@esprit.tn')
                ->setTo($mail->getEmail())
                ->setBody(
                    $this->renderView(
                        '@Boutique\Default\email.html.twig',
                        array('nom' => $mail->getNom(), 'prenom' => $mail->getPrenom())
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
            return $this->redirect($this->generateUrl('two'));
        }
        return $this->render('@Boutique\Default\index.html.twig',
            array('form' => $form->createView()));
    }


    public function successAction()
    {
        return new Response("email envoyé avec succès, Merci de vérifier votre boite
mail.");
    }


    public function premailAction(Request $request)
    {

        $email = $request->get('email');
        $nom = $request->get('nom');
        $id = $request->get('id');


        $modele = new Reclamation();
        $em = $this->getDoctrine()->getManager();
        $modele = $em->getRepository("BoutiqueBundle:Reclamation")->find($id);
        $modele->setEtat('traite');

        return $this->render('@Boutique\Dashboard\nada.html.twig', array(
            'email' => $email, 'nom' => $nom));

    }


    public function produitsAction()
    {
        return $this->render('@Boutique/produits.html.twig');
    }

    public function singleAction()
    {
        $ima = $this->getUser()->getImage();
        return $this->render('@Boutique/single.html.twig', array(
            'image' => $ima));
    }


    public function nadaAction()
    {
        $user = $this->getUser();
        //return $this->render('Boutique/single2.html.twig',array(
        //'user'=>$user));
        return $this->render('@Boutique/single2.html.twig');
    }


    public function pdfAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $email = $this->getUser()->getEmail();
        $modele = $em->getRepository('BoutiqueBundle:Reclamation')->findBy(array("email" => $email));


        $snappy = $this->get('knp_snappy.pdf');

        $user = $this->getUser();
        $email = $this->getUser()->getEmail();
        $html = $this->renderView('@Boutique/nada1.html.twig', array('m' => $modele, 'user' => $user, 'email' => $email));

        $filename = 'MesReclamationsPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '.pdf"'
            )
        );
    }


    public function statAction()
    {
        //$em = $this->container->get('doctrine')->getEntityManager();
        $em = $this->getDoctrine()->getManager();
        $classes = $em->getRepository('BoutiqueBundle:Reclamation')->findAll();
        $tab = array();
        $categories = array();
        foreach ($classes as $classe) {
            array_push($tab, $classe->getEmail());
            array_push($categories, $classe->getNom());
        }
// Chart
        $series = array(
            array("name" => "Nb étudiants", "data" => $tab)
        );
        $ob = new Highchart();
        $ob->chart->renderTo('linechart'); // #id du div où afficher le graphe
        $ob->title->text('Nombre des étudiants par niveau');
        $ob->xAxis->title(array('text' => "Classe"));
        $ob->yAxis->title(array('text' => "Nb étudiants"));
        $ob->xAxis->categories($categories);
        $ob->series($series);
        return $this->render('@Boutique/Graphe/LineChart.html.twig',
            array(
                'chart' => $ob
            ));

    }



public function EvoyerMailAction (Request $request)
{
    $message = \Swift_Message::newInstance()
        ->setSubject($request->get('titre'))
        ->setFrom('send@example.com')
        ->setTo($request->get('sendTo'))
        ->setBody(
            $request->get('sujet'))/*$this->renderView(
        // app/Resources/views/Emails/registration.html.twig
            '@Boutique/nada.html.twig'),
        'text/html'
    )
    /*
     * If you also want to include a plaintext version of the message
    ->addPart(
        $this->renderView(
            'Emails/registration.txt.twig',
            array('name' => $name)
        ),
        'text/plain'
    )
    */
    ;
    $this->get('mailer')->send($message);

    /* $id=$request->get('id');
     /*$modele=new Reclamation();
     $em=$this->getDoctrine()->getManager();
     $modele=$em->getRepository("BoutiqueBundle:Reclamation")->find($id);
*/


    return $this->render('@Boutique\Dashboard\layout.html.twig',
        array('titre' => $request->get('titre'), 'sendTo' => $request->get('sendTo')));

}

}
