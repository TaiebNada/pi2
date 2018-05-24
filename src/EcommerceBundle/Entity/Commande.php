<?php

namespace EcommerceBundle\Entity;
use UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="EcommerceBundle\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCommande", type="date")
     */
    private $dateCommande;

    /**
     * @var float
     *
     * @ORM\Column(name="Montant", type="float")
     */


    private $montant;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */

    private $listeProduits;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="Utilisateur",referencedColumnName="username")
     * @ORM\Column(type="string")
     */
    private $utilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="ModePaiement", type="string", length=255)
     */
    private $modePaiement;

    /**
     * Commande constructor.
     */
    public function __construct()
    {
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



    /**
     * Set dateCommande
     *
     * @param \DateTime $dateCommande
     *
     * @return Commande
     */
    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    /**
     * Get dateCommande
     *
     * @return \DateTime
     */
    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return Commande
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @return array
     */
    public function getListeProduits()
    {
        return $this->listeProduits;
    }

    /**
     * @param array $listeProduits
     */
    public function setListeProduits($listeProduits)
    {
        $this->listeProduits[] = $listeProduits;
    }

    /**
     * @return mixed
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * @param mixed $utilisateur
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;
    }









    /**
     * Set modePaiement
     *
     * @param string $modePaiement
     *
     * @return Commande
     */
    public function setModePaiement($modePaiement)
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    /**
     * Get modePaiement
     *
     * @return string
     */
    public function getModePaiement()
    {
        return $this->modePaiement;
    }





}

