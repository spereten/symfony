<?php

namespace App\Controller;

use App\Entity\ProfileService;
use App\Manager\ProfileManager;
use App\Manager\ServiceManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
    private const DEFAULT_PAGE = 0;
    private const DEFAULT_PER_PAGE = 20;

    public function __construct(
        private readonly ServiceManager $serviceManager,
        private readonly ProfileManager $profileService,
    ){}


    #[Route('/{parentSlug}/{slug?}', name: 'services.detail')]
    public function getProfileForService(string $parentSlug, ?string $slug, Request $request): Response
    {

        $service = $this->serviceManager->findBySlug($slug ?? $parentSlug);
        $page = $request->query->get('page');

        if($service === null){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $profiles = $this->profileService->getProfilesForService($service->getId(), $page ?? self::DEFAULT_PAGE, self::DEFAULT_PER_PAGE);

        return $this->render('/frontend/pages/service.html.twig', ['profiles' => $profiles]);


    }

}
