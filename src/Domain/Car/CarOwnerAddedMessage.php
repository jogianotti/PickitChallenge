<?php

namespace App\Domain\Car;

use App\Domain\Shared\StatusMessage;
use App\Domain\Shared\Uuid;

class CarOwnerAddedMessage implements StatusMessage
{
    private string $status;

    public function __construct(Uuid $ownerId, Uuid $carId)
    {
        $this->status = sprintf('Added owner %s to car %s', $ownerId->value(), $carId->value());
    }

    public function status(): string
    {
        return $this->status;
    }
}
