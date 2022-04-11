<?php

namespace App\Domain\Car;

use App\Domain\Shared\StatusMessage;
use App\Domain\Shared\Uuid;

class CreatedCarMessage implements StatusMessage
{
    private string $status;

    public function __construct(Uuid $id)
    {
        $this->status = sprintf('Created car %s', $id->value());
    }

    public function status(): string
    {
        return $this->status;
    }
}
