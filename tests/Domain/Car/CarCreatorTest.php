<?php

namespace App\Tests\Domain\Car;

use App\Domain\Car\Car;
use App\Domain\Car\CarCreator;
use App\Domain\Car\CarRepository;
use App\Domain\Car\Patent;
use App\Domain\Shared\Uuid;
use Hamcrest\Matchers;
use Mockery;
use PHPUnit\Framework\TestCase;

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

        (new CarCreator($this->carRepository))($uuid, $brand, $model, $year, $patent, $color);
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
