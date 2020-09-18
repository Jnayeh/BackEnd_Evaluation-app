<?php

namespace App\Repository;

use App\Entity\SatisfactionForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SatisfactionForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method SatisfactionForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method SatisfactionForm[]    findAll()
 * @method SatisfactionForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SatisfactionFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SatisfactionForm::class);
    }

    public function transform(SatisfactionForm $form)
    {
        return [
            'id'    => (int) $form->getId(),
            'date_formation' => (date_format($form->getDateFormaion(),'yy-m-d')) ,
            'Formateur'=> $form->getFormateur()->getPrenom().' '.$form->getFormateur()->getNom(),
            'Formation'=> $form->getFormation()->getTheme(),
            'Participant'=> $form->getParticipant()->getPrenom().' '.$form->getParticipant()->getNom(),
            'telephone'=> $form->getParticipant()->getTel(),
            'email'=> $form->getParticipant()->getMail(),
            'Etablissement'=> $form->getEtablissement()->getNom(),
            'Etablissement_type'=> $form->getEtablissement()->getType(),
            'date_evaluation'=> (date_format($form->getDateEvaluation(),'yy-m-d')) ,
            'Q1'=>$form->getQ1(),
            'Q2'=>$form->getQ2(),
            'Q3'=>$form->getQ3(),
            'Q4'=>$form->getQ4(),
            'Q5'=>$form->getQ5(),
            'Suggestion'=>$form->getSuggestion()
        ];
    }

    public function transformAll()
    {
        $forms = $this->findAll();
        $formsArray = [];

        foreach ($forms as $form) {
            $formsArray[] = $this->transform($form);
        }
        return $formsArray;
    }
    // /**
    //  * @return SatisfactionForm[] Returns an array of SatisfactionForm objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SatisfactionForm
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
