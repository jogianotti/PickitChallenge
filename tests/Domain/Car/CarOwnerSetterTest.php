<?php

namespace App\Tests\Domain\Car;

use App\Domain\Car\CarOwnerSetter;
use App\Domain\Car\CarRepository;
use App\Domain\Owner\OwnerRepository;
use App\Tests\Domain\Owner\OwnerMother;
use Mockery;
use PHPUnit\Framework\TestCase;

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

        (new CarOwnerSetter($this->carRepository, $this->ownerRepository))($car->uuid(), $owner->uuid());
    }

    protected function setUp(): void
    {
        $this->carRepository = Mockery::mock(CarRepository::class);
        $this->ownerRepository = Mockery::mock(OwnerRepository::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
