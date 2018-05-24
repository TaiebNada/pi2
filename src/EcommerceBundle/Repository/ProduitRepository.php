<?php
/**
 * Created by PhpStorm.
 * User: Nada
 * Date: 05/12/2017
 * Time: 09:52
 */

namespace EcommerceBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ProduitRepository extends EntityRepository
{public function findArray($array)
{
    $qb = $this->createQueryBuilder('u')
        ->select('u')
        ->where('u.id IN (:array)')
        ->setParameter('array', $array);
    return $qb->getQuery()->getResult();
}



    public function findNomDQL($nom){
        $query= $this->getEntityManager()
            ->createQuery("select m from EcommerceBundle:Produit m where m.nom=:N OR m.prix=:N")->setParameter('N',$nom);
        return $query->getResult();
    }

    public function findCategorieDQL($categorie){
        $query= $this->getEntityManager()
            ->createQuery("select m from EcommerceBundle:Produit m where m.categorie=:N")->setParameter('N',$categorie);
        return $query->getResult();
    }



}