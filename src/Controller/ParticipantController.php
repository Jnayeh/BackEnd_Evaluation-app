<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/participant")
 */
class ParticipantController extends ApiController
{
    /**
     * @Route("/", name="participant_index", methods={"GET"})
     * @param ParticipantRepository $participantRepository
     * @return Response
     */
    public function index(ParticipantRepository $participantRepository)
    {
        $participants = $participantRepository->transformAll();

        return $this->respond($participants);
    }

}
