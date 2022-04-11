<?php

namespace App\Tests\Api\Car;

use App\Domain\Car\CarSerializer;
use App\Tests\Domain\Car\CarMother;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarDeleteTest extends WebTestCase
{
    public function testItShouldDeleteOneCar(): void
    {
        $car = CarMother::create();
        $content = CarSerializer::toJson($car);
        $client = static::createClient();

        $client->request(
            method: 'POST',
            uri: '/cars',
            content: $content
        );
        self::assertResponseIsSuccessful();

        $client->request(
            method: 'DELETE',
            uri: sprintf('/cars/%s', $car->uuid()->value())
        );
        self::assertResponseIsSuccessful();

        $client->request(
            method: 'GET',
            uri: sprintf('/cars/%s', $car->uuid()->value())
        );

        self::assertResponseStatusCodeSame(expectedCode: 404);
        self::assertEquals(
            expected: '{"code":404,"message":"Car not found"}',
            actual: $client->getResponse()->getContent()
        );
    }

    public function testItShouldReturnInvalidUuidError(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'DELETE',
            uri: '/cars/fb3c-4a31-ba34'
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid UUID"}',
            actual: $client->getResponse()->getContent()
        );
    }
}
