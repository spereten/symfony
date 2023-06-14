<?php

namespace App\Manager;

use App\DTO\ServiceManagerDto;
use App\Entity\Service;
use App\Repository\ServiceRepository;

class ServiceManager
{
    public function __construct(private readonly ServiceRepository $serviceRepository)
    {
    }

    public function saveService(ServiceManagerDto $dto, bool $flush = true): Service
    {
        $serviceEntity = new Service();
        $serviceEntity->setTitle($dto->title);
        $serviceEntity->setCreatedAt();
        $serviceEntity->setUpdatedAt();

        $this->serviceRepository->save($serviceEntity, $flush);

        return $serviceEntity;
    }

    public function attachParentServices(Service $parent, Service $service): Service
    {
        $service->setParent($parent);
        return $service;
    }
}