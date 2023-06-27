<?php

namespace App\Manager;

use App\DTO\ProfileManagerDto;
use App\Entity\Profile;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ProfileManager
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function getProfilesForService(int $serviceId, int $page): array
    {
        return $this->getRepository()->getProfileForServiceWithPagination($serviceId, $page ?? 0, $perPage ?? 5);
    }

    public function getProfileBySlug(string $slug): ?Profile
    {
        return $this->getRepository()->findOneBy(['slug' => $slug]);
    }

    public function saveProfile(ProfileManagerDto $profileManagerDto, bool $flush = true): Profile
    {
        $profileEntity = new Profile();
        $profileEntity->setLastName($profileManagerDto->last_name);
        $profileEntity->setFirstName($profileManagerDto->first_name);
        $profileEntity->setSurname($profileManagerDto->surname);
        $profileEntity->setEmail($profileManagerDto->email);
        $profileEntity->setPhone($profileManagerDto->phone);
        $profileEntity->setExperience($profileManagerDto->experience);

        $this->getRepository()->save($profileEntity, $flush);


        return $profileEntity;
    }

    public function getProfile(int $profileId): ?Profile
    {
        return $this->getRepository()->find($profileId);
    }

    /** @return ProfileRepository */
    private function getRepository(): EntityRepository
    {
        return $this->em->getRepository(Profile::class);
    }
}