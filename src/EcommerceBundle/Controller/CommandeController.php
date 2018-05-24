<?php


namespace EcommerceBundle\Controller;
use Doctrine\ORM\Mapping\Id;
use EcommerceBundle\EcommerceBundle;
use EcommerceBundle\Entity\Livraison;
use FOS\UserBundle\Model\UserInterface;
use EcommerceBundle\Entity\Produit;
use MailBundle\Entity\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EcommerceBundle\Entity\Commande;


class CommandeController extends Controller
{
    public function commandeAction(Request $request)
    {
        $session=$request->getSession();
        //$session->remove('panier');
        //die();
        if(!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier');
        $em=$this->getDoctrine()->getManager();
        $produits=$em->getRepository('EcommerceBundle:Produit')->findArray(array_keys($session->get('panier')));

        $commande=new Commande();
        $livraison=new Livraison();


        if($request->isMethod('POST'))
        { $mail = new Mail();
            $user=$this->container->get('security.token_storage')->getToken()->getUser();
            $message = \Swift_Message::newInstance()
                ->setSubject('Accusé de réception')
                ->setFrom('admin@gmail.com')
                ->setTo('miropodolski77@gmail.com')
                ->setBody(
                    "Votre commande a ete effectué avec succes"
                );

            $this->get('mailer')->send($message);
            $commande->setDateCommande(new \DateTime());

            $commande->setUtilisateur($request->get('idConnecte'));
            $commande->setModePaiement($request->get('optradio'));
            $commande->setMontant($request->get('montant'));
            foreach ($produits as $p)
            {if ($panier[$p->getId()]>=$p->getQuantiteStock()) {$x=0;}
              else {$x=$p->getQuantiteStock()-$panier[$p->getId()];}
              $p->setVente($p->getVente()+$panier[$p->getId()]);
            $p->setQuantiteStock($x);
                $pNom=$p->getNom();
            $a=array();
                array_push($a,$pNom);
                $commande->setListeProduits($a);}
            $em3=$this->getDoctrine()->getManager();
            $livreur=$em3->getRepository("EcommerceBundle:Livreur")->findRegionDQL($request->get('region'));
                $livraison->setNomClient($request->get('idConnecte'));
            $livraison->setAdresseClient($request->get('addresse'));
            $livraison->setRegionClient($request->get('region'));
            $livraison->setNomLivreur($livreur[0]->getNom());


            $em=$this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();
            $em1=$this->getDoctrine()->getManager();
            $em1->persist($livraison);
            $em1->flush();


        }
        $Latitudes='36.8';
        $Longitudes='10.2';





        return $this->render('@Ecommerce/Commande/checkout.html.twig',array('produits'=>$produits,
            'panier'=> $session->get('panier') ,'Latitudes'=>$Latitudes,'Longitudes'=>$Longitudes));
    }





}