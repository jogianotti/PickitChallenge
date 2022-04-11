<?php

namespace App\Tests\Domain\Car;

use App\Domain\Car\CarOwnerAddedMessage;
use App\Domain\Car\CarOwnerSetter;
use App\Domain\Car\CarRepository;
use App\Domain\Owner\OwnerRepository;
use App\Tests\Domain\Owner\OwnerMother;
use Hamcrest\Matchers;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class CarOwnerSetterTest extends TestCase
{
    /** @doesNotPerformAssertions */
    public function testItShouldSetCarOwner(): void
    {
        $car = CarMother::create();
        $owner = OwnerMother::create();

        $this->ownerRepository
            ->shouldReceive('one')
            ->with($owner->uuid()->value())
            ->once()
            ->andReturn($owner);

        $this->carRepository
            ->shouldReceive('one')
            ->with($car->uuid()->value())
            ->once()
            ->andReturn($car);

        $car->setOwner($owner);

        $this->carRepository
            ->shouldReceive('save')
            ->with($car)
            ->once();

        $message = new CarOwnerAddedMessage(ownerId: $owner->uuid(), carId: $car->uuid());
        $this->messageBus
            ->shouldReceive('dispatch')
            ->with(Matchers::equalTo($message))
            ->once()
            ->andReturn(new Envelope($message));

        (new CarOwnerSetter(
            $this->carRepository, $this->ownerRepository, $this->messageBus
        ))(
            $car->uuid(),
            $owner->uuid()
        );
    }

    protected function setUp(): void
    {
        $this->carRepository = Mockery::mock(CarRepository::class);
        $this->ownerRepository = Mockery::mock(OwnerRepository::class);
        $this->messageBus = Mockery::mock(MessageBusInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
