<?php

namespace Animaux1Bundle\Controller;

use Animaux1Bundle\Entity\Demande;
use Animaux1Bundle\Entity\MailVet;
use Animaux1Bundle\Entity\Vet;
use Animaux1Bundle\Form\MailVetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\SwiftmailerBundle;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MailVetController extends Controller
{
    /*  public function indexAction(Request $request)
      {
          $mail = new MailVet();
          $form= $this->createForm(MailVetType::class, $mail);
          $form->handleRequest($request) ;
          if ($form->isValid()) {
              $message = \Swift_Message::newInstance()
                  ->setSubject('Accusé de réception')
                  ->setFrom($this->getUser()->getEmail())
                  //->setFrom('espritplus2017@gmail.com')
                  ->setTo('riia.vision@gmail.com')
                  ->setBody(
                      $this->renderView(
                          '@Animaux1/FrontOffice/mail/email.html.twig',

                          array('nom' => $mail->getNom(), 'prenom'=>$mail->getPrenom())

                      ),
                      'text/html'

                  );
              $this->get('mailer')->send($message);
              return $this->redirect($this->generateUrl('my_app_mail_accuse'));
          }
          return $this->render('@Animaux1/FrontOffice/mail/index.html.twig',
              array('form'=>$form->createView()));
      }

      public function successAction(){
          return new Response("email envoyé avec succès, Merci de vérifier votre boite mail.");
      }*/

    public function mailAction(Request $request,$mailR)
    {
        /* $message = \Swift_Message::newInstance()
             ->setSubject($request->get('titre'))
             ->setFrom('riia.vision@gmail.com')
             ->setTo($request->get('sendTo'))
             ->setBody(
                 $request->get('sujet'));
         $this->get('mailer')->send($message);

         return $this->render('@Animaux1/FrontOffice/mail/premail.html.twig',
             array('titre'=>$request->get('titre'),'sendTo'=>$request->get('sendTo')));*/
        $mail = new MailVet();
        $form= $this->createForm(MailVetType::class, $mail);
        $form->handleRequest($request) ;
        if ($form->isValid()) {

            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $mail->setEmail($mailR);
            /**
             * @var $user User
             */
            $message = \Swift_Message::newInstance()
                ->setSubject('Accusé de réception')
                ->setFrom($user->getEmail())
                ->setTo($mailR)
                ->setBody($this->renderView(
                    '@Animaux1/FrontOffice/mail/email.html.twig',
                    array('nom' => $mail->getNom(), 'prenom'=>$mail->getPrenom(),'text'=>$request->get('text'))
                ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
            return $this->redirect($this->generateUrl('my_app_mail_accuse'));
        }
        return $this->render('@Animaux1/FrontOffice/mail/index.html.twig',
            array('form'=>$form->createView()));
    }


    public function successAction()
    {
        //return new Response("email envoyé avec succès, Merci de vérifier votre boite mail.");
        return $this->render('@Animaux1/FrontOffice/mail/MailRecu.html.twig');
    }
    public function mailClientAction(Request $request,$mailR)
    {
        /* $message = \Swift_Message::newInstance()
             ->setSubject($request->get('titre'))
             ->setFrom('riia.vision@gmail.com')
             ->setTo($request->get('sendTo'))
             ->setBody(
                 $request->get('sujet'));
         $this->get('mailer')->send($message);

         return $this->render('@Animaux1/FrontOffice/mail/premail.html.twig',
             array('titre'=>$request->get('titre'),'sendTo'=>$request->get('sendTo')));*/
        $mail = new MailVet();
        $form= $this->createForm(MailVetType::class, $mail);
        $form->handleRequest($request) ;
        if ($form->isValid()) {

            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $mail->setEmail($mailR);
            /**
             * @var $user User
             */
            $message = \Swift_Message::newInstance()
                ->setSubject('Accusé de réception')
                ->setFrom($user->getEmail())
                ->setTo($mailR)
                ->setBody($this->renderView(
                    '@Animaux1/BackOffice/mail/email.html.twig',
                    array('nom' => $mail->getNom(), 'prenom'=>$mail->getPrenom(),'text'=>$request->get('text'))
                ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
            return $this->redirect($this->generateUrl('my_app_mail_accuse1'));
        }
        return $this->render('@Animaux1/BackOffice/mail/index.html.twig',
            array('form'=>$form->createView()));
    }
    public function successBackAction()
    {
        //return new Response("email envoyé avec succès, Merci de vérifier votre boite mail.");
        return $this->render('@Animaux1/BackOffice/mail/MailRecu.html.twig');
    }
//repondre demande
    public function repondreDemandeAction(Request $request,$mailR)
    {
        //$demande=new Demande();
        $vet=new Vet();
        $mail = new MailVet();
        $form= $this->createForm(MailVetType::class, $mail);

        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('Animaux1Bundle:Demande')->findOneBy(array('mail'=>$mailR));

        $form->handleRequest($request) ;
        if ($form->isValid()) {

            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $mail->setEmail($mailR);

            $modele->setType('Traité');
            $em->persist($modele);
            $em->flush();
            /**
             * @var $user User
             */
            $message = \Swift_Message::newInstance()
                ->setSubject('Accusé de réception')
                ->setFrom($user->getEmail())
                ->setTo($mailR)
                ->setBody($this->renderView(
                    '@Animaux1/BackOffice/mail/email.html.twig',
                    array('nom' => $mail->getNom(), 'prenom'=>$mail->getPrenom(),'text'=>$request->get('text'))
                ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
            return $this->redirect($this->generateUrl('my_app_mail_accuse2'));
        }
        return $this->render('@Animaux1/BackOffice/mail/index.html.twig',
            array('form'=>$form->createView()));
    }
    public function successDemandeAction()
    {
        //return new Response("email envoyé avec succès, Merci de vérifier votre boite mail.");
        return $this->render('@Animaux1/BackOffice/mail/DemandeMailRecu.html.twig');
    }
}



