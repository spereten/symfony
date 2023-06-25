<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\Service;
use App\Manager\ServiceManager;
use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
    public function __construct(private readonly ServiceManager $serviceManager)
    {
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
       $services = $this->serviceManager->getTreeAllServiceFromEntities();

       return $this->render('/frontend/pages/index.html.twig', ['services' => $services]);
    }
}
