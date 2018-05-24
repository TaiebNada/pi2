<?php

namespace Animaux1Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentaireVet
 *
 * @ORM\Table(name="commentaire_vet")
 * @ORM\Entity(repositoryClass="Animaux1Bundle\Repository\CommentaireVetRepository")
 */
class CommentaireVet
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
     * @ORM\Column(name="commentaire", type="string", length=255)
     */
    private $commentaire;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Vet")
     * @ORM\JoinColumn(name="id_vet",referencedColumnName="id")
     */
    private $vet;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;


    /**
     * @return mixed
     */
    public function getVet()
    {
        return $this->vet;
    }

    /**
     * @param mixed $vet
     */
    public function setVet($vet)
    {
        $this->vet = $vet;
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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return CommentaireVet
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

}

