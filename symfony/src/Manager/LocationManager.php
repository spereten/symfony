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

    public function createLocation(LocationCreateDto $dto, bool $flush = true): Location
    {

        $location = $this->saveFromDto($dto);
        $this->em->persist($location);
        if($flush){
            $this->em->flush();
        }

        return $location;
    }

    public function saveFromDto(LocationCreateDto $dto, ?Location $location = null ): Location
    {
        $location = $location ?? new Location();
        $location->setCity($dto->city);
        $location->setCountry($dto->country);
        if($dto->parent_id !== null){
            $parent = $this->getRepository()->find($dto->parent_id);
            if($parent){
                $location->setParent($parent);
            }
        }
        return $location;
    }


    /** @return LocationRepository */
    private function getRepository(): EntityRepository
    {
        return $this->em->getRepository(Location::class);
    }
}