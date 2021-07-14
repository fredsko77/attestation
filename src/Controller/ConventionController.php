<?php

namespace App\Controller;

use App\Entity\Convention;
use App\Entity\Etudiant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/convention")
 */
class ConventionController extends AbstractController
{
    /**
     * @Route("/{id}", name="app_convention_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Etudiant $etudiant): JsonResponse
    {
        return $this->json(
            $etudiant->getConvention(),
            Response::HTTP_OK,
            [],
            ['groups' => 'convention:read']
        );
    }
}
