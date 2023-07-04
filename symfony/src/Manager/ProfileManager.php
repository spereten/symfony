<?php

namespace App\Manager;

use App\DTO\ProfileManagerDto;
use App\Entity\Profile;
use App\Entity\Service;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ProfileManager
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }
    public function getProfileBySlug(string $slug): ?Profile
    {
        return $this->getRepository()->findOneBy(['slug' => $slug]);
    }

    public function getProfileById(int $profileId): ?Profile
    {
        return $this->getRepository()->find($profileId);
    }

    public function getProfilesForService(int $serviceId, int $page, int $perPage): array
    {
        return $this->getRepository()->getProfileForServiceWithPagination($serviceId, $page, $perPage);
    }

    public function saveProfile(ProfileManagerDto $profileManagerDto, bool $flush = true): Profile
    {
        $profileEntity = new Profile();
        $profileEntity = self::fillEntityFromDto($profileEntity, $profileManagerDto);
        $this->getRepository()->save($profileEntity, $flush);

        return $profileEntity;
    }

    public function updateProfile(int $profileId, ProfileManagerDto $profileManagerDto, bool $flush = true): Profile
    {
        $profileEntity = $this->getProfileBySlug($profileId);
        $profileEntity = self::fillEntityFromDto($profileEntity, $profileManagerDto);

        $this->getRepository()->save($profileEntity, $flush);

        return $profileEntity;
    }

    public function deleteProfile(int $profileId, bool $flush = true): bool
    {
        $profile = $this->getProfileById($profileId);
        if($profile === null){
            return false;
        }
        $this->getRepository()->remove($profile, $flush);

        return true;
    }

    public function addServiceToProfile(Profile $profile, Service $service): void
    {
        $profile->addService($service);
        $this->em->persist($profile);
        $this->em->flush();

    }

    public function removeServiceFromProfile(Profile $profile, Service $service): void
    {
        $profile->removeService($service);
        $this->em->persist($profile);
        $this->em->flush();
    }

    private static function fillEntityFromDto(Profile $profile, ProfileManagerDto $dto): Profile
    {
        $profile->setLastName($dto->last_name);
        $profile->setFirstName($dto->first_name);
        $profile->setSurname($dto->surname);
        $profile->setEmail($dto->email);
        $profile->setPhone($dto->phone);
        $profile->setExperience($dto->experience);

        return $profile;
    }

    /** @return ProfileRepository */
    private function getRepository(): EntityRepository
    {
        return $this->em->getRepository(Profile::class);
    }




}