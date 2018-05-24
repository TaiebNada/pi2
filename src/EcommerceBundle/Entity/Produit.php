<?php

namespace EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="EcommerceBundle\Repository\ProduitRepository")
 */
class Produit
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
     * @ORM\Column(type="string",length=255)
     *
     */
    private $nom;

    /**
     * @ORM\Column(type="string",length=255)
     *
     */
    private $categorie;


    /**
     * @ORM\Column(type="float")
     *
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $quantiteStock;


    /**
     * @ORM\Column(type="integer")
     *
     */
    private $vente=0;

    /**
     * @ORM\Column(type="float")
     *
     */
    private $rating=0;


    /**
     * @ORM\Column(type="integer")
     *
     */
    private $nombreDeVote=0;


    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product image as a png file.")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $image;


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
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }


    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }



    /**
     * @return mixed
     */


    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */

    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getQuantiteStock()
    {
        return $this->quantiteStock;
    }

    /**
     * @param mixed $quantiteStock
     */
    public function setQuantiteStock($quantiteStock)
    {
        $this->quantiteStock = $quantiteStock;
    }

    /**
     * @return mixed
     */
    public function getVente()
    {
        return $this->vente;
    }

    /**
     * @param mixed $vente
     */
    public function setVente($vente)
    {
        $this->vente = $vente;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getNombreDeVote()
    {
        return $this->nombreDeVote;
    }

    /**
     * @param mixed $nombreDeVote
     */
    public function setNombreDeVote($nombreDeVote)
    {
        $this->nombreDeVote = $nombreDeVote;
    }




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




}

