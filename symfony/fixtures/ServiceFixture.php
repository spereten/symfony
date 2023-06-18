<?php


namespace DataFixtures;

use App\DTO\ServiceManagerDto;
use App\Entity\Service;
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

        $fx = function(array $services, Service $parent = null) use(&$fx){
            foreach ($services as $service){
                $dto = new ServiceManagerDto(name: $service['name'], parent: $parent?->getId());
                $entity = $this->serviceManager->saveService($dto);
                if(key_exists('children', $service)){
                    $fx($service['children'], $entity);
                }
            }
        };
        $fx->bindTo($this);
        $fx($services);

        $manager->flush();
    }
}
