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

        $food = new Service();
        $food->setTitle('Food');

        $fruits = new Service();
        $fruits->setTitle('Fruits');
        $fruits->setParent($food);

        $vegetables = new Service();
        $vegetables->setTitle('Vegetables');
        $vegetables->setParent($food);

        $carrots = new Service();
        $carrots->setTitle('Carrots');
        $carrots->setParent($vegetables);

        $manager->persist($food);
        $manager->persist($fruits);
        $manager->persist($vegetables);
        $manager->persist($carrots);
        $manager->flush();
        $manager->flush();
   /*     die();

        foreach ($services as $service) {
            $e1 = $this->serviceManager->saveService(ServiceManagerDto::fromArray(['title' => $service['name']]), false);
            foreach ($service['children'] as $l1){
                $e2 = $this->serviceManager->saveService(ServiceManagerDto::fromArray(['title' => $l1['name']]), false);
                $e2->setParent($e1);
                foreach ($l1['children'] as $l2){
                    $p3 = $this->serviceManager->saveService(ServiceManagerDto::fromArray(['title' => $l2['name']]), false);
                    $p3->setParent($e2);
                }
            }
        }*/


    }
}
