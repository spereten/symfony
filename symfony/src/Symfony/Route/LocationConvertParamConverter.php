<?php
namespace App\Symfony\Route;

use App\Entity\Location;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use App\Manager\LocationManager;
use Symfony\Component\HttpFoundation\Request;

class LocationConvertParamConverter implements ParamConverterInterface
{

    public function __construct(
        private readonly LocationManager $locationManager
    ){}

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $parameter = $request->attributes->get('location');
        $location = null;

        if($parameter){
            $location = $this->locationManager->getLocationBySlug($parameter);
        }

        $request->attributes->set('location', $location);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === Location::class;
    }
}

