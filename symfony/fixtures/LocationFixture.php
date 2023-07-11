<?php


namespace DataFixtures;

use App\DTO\LocationCreateDto;
use App\DTO\ServiceManagerDto;
use App\Entity\Service;
use App\Manager\LocationManager;
use App\Manager\ServiceManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LocationFixture extends Fixture
{

    public function __construct(private readonly LocationManager $locationManager)
    {
    }

    public function load(ObjectManager $manager): void
    {

        $location = $this->locationManager->createLocation(new LocationCreateDto('Минск', 'Беларусь'));
        $this->locationManager->createLocation(new LocationCreateDto('Заславль', 'Беларусь', $location->getId() ));
        $this->locationManager->createLocation(new LocationCreateDto('Москва', 'Россия'));

    }
}
