<?php

namespace App\Repository;

use App\Entity\Projet;
use App\Validator\Deadline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projet>
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }
   /* public function findProjectsWithUpcomingDeadlines(Projet $projet)
    {
        $now = new \DateTime();
        $upcoming = $now->modify('-7 days');

        if ($upcoming == $projet->getDeadline()) {
            return $projet->getId();
        }
    }*/












    /**
     * @return Projet[] Returns an array of Projet objects
     */
    public function findProjetsDeadline($dn): array
    {
        return $this->createQueryBuilder('p')
            ->where("p.suivi='en cours'")
            ->andWhere("p.deadline<=:dn")
            ->setParameter('dn', $dn)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Projet
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
