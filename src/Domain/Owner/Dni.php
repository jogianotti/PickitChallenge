<?php

namespace App\Domain\Owner;

use App\Domain\Shared\InvalidArgumentException;

final class Dni
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $value
    ) {
        $this->validateDni($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validateDni(string $value): void
    {
        if (!preg_match('/\d{8}/', $value)) {
            throw new InvalidArgumentException('Invalid DNI');
        }
    }
}