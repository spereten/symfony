<?php

namespace App\Controller\Api;

use App\DTO\ProfileManagerDto;
use App\Manager\ProfileManager;
use App\Service\ServiceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilesController extends AbstractController
{
    public function __construct(
        private readonly ProfileManager $profileService,
        private readonly ServiceService $serviceService,
    ){}

    #[Route('/api/profile/{slug}', name: 'api.profile.by_slug', methods: 'GET')]
    public function getProfileBySlug(string $slug): JsonResponse
    {
        $profile = $this->profileService->getProfileBySlug($slug);
        if($profile === null){
            return new JsonResponse(['errors' => ['status' => Response::HTTP_NOT_FOUND, 'title' => 'Профиль пользователя не найден' ]], Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse(['data' => $profile->toArray()], Response::HTTP_OK);
    }

    #[Route('/api/profile', name: 'api.profile.create', methods: 'POST')]
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
            $profile = $this->profileService->saveProfile($dto);
        }catch (\Throwable $exception){
            $errors[] =  ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'title' => $exception->getMessage()];
            return new JsonResponse(['errors' => $errors], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['data' => $profile->toArray()]);
    }

    #[Route('/api/profile/{slug}', name: 'api.profile.update', methods: 'PATCH')]
    public function updateProfile(string $slug, Request $request): JsonResponse
    {
        $profile = $this->profileService->getProfileBySlug($slug);
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
            $profile = $this->profileService->updateProfile($profile->getId(), $dto);
        }catch (\Throwable $exception){
            $errors[] =  ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'title' => $exception->getMessage()];
            return new JsonResponse(['errors' => $errors], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['data' => $profile]);
    }

    #[Route('/api/profile/{slug}', name: 'api.profile.update', methods: 'DELETE')]
    public function deleteProfile(string $slug): JsonResponse
    {
        $profile = $this->profileService->getProfileBySlug($slug);
        if($profile === null){
            return new JsonResponse(['errors' => ['status' => Response::HTTP_NOT_FOUND, 'title' => 'Профиль пользователя не найден' ]], Response::HTTP_NOT_FOUND);
        }
        $result = $this->profileService->deleteProfile($profile->getId());
        return new JsonResponse(['data' => $result]);

    }

    #[Route('/api/test/{slug}', name: 'api.profile.attach_services', methods: 'GET')]
    public function attachServiceForProfile(string $slug, Request $request): JsonResponse
    {
        $profile = $this->profileService->getProfileBySlug($slug);
        if($profile === null){
            return new JsonResponse(['errors' => ['status' => Response::HTTP_NOT_FOUND, 'title' => 'Профиль пользователя не найден' ]], Response::HTTP_NOT_FOUND);
        }

        $servicesIds = $request->request->get('services');
        $servicesIds = [1,2,3,4,5];
        if(!empty($servicesIds)){
           $r =  $this->serviceService->attachServicesToProfile($profile->getId(), $servicesIds);
        }

        return new JsonResponse(['data' => []]);
    }





}
