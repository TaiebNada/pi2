<?php
/**
 * Created by PhpStorm.
 * User: Nada
 * Date: 05/12/2017
 * Time: 09:52
 */

namespace BienetreBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EvenementRepository extends EntityRepository
{

    public function findNomDQL($nom){
        $query= $this->getEntityManager()
            ->createQuery("select m from BienetreBundle:Evenement m where m.nomEvenement=:N OR m.themeEvenement=:N 
OR m.lieuEvenement=:N OR m.themeEvenement=:N

")->setParameter('N',$nom);
        return $query->getResult();
    }
public function getancien($date){
    $qb = $this->createQueryBuilder('c')
        ->select('c')
        ->where('c.dateEvenement < :ss')
        ->addOrderBy('c.dateEvenement')
        ->setParameter('ss', $date);



    return $qb->getQuery()
        ->getResult();

}
public function getprochain($date){
    $qb = $this->createQueryBuilder('c')
        ->select('c')
        ->where('c.dateEvenement > :ss')
        ->addOrderBy('c.dateEvenement')
        ->setParameter('ss', $date);



    return $qb->getQuery()
        ->getResult();

}


}