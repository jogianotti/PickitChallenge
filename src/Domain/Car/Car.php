<?php

namespace App\Domain\Car;

use App\Domain\Shared\Uuid;

class Car
{
    private string $uuid;
    private string $brand;
    private string $model;
    private int $year;
    private string $patent;
    private string $color;

    public static function create(
        Uuid $uuid,
        string $brand,
        string $model,
        int $year,
        Patent $patent,
        string $color
    ): self {
        $car = new self($uuid);
        $car->brand = $brand;
        $car->model = $model;
        $car->year = $year;
        $car->patent = $patent->value();
        $car->color = $color;

        return $car;
    }

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid->value();
    }

    public function uuid(): Uuid
    {
        return new Uuid($this->uuid);
    }

    public function brand(): string
    {
        return $this->brand;
    }

    public function model(): string
    {
        return $this->model;
    }

    public function year(): int
    {
        return $this->year;
    }

    public function patent(): Patent
    {
        return new Patent($this->patent);
    }

    public function color(): string
    {
        return $this->color;
    }


}