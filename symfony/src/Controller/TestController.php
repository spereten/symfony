<?php

namespace App\Controller;

use App\Entity\Service;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route('/test', name: 'app_test')]
    public function index(): JsonResponse
    {

        $food = new Service();
        $food->setTitle('Food');

        $fruits = new Service();
        $fruits->setTitle('Fruits');
        $fruits->setParent($food);

        $vegetables = new Service();
        $vegetables->setTitle('Vegetables');
        $vegetables->setParent($food);

        $carrots = new Service();
        $carrots->setTitle('Carrots');
        $carrots->setParent($vegetables);

        $this->em->persist($food);
        $this->em->persist($fruits);
        $this->em->persist($vegetables);
        $this->em->persist($carrots);
        $this->em->flush();
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }
}
