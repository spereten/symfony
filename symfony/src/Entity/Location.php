<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use App\Symfony\Doctrine\NestedSetEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Tree\Traits\NestedSetEntity;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[Gedmo\Tree(type: 'nested')]
#[ORM\Index(columns: ['parent_id'], name: 'location__parent_id__inx')]
#[ORM\Index(columns: ['slug'], name: 'location__slug__inx')]

class Location
{

    use NestedSetEntityTrait, TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['city'])]

    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private string $city;

    #[ORM\Column(length: 255)]
    private string $country;



    public function getId(): int
    {
        return $this->id;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
