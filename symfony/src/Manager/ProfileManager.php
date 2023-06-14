<?php

namespace App\Manager;

use App\DTO\ProfileManagerDto;
use App\Entity\Profile;
use App\Entity\ProfileEntity;
use App\Repository\ProfileRepository;

class ProfileManager
{
    public function __construct(private readonly ProfileRepository $profileRepository)
    {
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
        $profileEntity->setCreatedAt();
        $profileEntity->setUpdatedAt();

        $this->profileRepository->save($profileEntity, $flush);


        return $profileEntity;
    }
}