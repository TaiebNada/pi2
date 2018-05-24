<?php

namespace Animaux1Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;






/**
 * Animaux
 *
 * @ORM\Table(name="animaux")
 * @ORM\Entity(repositoryClass="Animaux1Bundle\Repository\AnimauxRepository")

 */
class Animaux
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
     * @ORM\Column(name="race", type="string", length=255)
     */
    private $race;

    /**
     * @var string
     *
     * @ORM\Column(name="espece", type="string", length=255)
     */
    private $espece;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     */
    private $sexe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $dateNaissance;

    /**
    * @var string
    *
    * @ORM\Column(name="description",type="string",length=255)
    */
    private $description;
    /**
     * @var integer
     *
     * @ORM\Column(name="taille", type="integer")
     */
    private $taille;
    /**
     * @var integer
     *
     * @ORM\Column(name="poids", type="integer")
     */
    private $poids;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateVisiteD", type="date",nullable=true)
     */
    private $dateVisiteD;
    /**
     * @var \DateTime     *
     * @ORM\Column(name="dateVaccin", type="date",nullable=true)
     */
    private $dateVaccin;
    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Vet")
     * @ORM\JoinColumn(name="id_vet",referencedColumnName="id")
     */
    private $vet;



    /**
     * @ORM\Column(type="string",name="image")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="User_id", type="integer")
     */
    private $User_id;



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
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $imageanimal
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
     * @return Animaux
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
     * Set race
     *
     * @param string $race
     *
     * @return Animaux
     */
    public function setRace($race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get race
     *
     * @return string
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set espece
     *
     * @param string $espece
     *
     * @return Animaux
     */
    public function setEspece($espece)
    {
        $this->espece = $espece;

        return $this;
    }

    /**
     * Get espece
     *
     * @return string
     */
    public function getEspece()
    {
        return $this->espece;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Animaux
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Animaux
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }
    /**
     * Set dateVaccin
     *
     * @param \DateTime|null $dateVaccin
     */
    public function setDateVaccin(\DateTime $dateVaccin = null)
    {
        $this->dateVaccin = $dateVaccin ? clone $dateVaccin : null;
    }

    /**
     * Get dateVaccin
     *
     * @return \DateTime|null
     */
    public function getDateVaccin()
    {
        return $this->dateVaccin ? clone $this->dateVaccin : null;
    }

    /**
     * Set dateVisiteD
     *
     * @param \DateTime|null $dateVisiteD
     */
    public function setDateVisiteD(\DateTime $dateVisiteD = null)
    {
        $this->dateVisiteD = $dateVisiteD ? clone $dateVisiteD : null;
    }

    /**
     * Get dateVisiteD
     *
     * @return \DateTime|null
     */
    public function getDateVisiteD()
    {
        return $this->dateVisiteD ? clone $this->dateVisiteD : null;
    }


    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->User_id;
    }

    /**
     * @param int $User_id
     */
    public function setUserId($User_id)
    {
        $this->User_id = $User_id;
    }





    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * @param int $taille
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;
    }

    /**
     * @return int
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     * @param int $poids
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;
    }











}

