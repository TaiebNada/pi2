<?php

namespace BienetreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table(name="state")
 * @ORM\Entity(repositoryClass="BienetreBundle\Repository\StatRepository")
 */
class State
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
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="nbParticipant", type="integer")
     */
    private $nbParticipant;

    /**
     * @var int
     *
     * @ORM\Column(name="nbMax", type="integer")
     */
    private $nbMax;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return State
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nbParticipant
     *
     * @param integer $nbParticipant
     *
     * @return State
     */
    public function setNbParticipant($nbParticipant)
    {
        $this->nbParticipant = $nbParticipant;

        return $this;
    }

    /**
     * Get nbParticipant
     *
     * @return int
     */
    public function getNbParticipant()
    {
        return $this->nbParticipant;
    }

    /**
     * Set nbMax
     *
     * @param integer $nbMax
     *
     * @return State
     */
    public function setNbMax($nbMax)
    {
        $this->nbMax = $nbMax;

        return $this;
    }

    /**
     * Get nbMax
     *
     * @return int
     */
    public function getNbMax()
    {
        return $this->nbMax;
    }
}

