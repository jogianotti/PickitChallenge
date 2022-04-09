<?php

namespace App\Controller;

use App\Domain\Shared\InvalidArgumentException;
use App\Domain\Shared\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OneCarGetController extends AbstractController
{
    #[Route('/cars/{id}', name: 'app_car_get', methods: ['GET'])]
    public function index(string $id): Response
    {
        try {
            $uuid = new Uuid($id);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(
                data: [
                    "code" => Response::HTTP_BAD_REQUEST,
                    "message" => $exception->getMessage(),
                ],
                status: Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse([]);
    }
}