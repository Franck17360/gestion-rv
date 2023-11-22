<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(['get_rendez_vous'])]
    private ?int $id = null;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['get_rendez_vous'])]
    private ?\DateTimeInterface $DateRendezVous;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups(['get_rendez_vous'])]
    private ?\DateTimeInterface $Heure;

    #[ORM\Column(length: 255)]
    #[Groups(['get_rendez_vous'])]
    private ?string $Lieu;

    #[ORM\Column(length: 500)]
    #[Groups(['get_rendez_vous'])]
    private ?string $Description;

    #[ORM\ManyToMany(targetEntity: RendezVous::class, mappedBy: 'UtilisateurId')]
    #[Groups(['get_rendez_vous'])]
    private Collection $UtilisateurId;

    #[ORM\ManyToMany(targetEntity: Contacts::class, inversedBy: 'ContactId')]
    #[Groups(['get_rendez_vous'])]
    private Collection $ContactId;

    public function __construct()
    {
        $this->UtilisateurId = new ArrayCollection();
        $this->ContactId = new ArrayCollection();
        $this->id = null;
    }

    public function getId(): ?int
    {
        return $this->id instanceof ArrayCollection ?null : $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getDateRendezVous(): ?\DateTimeInterface
    {
        return $this->DateRendezVous;
    }

    public function setDateRendezVous(\DateTimeInterface $DateRendezVous): static
    {
        $this->DateRendezVous = $DateRendezVous;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->Heure;
    }

    public function setHeure(\DateTimeInterface $Heure): static
    {
        $this->Heure = $Heure;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->Lieu;
    }

    public function setLieu(string $Lieu): static
    {
        $this->Lieu = $Lieu;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUtilisateurId(): Collection
    {
        return $this->UtilisateurId;
    }

    /**
     * @return Collection<int, self>
     */
    public function getContactId(): Collection
    {
        return $this->ContactId;
    }
}
