<?php

namespace App\Controller;

use App\Entity\ProfileService;
use App\Manager\ProfileManager;
use App\Manager\ServiceManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
    public function __construct(
        private readonly ServiceManager $serviceManager,
        private readonly ProfileManager $profileService,
    ){}

    #[Route('/service', name: 'services.index')]
    public function index(): Response
    {

    }
    #[Route('/{parentSlug}/{slug}', name: 'services.detail')]
    public function detail(string $parentSlug, string $slug): Response
    {
        $service = $this->serviceManager->findBySlug($slug);
        if($service){
            //response code;
        }

        $r = $this->profileService->getProfilesForService($service->getId());
        dd($r);


    }

}
