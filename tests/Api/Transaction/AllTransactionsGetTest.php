<?php

namespace App\Tests\Api\Transaction;

use App\Tests\Domain\Car\CarMother;
use App\Tests\Domain\Car\CarSerializer;
use App\Tests\Domain\Transaction\TransactionMother;
use App\Tests\Domain\Transaction\TransactionSerializer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class AllTransactionsGetTest extends WebTestCase
{

    public function testItShouldGetAllCars(): void
    {
        $client = static::createClient();

        $car = CarMother::create();
        $content = CarSerializer::toJson($car);
        $client->request(
            method: 'POST',
            uri: '/cars',
            content: $content
        );

        $transaction = TransactionMother::create();
        $content = TransactionSerializer::toJson($transaction);
        $client->request(
            method: 'POST',
            uri: sprintf('/cars/%s/transactions', $car->uuid()->value()),
            content: $content
        );

        $client->request(
            method: 'GET',
            uri: sprintf('/cars/%s/transactions', $car->uuid()->value())
        );

        self::assertResponseIsSuccessful();
        self::assertJson($client->getResponse()->getContent());
    }
}