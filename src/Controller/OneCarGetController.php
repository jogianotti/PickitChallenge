<?php

namespace App\Controller;

use App\Domain\Car\CarFinder;
use App\Domain\Shared\EntityNotFoundException;
use App\Domain\Shared\InvalidArgumentException;
use App\Domain\Shared\Uuid;
use App\Tests\Domain\Car\CarSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OneCarGetController extends AbstractController
{
    #[Route('/cars/{id}', name: 'app_car_get', methods: ['GET'])]
    public function index(string $id, CarFinder $carFinder): Response
    {
        try {
            $uuid = new Uuid($id);
            $car = $carFinder($uuid);

            return new JsonResponse(CarSerializer::toJson($car));
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
    }
}
