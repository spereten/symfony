<?php


namespace DataFixtures;

use App\Entity\ProfileService;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProfileServiceFixture extends AbstractBaseFixture  implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {

        for($i = 0; $i <= 1000; $i++){
            $profile = $this->getRandomProfile();
            $service = $this->getRandomService();

            $profileService = new ProfileService();
            $profileService->setPrice($this->faker->numberBetween(100, 500));
            $profileService->setProfile($profile);
            $profileService->setService($service);
            $this->em->persist($profileService);
            $this->em->flush();
        }


    }

    public function getDependencies(): array
    {
        return [
            ProfileFixtures::class,
            ServiceFixture::class
        ];
    }
}
