<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/formateur")
 */

class FormateurController extends ApiController
{
    /**
     * @Route("/formateurs", methods="GET")
     * @param FormateurRepository $formateurRepository
     * @return JsonResponse
     */
    public function index(FormateurRepository $formateurRepository)
    {
        $formateurs = $formateurRepository->transformAll();

        return $this->respond($formateurs);
    }

    /**
     * @Route("/formateurs/add", methods="POST")
     * @param Request $request
     * @param FormateurRepository $formateurRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function create(Request $request, FormateurRepository $formateurRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);

        if (!$request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the name
        if (!$request->get('nom')) {
            return $this->respondValidationError('Please provide a name!');
        }

        // validate the first name
        if (!$request->get('prenom')) {
            return $this->respondValidationError('Please provide a first name!');
        }

        // validate the genre
        if (!$request->get('sexe')) {
            return $this->respondValidationError('Please provide a genre!');
        }

        // validate the telephone
        if (!$request->get('telephone')) {
            return $this->respondValidationError('Please provide a telephone!');
        }

        // validate the email
        if (!$request->get('email')) {
            return $this->respondValidationError('Please provide an email!');
        }

        // persist the new formateur

        $formateur = new Formateur();
        $formateur->setNom($request->get('nom'));
        $formateur->setPrenom($request->get('prenom'));
        $formateur->setSexe($request->get('sexe'));
        $formateur->setTelephone($request->get('telephone'));
        $formateur->setEmail($request->get('email'));
        $em->persist($formateur);
        $em->flush();

        return $this->respondCreated($formateurRepository->transform($formateur));
    }


    /**
     * @Route("/{id}/edit", name="formateur_edit", methods={"GET","POST"})
     * @param $id
     * @param Request $request
     * @param FormateurRepository $formateurRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function edit($id, Request $request, FormateurRepository $formateurRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);
        $formateur = $formateurRepository->find($id);

        if (!$formateur) {
            return $this->respondValidationError(
                'There are no articles with the following id: ' . $id
            );
        }

        if (!$request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // persist the new formateur
        $formateur->setNom($request->get('nom'));
        $formateur->setPrenom($request->get('prenom'));
        $formateur->setSexe($request->get('sexe'));
        $formateur->setTelephone($request->get('telephone'));
        $formateur->setEmail($request->get('email'));
        $em->persist($formateur);
        $em->flush();

        return $this->respondCreated($formateurRepository->transform($formateur));
    }

    /**
     * @Route("/{id}", methods="POST")
     * @param $id
     * @param FormateurRepository $formateurRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function delete($id, FormateurRepository $formateurRepository, EntityManagerInterface $em)
    {
        $formateur = $formateurRepository->find($id);

        if (!$formateur) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        $em->remove($formateur);
        $em->flush();

        return $this->respondCreated($formateur->getNom());
    }
}