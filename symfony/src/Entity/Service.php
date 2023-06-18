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

    #[ORM\Column(name: 'title', type: Types::STRING, length: 64)]
    private ?string $title;

    #[Gedmo\TreeParent]
    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?self $parent;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Service::class)]
    private $children;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: ProfileService::class)]
    private Collection $profileServices;

    public function __construct()
    {
        $this->profileServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
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

    /**
     * @return Collection<int, ProfileService>
     */
    public function getProfileServices(): Collection
    {
        return $this->profileServices;
    }

    public function addProfileService(ProfileService $profileService): static
    {
        if (!$this->profileServices->contains($profileService)) {
            $this->profileServices->add($profileService);
            $profileService->setService($this);
        }

        return $this;
    }
}
