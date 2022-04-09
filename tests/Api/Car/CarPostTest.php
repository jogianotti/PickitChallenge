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
                "brand": "Ford",
                "model": "Ecosport",
                "year": 2020,
                "patent": "AV114XY",
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
                "brand": "Renault",
                "model": "Mégane",
                "year": 2001,
                "patent": "EDA536",
                "color": "Azul"
            }'
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid UUID"}',
            actual: $client->getResponse()->getContent()
        );
    }

    public function testItShouldReturnPatentError(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/cars',
            content: '{
                "uuid": "e32124f9-aff7-4d4e-a432-60ed436deab9",
                "brand": "Citroen",
                "model": "C4",
                "year": 2011,
                "patent": "E5D3G6S",
                "color": "Rojo"
            }'
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid Patent"}',
            actual: $client->getResponse()->getContent()
        );
    }
}
