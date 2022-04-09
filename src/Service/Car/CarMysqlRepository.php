<?php

namespace App\Service\Car;

use App\Domain\Car\Car;
use App\Domain\Car\CarRepository;

class CarMysqlRepository implements CarRepository
{

    public function save(Car $car): void
    {
        // TODO: Implement save() method.
    }
}