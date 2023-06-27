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

    public function addProfileToService(int $profileId, int $serviceId, ){
        $services = $this->serviceManager->getPathService($serviceId);
        $profile = $this->profileManager->getProfile($profileId);

        foreach ($services as $service){
            $service->addProfile($profile);
        }
    }
}