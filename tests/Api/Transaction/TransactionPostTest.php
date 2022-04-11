<?php

namespace App\Tests\Api\Transaction;

use App\Tests\Domain\Car\CarMother;
use App\Tests\Domain\Car\CarSerializer;
use App\Tests\Domain\Transaction\TransactionMother;
use App\Tests\Domain\Transaction\TransactionSerializer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TransactionPostTest extends WebTestCase
{
    public function testItShouldPostATransaction(): void
    {
        $client = static::createClient();

        $car = CarMother::create();
        $content = CarSerializer::toJson($car);

        $client->request(
            method: 'POST',
            uri: '/cars',
            content: $content
        );

        self::assertResponseIsSuccessful();

        $transaction = TransactionMother::create();
        $content = TransactionSerializer::toJson($transaction);

        $client->request(
            method: 'POST',
            uri: sprintf('/cars/%s/transactions', $car->uuid()->value()),
            content: $content
        );

        $response = $client->getResponse()->getContent();

        self::assertResponseIsSuccessful();
        self::assertJson($content);
        self::assertEquals(
            expected: sprintf('{"total":%s}', $transaction->total()),
            actual: $response
        );
    }

    public function testItShouldReturnUuidError(): void
    {
        $client = static::createClient();

        $car = CarMother::create();
        $content = CarSerializer::toJson($car);

        $client->request(
            method: 'POST',
            uri: '/cars',
            content: $content
        );

        self::assertResponseIsSuccessful();

        $transaction = TransactionMother::create();
        $content = TransactionSerializer::toJsonWithWrongUuid($transaction);

        $client->request(
            method: 'POST',
            uri: sprintf('/cars/%s/transactions', $car->uuid()->value()),
            content: $content
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid UUID"}',
            actual: $client->getResponse()->getContent()
        );
    }

    public function testItShouldReturnServicesError(): void
    {
        $client = static::createClient();

        $car = CarMother::create();
        $content = CarSerializer::toJson($car);

        $client->request(
            method: 'POST',
            uri: '/cars',
            content: $content
        );

        self::assertResponseIsSuccessful();

        $transaction = TransactionMother::create();
        $content = TransactionSerializer::toJsonWithWrongService($transaction);

        $client->request(
            method: 'POST',
            uri: sprintf('/cars/%s/transactions', $car->uuid()->value()),
            content: $content
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid services"}',
            actual: $client->getResponse()->getContent()
        );
    }

    public function testItShouldReturnParametersAreMissingError(): void
    {
        $client = static::createClient();

        $car = CarMother::create();
        $content = CarSerializer::toJson($car);

        $client->request(
            method: 'POST',
            uri: '/cars',
            content: $content
        );

        self::assertResponseIsSuccessful();

        $transaction = TransactionMother::create();
        $content = TransactionSerializer::toJsonWithoutService($transaction);

        $client->request(
            method: 'POST',
            uri: sprintf('/cars/%s/transactions', $car->uuid()->value()),
            content: $content
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Parameters are missing"}',
            actual: $client->getResponse()->getContent()
        );
    }

    public function testItShouldReturnCarNotFoundError(): void
    {
        $client = static::createClient();

        $car = CarMother::create();
        $transaction = TransactionMother::create();
        $content = TransactionSerializer::toJson($transaction);

        $client->request(
            method: 'POST',
            uri: sprintf('/cars/%s/transactions', $car->uuid()->value()),
            content: $content
        );

        self::assertResponseStatusCodeSame(expectedCode: 404);
        self::assertEquals(
            expected: '{"code":404,"message":"Car not found"}',
            actual: $client->getResponse()->getContent()
        );
    }

    public function testItShouldReturnPaintServiceOnGreyCarError(): void
    {
        $client = static::createClient();

        $car = CarMother::create();
        $car->setColor('Gris');
        $content = CarSerializer::toJson($car);

        $client->request(
            method: 'POST',
            uri: '/cars',
            content: $content
        );

        self::assertResponseIsSuccessful();

        $transaction = TransactionMother::createWithPaintService();
        $content = TransactionSerializer::toJson($transaction);

        $client->request(
            method: 'POST',
            uri: sprintf('/cars/%s/transactions', $car->uuid()->value()),
            content: $content
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Service not allowed"}',
            actual: $client->getResponse()->getContent()
        );
    }
}
