<?php

namespace DataFixtures;

use App\DTO\ServiceManagerDto;
use App\Manager\ServiceManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixture extends Fixture
{

    public function __construct(private readonly ServiceManager $serviceManager)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $services = json_decode(file_get_contents(__DIR__ . '/data/services.json'), true);

        dd($services);

        if($services){

        }
        dd($services);
        foreach ($services as $service){
             $this->serviceManager->saveService(ServiceManagerDto::fromArray(['title' => $service]), false);
        }

        $manager->flush();
    }
}
