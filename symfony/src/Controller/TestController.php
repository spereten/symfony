<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\Service;
use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em,
                                private ProfileRepository $profileRepository)
    {
    }

    #[Route('/test', name: 'app_test')]
    public function index(): JsonResponse
    {

        $repository = $this->em->getRepository(Profile::class)->findAll();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }
}
