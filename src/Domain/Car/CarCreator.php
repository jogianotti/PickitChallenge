<?php

namespace App\Domain\Car;

use App\Domain\Shared\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;

class CarCreator
{
    public function __construct(
        private CarRepository $carRepository,
        private MessageBusInterface $messageBus
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
        $car = Car::create(
            uuid: $uuid,
            brand: $brand,
            model: $model,
            year: $year,
            patent: $patent,
            color: $color
        );

        $this->carRepository->save($car);

        $this->messageBus->dispatch(new CreatedCarMessage(id: $uuid));
    }
}
