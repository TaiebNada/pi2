<?php

namespace Animaux1Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


use Symfony\Component\HttpFoundation\File\File;

/**
 * ReclamationVet
 *
 * @ORM\Table(name="reclamation_vet")
 * @ORM\Entity(repositoryClass="Animaux1Bundle\Repository\ReclamationVetRepository")

 */
class ReclamationVet
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;


    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var integer
     *
     * @ORM\Column(name="mobile", type="integer")
     */
    private $mobile;

    /**
     * @var integer
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;
    /**
     * @var integer
     *
     * @ORM\Column(name="id_vet")
     */
    private $id_vet;
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $image;

    /**
     * @var date
     *
     * @ORM\Column(name="DateR", type="datetime")
     */
    private $DateR;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
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
     * Set nom
     *
     * @param string $nom
     *
     * @return ReclamationVet
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
     * Set mail
     *
     * @param string $mail
     *
     * @return ReclamationVet
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return ReclamationVet
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return ReclamationVet
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return ReclamationVet
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return date
     */
    public function getDateR()
    {
        return $this->DateR;
    }

    /**
     * @param date $DateR
     */
    public function setDateR($DateR)
    {
        $this->DateR = $DateR;
    }

    /**
     * @return int
     */
    public function getIdVet()
    {
        return $this->id_vet;
    }

    /**
     * @param int $id_vet
     */
    public function setIdVet($id_vet)
    {
        $this->id_vet = $id_vet;
    }



    /**
     * @ORM\Column(name="imageR", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $imageR;




    public function setImageR($image)
    {
        $this->imageR = $image;
    }

    public function getImageR()
    {
        return $this->imageR;
    }



}

