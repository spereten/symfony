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
        $services = [
            'Электрик',
            'Сантехник',
            'Муж на час',
            'Столяр',
            'Слесарь',
            'Ремонт квартир',
            'Укладка плитки',
            'Малярные и штукатурные работы',
            'Монтаж отопления',
            'Сварочные работы'
        ];
        foreach ($services as $service){
             $this->serviceManager->saveService(ServiceManagerDto::fromArray(['title' => $service]), false);
        }

        $manager->flush();
    }
}
