<?php

namespace App\Domain\Transaction;

use App\Domain\Car\Car;

class AllTransactionsFinder
{
    public function __construct(
        private TransactionRepository $transactionRepository
    ) {
    }

    public function __invoke(Car $car, int $limit = 10, int $offset = 0): array
    {
        return $this->transactionRepository->all($car, $limit, $offset);
    }
}