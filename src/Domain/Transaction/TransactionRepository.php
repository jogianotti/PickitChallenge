<?php

namespace App\Domain\Transaction;

use App\Domain\Car\Car;

interface TransactionRepository
{
    public function save(Transaction $transaction): void;

    public function all(Car $car, int $limit, int $offset): array;

    public function one(Car $car, string $id): ?Transaction;

    public function delete(Transaction $transaction): void;
}
