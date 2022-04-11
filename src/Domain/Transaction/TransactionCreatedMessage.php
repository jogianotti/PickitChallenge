<?php

namespace App\Domain\Transaction;

use App\Domain\Shared\StatusMessage;
use App\Domain\Shared\Uuid;

class TransactionCreatedMessage implements StatusMessage
{
    private string $status;

    public function __construct(Uuid $transactionId, Uuid $carId)
    {
        $this->status = sprintf(
            'Created transaction %s to car %s',
            $transactionId->value(),
            $carId->value()
        );
    }

    public function status(): string
    {
        return $this->status;
    }
}
