<?php

namespace App\Controller;

use App\Entity\TypeEtablissemnt;
use App\Repository\TypeEtablissemntRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class TypeEtablissemntController extends ApiController
{
    /**
     * @Route("/types", methods="GET")
     * @param TypeEtablissemntRepository $typeEtablissemntRepository
     * @return JsonResponse
     */
    public function index(TypeEtablissemntRepository $typeEtablissemntRepository)
    {
        $types = $typeEtablissemntRepository->transformAll();

        return $this->respond($types);
    }

}
