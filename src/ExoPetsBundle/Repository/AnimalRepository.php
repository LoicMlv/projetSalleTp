<?php

namespace ExoPetsBundle\Repository;

use Doctrine\ORM\Query\Expr;

/**
 * AnimalRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnimalRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByNomApproximatif($souschaine){
        $qB = $this->createQueryBuilder('a');
        $qB->select('a')
            ->where($qB->expr()->like('a.nom', $qB->expr()->literal('%'.$souschaine.'%')));
        return $qB->getQuery()->getResult();

    }

    public function findAnimalLourd($poids){
        $qB = $this->createQueryBuilder('a');
        $qB->where('a.poids >= :poids')
            ->setParameter('poids',$poids);
        return $qB->getQuery()->getResult();
    }

    public function findCPoidsMin(){
        $qB = $this->createQueryBuilder('a');
        $qB->select('a')
            ->orderBy('a.poids', 'asc')
            ->setMaxResults(1);
        return $qB->getQuery()->getResult();
   }

    public function doubler(){
        $query = $this->getEntityManager()->createQuery("UPDATE ExoPetsBundle:Animal a SET a.poids = a.poids + a.poids");
        $query->execute();
    }
}
