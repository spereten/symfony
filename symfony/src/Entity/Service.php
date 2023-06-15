<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;


#[Gedmo\Tree(type: 'nested')]
#[ORM\Table(name: 'service')]
#[ORM\Entity(repositoryClass: NestedTreeRepository::class)]
class Service
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;


    #[ORM\Column(name: 'title', type: Types::STRING, length: 64)]
    private $title;




    #[Gedmo\TreeRoot]
    #[ORM\ManyToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(name: 'tree_root', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private $root;


    #[Gedmo\TreeParent]
    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private $parent;

    #[ORM\OneToMany(targetEntity: Service::class, mappedBy: 'parent')]
    #[ORM\OrderBy(['lft' => 'ASC'])]
    private $children;

    #[ORM\OneToOne(mappedBy: 'service', cascade: ['persist', 'remove'])]
    private ?ProfileService $profileService = null;


    public function getId(): ?intпше
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

    public function getRoot(): ?self
    {
        return $this->root;
    }

    public function setParent(self $parent = null): void
    {
        $this->parent = $parent;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function getProfileService(): ?ProfileService
    {
        return $this->profileService;
    }

    public function setProfileService(?ProfileService $profileService): static
    {
        // unset the owning side of the relation if necessary
        if ($profileService === null && $this->profileService !== null) {
            $this->profileService->setService(null);
        }

        // set the owning side of the relation if necessary
        if ($profileService !== null && $profileService->getService() !== $this) {
            $profileService->setService($this);
        }

        $this->profileService = $profileService;

        return $this;
    }
}
