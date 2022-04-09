<?php

namespace App\Domain\Car;

use App\Domain\Shared\InvalidArgumentException;

final class Patent
{
    private string $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $patent)
    {
        if (!$this->isValid($patent)) {
            throw new InvalidArgumentException('Invalid Patent');
        }

        $this->value = $patent;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function isValid(string $patent): bool
    {
        return $this->isValidOld($patent) || $this->isValidNew($patent);
    }

    private function isValidOld(string $patent): bool
    {
        return (bool)preg_match('/^[A-Z]{3}[\d]{3}$/i', str_replace(' ', '', $patent));
    }

    private function isValidNew(string $patent): bool
    {
        return (bool)preg_match('/^[A-Z]{2}[\d]{3}[A-Z]{2}$/i', str_replace(' ', '', $patent));
    }
}