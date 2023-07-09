<?php

namespace App\Symfony\Route;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;



class CustomCondition
{
    public function matches(Request $request)
    {
        $parameter = $request->query->get('location');

        return $parameter !== null && $parameter === 'some_value';
    }

}

