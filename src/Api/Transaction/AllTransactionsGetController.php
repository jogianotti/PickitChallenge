<?php

namespace App\Api\Transaction;

use App\Domain\Car\CarFinder;
use App\Domain\Shared\EntityNotFoundException;
use App\Domain\Shared\InvalidArgumentException;
use App\Domain\Shared\Uuid;
use App\Domain\Transaction\AllTransactionsFinder;
use App\Domain\Transaction\TransactionSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllTransactionsGetController extends AbstractController
{
    #[Route('/cars/{id}/transactions', name: 'app_cars_transactions_get', methods: ['GET'])]
    public function index(
        Request $request,
        string $id,
        AllTransactionsFinder $allTransactionsFinder,
        CarFinder $carFinder
    ): Response {
        try {
            $car = $carFinder(new Uuid($id));
            $limit = $request->get('limit', 10);
            $offset = $request->get('offset', 0);

            $transactions = $allTransactionsFinder($car, $limit, $offset);

            return new JsonResponse(TransactionSerializer::arrayToJson($transactions));
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
