<?php

namespace App\Entity;


use App\Repository\ServiceRepository;
use App\Symfony\Doctrine\NestedSetEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Tree\Traits\NestedSetEntity;


#[Gedmo\Tree(type: 'nested')]
#[ORM\Table(name: 'service')]
#[ORM\Index(columns: ['parent_id'], name: 'service__parent_id__inx')]
#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    use NestedSetEntityTrait, TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['name'])]
    private string $slug;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 64)]
    private string $name;


    #[ORM\ManyToMany(targetEntity: Profile::class, inversedBy: 'services')]
    private Collection $profile;


    public function __construct()
    {
        $this->profile = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'slug' => $this->getSlug(),
            'name' => $this->getName(),
        ];
    }

    /**
     * @return Collection<int, Profile>
     */
    public function getProfile(): Collection
    {
        return $this->profile;
    }

    public function addProfile(Profile $profile): static
    {

        if (!$this->profile->contains($profile)) {
            $this->profile->add($profile);
        }

        return $this;
    }

    public function removeProfile(Profile $profile): static
    {
        $this->profile->removeElement($profile);

        return $this;
    }
}
