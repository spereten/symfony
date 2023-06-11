<?php

namespace App\Controller;

use App\Entity\ProfileEntity;
use App\Repository\Contract\ProfileRepositoryInterface;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    public function __construct(private readonly ProfileRepository $profileRepository)
    {

    }

    #[Route('/test', name: 'app_test')]
    public function index(): JsonResponse
    {
        $profileEntity = new ProfileEntity();
        $profileEntity->setFirstName('Геннадий')->setFirstName('Дмитриевич')->setSurname('Фомин');
        $this->profileRepository->save($profileEntity);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }
}
