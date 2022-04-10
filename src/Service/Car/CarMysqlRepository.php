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

    public function all(int $limit, int $offset): array
    {
        // TODO: Implement all() method.
    }

    public function one(string $id): ?Car
    {
        // TODO: Implement one() method.

        return null;
    }

    public function delete(string $id): void
    {
        // TODO: Implement delete() method.
    }
}
