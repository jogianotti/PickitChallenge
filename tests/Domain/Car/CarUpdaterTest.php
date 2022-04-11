<?php

namespace App\Tests\Domain\Car;

use App\Domain\Car\CarRepository;
use App\Domain\Car\CarUpdater;
use Hamcrest\Matchers;
use Mockery;
use PHPUnit\Framework\TestCase;

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

        (new CarUpdater($this->carRepository))(
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
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
