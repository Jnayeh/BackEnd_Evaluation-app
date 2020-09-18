<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Participant;
use App\Entity\SatisfactionForm;
use App\Repository\EtablissementRepository;
use App\Repository\FormateurRepository;
use App\Repository\FormationRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SatisfactionFormRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * @Route("/satisfaction/forms")
 */
class SatisfactionFormController extends ApiController
{
    /**
     * @Route("/", name="satisfaction_form_index", methods={"GET"})
     * @param SatisfactionFormRepository $satisfactionFormRepository
     * @return JsonResponse
     */
    public function index(SatisfactionFormRepository $satisfactionFormRepository)
    {
        $satisfactionForms = $satisfactionFormRepository->transformAll();

        return $this->respond($satisfactionForms);
    }

    /**
     * @Route("/add", methods="POST")
     * @param Request $request
     * @param SatisfactionFormRepository $SFRepository
     * @param ParticipantRepository $PRepository
     * @param FormationRepository $formationRepository
     * @param FormateurRepository $formateurRepository
     * @param EtablissementRepository $etablissementRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function create(Request $request, SatisfactionFormRepository $SFRepository,ParticipantRepository $PRepository, FormationRepository $formationRepository, FormateurRepository $formateurRepository, EtablissementRepository $etablissementRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);
        if (!$request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the name
        if (!$request->get('nomParticipant')) {
            return $this->respondValidationError('Please provide a name!');
        }

//        $normalizers= [new ObjectNormalizer(),new ArrayDenormalizer()];
//        $encoders = [new JsonEncoder()];
//        $serializer= new Serializer($normalizers ,$encoders );
//        $formation =new Formation();
//        $serializer->denormalize($formation,Formation::class,'',$request->get('formation'));
//        $formateur =new Formateur();(int)
//        $serializer->denormalize($formation,Formateur::class,'',$request->get('formateur'));
//        $etablissement =new Etablissement();
//        $serializer->denormalize($formation,Etablissement::class,'',$request->get('etablissement'));


        // persist the new form
        $form = new SatisfactionForm();


        $participant= new Participant();
        $participant->setNom($request->get('nomParticipant'));
        $participant->setPrenom($request->get('prenomParticipant'));
        $participant->setTel($request->get('telephone'));
        $participant->setMail($request->get('email'));
        $p=$PRepository->findBy(array('mail' => $request->get('email')),array('mail' => 'ASC'),1,0);
        if ($p!=null){
            $p=$p[0];
            $p->addSatisfactionForm($form);
            $participant=$p;
        }
        else{
            $participant->addSatisfactionForm($form);
        }
        $em->persist($participant);


        $form->setParticipant($participant);
        $form->setFormation($formationRepository->find($request->get('id_formation')));
        $form->setFormateur($formateurRepository->find($request->get('id_formateur')));
        $form->setEtablissement($etablissementRepository->find($request->get('id_etablissement')));
        $form->setDateFormaion(\DateTime::createFromFormat('Y-m-d', $request->get('date_formation')));
        $form->setDateEvaluation(new \DateTime('now'));
        $form->setQ1($request->get('Q1'));
        $form->setQ2($request->get('Q2'));
        $form->setQ3($request->get('Q3'));
        $form->setQ4($request->get('Q4'));
        $form->setQ5($request->get('Q5'));
        $form->setSuggestion($request->get('suggestion'));
        $em->persist($form);
        $em->flush();

        return $this->respondCreated($SFRepository->transform($form));
    }

}
