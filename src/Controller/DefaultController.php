<?php

namespace App\Controller;

use App\Repository\AttestationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @var AttestationRepository $attestationRepository
     */
    private $attestationRepository;

    public function __construct(AttestationRepository $attestationRepository)
    {
        $this->attestationRepository = $attestationRepository;
    }

    /**
     * @Route("/", name="app_default", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'attestations' => $this->attestationRepository->findAll(),
        ]);
    }
}
