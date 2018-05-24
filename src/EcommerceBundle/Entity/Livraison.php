<?php

namespace EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livraison
 *
 * @ORM\Table(name="livraison")
 * @ORM\Entity(repositoryClass="EcommerceBundle\Repository\LivraisonRepository")
 */
class Livraison
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
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $nomLivreur='';


    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $nomClient;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $adresseClient;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $regionClient;


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
     * @return string
     */
    public function getNomLivreur()
    {
        return $this->nomLivreur;
    }

    /**
     * @param string $nomLivreur
     * @return Livraison
     */
    public function setNomLivreur($nomLivreur)
    {
        $this->nomLivreur = $nomLivreur;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomClient()
    {
        return $this->nomClient;
    }

    /**
     * @param string $nomClient
     */
    public function setNomClient($nomClient)
    {
        $this->nomClient = $nomClient;
    }

    /**
     * @return string
     */
    public function getAdresseClient()
    {
        return $this->adresseClient;
    }

    /**
     * @param string $adresseClient
     */
    public function setAdresseClient($adresseClient)
    {
        $this->adresseClient = $adresseClient;
    }

    /**
     * @return string
     */
    public function getRegionClient()
    {
        return $this->regionClient;
    }

    /**
     * @param string $regionClient
     */
    public function setRegionClient($regionClient)
    {
        $this->regionClient = $regionClient;
    }



}

