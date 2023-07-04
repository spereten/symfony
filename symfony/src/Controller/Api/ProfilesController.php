<?php

namespace App\Controller\Api;

use App\DTO\ProfileManagerDto;
use App\Entity\Profile;
use App\Manager\ProfileManager;
use App\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/profile', name: 'api.profile.')]
class ProfilesController extends AbstractController
{
    public function __construct(
        private readonly ProfileManager $profileManager,
        private readonly ProfileService $profileService,
    ){}

    #[Route('/{slug}', name: 'api.profile.by_slug', methods: 'GET')]
    public function getProfileBySlug(?Profile $profile): JsonResponse
    {
        if($profile === null){
            return new JsonResponse(['errors' => ['status' => Response::HTTP_NOT_FOUND, 'title' => 'Профиль пользователя не найден' ]], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse(['data' => $profile->toArray()], Response::HTTP_OK);
    }

    #[Route('/', name: 'create', methods: 'POST')]
    public function createProfile(Request $request): JsonResponse
    {
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        $surname = $request->get('surname');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $experience = $request->get('experience');

        try {
            $dto = new ProfileManagerDto(
                first_name: $first_name, last_name: $last_name, surname: $surname, email : $email, phone: $phone, experience:$experience
            );
            $profile = $this->profileManager->saveProfile($dto);
        }catch (\Throwable $exception){
            $errors[] =  ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'title' => $exception->getMessage()];
            return new JsonResponse(['errors' => $errors], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['data' => $profile->toArray()]);
    }

    #[Route('/{slug}', name: 'update', methods: 'PATCH')]
    public function updateProfile(?Profile $profile, Request $request): JsonResponse
    {
        if($profile === null){
            return new JsonResponse(['errors' => ['status' => Response::HTTP_NOT_FOUND, 'title' => 'Профиль пользователя не найден' ]], Response::HTTP_NOT_FOUND);
        }

        $first_name = $request->request->get('first_name');
        $last_name = $request->request->get('last_name');
        $surname = $request->request->get('surname');
        $email = $request->request->get('email');
        $phone = $request->request->get('phone');
        $experience = $request->request->get('experience');

        try {
            $dto = new ProfileManagerDto(
                first_name: $first_name, last_name: $last_name, surname: $surname, email : $email, phone: $phone, experience: $experience
            );
            $profile = $this->profileManager->updateProfile($profile->getId(), $dto);
        }catch (\Throwable $exception){
            $errors[] =  ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'title' => $exception->getMessage()];
            return new JsonResponse(['errors' => $errors], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['data' => $profile]);
    }

    #[Route('/{slug}', name: 'update', methods: 'DELETE')]
    public function deleteProfile(?Profile $profile): JsonResponse
    {
        if($profile === null){
            return new JsonResponse(['errors' => ['status' => Response::HTTP_NOT_FOUND, 'title' => 'Профиль пользователя не найден' ]], Response::HTTP_NOT_FOUND);
        }
        $result = $this->profileManager->deleteProfile($profile->getId());
        return new JsonResponse(['data' => $result]);

    }

    #[Route('/{slug}/sync-services', name: 'sync-services', methods: 'PATCH')]
    public function syncServicesForProfile(?Profile $profile, Request $request): JsonResponse
    {
        if($profile === null){
            return new JsonResponse(['errors' => ['status' => Response::HTTP_NOT_FOUND, 'title' => 'Профиль пользователя не найден' ]], Response::HTTP_NOT_FOUND);
        }

        $services = (array)$request->request->get('services');

        $result = $this->profileService->syncProfileWithServices($profile->getId(), $services);

        return new JsonResponse(['data' => $result]);
    }





}
