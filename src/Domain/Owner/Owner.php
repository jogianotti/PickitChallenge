<?php

namespace App\Domain\Owner;

use App\Domain\Shared\Uuid;

class Owner
{
    private string $uuid;
    private string $dni;
    private string $surname;
    private string $name;

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid->value();
    }

    public static function create(
        Uuid $uuid,
        Dni $dni,
        string $surname,
        string $name
    ): Owner {
        $owner = new self($uuid);
        $owner->dni = $dni->value();
        $owner->surname = $surname;
        $owner->name = $name;

        return $owner;
    }

    public function uuid(): Uuid
    {
        return new Uuid($this->uuid);
    }

    public function dni(): Dni
    {
        return new Dni($this->dni);
    }

    public function surname(): string
    {
        return $this->surname;
    }

    public function name(): string
    {
        return $this->name;
    }
}