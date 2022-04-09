<?php

namespace App\Tests\Api\Car;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarPostTest extends WebTestCase
{
    public function testItShouldPostCar(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/cars',
            content: '{
                "uuid": "af4cbe9a-f218-4a27-801f-91ee04e0547c",
                "marca": "Ford",
                "modelo": "Ecosport",
                "año": 2020,
                "patente": "AV114XY",
                "color": "Gris"
            }'
        );

        self::assertResponseIsSuccessful();
    }

    public function testItShouldReturnUuidError(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/cars',
            content: '{
                "uuid": "ee25f0a3",
                "marca": "Renault",
                "modelo": "Mégane",
                "año": 2001,
                "patente": "EDA536",
                "color": "Azul"
            }'
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid UUID"}',
            actual: $client->getResponse()->getContent()
        );
    }
}
