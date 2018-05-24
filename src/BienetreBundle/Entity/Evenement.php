<?php

namespace BienetreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="BienetreBundle\Repository\EvenementRepository")
 */
class Evenement
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nomEvenement;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $themeEvenement;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $lieuEvenement;
    /**
* @ORM\Column(name="dateEvenement", type="datetime")
* @Assert\NotBlank()
*/
    private $dateEvenement;

    /**
     * @ORM\Column(name="heureEvenement", type="datetime")
     * @Assert\NotBlank()
     */
    private $heureEvenement;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $imageEvenement;

    /**
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0}, nullable=true)
     */
    private $nbr_participant;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */

    private $nbrMAX_participant;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $descriptionEvenement;
    /**
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0}, nullable=true)
     */
    private $idutil;
    /**
     * @return mixed
     */
    public function getNbrParticipant()
    {
        return $this->nbr_participant;
    }

    /**
     * @param mixed $nbr_participant
     */
    public function setNbrParticipant($nbr_participant)
    {
        $this->nbr_participant = $nbr_participant;
    }


    /**
     * @return int
     */
    public function getNbrMAXParticipant()
    {
        return $this->nbrMAX_participant;
    }

    /**
     * @param int $nbrMAX_participant
     */
    public function setNbrMAXParticipant($nbrMAX_participant)
    {
        $this->nbrMAX_participant = $nbrMAX_participant;
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
     * Set nomEvenement
     *
     * @param string $nomEvenement
     *
     * @return Evenement
     */
    public function setNomEvenement($nomEvenement)
    {
        $this->nomEvenement = $nomEvenement;

        return $this;
    }

    /**
     * Get nomEvenement
     *
     * @return string
     */
    public function getNomEvenement()
    {
        return $this->nomEvenement;
    }

    /**
     * Set themeEvenement
     *
     * @param string $themeEvenement
     *
     * @return Evenement
     */
    public function setThemeEvenement($themeEvenement)
    {
        $this->themeEvenement = $themeEvenement;

        return $this;
    }

    /**
     * Get themeEvenement
     *
     * @return string
     */
    public function getThemeEvenement()
    {
        return $this->themeEvenement;
    }

    /**
     * Set lieuEvenement
     *
     * @param string $lieuEvenement
     *
     * @return Evenement
     */
    public function setLieuEvenement($lieuEvenement)
    {
        $this->lieuEvenement = $lieuEvenement;

        return $this;
    }

    /**
     * Get lieuEvenement
     *
     * @return string
     */
    public function getLieuEvenement()
    {
        return $this->lieuEvenement;
    }

    /**
     * @return string
     */
    public function getHeureEvenement()
    {
        return $this->heureEvenement;
    }

    /**
     * @param string $heureEvenement
     */
    public function setHeureEvenement($heureEvenement)
    {
        $this->heureEvenement = $heureEvenement;
    }

    /**
     * @return string
     */
    public function getDateEvenement()
    {
        return $this->dateEvenement;
    }

    /**
     * @param string $dateEvenement
     */
    public function setDateEvenement($dateEvenement)
    {
        $this->dateEvenement = $dateEvenement;
    }



    public function setImageEvenement($imageEvenement)
    {
        $this->imageEvenement = $imageEvenement;

        return $this;
    }


    public function getImageEvenement()
    {
        return $this->imageEvenement;
    }

    /**
     * Set descriptionEvenement
     *
     * @param string $descriptionEvenement
     *
     * @return Evenement
     */
    public function setDescriptionEvenement($descriptionEvenement)
    {
        $this->descriptionEvenement = $descriptionEvenement;

        return $this;
    }

    /**
     * Get descriptionEvenement
     *
     * @return string
     */
    public function getDescriptionEvenement()
    {
        return $this->descriptionEvenement;
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

