<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\ProfileService;
use App\Entity\Service;
use App\Manager\LocationManager;
use App\Manager\ProfileManager;
use App\Manager\ServiceManager;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
    private const DEFAULT_PAGE = 0;
    private const DEFAULT_PER_PAGE = 20;

    public function __construct(
        private readonly ProfileManager $profileService,
    ){}

    #[Route('/{location}/{slug}', name: 'service.location.profiles')]
    public function getProfilesForServiceWithLocation(
        Location $location,
        Service $service,
        Request $request): Response
    {
        $page = $request->query->get('page') ?? self::DEFAULT_PAGE;
        $perPage = self::DEFAULT_PER_PAGE;

        $criteria = ['service_id' => $service->getId(), 'location_id' => $location->getId()];
        $profiles = $this->profileService->getProfilesForService($criteria, $page , $perPage);


        return $this->render('/frontend/pages/service.html.twig', ['profiles' => $profiles, 'location' => $location]);
    }

    #[Route('/{slug}', name: 'service.profiles')]
    public function getProfilesForService(
        Service $service,
        Request $request): Response
    {
        $page = $request->query->get('page') ?? self::DEFAULT_PAGE;
        $perPage = self::DEFAULT_PER_PAGE;

        $criteria = ['service_id' => $service->getId()];
        $profiles = $this->profileService->getProfilesForService($criteria, $page , $perPage);

        return $this->render('/frontend/pages/service.html.twig', ['profiles' => $profiles]);
    }

}
