<?php


namespace DataFixtures;

use App\Entity\ProfileService;
use Doctrine\Persistence\ObjectManager;

class ProfileServiceFixture extends AbstractBaseFixture
{


    public function load(ObjectManager $manager): void
    {

        $profile = $this->getRandomProfile();
        $service = $this->getRandomService();

        $profileService = new ProfileService();
        $profileService->setPrice($this->faker->randomFloat(100));
        $profileService->setProfile($profile);
        $profileService->setService($service);
        $this->em->persist($profileService);
        $this->em->flush();




    }
}
