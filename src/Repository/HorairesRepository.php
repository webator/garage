<?php

namespace App\Repository;

use App\Entity\Horaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Horaires>
 *
 * @method Horaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Horaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Horaires[]    findAll()
 * @method Horaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HorairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Horaires::class);
    }
    public function save(Horaires $entity, bool $flush = false): void
    {

        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }    
    public function remove(Horaires $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



    public function findAllReplaceDays()
    {
        $qb = $this->createQueryBuilder('h');

        return $qb
            ->select('h.id, 
                       CASE 
                          WHEN h.jour = 1 THEN \'Lundi\'
                          WHEN h.jour = 2 THEN \'Mardi\'
                          WHEN h.jour = 3 THEN \'Mercredi\'
                          WHEN h.jour = 4 THEN \'Jeudi\'
                          WHEN h.jour = 5 THEN \'Vendredi\'
                          WHEN h.jour = 6 THEN \'Samedi\'
                          WHEN h.jour = 7 THEN \'Dimanche\'
                          ELSE \'Unknown\'
                       END AS jour,
                       h.tranche')
            ->orderBy('h.jour', 'ASC')         
            ->addOrderBy('h.tranche', 'ASC')
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Horaires[] Returns an array of Horaires objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
    public function findSorted()
    {
        $result = $this->createQueryBuilder('h')
        ->select('h.id, 
            CASE 
                WHEN h.jour = 1 THEN \'Lundi\'
                WHEN h.jour = 2 THEN \'Mardi\'
                WHEN h.jour = 3 THEN \'Mercredi\'
                WHEN h.jour = 4 THEN \'Jeudi\'
                WHEN h.jour = 5 THEN \'Vendredi\'
                WHEN h.jour = 6 THEN \'Samedi\'
                WHEN h.jour = 7 THEN \'Dimanche\'
                ELSE \'Autre\' 
            END as journom,
            h.tranche')
        ->orderBy('h.jour', 'ASC')
        ->addOrderBy('h.tranche', 'ASC')
        ->getQuery()
        ->getResult();
        return $result;
    }
//    public function findOneBySomeField($value): ?Horaires
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
