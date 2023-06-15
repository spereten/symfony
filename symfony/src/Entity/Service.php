<?php

namespace App\Entity;


use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;


#[Gedmo\Tree(type: 'nested')]
#[ORM\Table(name: 'service')]
#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;


    #[ORM\Column(name: 'title', type: Types::STRING, length: 64)]
    private $title;


    #[Gedmo\TreeLeft]
    #[ORM\Column(name: 'lft', type: Types::INTEGER)]
    private $lft;

    #[Gedmo\TreeRight]
    #[ORM\Column(name: 'rgt', type: Types::INTEGER)]
    private $rgt;

    #[Gedmo\TreeLevel]
    #[ORM\Column(name: 'lvl', type: Types::INTEGER)]
    private $lvl;

    #[Gedmo\TreeRoot]
    #[ORM\ManyToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(name: 'tree_root', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private $root;

    #[Gedmo\TreeParent]
    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private $parent;

    #[ORM\OneToMany(targetEntity: Service::class, mappedBy: 'parent')]
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

    public function getRoot(): ?self
    {
        return $this->root;
    }

    /**
     * @return mixed
     */
    public function getLft()
    {
        return $this->lft;
    }

    public function setLft($lft)
    {
        $this->lft = $lft;
        return $this;
    }

    public function getRgt()
    {
        return $this->rgt;
    }

    public function setRgt($rgt)
    {
        $this->rgt = $rgt;
        return $this;
    }

    public function getLvl()
    {
        return $this->lvl;
    }

    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren($children)
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

    public function removeProfileService(ProfileService $profileService): static
    {
        if ($this->profileServices->removeElement($profileService)) {
            // set the owning side to null (unless already changed)
            if ($profileService->getService() === $this) {
                $profileService->setService(null);
            }
        }

        return $this;
    }
}
