<?php

namespace App\Symfony\Route;

use App\Manager\LocationManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Attribute\AsRoutingConditionService;

#[AsRoutingConditionService(alias: 'route_match_location')]

class CustomMatcher
{
    public function __construct(private readonly LocationManager $locationManager)
    {
    }

    public function check(Request $request, $params, $context): bool
    {
        return $this->locationManager->hasLocationBySlug($params['location']);
    }
}