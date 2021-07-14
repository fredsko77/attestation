<?php
namespace App\Controller;

use App\Entity\Attestation;
use App\Repository\ConventionRepository;
use App\Repository\EtudiantRepository;
use App\Services\AttestationServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attestation")
 */
class AttestationController extends AbstractController
{

    /**
     * @var AttestationServicesInterface $services
     */
    private $services;

    /**
     * @var EtudiantRepository $etudiantRepository
     */
    private $etudiantRepository;

    /**
     * @var ConventionRepository $conventionRepository
     */
    private $conventionRepository;

    public function __construct(
        AttestationServicesInterface $services,
        ConventionRepository $conventionRepository,
        EtudiantRepository $etudiantRepository
    ) {
        $this->services = $services;
        $this->conventionRepository = $conventionRepository;
        $this->etudiantRepository = $etudiantRepository;
    }

    /**
     * @Route("/create", name="app_attestation_create", methods={"GET"})
     */
    public function create(): Response
    {
        return $this->render('attestation/create.html.twig', [
            'etudiants' => $this->etudiantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_attestation_edit", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function edit(Attestation $attestation): Response
    {
        return $this->render('attestation/edit.html.twig', [
            'attestation' => $attestation,
            'etudiants' => $this->etudiantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="app_attestation_store", methods={"POST"})
     */
    public function store(Request $request): JsonResponse
    {
        $response = $this->services->store($request);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'attestation:read']
        );
    }

    /**
     * @Route("/{id}", name="app_attestation_show", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function read(Attestation $attestation): JsonResponse
    {
        return $this->json(
            $attestation,
            Response::HTTP_OK,
            [],
            ['groups' => 'attestation:read']
        );
    }

}
