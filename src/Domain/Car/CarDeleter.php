<?php

namespace App\Domain\Car;

use Symfony\Component\Messenger\MessageBusInterface;

class CarDeleter
{
    public function __construct(
        private CarRepository $carRepository,
        private MessageBusInterface $messageBus

    ) {
    }

    public function __invoke(Car $car): void
    {
        $this->carRepository->delete(car: $car);

        $this->messageBus->dispatch(new DeletedCarMessage(id: $car->uuid()));
    }
}
