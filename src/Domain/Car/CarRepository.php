<?php

namespace App\Domain\Car;

interface CarRepository
{
    public function save(Car $car): void;
}