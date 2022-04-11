<?php

namespace App\Tests\Domain\Car;

use App\Domain\Car\Car;

final class CarSerializer
{
    public static function toJson(Car $car): string
    {
        return self::loadData(
            $car->uuid()->value(),
            $car->brand(),
            $car->model(),
            $car->year(),
            $car->patent()->value(),
            $car->color()
        );
    }

    public static function toJsonWithWrongUuid(Car $car)
    {
        return self::loadData(
            '3315efe7-a87c',
            $car->brand(),
            $car->model(),
            $car->year(),
            $car->patent()->value(),
            $car->color()
        );
    }

    public static function toJsonWithWrongPatent(Car $car)
    {
        return self::loadData(
            $car->uuid()->value(),
            $car->brand(),
            $car->model(),
            $car->year(),
            '232323',
            $car->color()
        );
    }

    public static function array(array $cars): array
    {
        $mapped = [];
        foreach ($cars as $car) {
            $mapped[] = self::toArray($car);
        }

        return $mapped;
    }

    private static function loadData(
        string $uuid,
        string $brand,
        string $model,
        int $year,
        string $patent,
        string $color
    ): string {
        $json = '{ "uuid": "%s", "brand": "%s", "model": "%s", "year": %s, "patent": "%s", "color": "%s" }';

        return sprintf($json, $uuid, $brand, $model, $year, $patent, $color);
    }

    public static function toArray(Car $car): array
    {
        return json_decode(self::toJson($car), associative: true);
    }
}
