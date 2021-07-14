<?php

namespace App\Entity;

use App\Repository\ConventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ConventionRepository::class)
 */
class Convention
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"convention:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"attestation:read", "convention:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"attestation:read", "convention:read"})
     */
    private $nbHeur;

    /**
     * @ORM\OneToMany(targetEntity=Attestation::class, mappedBy="convention")
     */
    private $attestations;

    /**
     * @ORM\OneToMany(targetEntity=Etudiant::class, mappedBy="convention")
     * @Groups({"convention:read"})
     */
    private $etudiants;

    public function __construct()
    {
        $this->attestations = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNbHeur(): ?int
    {
        return $this->nbHeur;
    }

    public function setNbHeur(int $nbHeur): self
    {
        $this->nbHeur = $nbHeur;

        return $this;
    }

    /**
     * @return Collection|Attestation[]
     */
    public function getAttestations(): Collection
    {
        return $this->attestations;
    }

    public function addAttestation(Attestation $attestation): self
    {
        if (!$this->attestations->contains($attestation)) {
            $this->attestations[] = $attestation;
            $attestation->setConvention($this);
        }

        return $this;
    }

    public function removeAttestation(Attestation $attestation): self
    {
        if ($this->attestations->removeElement($attestation)) {
            // set the owning side to null (unless already changed)
            if ($attestation->getConvention() === $this) {
                $attestation->setConvention(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setConvention($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getConvention() === $this) {
                $etudiant->setConvention(null);
            }
        }

        return $this;
    }
}
