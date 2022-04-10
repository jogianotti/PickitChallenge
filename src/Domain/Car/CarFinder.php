<?php

namespace App\Domain\Car;

use App\Domain\Shared\EntityNotFoundException;
use App\Domain\Shared\Uuid;

class CarFinder
{
    public function __construct(
        private CarRepository $carRepository
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function __invoke(Uuid $uuid): Car
    {
        $car = $this->carRepository->one($uuid->value());

        if (!$car) {
            throw new EntityNotFoundException('Car not found');
        }

        return $car;
    }
}