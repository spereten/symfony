<?php
declare(strict_types=1);

namespace DataFixtures;

use App\Entity\Profile;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;

abstract class AbstractBaseFixture extends Fixture
{
    public readonly Generator $faker;

    public function __construct(public readonly EntityManagerInterface $em)
    {
        $this->faker = \Faker\Factory::create('ru_RU');
    }

    public function getRandomProfile(): Profile{
        static $entities = null;
        if($entities === null){
            $entities = $this->em->getRepository(Profile::class)->findAll();
        }
        shuffle($entities);
        return $entities[0];
    }

    public function getRandomService(): Service
    {

         $entities = null;
        if($entities === null){
            $entities = $this->em->getRepository(Service::class)->findAll();
        }
        shuffle($entities);
        return $entities[0];
    }

}