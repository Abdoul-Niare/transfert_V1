<?php

namespace App\Repository;

use App\Entity\Transfert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transfert>
 *
 * @method Transfert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transfert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transfert[]    findAll()
 * @method Transfert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransfertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transfert::class);
    }

    public function save(Transfert $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Transfert $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


 /**
    * @return Transfert[] Returns an array of Transfert objects
    */
    public function findByAgentLivreurId($value): array
    {
         $mesTransferts = $this->createQueryBuilder('t')
         ->andWhere('t.agentLivreur = :val or t.agentLivreur is NULL')
         ->setParameter('val', $value)
         ->orderBy('t.id', 'ASC')
         //->setMaxResults(10)
         ->getQuery()
         ->getResult(); 
 
         // $transfertsDispo =  $this->createQueryBuilder('t')
         // ->andWhere('t.agentLivreur is null')
         // ->setParameter('val', NULL)
         // ->orderBy('t.id', 'ASC')
         // ->setMaxResults(10)
         // ->getQuery()
         // ->getResult(); 
 
        return $mesTransferts;
    }
 
     /**
     * @return Transfert[] Returns an array of Transfert objects
     */
     public function findByExpediteurId($value): array
     {
         return $this->createQueryBuilder('t')
             ->andWhere('t.expediteur = :val')
             ->setParameter('val', $value)
             ->orderBy('t.id', 'ASC')
             //->setMaxResults(10)
             ->getQuery()
             ->getResult()
         ;
     }



//    /**
//     * @return Transfert[] Returns an array of Transfert objects
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

//    public function findOneBySomeField($value): ?Transfert
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    // public function findAllExceptDelivered(): array
    // {
        
    // }
}
