<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Form\EtablissementType;
use App\Repository\EtablissementRepository;
use App\Repository\TypeEtablissemntRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/etablissement")
 */
class EtablissementController extends ApiController
{
    /**
     * @Route("/etablissements", methods="GET")
     * @return JsonResponse
     */
    public function index(EtablissementRepository $etablissementRepository)
    {
        $etablissements = $etablissementRepository->transformAll();

        return $this->respond($etablissements);
    }

    /**
     * @Route("/etablissements/add", methods="POST")
     * @param Request $request
     * @param EtablissementRepository $etablissementRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function create(Request $request, EtablissementRepository $etablissementRepository, TypeEtablissemntRepository $TREP , EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);
        if (!$request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the name
        if (!$request->get('nom')) {
            return $this->respondValidationError('Please provide a name!');
        }


        // validate the type
        if (!$request->get('type')) {
            return $this->respondValidationError('Please provide a type!');
        }


        // persist the new etablissement
        $etablissement = new Etablissement();
        $etablissement->setNom($request->get('nom'));
        $etablissement->setType($request->get('type'));
        $etablissement->setEtabType($TREP->findOneBy(array('type'=>$request->get('type'))));
        $em->persist($etablissement);
        $em->flush();

        return $this->respondCreated($etablissementRepository->transform($etablissement));
    }


    /**
     * @Route("/{id}/edit", name="etablissement_edit", methods={"GET","POST"})
     * @param $id
     * @param Request $request
     * @param EtablissementRepository $etablissementRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function edit($id, Request $request, EtablissementRepository $etablissementRepository, TypeEtablissemntRepository $TREP , EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);
        $etablissement = $etablissementRepository->find($id);

        if (!$etablissement) {
            return $this->respondValidationError(
                'There are no articles with the following id: ' . $id
            );
        }

        if (!$request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

//        // validate the name
//        if (!$request->get('nom')) {
//            return $this->respondValidationError('Please provide a name!');
//        }
//
//        // validate the first name
//        if (!$request->get('prenom')) {
//            return $this->respondValidationError('Please provide a first name!');
//        }
//
//        // validate the genre
//        if (!$request->get('sexe')) {
//            return $this->respondValidationError('Please provide a genre!');
//        }
//
//        // validate the telephone
//        if (!$request->get('telephone')) {
//            return $this->respondValidationError('Please provide a telephone!');
//        }
//
//        // validate the email
//        if (!$request->get('email')) {
//            return $this->respondValidationError('Please provide an email!');
//        }

        // persist the new formation
        $etablissement->setNom($request->get('nom'));
        $etablissement->setType($request->get('type'));
        $etablissement->setEtabType($TREP->findOneBy(array('type'=>$request->get('type'))));
        $em->persist($etablissement);
        $em->flush();

        return $this->respondCreated($etablissementRepository->transform($etablissement));
    }

    /**
     * @Route("/{id}", methods="POST")
     * @param $id
     * @param EtablissementRepository $etablissementRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function delete($id, EtablissementRepository $etablissementRepository, EntityManagerInterface $em)
    {
        $etablissement = $etablissementRepository->find($id);

        if (!$etablissement) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        $em->remove($etablissement);
        $em->flush();

        return $this->respondCreated($etablissement->getNom());
    }
}