<?php

namespace BienetreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participant
 *
 * @ORM\Table(name="participant")
 * @ORM\Entity(repositoryClass="BienetreBundle\Repository\ParticipantRepository")
 */
class Participant
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
     * @ORM\ManyToOne(targetEntity="BienetreBundle\Entity\evenement", inversedBy="participant")
     * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id")
     */
    private $evenement;

    /**
     * @var integer $participer
     *
     * @ORM\Column(name="participer", type="integer", options={"default" : 0}, nullable=true)
     */
    private $participer;
    /**
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0}, nullable=true)
     */
    private $idutil;


    /**
     * @return mixed
     */
    public function getEvenement()
    {
        return $this->evenement;
    }

    /**
     * @param mixed $evenement
     */
    public function setEvenement($evenement)
    {
        $this->evenement = $evenement;
    }

    /**
     * @return int
     */
    public function getParticiper()
    {
        return $this->participer;
    }

    /**
     * @param int $participer
     */
    public function setParticiper($participer)
    {
        $this->participer = $participer;
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
     * @return mixed
     */
    public function getIdutil()
    {
        return $this->idutil;
    }

    /**
     * @param mixed $Idutil
     */
    public function setIdutil($idutil)
    {
        $this->idutil = $idutil;
    }
}

