<?php

namespace App\Repository;

use App\Entity\Temoignages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Temoignages>
 *
 * @method Temoignages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temoignages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temoignages[]    findAll()
 * @method Temoignages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemoignagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temoignages::class);
    }
    public function findActive()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.status = :status')
            ->setParameter('status', 1)
            ->getQuery()
            ->getResult();
    }


    public function save(Temoignages $entity, bool $flush = false): void
    {

        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }    
    public function remove(Temoignages $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSortedByStatusAndDate()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.status', 'ASC') // Sort by status in descending order
            ->addOrderBy('t.id', 'DESC') // Assuming you have a 'createdAt' field in your entity
            ->getQuery()
            ->getResult();
    }

    
//    /**
//     * @return Temoignages[] Returns an array of Temoignages objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Temoignages
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
