<?php

namespace App\Domain\Transaction;

interface TransactionRepository
{
    public function save(Transaction $car): void;

    public function all(int $limit, int $offset): array;

    public function one(string $id): ?Transaction;

    public function delete(Transaction $car): void;
}
