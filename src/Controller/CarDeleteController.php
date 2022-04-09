<?php

namespace App\Controller;

use App\Domain\Car\CarDeleter;
use App\Domain\Shared\InvalidArgumentException;
use App\Domain\Shared\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarDeleteController extends AbstractController
{
    #[Route('/cars/{id}', name: 'app_car_delete', methods: ['DELETE'])]
    public function index(string $id, CarDeleter $carDeleter): Response
    {
        try {
            $uuid = new Uuid($id);

            $carDeleter($uuid);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(
                data: [
                    "code" => Response::HTTP_BAD_REQUEST,
                    "message" => $exception->getMessage(),
                ],
                status: Response::HTTP_BAD_REQUEST
            );
        }

        return new Response();
    }
}
