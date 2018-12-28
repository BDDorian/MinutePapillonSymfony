<?php

namespace App\Repository;

use App\Entity\ListOfTasks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ListOfTasks|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListOfTasks|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListOfTasks[]    findAll()
 * @method ListOfTasks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListOfTasksRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ListOfTasks::class);
    }

    // /**
    //  * @return ListOfTasks[] Returns an array of ListOfTasks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListOfTasks
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
