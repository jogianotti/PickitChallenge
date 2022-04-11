<?php

namespace App\Tests\Domain\Car;

use App\Domain\Car\CarRepository;
use App\Domain\Car\CarUpdater;
use App\Domain\Car\UpdatedCarMessage;
use Hamcrest\Matchers;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class CarUpdaterTest extends TestCase
{
    /** @doesNotPerformAssertions */
    public function testItShouldUpdateACar(): void
    {
        $original = CarMother::create();

        $updated = clone $original;
        $updated->setBrand(brand: 'NewBrand');
        $updated->setModel(model: 'NewModel');
        $updated->setColor(color: 'NewColor');

        $this->carRepository
            ->shouldReceive('one')
            ->with($original->uuid()->value())
            ->once()
            ->andReturn($original);

        $this->carRepository
            ->shouldReceive('save')
            ->with(Matchers::equalTo($updated))
            ->once();

        $message = new UpdatedCarMessage(id: $updated->uuid());
        $this->messageBus
            ->shouldReceive('dispatch')
            ->with(Matchers::equalTo($message))
            ->once()
            ->andReturn(new Envelope($message));

        (new CarUpdater($this->carRepository, $this->messageBus))(
            $updated->uuid(),
            $updated->brand(),
            $updated->model(),
            $updated->year(),
            $updated->patent(),
            $updated->color()
        );
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
