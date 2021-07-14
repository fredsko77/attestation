<?php
namespace App\Services;

use App\Entity\Attestation;
use App\Repository\AttestationRepository;
use App\Repository\ConventionRepository;
use App\Repository\EtudiantRepository;
use App\Services\AttestationServicesInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AttestationServices implements AttestationServicesInterface
{
    use ServicesTrait;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var EtudiantRepository $etudiantRepository
     */
    private $etudiantRepository;

    /**
     * @var ConventionRepository $conventionRepository
     */
    private $conventionRepository;

    /**
     * @var AttestationRepository $attestationRepository
     */
    private $attestationRepository;

    /**
     * @var UrlGeneratorInterface $router
     */
    private $router;

    public function __construct(
        EntityManagerInterface $manager,
        EtudiantRepository $etudiantRepository,
        ConventionRepository $conventionRepository,
        AttestationRepository $attestationRepository,
        UrlGeneratorInterface $router
    ) {
        $this->manager = $manager;
        $this->etudiantRepository = $etudiantRepository;
        $this->conventionRepository = $conventionRepository;
        $this->attestationRepository = $attestationRepository;
        $this->router = $router;
    }

    public function store(Request $request): object
    {
        $data = (array) json_decode($request->getContent());

        $etudiant = $this->etudiantRepository->find((int) $data['etudiant']);
        $convention = $this->conventionRepository->find((int) $data['convention']);

        // Vérifier si une attestation existe avec l'étudiant et la convention
        $attestationExist = $this->attestationRepository->findOneBy(['convention' => $convention, 'etudiant' => $etudiant]) ?? false;

        $attestation = !$attestationExist ? new Attestation : $attestationExist;

        $attestation->setConvention($convention)
            ->setEtudiant($etudiant)
            ->setMessage($data['message'])
        ;

        $this->persist($attestation);

        return $this->sendJson(
            $attestation,
            $attestationExist === false ? Response::HTTP_CREATED : Response::HTTP_OK,
            ['Location' => $this->router->generate('app_attestation_edit', ['id' => $attestation->getId()], UrlGeneratorInterface::ABSOLUTE_URL)]
        );
    }

    public function persist(object $object)
    {
        $this->manager->persist($object);
        $this->manager->flush();
    }
}
