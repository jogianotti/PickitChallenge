<?php

namespace App\Api\Car;

use App\Domain\Car\CarUpdater;
use App\Domain\Car\Patent;
use App\Domain\Shared\EntityNotFoundException;
use App\Domain\Shared\InvalidArgumentException;
use App\Domain\Shared\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarPutController extends AbstractController
{
    #[Route('/cars/{id}', name: 'app_cars_put', methods: ['PUT'])]
    public function index(
        Request $request,
        string $id,
        CarUpdater $carUpdater
    ): Response {
        $data = $request->toArray();

        try {
            $this->validateData($data);
            $uuid = new Uuid($id);
            $patent = new Patent($data['patent']);

            $carUpdater(
                uuid: $uuid,
                brand: $data['brand'],
                model: $data['model'],
                year: (int)$data['year'],
                patent: $patent,
                color: $data['color']
            );
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

        return new Response(status: Response::HTTP_OK);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validateData(array $data): void
    {
        $parametersExists = isset(
            $data['brand'],
            $data['model'],
            $data['year'],
            $data['patent'],
            $data['color']
        );

        $parametersHasContent = !empty($data['brand'])
            && !empty($data['model'])
            && !empty($data['year'])
            && !empty($data['patent'])
            && !empty($data['color']);

        if (!$parametersExists || !$parametersHasContent) {
            throw new InvalidArgumentException('Parameters are missing');
        }
    }
}
