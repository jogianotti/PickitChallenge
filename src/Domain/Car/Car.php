<?php

namespace App\Domain\Car;

use App\Domain\Owner\Owner;
use App\Domain\Shared\Uuid;
use App\Domain\Transaction\Transaction;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string')]
    private string $uuid;

    #[ORM\Column(type: 'string', length: 100)]
    private string $brand;

    #[ORM\Column(type: 'string', length: 100)]
    private string $model;

    #[ORM\Column(type: 'integer')]
    private int $year;

    #[ORM\Column(type: 'string', length: 7)]
    private string $patent;

    #[ORM\Column(type: 'string', length: 100)]
    private string $color;

    #[ORM\OneToMany(mappedBy: "car", targetEntity: Transaction::class)]
    private Collection $transactions;

    #[ORM\ManyToOne(targetEntity: Owner::class, inversedBy: "cars")]
    private Owner $owner;

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
        $this->transactions = new ArrayCollection();
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

    public function addTransaction(Transaction $transaction)
    {
        $this->transactions->add($transaction);
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function setPatent(Patent $patent): self
    {
        $this->patent = $patent->value();

        return $this;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function setOwner(Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function canApply(string $service): bool
    {
        return $this->color !== 'Gris' || $service !== 'Pintura';
    }
}
