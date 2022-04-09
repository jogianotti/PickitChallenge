<?php

namespace App\Tests\Domain\Car;

use App\Domain\Car\AllCarsFinder;
use App\Domain\Car\CarRepository;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class AllCarsFinderTest extends TestCase
{
    private MockInterface|CarRepository $carRepository;

    /** @doesNotPerformAssertions */
    public function testItShouldFindAllCars(): void
    {
        $limit = 10;
        $offset = 0;

        $this->carRepository
            ->shouldReceive('all')
            ->with($limit, $offset)
            ->once();

        (new AllCarsFinder($this->carRepository))($limit, $offset);
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
