<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/formation")
 */

class FormationController extends ApiController
{
    /**
     * @Route("/formations", methods="GET")
     * @param FormationRepository $formationRepository
     * @return JsonResponse
     */
    public function index(FormationRepository $formationRepository)
    {
        $formations = $formationRepository->transformAll();

        return $this->respond($formations);
    }

    /**
     * @Route("/formations/add", methods="POST")
     * @param Request $request
     * @param FormationRepository $formationRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function create(Request $request, FormationRepository $formationRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);

        if (!$request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the title
        if (!$request->get('theme')) {
            return $this->respondValidationError('Please provide a theme!');
        }

        // persist the new formation
        $formation = new Formation;
        $formation->setTheme($request->get('theme'));
        $em->persist($formation);
        $em->flush();

        return $this->respondCreated($formationRepository->transform($formation));
    }


    /**
     * @Route("/{id}/edit", name="formation_edit", methods={"GET","POST"})
     * @param $id
     * @param Request $request
     * @param FormationRepository $formationRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function edit($id,Request $request, FormationRepository $formationRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);
        $formation = $formationRepository->find($id);

        if (!$formation) {
            return $this->respondValidationError(
                'There are no articles with the following id: ' . $id
            );
        }

        if (!$request) {
            return $this->respondValidationError('Please provide a valid request!'.$request);
        }

        // validate the title
        if (!$request->get('theme')) {
            return $this->respondValidationError('Please provide a theme!');
        }

        // persist the new formation
        $formation->setTheme($request->get('theme'));
        $em->persist($formation);
        $em->flush();

        return $this->respondCreated($formationRepository->transform($formation));
    }

    /**
     * @Route("/{id}", methods="POST")
     * @param $id
     * @param FormationRepository $formationRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function delete($id, FormationRepository $formationRepository, EntityManagerInterface $em)
    {
        $formation = $formationRepository->find($id);

        if (!$formation) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        $em->remove($formation);
        $em->flush();

        return $this->respondCreated($formation->getTheme());
    }
}