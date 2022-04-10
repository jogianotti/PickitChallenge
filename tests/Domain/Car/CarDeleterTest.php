<?php

namespace App\Tests\Domain\Car;

use App\Domain\Car\Car;
use App\Domain\Car\CarDeleter;
use App\Domain\Car\CarRepository;
use App\Domain\Shared\Uuid;
use Hamcrest\Matchers;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

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

        (new CarDeleter($this->carRepository))(car: $car);
    }

    protected function setUp(): void
    {
        $this->carRepository = Mockery::mock(CarRepository::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
