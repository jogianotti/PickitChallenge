<?php

namespace App\Tests\Api\Car;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarDeleteTest extends WebTestCase
{
    public function testItShouldDeleteOneCar(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'DELETE',
            uri: '/cars/b41ca9ae-fb3c-4a31-ba34-03531e04abe7'
        );

        self::assertResponseIsSuccessful();
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
