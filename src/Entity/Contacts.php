<?php

namespace App\Entity;

use App\Repository\ContactsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ContactsRepository::class)]
class Contacts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(['get_contacts'])]
    private ?int $id;

    #[ORM\Column(type: "string",length: 255)]
    #[Groups(['get_contacts'])]
    private ?string $Name ;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['get_contacts'])]
    private ?string $FirstName ;

    #[ORM\Column(type: "string", nullable : false, length: 255 )]
    #[Groups(['get_contacts'])]

    private ?string $password;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['get_contacts'])]
    private ?string $Address ;

    #[ORM\Column(type: "string", length: 16)]
    #[Groups(['get_contacts'])]
    private ?string $ZipCode ;

    #[ORM\Column(type: "string", length: 80)]
    #[Groups(['get_contacts'])]
    private ?string $Town ;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['get_contacts'])]
    private ?string $Email ;

    #[ORM\Column(type:"string", length: 16)]
    #[Groups(['get_contacts'])]
    private ?string $Phone ;

    #[ORM\Column(type: "array", length: 80)]
    #[Groups(['get_contacts'])]
    private ?array $role ;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['get_contacts'])]
    private ?string $Objectif ;

    #[ORM\ManyToMany(targetEntity: RendezVous::class, mappedBy: 'UtilisateurId')]
    #[Groups(['get_contacts'])]
    private Collection $Id;

    public function __construct()
    {
        $this->Id = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): static
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->ZipCode;
    }

    public function setZipCode(string $ZipCode): static
    {
        $this->ZipCode = $ZipCode;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->Town;
    }

    public function setTown(string $Town): static
    {
        $this->Town = $Town;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    #[ORM\Column(type: "string", length: 14)]

    public function getRole(): ?array
    {
        return $this->role;
    }

    public function setRole(array $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->Phone;
    }

    public function setPhone(?string $Phone): self
    {
        $this->Phone = $Phone;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);

        return $this;
    }

    public function verifyPassword(string $password): bool
    {
    return password_verify($password, $this->password);
    }
}
