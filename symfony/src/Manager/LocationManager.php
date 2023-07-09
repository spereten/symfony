<?php

namespace App\Manager;

use App\DTO\LocationCreateDto;
use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class LocationManager
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function getDefaultLocation(): Location
    {
        $this->getRepository()->find(['default' => true]);
    }

    public function hasLocationBySlug(string $slug): bool
    {
       return (bool) $this->getLocationBySlug($slug);
    }

    public function getLocationBySlug(string $slug): ?Location
    {
        return $this->getRepository()->findOneBy(['slug' => $slug]);
    }

    public function createLocation(LocationCreateDto $dto): void
    {
        $location = new Location();
        $location->setCity($dto->city);
        $location->setCountry($dto->country);

        $this->em->persist($location);
        $this->em->flush();
    }


    /** @return LocationRepository */
    private function getRepository(): EntityRepository
    {
        return $this->em->getRepository(Location::class);
    }
}