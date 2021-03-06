<?php

namespace App\Tests\Domain\Car;

use App\Domain\Car\Car;
use App\Domain\Car\Patent;
use App\Domain\Shared\Uuid;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Fakecar;

final class CarMother
{
    private static Generator $generator;

    public static function create(): Car
    {
        return Car::create(
            uuid: new Uuid(self::generator()->uuid()),
            brand: self::generator()->vehicleBrand(),
            model: self::generator()->vehicleModel(),
            year: (int)self::generator()->year(),
            patent: new Patent(self::generator()->regexify('[A-Z]{2}[0-9]{3}[A-Z]{2}')),
            color: self::generator()->colorName(),
        );
    }

    public static function generator(): Generator
    {
        $faker = Factory::create();
        $faker->addProvider(new Fakecar($faker));

        return self::$generator = self::$generator ?? $faker;
    }
}
