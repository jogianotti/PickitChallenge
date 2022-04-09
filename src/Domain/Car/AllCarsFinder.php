<?php

namespace App\Domain\Car;

class AllCarsFinder
{
    public function __construct(
        private CarRepository $carRepository
    ) {
    }

    public function __invoke(int $limit = 10, int $offset = 0): array
    {
        return $this->carRepository->all($limit, $offset);
    }
}