<?php

namespace BienetreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;



use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * CommentaireEvenement
 *
 * @ORM\Table(name="commentaire_evenement")
 * @ORM\Entity(repositoryClass="BienetreBundle\Repository\CommentaireEvenementRepository")
 */
class CommentaireEvenement
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
     * @var string
     *
     * @ORM\Column(name="comm", type="string", length=255)
     */
    private $comm;
    /**
     * @var string
     *
     * @ORM\Column(name="nomuser", type="string", length=255)
     */
    private $nomuser;
    /**
     * @var string
     *
     * @ORM\Column(name="emailuser", type="string", length=255)
     */
    private $emailuser;
    /**
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0}, nullable=true)
     */
    private $idutil;
    /**
     * @return mixed
     */
    public function getNomuser()
    {
        return $this->nomuser;
    }

    /**
     * @param mixed $nomuser
     */
    public function setNomuser($nomuser)
    {
        $this->nomuser = $nomuser;
    }

    /**
     * @return mixed
     */
    public function getEmailuser()
    {
        return $this->emailuser;
    }

    /**
     * @param mixed $emailuser
     */
    public function setEmailuser($emailuser)
    {
        $this->emailuser = $emailuser;
    }

    /**
     * @ORM\Column(name="dateCommentaire", type="datetime")
     * @Assert\NotBlank()
     */
    private $dateCommentaire;

    /**
     * @return string
     */
    public function getdateCommentaire()
    {
        return $this->dateCommentaire;
    }

    /**
     * @param string $dateCommentaire
     */
    public function setdateCommentaire($dateCommentaire)
    {
        $this->dateCommentaire = new \DateTime();
    }




    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumn(name="ss",referencedColumnName="id")
     */
    private $EvenementA;

    /**
     * @return mixed
     */
    public function getEvenementA()
    {
        return $this->EvenementA;
    }

    /**
     * @param mixed $Evenement
     */
    public function setEvenementA($EvenementA)
    {
        $this->EvenementA = $EvenementA;
    }

    /**
     * @return string
     */
    public function getComm()
    {
        return $this->comm;
    }

    /**
     * @param string $comm
     */
    public function setComm($comm)
    {
        $this->comm = $comm;
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

