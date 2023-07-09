<?php

namespace App\Controller;

use App\Entity\Location;
use App\Manager\LocationManager;
use App\Manager\ServiceManager;
use App\Symfony\Route\CustomMatcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PagesController extends AbstractController
{
    public function __construct(
        private readonly ServiceManager $serviceManager,
        private readonly LocationManager $locationManager,
    ){}

    #[Route('/{location?}', condition: "service('route_match_location').check(request, params, context)" )]

    public function home(?Location $location): Response
    {
       $services = $this->serviceManager->getTreeAllServiceFromEntities();
       return $this->render('/frontend/pages/index.html.twig', ['services' => $services, 'location' => $location]);
    }
}
