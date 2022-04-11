<?php

namespace App\Api\Transaction;

use App\Domain\Car\Car;
use App\Domain\Car\CarFinder;
use App\Domain\Shared\EntityNotFoundException;
use App\Domain\Shared\InvalidArgumentException;
use App\Domain\Shared\Uuid;
use App\Domain\Transaction\Transaction;
use App\Domain\Transaction\TransactionCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionPostController extends AbstractController
{
    #[Route('/cars/{id}/transactions', name: 'app_cars_transactions_post', methods: ['POST'])]
    public function index(
        Request $request,
        string $id,
        CarFinder $carFinder,
        TransactionCreator $transactionCreator
    ): Response {
        $data = $request->toArray();

        try {
            $this->validateData($data);
            $uuid = new Uuid($data['uuid']);
            $car = $carFinder(new Uuid($id));
            $this->validateServices($car, $data['services']);

            $transaction = $transactionCreator(
                car: $car,
                uuid: $uuid,
                services: $data['services'],
            );

            return new JsonResponse(
                data: ["total" => $transaction->total()]
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
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validateData(array $data): void
    {
        $parametersExists = isset($data['uuid'], $data['services']);
        $parametersHasContent = !empty($data['uuid']) && !empty($data['services']);

        if (!$parametersExists || !$parametersHasContent) {
            throw new InvalidArgumentException('Parameters are missing');
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validateServices(Car $car, array $services): void
    {
        foreach ($services as $service) {
            $valid = in_array($service['service'], Transaction::$availableServices, strict: true);
            if (!$valid) {
                throw new InvalidArgumentException('Invalid services');
            }

            if (!$car->canApply($service['service'])) {
                throw new InvalidArgumentException('Service not allowed');
            }
        }
    }
}
