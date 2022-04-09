<?php

namespace App\Domain\Shared;

final class Uuid
{
    private string $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $uuid)
    {
        if (!\Ramsey\Uuid\Uuid::isValid($uuid)) {
            throw new InvalidArgumentException('Invalid UUID');
        }

        $this->value = $uuid;
    }

    public function value(): string
    {
        return $this->value;
    }
}
