<?php

namespace App\Service;

use App\Manager\ProfileManager;
use App\Manager\ServiceManager;

class ServiceService
{
    public function __construct(
        private readonly ServiceManager $serviceManager,
        private readonly ProfileManager $profileManager
    )
    {
    }
    /** @deprecated  */
    public function addProfileToService(int $profileId, int $serviceId, ): void
    {
        $services = $this->serviceManager->getPathService($serviceId);
        $profile = $this->profileManager->getProfileById($profileId);

        foreach ($services as $service){
            $service->addProfile($profile);
        }
    }

    public function attachServicesToProfile(int $profileId, array $serviceIds): bool
    {
        $profile = $this->profileManager->getProfileById($profileId);
        if($profile === null){
            return false;
        }
        $services = $this->serviceManager->findByCriteria(['id' => $serviceIds]);
        if(empty($services)){
            return false;
        }
        foreach ($services as $service){
            $service->addProfile($profile);
        }

        return true;
    }

    public function attachServiceToProfile(int $profileId, int $serviceId): void
    {
        $services = $this->serviceManager->getPathService($serviceId);
        $profile = $this->profileManager->getProfileById($profileId);

        foreach ($services as $service){
            $this->serviceManager->addProfile($service, $profile);
        }
    }
}