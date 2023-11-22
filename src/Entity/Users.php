<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id ;

    #[ORM\Column(type: "string",length: 255)]
    private ?string $Name ;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $FirstName ;

    #[ORM\Column(type: "string", nullable : false, length: 255 )]

    private ?string $password;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $Address ;

    #[ORM\Column(type: "string", length: 16)]
    private ?string $ZipCode ;

    #[ORM\Column(type: "string", length: 80)]
    private ?string $Town ;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $Email ;

    #[ORM\Column(type:"string", length: 16)]
    private ?string $Phone ;

    #[ORM\Column(type: "array", length: 80)]
    private ?array $role ;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $Objectif ;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPhone(): ?string
    {
        return $this->Phone;
    }

    public function setPhone(int $Phone): static
    {
        $this->Phone = $Phone;

        return $this;
    }

    public function getRole(): ?array
    {
        return $this->role;
    }

    public function setRole(array $role): ?array
    {
        return $this->role = $role;
    }

    public function getObjectif(): ?string
    {
        return $this->Objectif;
    }

    public function setObjectif(string $objectif): static
    {
        $this->Objectif = $objectif;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}
