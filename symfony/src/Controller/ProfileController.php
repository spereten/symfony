<?php

namespace App\Controller;

use App\Entity\ProfileEntity;
use App\Repository\Contract\ProfileRepositoryInterface;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    public function __construct(private readonly ProfileRepository $profileRepository)
    {
    }

    #[Route('/profile', name: 'profile.index', methods: 'GET')]
    public function index(): Response
    {
        $profiles = $this->profileRepository->findAll();

        return $this->render('profile/profile-index.html.twig', [
            'profiles' => $profiles,
        ]);
    }
}
