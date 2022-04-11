<?php

namespace App\Tests\Domain\Transaction;

use App\Domain\Shared\Uuid;
use App\Domain\Transaction\Transaction;
use Faker\Factory;
use Faker\Generator;

class TransactionMother
{
    private static Generator $generator;

    public static function create(): Transaction
    {
        $count = random_int(min: 2, max: 6);
        $keys = array_rand(Transaction::$availableServices, $count);

        $services = [];
        foreach ($keys as $key) {
            $services[] = [
                "service" => Transaction::$availableServices[$key],
                "price" => self::generator()->randomFloat(2, min: 5000, max: 100000),
            ];
        }

        return Transaction::create(
            id: new Uuid(self::generator()->uuid()),
            services: $services
        );
    }

    public static function createWithPaintService(): Transaction
    {
        $services[] = [
            "service" => 'Pintura',
            "price" => self::generator()->randomFloat(2, min: 5000, max: 100000),
        ];

        return Transaction::create(
            id: new Uuid(self::generator()->uuid()),
            services: $services
        );
    }

    public static function generator(): Generator
    {
        return self::$generator = self::$generator ?? Factory::create();
    }
}
