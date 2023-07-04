<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Service;
use App\Manager\ProfileManager;
use App\Manager\ServiceManager;
use Doctrine\Common\Collections\ArrayCollection;

class ProfileService
{
    public function __construct(
        private readonly ServiceManager $serviceManager,
        private readonly ProfileManager $profileManager
    ){}

    public function syncProfileWithServices(int $profileId, array $services = []): bool
    {
        $profile = $this->profileManager->getProfileById($profileId);
        if($profile === null){
            return false;
        }
        /** @var Service[]  $services*/
        $currentServices = $profile->getServices();
        /** @var Service[]  $services*/
        $newServices = new ArrayCollection($this->serviceManager->findByCriteria(['id' => $services]));

        $currentServices->map(function(Service $service) use($newServices, $profile) {
            if(!$newServices->contains($service)){
                $this->profileManager->removeServiceFromProfile($profile, $service);
            }
            return $service;
        });

        $newServices->map( function(Service $service) use($currentServices, $profile) {
            if(!$currentServices->contains($service)){
                $this->profileManager->addServiceToProfile($profile, $service);
            }
            return $service;
        });


        return true;

    }
}