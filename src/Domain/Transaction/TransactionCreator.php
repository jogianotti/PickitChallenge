<?php

namespace App\Domain\Transaction;

use App\Domain\Car\Car;
use App\Domain\Shared\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;

class TransactionCreator
{
    public function __construct(
        private TransactionRepository $transactionRepository,
        private MessageBusInterface $messageBus
    ) {
    }

    public function __invoke(Car $car, Uuid $uuid, array $services): Transaction
    {
        $transaction = Transaction::create($uuid, $services);
        $transaction->setCar($car);

        $this->transactionRepository->save($transaction);

        $this->messageBus->dispatch(new TransactionCreatedMessage($transaction->uuid(), $car->uuid()));

        return $transaction;
    }
}
