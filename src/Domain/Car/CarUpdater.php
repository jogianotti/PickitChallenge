<?php

namespace App\Domain\Car;

use App\Domain\Shared\EntityNotFoundException;
use App\Domain\Shared\Uuid;

class  CarUpdater
{
    public function __construct(
        private CarRepository $carRepository
    ) {
    }

    public function __invoke(
        Uuid $uuid,
        string $brand,
        string $model,
        int $year,
        Patent $patent,
        string $color
    ): void {
        $car = $this->carRepository->one($uuid->value());

        if (!$car) {
            throw new EntityNotFoundException('Car not found');
        }

        $car->setBrand($brand)
            ->setModel($model)
            ->setColor($color)
            ->setPatent($patent)
            ->setYear($year);

        $this->carRepository->save($car);
    }
}