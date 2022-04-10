<?php

namespace App\Tests\Domain\Owner;

use App\Domain\Owner\Dni;
use App\Domain\Owner\Owner;
use App\Domain\Shared\Uuid;
use Faker\Factory;
use Faker\Generator;

class OwnerMother
{
    private static Generator $generator;

    public static function create(): Owner
    {
        return Owner::create(
            uuid: new Uuid(self::generator()->uuid()),
            dni: new Dni(self::generator()->randomNumber(8, strict: true)),
            surname: self::generator()->name(),
            name: self::generator()->lastName()
        );
    }

    public static function generator(): Generator
    {
        return self::$generator = self::$generator ?? Factory::create();
    }
}
