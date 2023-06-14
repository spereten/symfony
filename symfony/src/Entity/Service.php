<?php

namespace App\Entity;


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


    #[Gedmo\TreeLeft]
    #[ORM\Column(name: 'lft', type: Types::INTEGER, nullable: true)]
    private ?int $lft = null;



    #[Gedmo\TreeLevel]
    #[ORM\Column(name: 'lvl', type: Types::INTEGER, nullable: true)]
    private ?int $lvl = null;


    #[Gedmo\TreeRight]
    #[ORM\Column(name: 'rgt', type: Types::INTEGER, nullable: true)]
    private ?int $rgt = null;


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

    public function setParent(self $parent = null): void
    {
        $this->parent = $parent;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }
}
