<?php


namespace DataFixtures;

use App\Entity\Service;
use App\Service\ServiceService;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class ProfileServiceFixture extends AbstractBaseFixture implements DependentFixtureInterface
{
    public function __construct(public readonly EntityManagerInterface $em, private readonly ServiceService $serviceService)
    {
    }

    public function load(ObjectManager $manager): void
    {

        $queryBuilder = $manager->createQueryBuilder();
        $queryBuilder->select('u')
            ->from(Service::class, 'u');

        for($i = 0; $i <= 1000; $i++){
            $profile = $this->getRandomProfile();
            $service = $this->getRandomService();
            $this->serviceService->addProfileToService($profile->getId(), $service->getId());
            $this->em->persist($service);
        }
        $this->em->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProfileFixtures::class,
            ServiceFixture::class
        ];
    }


}
