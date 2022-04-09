<?php

namespace App\Domain\Car;

interface CarRepository
{
    public function save(Car $car): void;

    public function all(int $limit, int $offset): array;
}