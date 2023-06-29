<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AbstractApiController  extends AbstractController
{
    private array $errors = [];
    private array $data = [];

    protected function sendResponseNotFountEntity(): JsonResponse
    {

    }

    protected function sendErrorJsonResponse(): JsonResponse
    {

    }

    public function sendJsonResponse(): JsonResponse
    {
        if($this->errors){
            return new JsonResponse(['errors' => $this->errors], Response::HTTP_);

        }
    }
}