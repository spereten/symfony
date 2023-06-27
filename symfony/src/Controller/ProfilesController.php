<?php

namespace App\Controller;

use App\Entity\ProfileService;
use App\Manager\ProfileManager;
use App\Manager\ServiceManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilesController extends AbstractController
{
    public function __construct(
        private readonly ProfileManager $profileService,
    ){}


    #[Route('/profile/{slug}', name: 'profile.detail')]
    public function detail(string $slug): Response
    {
        $profile = $this->profileService->getProfileBySlug($slug);

        return $this->render('/frontend/pages/profile.html.twig', ['profile' => $profile]);
    }

}
