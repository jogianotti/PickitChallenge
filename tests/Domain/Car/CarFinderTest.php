<?php

namespace App\Tests\Domain\Car;

use App\Domain\Car\CarFinder;
use App\Domain\Car\CarRepository;
use App\Domain\Shared\Uuid;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class CarFinderTest extends TestCase
{
    private MockInterface|CarRepository $carRepository;

    /** @doesNotPerformAssertions */
    public function testItShouldFindAllCars(): void
    {
        $uuid = new Uuid('d44e052f-2d9d-4d97-b377-16b8ad2421a1');

        $this->carRepository
            ->shouldReceive('one')
            ->with($uuid->value())
            ->once();

        (new CarFinder($this->carRepository))($uuid);
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
