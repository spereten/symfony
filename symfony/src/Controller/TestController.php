<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\Service;
use App\Repository\ProfileRepository;
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
        $criteria = Criteria::create();//->orderBy(['id' => 'rand']);
        $criteria->andWhere(Criteria::expr()->eq('id', 1));
        $repository = $this->em->getRepository(Profile::class);

        dd($this->profileRepository->findAll());
        dd();
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
