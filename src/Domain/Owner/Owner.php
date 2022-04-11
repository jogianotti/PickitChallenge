<?php

namespace App\Domain\Owner;

use App\Domain\Car\Car;
use App\Domain\Shared\Uuid;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OwnerRepository::class)]
class Owner
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::STRING)]
    private string $uuid;

    #[ORM\Column(type: Types::STRING, length: 8)]
    private string $dni;

    #[ORM\Column(type: Types::STRING)]
    private string $surname;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\OneToMany(mappedBy: "owner", targetEntity: Car::class)]
    private Collection $cars;

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

    public function fullName(): string
    {
        return "$this->surname $this->name";
    }
}