<?php

namespace App\Tests\Domain\Transaction;

use App\Domain\Transaction\Transaction;

class TransactionSerializer
{
    public static function toJson(Transaction $transaction): string
    {
        return self::loadData(
            $transaction->uuid()->value(),
            $transaction->services()
        );
    }

    public static function toJsonWithWrongUuid(Transaction $transaction): string
    {
        return self::loadData(
            '-99e3-4230-bbea-',
            $transaction->services()
        );
    }

    public static function toJsonWithWrongService(Transaction $transaction): string
    {
        return self::loadData(
            $transaction->uuid()->value(),
            [["service" => 'Lavado', "price" => 1000.00]]
        );
    }

    public static function toJsonWithoutService(Transaction $transaction): string
    {
        return self::loadData($transaction->uuid()->value(), []);
    }

    private static function loadData(string $uuid, array $services): string
    {
        $json = '{ 
            "uuid": "%s",
            "services": %s
        }';

        return sprintf($json, $uuid, json_encode($services));
    }

    public static function arrayToJson(array $transactions): string
    {
        $serialized = [];
        foreach ($transactions as $transaction) {
            $serialized[] = self::toJson($transaction);
        }

        return sprintf('[ %s ]', implode(', ', $serialized));
    }
}
