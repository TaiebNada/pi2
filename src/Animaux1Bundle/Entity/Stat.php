<?php

namespace Animaux1Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Zend\Json\Expr;

/**
 * State
 *
 * @ORM\Table(name="stat")
 * @ORM\Entity(repositoryClass="Animaux1Bundle\Repository\StatRepository")
 */
class Stat
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
     * @var int
     *
     * @ORM\Column(name="nbAnimaux", type="integer")
     */
    private $nbAnimaux;
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string")
     */
    private $nom;

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="nbChien", type="integer")
     */
    private $nbChien;

    /**
     * @var int
     *
     * @ORM\Column(name="nbChat", type="integer")
     */
    private $nbChat;

    /**
     * @var int
     *
     * @ORM\Column(name="nbEquide", type="integer")
     */
    private $nbEquide;

    /**
     * @var int
     *
     * @ORM\Column(name="nbNac", type="integer")
     */
    private $nbNac;

    /**
     * @var int
     *
     * @ORM\Column(name="nbPorcin", type="integer")
     */
    private $nbPorcin;

    /**
     * @var int
     *
     * @ORM\Column(name="nbBovin", type="integer")
     */
    private $nbBovin;

    /**
     * @var int
     *
     * @ORM\Column(name="nbOvin", type="integer")
     */
    private $nbOvin;

    /**
     * @var int
     *
     * @ORM\Column(name="nbCaprin", type="integer")
     */
    private $nbCaprin;

    /**
     * @var int
     *
     * @ORM\Column(name="Autre", type="integer")
     */
    private $autre;


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
     * Set nbAnimaux
     *
     * @param integer $nbAnimaux
     *
     * @return Stat
     */
    public function setNbAnimaux($nbAnimaux)
    {
        $this->nbAnimaux = $nbAnimaux;

        return $this;
    }

    /**
     * Get nbAnimaux
     *
     * @return int
     */
    public function getNbAnimaux()
    {
        return $this->nbAnimaux;
    }

    /**
     * Set nbChien
     *
     * @param integer $nbChien
     *
     * @return Stat
     */
    public function setNbChien($nbChien)
    {
        $this->nbChien = $nbChien;

        return $this;
    }

    /**
     * Get nbChien
     *
     * @return int
     */
    public function getNbChien()
    {
        return $this->nbChien;
    }

    /**
     * Set nbChat
     *
     * @param integer $nbChat
     *
     * @return Stat
     */
    public function setNbChat($nbChat)
    {
        $this->nbChat = $nbChat;

        return $this;
    }

    /**
     * Get nbChat
     *
     * @return int
     */
    public function getNbChat()
    {
        return $this->nbChat;
    }

    /**
     * Set nbEquide
     *
     * @param integer $nbEquide
     *
     * @return Stat
     */
    public function setNbEquide($nbEquide)
    {
        $this->nbEquide = $nbEquide;

        return $this;
    }

    /**
     * Get nbEquide
     *
     * @return int
     */
    public function getNbEquide()
    {
        return $this->nbEquide;
    }

    /**
     * Set nbNac
     *
     * @param integer $nbNac
     *
     * @return Stat
     */
    public function setNbNac($nbNac)
    {
        $this->nbNac = $nbNac;

        return $this;
    }

    /**
     * Get nbNac
     *
     * @return int
     */
    public function getNbNac()
    {
        return $this->nbNac;
    }

    /**
     * Set nbPorcin
     *
     * @param integer $nbPorcin
     *
     * @return Stat
     */
    public function setNbPorcin($nbPorcin)
    {
        $this->nbPorcin = $nbPorcin;

        return $this;
    }

    /**
     * Get nbPorcin
     *
     * @return int
     */
    public function getNbPorcin()
    {
        return $this->nbPorcin;
    }

    /**
     * Set nbBovin
     *
     * @param integer $nbBovin
     *
     * @return Stat
     */
    public function setNbBovin($nbBovin)
    {
        $this->nbBovin = $nbBovin;

        return $this;
    }

    /**
     * Get nbBovin
     *
     * @return int
     */
    public function getNbBovin()
    {
        return $this->nbBovin;
    }

    /**
     * Set nbOvin
     *
     * @param integer $nbOvin
     *
     * @return Stat
     */
    public function setNbOvin($nbOvin)
    {
        $this->nbOvin = $nbOvin;

        return $this;
    }

    /**
     * Get nbOvin
     *
     * @return int
     */
    public function getNbOvin()
    {
        return $this->nbOvin;
    }

    /**
     * Set nbCaprin
     *
     * @param integer $nbCaprin
     *
     * @return Stat
     */
    public function setNbCaprin($nbCaprin)
    {
        $this->nbCaprin = $nbCaprin;

        return $this;
    }

    /**
     * Get nbCaprin
     *
     * @return int
     */
    public function getNbCaprin()
    {
        return $this->nbCaprin;
    }

    /**
     * Set autre
     *
     * @param integer $autre
     *
     * @return Stat
     */
    public function setAutre($autre)
    {
        $this->autre = $autre;

        return $this;
    }

    /**
     * Get autre
     *
     * @return int
     */
    public function getAutre()
    {
        return $this->autre;
    }
}

