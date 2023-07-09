<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Profile;
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

    public function syncProfileWithServices(Profile $profile, array $services = []): bool
    {

        $servicesWhichExistId = array_map(function($service) {return $service->getId();}, $profile->getServices()->toArray());

        // новые, которых не было;
        $servicesWhichNeedAddId = array_diff($services, $servicesWhichExistId);
        $servicesWhichNeedAdd = $this->serviceManager->findByCriteria(['id' => $servicesWhichNeedAddId]);

        // старые, которых не стало;
        $servicesWhichNeedDeleteId = array_diff($servicesWhichExistId, $services);
        $servicesWhichNeedDelete = $this->serviceManager->findByCriteria(['id' => $servicesWhichNeedDeleteId]);

        //старые, которые остались
        //array_diff($services, $servicesWhichNeedDeleteId, $servicesWhichNeedAddId));

        return $this->profileManager->syncProfileWithServices($profile, $servicesWhichNeedAdd, $servicesWhichNeedDelete);

    }
}