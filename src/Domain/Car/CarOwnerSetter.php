<?php

namespace App\Domain\Car;

use App\Domain\Owner\OwnerRepository;
use App\Domain\Shared\EntityNotFoundException;
use App\Domain\Shared\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;

class CarOwnerSetter
{
    public function __construct(
        private CarRepository $carRepository,
        private OwnerRepository $ownerRepository,
        private MessageBusInterface $messageBus
    ) {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function __invoke(Uuid $carId, Uuid $ownerId)
    {
        $car = $this->carRepository->one($carId->value());
        if (!$car) {
            throw new EntityNotFoundException('Car not found');
        }

        $owner = $this->ownerRepository->one($ownerId->value());
        if (!$owner) {
            throw new EntityNotFoundException('Owner not found');
        }

        $car->setOwner($owner);

        $this->carRepository->save($car);

        $this->messageBus->dispatch(new CarOwnerAddedMessage(ownerId: $ownerId, carId: $carId));
    }
}
