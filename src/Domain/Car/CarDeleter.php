<?php

namespace App\Domain\Car;

class CarDeleter
{
    public function __construct(
        private CarRepository $carRepository
    ) {
    }

    public function __invoke(Car $car): void
    {
        $this->carRepository->delete(car: $car);
    }
}