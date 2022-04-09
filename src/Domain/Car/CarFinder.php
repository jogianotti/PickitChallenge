<?php

namespace App\Domain\Car;

use App\Domain\Shared\Uuid;

class CarFinder
{
    public function __construct(
        private CarRepository $carRepository
    ) {
    }

    public function __invoke(Uuid $uuid): ?Car
    {
        return $this->carRepository->one($uuid->value());
    }
}