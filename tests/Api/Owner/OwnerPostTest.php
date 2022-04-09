<?php

namespace App\Tests\Api\Owner;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OwnerPostTest extends WebTestCase
{
    public function testItShouldPostAnOwner(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/owners',
            content: '{
                "uuid": "af4cbe9a-f218-4a27-801f-91ee04e0547c",
                "dni": "12345678",
                "name": "Julia",
                "surname": "Ruiz"
            }'
        );

        self::assertResponseIsSuccessful();
    }

    public function testItShouldReturnUuidError(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/owners',
            content: '{
                "uuid": "af4cbe9a-f218",
                "dni": "12345678",
                "name": "Julia",
                "surname": "Ruiz"
            }'
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid UUID"}',
            actual: $client->getResponse()->getContent()
        );
    }

    public function testItShouldReturnDniError(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/owners',
            content: '{
                "uuid": "7b49c246-0672-4a03-ab93-484954060478",
                "dni": "ab123",
                "name": "Julia",
                "surname": "Ruiz"
            }'
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid DNI"}',
            actual: $client->getResponse()->getContent()
        );
    }

    public function testItShouldReturnParametersAreMissingError(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/owners',
            content: '{
                "uuid": "23e8fddc-ce49-45d6-8f4f-d1e0c68a8c52"
            }'
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Parameters are missing"}',
            actual: $client->getResponse()->getContent()
        );
    }
}
