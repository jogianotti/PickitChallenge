<?php

namespace App\Tests\Api\Car;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OneCarGetTest extends WebTestCase
{
    public function testItShouldGetAllCars(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'GET',
            uri: '/cars/89d2ff49-2f03-4241-b186-12c5c5ea1c43'
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