<?php

namespace App\Domain\Owner;

use App\Domain\Shared\StatusMessage;
use App\Domain\Shared\Uuid;

class OwnerCreatedMessage implements StatusMessage
{
    private string $status;

    public function __construct(Uuid $id)
    {
        $this->status = sprintf('Updated owner %s', $id->value());
    }

    public function status(): string
    {
        return $this->status;
    }
}