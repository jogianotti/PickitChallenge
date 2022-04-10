<?php

namespace App\Controller\Car;

use App\Domain\Car\CarDeleter;
use App\Domain\Car\CarFinder;
use App\Domain\Shared\EntityNotFoundException;
use App\Domain\Shared\InvalidArgumentException;
use App\Domain\Shared\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarDeleteController extends AbstractController
{
    #[Route('/cars/{id}', name: 'app_car_delete', methods: ['DELETE'])]
    public function index(string $id, CarFinder $carFinder, CarDeleter $carDeleter): Response
    {
        try {
            $car = $carFinder(uuid: new Uuid($id));

            $carDeleter(car: $car);
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(
                data: [
                    "code" => Response::HTTP_BAD_REQUEST,
                    "message" => $exception->getMessage(),
                ],
                status: Response::HTTP_BAD_REQUEST
            );
        } catch (EntityNotFoundException $exception) {
            return new JsonResponse(
                data: [
                    "code" => Response::HTTP_NOT_FOUND,
                    "message" => $exception->getMessage(),
                ],
                status: Response::HTTP_NOT_FOUND
            );
        }

        return new Response();
    }
}
