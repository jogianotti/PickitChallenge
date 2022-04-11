<?php

namespace App\Tests\Api\Car;

use App\Domain\Car\CarSerializer;
use App\Tests\Domain\Car\CarMother;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OneCarGetTest extends WebTestCase
{
    public function testItShouldGetACar(): void
    {
        $car = CarMother::create();
        $content = CarSerializer::toJson($car);

        $client = static::createClient();

        $client->request(
            method: 'POST',
            uri: '/cars',
            content: $content
        );

        $client->request(
            method: 'GET',
            uri: sprintf('/cars/%s', $car->uuid()->value())
        );

        self::assertResponseIsSuccessful();
        self::assertJson($client->getResponse()->getContent());
    }

    public function testItShouldReturnInvalidUuidError(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'GET',
            uri: '/cars/12c5c5ea1c43'
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid UUID"}',
            actual: $client->getResponse()->getContent()
        );
    }
}