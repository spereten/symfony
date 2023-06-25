<?php

namespace App\Entity;


use App\Repository\ServiceRepository;
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
    use NestedSetEntity, TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['name'])]
    private ?string $slug = null;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 64)]
    private ?string $name;

    #[Gedmo\TreeParent]
    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?self $parent;

    #[ORM\OneToOne(mappedBy: 'parent', targetEntity: Service::class)]
    private $children;

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

    public function getRoot(): int
    {
        return $this->root;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(self $parent): static
    {
        $this->parent = $parent;
        return $this;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren($children): static
    {
        $this->children = $children;
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
