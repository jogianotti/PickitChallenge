<?php

namespace App\Domain\Car;

use App\Domain\Shared\Uuid;

class CarDeleter
{
    public function __construct(
        private CarRepository $carRepository
    ) {
    }

    public function __invoke(Uuid $uuid): void
    {
        $this->carRepository->delete($uuid->value());
    }
}