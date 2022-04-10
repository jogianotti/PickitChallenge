<?php

namespace App\Tests\Api\Owner;

use App\Tests\Domain\Owner\OwnerMother;
use App\Tests\Domain\Owner\OwnerSerializer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OwnerPostTest extends WebTestCase
{
    public function testItShouldPostAnOwner(): void
    {
        $owner = OwnerMother::create();
        $content = OwnerSerializer::toJson($owner);

        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/owners',
            content: $content
        );

        self::assertResponseIsSuccessful();
    }

    public function testItShouldReturnUuidError(): void
    {
        $owner = OwnerMother::create();
        $content = OwnerSerializer::toJsonWithWrongUuid($owner);

        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/owners',
            content: $content
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid UUID"}',
            actual: $client->getResponse()->getContent()
        );
    }

    public function testItShouldReturnDniError(): void
    {
        $owner = OwnerMother::create();
        $content = OwnerSerializer::toJsonWithWrongDni($owner);

        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/owners',
            content: $content
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Invalid DNI"}',
            actual: $client->getResponse()->getContent()
        );
    }

    public function testItShouldReturnParametersAreMissingError(): void
    {
        $owner = OwnerMother::create();
        $content = OwnerSerializer::toJsonWithEmptyParameters($owner);

        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/owners',
            content: $content
        );

        self::assertResponseStatusCodeSame(expectedCode: 400);
        self::assertEquals(
            expected: '{"code":400,"message":"Parameters are missing"}',
            actual: $client->getResponse()->getContent()
        );
    }
}
