<?php

namespace App\Tests\Domain\Car;

use App\Domain\Car\Car;
use App\Domain\Car\CarCreator;
use App\Domain\Car\CarRepository;
use App\Domain\Car\CreatedCarMessage;
use App\Domain\Car\Patent;
use App\Domain\Shared\Uuid;
use Hamcrest\Matchers;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class CarCreatorTest extends TestCase
{
    /** @doesNotPerformAssertions */
    public function testItShouldCreateACar(): void
    {
        $uuid = new Uuid('9239c274-3240-4730-9eac-1c3ec595c346');
        $brand = 'Renault';
        $model = 'Duster';
        $year = 2021;
        $patent = new Patent('YR578ER');
        $color = 'Naranja';

        $car = Car::create(
            uuid: $uuid,
            brand: $brand,
            model: $model,
            year: $year,
            patent: $patent,
            color: $color
        );

        $this->carRepository
            ->shouldReceive('save')
            ->with(Matchers::equalTo($car))
            ->once();

        $message = new CreatedCarMessage(id: $uuid);
        $this->messageBus
            ->shouldReceive('dispatch')
            ->with(Matchers::equalTo($message))
            ->once()
            ->andReturn(new Envelope($message));

        (new CarCreator($this->carRepository, $this->messageBus))($uuid, $brand, $model, $year, $patent, $color);
    }

    protected function setUp(): void
    {
        $this->carRepository = Mockery::mock(CarRepository::class);
        $this->messageBus = Mockery::mock(MessageBusInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
