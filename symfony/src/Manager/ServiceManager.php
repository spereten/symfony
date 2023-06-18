<?php

namespace App\Manager;

use App\DTO\ServiceManagerDto;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class ServiceManager
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function saveService(ServiceManagerDto $dto, bool $flush = true): Service
    {
        $entity = new Service();
        $entity->setTitle($dto->name);
        if($dto->parent){
            $entity->setParent($this->getRepository()->find($dto->parent));
        }

        $this->getRepository()->save($entity, $flush);
        return $entity;
    }

    /** @return ServiceRepository */
    private function getRepository(): \Doctrine\ORM\EntityRepository
    {
        return $this->em->getRepository(Service::class);
    }
}