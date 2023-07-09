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

    public function getProfilesForService(array $criteria, int $page, int $perPage): array
    {
        if(empty($criteria['service_id'])){
            throw new \InvalidArgumentException('Bad parameter service_id');
        }
        return $this->getRepository()->getProfileForServiceWithPagination($criteria, $page, $perPage);
    }

    /**
     * @var Service $newServices[]
     * @var Service $removeServices[]
     *
     */
    public function syncProfileWithServices(Profile $profile, array $servicesWhichNeedAdd, array $servicesWhichNeedDelete): bool
    {

        array_map(fn($service) => $profile->addService($service), $servicesWhichNeedAdd);
        array_map(fn($service) => $profile->removeService($service), $servicesWhichNeedDelete);

        $this->em->flush();

        return true;
    }

    public function saveProfile(ProfileManagerDto $profileManagerDto, bool $flush = true): Profile
    {
        $profileEntity = new Profile();
        $profileEntity = self::fillEntityFromDto($profileEntity, $profileManagerDto);
        $this->getRepository()->save($profileEntity, $flush);

        return $profileEntity;
    }

    public function updateProfile(Profile $profile, ProfileManagerDto $profileManagerDto, bool $flush = true): Profile
    {
        $profileEntity = self::fillEntityFromDto($profile, $profileManagerDto);
        $this->getRepository()->save($profileEntity, $flush);

        return $profileEntity;
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

    public function deleteProfile(int $profileId, bool $flush = true): bool
    {
        $profile = $this->getProfileById($profileId);
        if($profile === null){
            return false;
        }
        $this->getRepository()->remove($profile, $flush);

        return true;
    }


    /** @return ProfileRepository */
    private function getRepository(): EntityRepository
    {
        return $this->em->getRepository(Profile::class);
    }

}