<?php

namespace App\Repository;

use App\Entity\Formateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Formateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formateur[]    findAll()
 * @method Formateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formateur::class);
    }

    public function transform(Formateur $formateur)
    {
        return [
            'id'    => (int) $formateur->getId(),
            'nom' => (string) $formateur->getNom(),
            'prenom'=>$formateur->getPrenom(),
            'sexe'=>$formateur->getSexe(),
            'telephone'=>$formateur->getTelephone(),
            'email'=>$formateur->getEmail(),

        ];
    }

    public function transformAll()
    {
        $formateurs = $this->findAll();
        $formateursArray = [];

        foreach ($formateurs as $formateur) {
            $formateursArray[] = $this->transform($formateur);
        }

        return $formateursArray;
    }
    // /**
    //  * @return Formateur[] Returns an array of Formateur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Formateur
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
