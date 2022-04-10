<?php

namespace App\Domain\Transaction;

use App\Domain\Car\Car;
use App\Domain\Shared\Uuid;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::STRING)]
    private string $uuid;

    #[ORM\Column(type: Types::ARRAY)]
    private array $services;

    #[ORM\ManyToOne(targetEntity: Car::class, inversedBy: "transactions")]
    private Car $car;

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid->value();
    }

    public static function create(Uuid $id, array $services): Transaction
    {
        $transaction = new self($id);
        $transaction->services = $services;

        return $transaction;
    }

    public function uuid(): Uuid
    {
        return new Uuid($this->uuid);
    }

    public function services(): array
    {
        return $this->services;
    }

    public function car(): ?Car
    {
        return $this->car;
    }

    public function setCar(Car $car): void
    {
        $this->car = $car;
    }
}
