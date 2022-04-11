<?php

namespace App\Tests\Domain\Car;

use App\Domain\Car\Car;
use App\Domain\Car\CarDeleter;
use App\Domain\Car\CarRepository;
use App\Domain\Car\DeletedCarMessage;
use App\Domain\Shared\Uuid;
use Hamcrest\Matchers;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class CarDeleterTest extends TestCase
{
    private MockInterface|CarRepository $carRepository;

    /** @doesNotPerformAssertions */
    public function testItShouldDeleteACar(): void
    {
        $uuid = new Uuid('5b897388-48c7-4c2a-a86e-2dedc22c908c');
        $car = new Car($uuid);

        $this->carRepository
            ->shouldReceive('delete')
            ->with(Matchers::equalTo($car))
            ->once();

        $message = new DeletedCarMessage(id: $uuid);
        $this->messageBus
            ->shouldReceive('dispatch')
            ->with(Matchers::equalTo($message))
            ->once()
            ->andReturn(new Envelope($message));

        (new CarDeleter($this->carRepository, $this->messageBus))(car: $car);
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
