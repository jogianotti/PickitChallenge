<?php

namespace App\Tests\Domain\Car;

use App\Domain\Car\CarDeleter;
use App\Domain\Car\CarRepository;
use App\Domain\Shared\Uuid;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class DeleteCarTest extends TestCase
{
    private MockInterface|CarRepository $carRepository;

    /** @doesNotPerformAssertions */
    public function testItShouldDeleteACar(): void
    {
        $uuid = new Uuid('5b897388-48c7-4c2a-a86e-2dedc22c908c');

        $this->carRepository
            ->shouldReceive('delete')
            ->with($uuid->value())
            ->once();

        (new CarDeleter($this->carRepository))($uuid);
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
