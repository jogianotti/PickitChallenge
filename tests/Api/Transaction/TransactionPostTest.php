<?php

namespace App\Tests\Api\Transaction;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TransactionPostTest extends WebTestCase
{
    public function testItShouldPostATransaction(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/cars/af4cbe9a-f218-4a27-801f-91ee04e0547c/transactions',
            content: '{
                "uuid": "382acb66-99e9-4107-8ba7-797bdde6d5ec",
                "services": [ 
                    { "service": "Revisión General", "price": 3000.00 },
                    { "service": "Cambio de Filtro", "price": 4000.00 }
                ]
            }'
        );

        $content = $client->getResponse()->getContent();

        self::assertResponseIsSuccessful();
        self::assertJson($content);
        self::assertEquals(
            expected: '{"total":7000.00}',
            actual: $content
        );
    }

    public function testItShouldReturnUuidError(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/cars/a9180e84-c8c6-455c-a5e6-f721705ae3a1/transactions',
            content: '{
                "uuid": "-455c-a5e6-f721705ae3a1",
                "services": [ { "service": "Revisión General", "price": 3000.00 } ]
            }'
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
        $client->request(
            method: 'POST',
            uri: '/cars/a4036557-99e3-4230-bbea-d1e22b15bfb9/transactions',
            content: '{
                "uuid": "8338eb5e-248c-4140-a391-1e99890b691f",
                "services": [ { "service": "Lavado", "price": 2000.00 } ]
            }'
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid Services"}',
            actual: $client->getResponse()->getContent()
        );
    }

    public function testItShouldReturnParametersAreMissingError(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/cars/d57c919c-8a51-4bed-b4a9-6112a6979d2d/transactions',
            content: '{
                "uuid": "db832f4b-d74a-409e-a39d-9547b57d6e47"
            }'
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
        $client->request(
            method: 'POST',
            uri: '/cars/c9f7b2d1-4511-4762-bd16-72e8fa4706bd/transactions',
            content: '{
                "uuid": "3315efe7-a87c-4dad-823b-4d285fa90c58"
                "services": [ { "service": "Otros", "price": 2000.00 } ]
            }'
        );

        self::assertResponseStatusCodeSame(expectedCode: 404);
        self::assertEquals(
            expected: '{"code":404,"message":"Car not found"}',
            actual: $client->getResponse()->getContent()
        );
    }
}
