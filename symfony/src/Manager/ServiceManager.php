<?php

namespace App\Manager;

use App\DTO\ServiceManagerDto;
use App\Entity\ServiceEntity;
use App\Repository\ServiceRepository;

class ServiceManager
{
    public function __construct(private readonly ServiceRepository $serviceRepository)
    {
    }

    public function saveService(ServiceManagerDto $dto, bool $flush = true): ServiceEntity
    {
        $serviceEntity = new ServiceEntity();
        $serviceEntity->setTitle($dto->title);
        $serviceEntity->setCreatedAt();
        $serviceEntity->setUpdatedAt();

        $this->serviceRepository->save($serviceEntity, $flush);

        return $serviceEntity;
    }
}