<?php

namespace App\Api\Car;

use App\Domain\Car\CarOwnerSetter;
use App\Domain\Shared\EntityNotFoundException;
use App\Domain\Shared\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarOwnerPutController extends AbstractController
{
    #[Route('/cars/{car}/owner/{owner}', name: 'app_cars_owner_put', methods: ['PUT'])]
    public function index(
        string $car,
        string $owner,
        CarOwnerSetter $carOwnerSetter
    ): Response {
        try {
            $carId = new Uuid($car);
            $ownerId = new Uuid($owner);

            $carOwnerSetter($carId, $ownerId);
        } catch (EntityNotFoundException $exception) {
            return new JsonResponse(
                data: [
                    "code" => Response::HTTP_NOT_FOUND,
                    "message" => $exception->getMessage(),
                ],
                status: Response::HTTP_NOT_FOUND
            );
        }

        return new Response(status: Response::HTTP_OK);
    }
}
