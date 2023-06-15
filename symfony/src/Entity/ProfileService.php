<?php

namespace App\Entity;

use App\Repository\ProfileServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileServiceRepository::class)]
#[ORM\Table(name: 'profile_service')]
class ProfileService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\OneToOne(inversedBy: 'profileService', cascade: ['persist', 'remove'])]
    private ?Profile $profile = null;

    #[ORM\OneToOne(inversedBy: 'profileService', cascade: ['persist', 'remove'])]
    private ?Service $service = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }
}
