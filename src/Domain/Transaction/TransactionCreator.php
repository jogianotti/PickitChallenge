<?php

namespace App\Domain\Transaction;

use App\Domain\Car\Car;
use App\Domain\Shared\Uuid;

class TransactionCreator
{
    public function __construct(
        private TransactionRepository $transactionRepository,
    ) {
    }

    public function __invoke(Car $car, Uuid $uuid, array $services): Transaction
    {
        $transaction = Transaction::create($uuid, $services);
        $transaction->setCar($car);

        $this->transactionRepository->save($transaction);

        return $transaction;
    }
}
