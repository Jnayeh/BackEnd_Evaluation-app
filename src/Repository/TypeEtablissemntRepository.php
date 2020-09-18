<?php

namespace App\Repository;

use App\Entity\TypeEtablissemnt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeEtablissemnt|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeEtablissemnt|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeEtablissemnt[]    findAll()
 * @method TypeEtablissemnt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeEtablissemntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeEtablissemnt::class);
    }
    public function transform(TypeEtablissemnt $typeEtablissement)
    {
        return [
            'id'    => (int) $typeEtablissement->getId(),
            'type'=>(String)$typeEtablissement->getType()
        ];
    }

    public function transformAll()
    {
        $typeEtablissemnts = $this->findAll();
        $typeEtablissementsArray = [];

        foreach ($typeEtablissemnts as $typeEtablissemnt) {
            $typeEtablissementsArray[] = $this->transform($typeEtablissemnt);
        }

        return $typeEtablissementsArray;
    }

    // /**
    //  * @return TypeEtablissemnt[] Returns an array of TypeEtablissemnt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeEtablissemnt
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
